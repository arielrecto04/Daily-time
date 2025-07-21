<script setup>
import { AuthLayout } from '@/layouts';
import { Table, Loader, Paginate, Button, Modal } from '@/components';
import { ref, onMounted, computed } from 'vue';
import { useAttendanceStore } from '@/stores';
import { storeToRefs } from 'pinia';
import { PencilIcon, TrashIcon } from '@heroicons/vue/24/outline'

const attendanceStore = useAttendanceStore();
// Use storeToRefs to keep reactivity
const { attendances, isLoading, error, pagination, selectedAttendance, _attendance } = storeToRefs(attendanceStore);

const columns = [
    { key: 'id', label: 'ID' },
    { key: 'name', label: 'Name' },
    { key: 'date', label: 'Date' },
    { key: 'check_in', label: 'Time In (HH:mm:ss)' },
    { key: 'check_out', label: 'Time Out (HH:mm:ss)' },
    { key: 'late_in_minutes', label: 'Late In (minutes)' },
    { key: 'overtime_in_minutes', label: 'Overtime In (minutes)' },
    { key: 'day_of_week', label: 'Day of Week' },
    { key: 'duration_days', label: 'Duration Days' },
];


const isModalOpen = ref(false);
const isModalDelete = ref(false);

/**
 * Handles the page change event from the pagination component.
 * It calls the Pinia store action to fetch data for the new page.
 * @param {number} newPage - The new page number.
 */
const onPageChange = (newPage) => {
    // The fetchAttendance action will handle updating the state,
    // including the current page number.
    attendanceStore.fetchAttendance(newPage, pagination.value.per_page);
};

const openModal = (id) => {
    isModalOpen.value = true;
    attendanceStore.selectedByAttendance(id);
}

const closeModal = () => {
    isModalOpen.value = false;
}

const openModalDelete = (id) => {
    isModalDelete.value = true;
    attendanceStore.selectedByAttendance(id);
}

const closeModalDelete = () => {
    isModalDelete.value = false;
}

const deleteAttendance = (id) => {
    attendanceStore.deleteAttendance(id);
    closeModalDelete();
}

// Fetch initial data when the component is mounted
onMounted(() => {
    attendanceStore.fetchAttendance();
});


</script>

<template>
    <AuthLayout>
        <div class="flex flex-col gap-4 relative">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Attendance</h1>
                    <p class="text-gray-500 text-sm mt-1">View and manage employee attendance records.</p>
                </div>
                <div>
                    <input type="text" placeholder="Search by name or email"
                        class="border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        disabled />
                </div>
            </div>

            <Loader v-if="isLoading" message="Loading..." />

            <div v-else class="bg-white rounded-lg shadow p-4">
                <Table :columns="columns" :rows="attendances">
                    <template #actions="{ row }">
                        <Button variant="primary" @click="openModal(row.id)">
                            <PencilIcon class="w-5 h-5" />
                        </Button>
                        <Button variant="danger" @click="openModalDelete(row.id)">
                            <TrashIcon class="w-5 h-5" />
                        </Button>
                    </template>
                </Table>
                <!--
                  Correctly bind totalPages and currentPage to the pagination state from the Pinia store.
                  Only show pagination if there is more than one page.
                -->
                <Paginate v-if="pagination && pagination.last_page > 1" :totalPages="pagination.last_page"
                    :currentPage="pagination.current_page" :totalItems="pagination.total"
                    @page-changed="onPageChange" />
            </div>
        </div>
        <Modal :isOpen="isModalOpen" @close="closeModal" maxWidth="2xl">
            <template #header>
                <h1 class="text-lg font-medium leading-6 text-gray-800">Edit Attendance</h1>
            </template>
            <template #body>
                <div class="flex flex-col gap-5 w-full">
                    <div class="flex flex-col gap-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="name" v-model="_attendance.name"
                            class="mt-1 block w-full px-2 py-2 underline-offset-2 border-b border-b-blue-500 duration-700 focus:outline-none focus:border-b-2 text-sm" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="text" id="name" v-model="_attendance.date"
                            class="mt-1 block w-full px-2 py-2 underline-offset-2 border-b border-b-blue-500 duration-700 focus:outline-none focus:border-b-2 text-sm" />
                    </div>
                    <div class="flex items-center gap-2 w-full">
                        <div class="flex flex-col gap-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Time In</label>
                            <input type="time" id="name" v-model="_attendance.check_in"
                                class="mt-1 block w-full px-2 py-2 underline-offset-2 border-b border-b-blue-500 duration-700 focus:outline-none focus:border-b-2 text-sm" />
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Time Out</label>
                            <input type="time" id="name" v-model="_attendance.check_out"
                                class="mt-1 block w-full px-2 py-2 underline-offset-2 border-b border-b-blue-500 duration-700 focus:outline-none focus:border-b-2 text-sm" />
                        </div>
                    </div>
                    <div class="flex items-center gap-2 w-full">
                        <div class="flex flex-col gap-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Overtime</label>
                            <input type="number" id="name" v-model="_attendance.overtime_in_minutes"
                                class="mt-1 block w-full px-2 py-2 underline-offset-2 border-b border-b-blue-500 duration-700 focus:outline-none focus:border-b-2 text-sm" />
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Late</label>
                            <input type="number" id="name" v-model="_attendance.late_in_minutes"
                                class="mt-1 block w-full px-2 py-2 underline-offset-2 border-b border-b-blue-500 duration-700 focus:outline-none focus:border-b-2 text-sm" />
                        </div>
                    </div>
                    <div class="flex items-center gap-2 w-full">
                        <div class="flex flex-col gap-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Day of Week</label>
                            <input type="text" id="name" v-model="_attendance.day_of_week"
                                class="mt-1 block w-full px-2 py-2 underline-offset-2 border-b border-b-blue-500 duration-700 focus:outline-none focus:border-b-2 text-sm" />
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Duration Days</label>
                            <input type="number" id="name" v-model="_attendance.duration_days"
                                class="mt-1 block w-full px-2 py-2 underline-offset-2 border-b border-b-blue-500 duration-700 focus:outline-none focus:border-b-2 text-sm" />
                        </div>
                    </div>
                </div>

            </template>
            <template #footer>
                <Button variant="primary" @click="closeModal">Close</Button>
                <!-- <Button variant="danger" @click="deleteAttendance(_attendance.id)">Delete</Button> -->
            </template>
        </Modal>

        <Modal :isOpen="isModalDelete" @close="closeModalDelete">
            <template #header>
                <h1 class="text-lg font-medium leading-6 text-gray-800">Delete Attendance</h1>
            </template>
            <template #body>
                <div class="flex flex-col gap-5 w-full">
                    <div class="flex flex-col gap-2">
                        <p>Are you sure you want to delete this attendance?</p>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="name" v-model="_attendance.name" disabled
                            class="mt-1 block w-full px-2 py-2 underline-offset-2  border-b border-b-blue-500 duration-700 focus:outline-none focus:border-b-2 text-sm" />
                    </div>
                </div>
            </template>
            <template #footer>
                <Button variant="primary" @click="closeModalDelete">Close</Button>
                <Button variant="danger" @click="deleteAttendance(_attendance.id)">Delete</Button>
            </template>
        </Modal>
    </AuthLayout>
</template>
