<script setup>
import { Table, Button, Loader } from "@/components";
import { PencilIcon, TrashIcon, EyeIcon } from "@heroicons/vue/24/outline";
import { useLeaveApplicationStore } from "@/stores/useLeaveApplicationStore";
import { storeToRefs } from "pinia";
import { onMounted } from "vue";
const leaveApplicationStore = useLeaveApplicationStore();
const { leaveApplications, isLoading } = storeToRefs(leaveApplicationStore);

const columns = [
    { label: "Name", key: "name" },
    { label: "Leave Type", key: "leave_type.name" },
    { label: "Start Date", key: "start_date" },
    { label: "End Date", key: "end_date" },
    { label: "Status", key: "status" },
];

const handleEdit = (row) => {
    console.log(row);
};

const handleDelete = (row) => {
    console.log(row);
};

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

            <Button @click="handleDelete(row)" variant="danger">
                <TrashIcon class="w-5 h-5" />
            </Button>
        </template>
    </Table>
</template>
