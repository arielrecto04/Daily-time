<script setup>
import { Table, Button, Loader, Modal } from "@/components";
import { PencilIcon, TrashIcon, EyeIcon } from "@heroicons/vue/24/outline";
import { useLeaveApplicationStore } from "@/stores/useLeaveApplicationStore";
import { storeToRefs } from "pinia";
import { onMounted, ref } from "vue";
const leaveApplicationStore = useLeaveApplicationStore();
const { leaveApplications, isLoading } = storeToRefs(leaveApplicationStore);

const columns = [
    { label: "Name", key: "name" },
    { label: "Leave Type", key: "leave_type.name" },
    { label: "Start Date", key: "start_date" },
    { label: "End Date", key: "end_date" },
    { label: "Status", key: "status" },
];

const isDeleteModalOpen = ref(false);

const handleDeleteModalAction = (row) => {
    isDeleteModalOpen.value = !isDeleteModalOpen.value;
    leaveApplicationStore.selectLeaveApplication(row);
};



const deleteDataHandle = async () => {
    try {
        await leaveApplicationStore.deleteLeaveApplication()
        isDeleteModalOpen.value = false;
    } catch (error) {
        console.log(error)
    }
}

onMounted(() => {
    leaveApplicationStore.fetchLeaveApplications();
});
</script>

<template>
    <Loader v-if="isLoading" />
    <Table v-else :columns="columns" :rows="leaveApplications">
        <template #actions="{ row }">
            <router-link :to="`/leave-application/show/${row.id}`">
                <Button variant="secondary">
                    <EyeIcon class="w-5 h-5" />
                </Button>
            </router-link>

            <router-link :to="`/leave-application/edit/${row.id}`">
                <Button variant="primary">
                    <PencilIcon class="w-5 h-5" />
                </Button>
            </router-link>

            <Button @click="handleDeleteModalAction(row)" variant="danger">
                <TrashIcon class="w-5 h-5" />
            </Button>
        </template>
    </Table>

    <Modal :isOpen="isDeleteModalOpen">
        <template #header> Delete </template>

        <template #body> Are you sure to delete the Data ? </template>

        <template #footer>
            <button
                @click="handleDeleteModalAction"
                type="button"
                class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors"
            >
                Cancel
            </button>
            <button
                @click="deleteDataHandle"
                type="button"
                class="inline-flex justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors"
            >
                Delete
            </button>
        </template>
    </Modal>
</template>
