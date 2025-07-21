<script setup>
import { ref, onMounted, computed } from 'vue';
import { useDepartmentStore } from '@/stores/useDepartmentStore'; // Assuming path is correct
import { storeToRefs } from 'pinia';
import { AuthLayout } from '@/layouts';
import { Card, Modal, DepartmentForm, Loader } from '@/components';
import { PencilIcon, TrashIcon } from '@heroicons/vue/24/outline'

const departmentStore = useDepartmentStore();

const { departments, isLoading, error, department } = storeToRefs(departmentStore);


const isAddModalOpen = ref(false);
const isEditModalOpen = ref(false);
const isDeleteModalOpen = ref(false);


const openAddModal = () => {
    isAddModalOpen.value = true;
};

const openEditModal = (department) => {
    departmentStore.setSelectedDepartment(department);
    isEditModalOpen.value = true;
};

const openDeleteModal = (department) => {
    departmentStore.setSelectedDepartment(department);
    isDeleteModalOpen.value = true;
};




const closeModal = () => {
    isAddModalOpen.value = false;
    isEditModalOpen.value = false;
    isDeleteModalOpen.value = false;
    departmentStore.setSelectedDepartment(null);
};


const handleDeleteDepartment = () => {
    closeModal();
};

onMounted(() => {
    departmentStore.fetchDepartments();
});
</script>

<template>
    <AuthLayout>
        <div class="p-4 sm:p-6 lg:p-8 bg-gray-50 min-h-full relative">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Departments</h1>
                    <p class="text-sm text-gray-500 mt-1">Organize, view, and manage your company's departments.</p>
                </div>
                <button @click="openAddModal"
                    class="mt-4 sm:mt-0 inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path
                            d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    Add Department
                </button>
            </div>

            <!-- Loading State -->
            <template v-if="!isLoading">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <template v-for="department in departments" :key="department.id">
                        <Card :department="department">
                            <template #actions>
                                <div class="flex  items-center justify-end gap-2 p-2">
                                    <button @click="openEditModal(department)"
                                        class="text-blue-500"><PencilIcon class="w-5 h-5" /></button>
                                    <button @click="openDeleteModal(department)"
                                        class="text-red-500"><TrashIcon class="w-5 h-5" /></button>
                                </div>
                            </template>
                        </Card>
                    </template>
                </div>
                <Paginate :pagination="pagination" />
            </template>
            <template v-else>
                <Loader />
            </template>
        </div>

        <!-- Modals -->
        <Modal :isOpen="isAddModalOpen" @close="closeModal">
            <template #header>
                <h2 class="text-lg font-medium text-gray-900">Add New Department</h2>
            </template>
            <template #body>
                <DepartmentForm :department="department" @close="closeModal" />
            </template>
            <template #footer>
                <div>

                </div>
            </template>
        </Modal>

        <Modal :isOpen="isEditModalOpen" @close="closeModal">
            <template #header>
                <h2 class="text-lg font-medium text-gray-900">Edit Department</h2>
            </template>
            <template #body>
                <DepartmentForm :department="department" @close="closeModal" />
            </template>
            <template #footer>
                <div>

                </div>
            </template>
        </Modal>

        <Modal :isOpen="isDeleteModalOpen" @close="closeModal">
            <template #header>Delete Department</template>
            <template #body>
                <p v-if="selectedDepartment">Are you sure you want to delete the <strong>{{ selectedDepartment.name
                }}</strong> department? This action cannot be undone.</p>
            </template>
            <template #footer>
                <button @click="closeModal" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                <button @click="handleDeleteDepartment" class="px-4 py-2 text-white bg-red-600 rounded">Delete</button>
            </template>
        </Modal>

        <!-- You would have a similar modal for editing -->

    </AuthLayout>
</template>
