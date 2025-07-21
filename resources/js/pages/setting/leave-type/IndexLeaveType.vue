<script setup>
import { Table, Modal, Loader, LeaveTypeForm, Paginate, BadgeStatus, Toggle } from '@/components';
import { useLeaveTypeStore } from '@/stores';
import { storeToRefs } from 'pinia';
import { ref, onMounted } from 'vue';
import { PencilIcon, TrashIcon } from '@heroicons/vue/24/outline'
import { useToast } from '@/utils';


const leaveTypeStore = useLeaveTypeStore();
const toast = useToast();
const { isLoading, error, leaveTypes, pagination } = storeToRefs(leaveTypeStore);
const { showToast } = toast;

const columns = [
    {
        key: 'name',
        label: 'Name',
    },
    {
        key: 'descriptions',
        label: 'Description',
    },
    {
        key: 'is_active',
        label: 'Active',
    },
    {
        key: 'is_credited',
        label: 'Credited',
    }
];


const addModalOpen = ref(false);
const editModalOpen = ref(false);
const deleteModalOpen = ref(false);

const addModalAction = () => {
    addModalOpen.value = !addModalOpen.value;
};

const editModalAction = (leaveType) => {
    leaveTypeStore.selectLeaveType(leaveType);
    editModalOpen.value = !editModalOpen.value;
};

const deleteModalAction = (leaveType) => {
    leaveTypeStore.selectLeaveType(leaveType);
    deleteModalOpen.value = !deleteModalOpen.value;
};


const handleDelete = () => {

    try {
        leaveTypeStore.deleteLeaveType();
        showToast('Leave type deleted successfully', 'success');
    } catch (error) {
        showToast(error.response.data.message, 'error');
    }
    deleteModalOpen.value = false;
};

const handleUpdateStatus = (leaveType) => {
    try {
        leaveTypeStore.selectLeaveType(leaveType);
        leaveTypeStore.updateStatus();
        showToast('Leave type updated successfully', 'success');
    } catch (error) {
        showToast(error.response.data.message, 'error');
    }
};

const handleUpdateCredited = (leaveType) => {
    try {
        leaveTypeStore.selectLeaveType(leaveType);
        leaveTypeStore.updateCredited();
        showToast('Leave type updated successfully', 'success');
    } catch (error) {
        showToast(error.response.data.message, 'error');
    }
};

onMounted(() => {
    leaveTypeStore.fetchLeaveTypes();
    console.log(pagination.value);
});
</script>

<template>
    <div class="h-full overflow-auto p-6 relative">
        <div class="flex gap-2">
            <div class="w-full gap-2 flex flex-col sticky top-0 z-10">
                <h1 class="text-2xl font-bold">Leave Type</h1>
                <p class="text-sm text-gray-500 mt-1">Manage your account settings and preferences.</p>
            </div>
            <div class="flex justify-end mt-6">
                <button @click="addModalAction"
                    class="bg-blue-500 h-10 w-40 text-white px-4 py-2 rounded-lg hover:bg-blue-600 duration-700">Add Leave
                    Type</button>
            </div>
        </div>



        <div class="mt-6">
            <Loader v-if="isLoading" />
            <Table v-else :columns="columns" :rows="leaveTypes">
                <template #cell(is_active)="{ row }">
                    <Toggle v-model="row.is_active" @change="handleUpdateStatus(row)" />
                </template>
                <template #cell(is_credited)="{ row }">
                    <Toggle v-model="row.is_credited" @change="handleUpdateCredited(row)" />
                </template>
                <template #actions="{ row }">
                    <button @click="editModalAction(row)"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 duration-700">
                        <PencilIcon class="w-5 h-5" />
                    </button>
                    <button @click="deleteModalAction(row)"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 duration-700">
                        <TrashIcon class="w-5 h-5" />
                    </button>
                </template>
            </Table>
            <Paginate :totalItems="pagination.total" :currentPage="pagination.current_page" :itemsPerPage="pagination.per_page" :totalPages="pagination.last_page" />
        </div>

        <Modal :isOpen="addModalOpen" @close="addModalAction">

            <template #header>
                <h2 class="text-lg font-medium text-gray-900">Add Leave Type</h2>
            </template>
            <template #body>
                <LeaveTypeForm :leaveType="{}" @close="addModalAction" />
            </template>
            <template #footer>
                <div>

                </div>

            </template>
        </Modal>

        <Modal :isOpen="editModalOpen" @close="editModalAction">
            <template #header>
                <h2 class="text-lg font-medium text-gray-900">Edit Leave Type</h2>
            </template>
            <template #body>
                <LeaveTypeForm :leaveType="leaveTypeStore.leaveType" @close="editModalAction" />
            </template>
            <template #footer>
                <div>

                </div>
            </template>
        </Modal>


        <Modal :isOpen="deleteModalOpen" @close="deleteModalAction">
            <template #header>
                <h2 class="text-lg font-medium text-gray-900">Delete Leave Type</h2>
            </template>
            <template #body>
                <p>Are you sure you want to delete this leave type?</p>
            </template>
            <template #footer>
                <button @click="deleteModalAction" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                <button @click="handleDelete" class="px-4 py-2 bg-red-500 text-white rounded">Delete</button>
            </template>
        </Modal>

    </div>
</template>
