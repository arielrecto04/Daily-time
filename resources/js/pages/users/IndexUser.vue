<script setup>

import { ref, onMounted, watch } from 'vue';
import { PencilIcon, TrashIcon, UserPlusIcon, UserCircleIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import { AuthLayout } from '@/layouts';
import { UserForm, Table, Button, Modal, Loader, Paginate, BadgeStatus, PopOver } from '@/components'
import { useUsersStore, useDepartmentStore } from '@/stores';
import { storeToRefs } from 'pinia';
import { useToast } from '@/utils';

const usersStore = useUsersStore();
const { users, isLoading, error, pagination, user, status } = storeToRefs(usersStore);

const departmentStore = useDepartmentStore();
const { departments } = storeToRefs(departmentStore);

const { showToast } = useToast();

const addUserModal = ref(false);
const editUserModal = ref(false);
const deleteUserModal = ref(false);
const statusLoading = ref(false);
const isDepartmentOptionOpen = ref(false);




const addUserModalAction = () => {
    addUserModal.value = !addUserModal.value;
}

const editUserModalAction = () => {
    editUserModal.value = !editUserModal.value;
}

const deleteUserModalAction = () => {
    deleteUserModal.value = !deleteUserModal.value;
}

onMounted(() => {
    usersStore.fetchUsers();
    departmentStore.fetchDepartments();
})




// Table columns configuration
const columns = [
    {
        key: 'name',
        label: 'User',
        sortable: true,

    },
    {
        key: 'email',
        label: 'Email',
        sortable: true,
    },
    {
        key: 'department',
        label: 'Department',

    },
    {
        key: 'role',
        label: 'Role',

    },
    {
        key: 'status',
        label: 'Status',
    },
    {
        key: 'lastActive',
        label: 'Last Active',
    }
];




const formatDate = (dateString) => {
    const options = {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return new Date(dateString).toLocaleDateString('en-US', options);
};

// Handle actions
const handleEdit = (_user) => {
    console.log('Edit user:', _user.id);
    usersStore.selectUser(_user);
    editUserModalAction();
    // In a real app, this would open an edit modal or navigate to edit page
};

const handleDelete = (user) => {
    usersStore.selectUser(user);
    deleteUserModalAction();
};

const handleDeleteUser = () => {
    usersStore.deleteUser();
    deleteUserModalAction();
};

const toggleStatus = async (user, status) => {

    try {

        statusLoading.value = true;
        usersStore.selectUser(user);
        await usersStore.toggleStatus(status);
        showToast({
            icon: 'success',
            title: 'Status updated successfully'
        });
    } catch (error) {
        console.log(error);
        showToast({
            icon: 'error',
            title: 'Failed to update status'
        });
    } finally {
        statusLoading.value = false;
    }
};


const handleDepartmentSelect = (department) => {
    usersStore.selectUser(department);
    isDepartmentOptionOpen.value = !isDepartmentOptionOpen.value;
}

const updateDepartment = async (department, user) => {

    console.log(department, user);
    try {
        usersStore.selectUser(user);
        await usersStore.updateDepartment(department);
        isDepartmentOptionOpen.value = false;
        showToast({
            icon: 'success',
            title: 'Department updated successfully'
        });
    } catch (error) {
        console.log(error);
        showToast({
            icon: 'error',
            title: 'Failed to update department'
        });
    }
}


</script>

<template>
    <AuthLayout>
        <div class="px-4 py-6 sm:px-6 lg:px-8 relative">
            <!-- Page header -->
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        A list of all users including their details and account status.
                    </p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <Button @click="addUserModalAction" variant="primary">
                        <UserPlusIcon class="h-4 w-4 mr-2" />
                        Add User
                    </Button>
                </div>
            </div>

            <!-- Stats cards -->
            <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Total Users -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <UserCircleIcon class="h-6 w-6 text-white" />
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">{{ users?.length }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Users -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <UserCircleIcon class="h-6 w-6 text-white" />
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Active Users</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">
                                            {{ users.length }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inactive Users -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gray-400 rounded-md p-3">
                                <UserCircleIcon class="h-6 w-6 text-white" />
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Inactive Users</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">
                                            {{ users.length }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Suspended Users -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <UserCircleIcon class="h-6 w-6 text-white" />
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Suspended Users</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">
                                            {{ users.length }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User table -->
            <div class="mt-8 bg-white shadow rounded-lg overflow-hidden p-2 flex flex-col gap-2">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">All Users</h3>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="Search users...">
                        </div>
                    </div>
                </div>

                <Table v-if="!isLoading" :columns="columns" :rows="users" :per-page="5" class="min-h-[400px]">
                    <template #cell(name)="{ row }">

                        <div class="flex items-center gap-2">
                            <img :src="row.profile?.image_url || `https://placehold.co/128x128/E0E7FF/4F46E5?name=${row.name}`"
                                alt="" srcset="" class="w-12 h-12 rounded-full object-cover">
                            <span>{{ row.name }}</span>
                        </div>

                    </template>
                    <template #cell(status)="{ row }">
                        <BadgeStatus :text="row.status" :variant="row.status === 'active' ? 'success' : 'danger'" />
                    </template>
                    <template #cell(department)="{ row }">
                        <button v-if="!isDepartmentOptionOpen" @dblclick="handleDepartmentSelect(row)" class="hover:bg-blue-100 px-2 w-24 hover:cursor-pointer hover:font-semibold hover:scale-110 transition-all duration-300 text-center py-1 rounded">{{
                            row.department?.name || 'N/A' }}</button>
                        <template v-if="isDepartmentOptionOpen">
                            <div class="flex items-center gap-2">
                                <PopOver :options="departments" @option-selected="updateDepartment($event, row)" />
                                <button @click="isDepartmentOptionOpen = false" class="hover:bg-blue-100 px-2 py-1 rounded">
                                    <XMarkIcon class="h-4 w-4 text-gray-400 hover:text-red-500" />
                                </button>
                            </div>
                        </template>
                    </template>
                    <template #actions="{ row }">
                        <div class="flex justify-end space-x-2">
                            <template v-if="row.status === 'active'">
                                <Button size="xs" variant="light" @click="toggleStatus(row, status.inactive)">


                                    <svg v-if="!statusLoading" class="h-4 w-4 text-green-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>

                                    <span v-else class="loader">
                                        <svg class="animate-spin h-4 w-4 text-green-600" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                </Button>
                            </template>
                            <template v-else>
                                <Button size="xs" variant="light" @click="toggleStatus(row, status.active)">

                                    <svg v-if="!statusLoading" class="h-4 w-4 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <span v-else class="loader">
                                        <svg class="animate-spin h-4 w-4 text-gray-400" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                </Button>
                            </template>
                            <Button size="xs" variant="light" @click="handleEdit(row)" title="Edit User">
                                <PencilIcon class="h-4 w-4 text-blue-600" />
                            </Button>
                            <Button size="xs" variant="light" @click="handleDelete(row)" title="Delete User">
                                <TrashIcon class="h-4 w-4 text-red-600" />
                            </Button>
                        </div>
                    </template>
                </Table>
                <Loader v-if="isLoading" />

                <Paginate v-if="pagination && pagination.last_page > 1" :totalPages="pagination.last_page"
                    :currentPage="pagination.current_page" :totalItems="pagination.total"
                    @page-changed="onPageChange" />
            </div>
        </div>
    </AuthLayout>


    <Modal :isOpen="addUserModal" @close="addUserModalAction" :maxWidth="'2xl'" :height="'h-[calc(100vh-4rem)]'">
        <template #header>
            <h3 class="text-lg font-medium leading-6 text-gray-900">Add User</h3>
        </template>
        <template #body>
            <UserForm @close="addUserModalAction" />
        </template>
        <!-- <template #footer>
            <Button variant="primary" @click="addUserModalAction">Close</Button>
        </template> -->
    </Modal>


    <Modal :isOpen="editUserModal" @close="editUserModalAction" :maxWidth="'2xl'" :height="'h-[calc(100vh-4rem)]'">

        <template #header>
            <h3 class="text-lg font-medium leading-6 text-gray-900">Edit User</h3>
        </template>

        <template #body>
            <UserForm :user="user" @close="editUserModalAction" />
        </template>

        <template #footer>
            <Button variant="primary" @click="editUserModalAction">Close</Button>
        </template>
    </Modal>


    <Modal :isOpen="deleteUserModal" @close="deleteUserModalAction">
        <template #header>
            <h3 class="text-lg font-medium leading-6 text-gray-900">Delete User</h3>
        </template>
        <template #body>
            <p>Are you sure you want to delete this user?</p>
        </template>
        <template #footer>
            <Button variant="danger" @click="handleDeleteUser()">Delete</Button>
            <Button variant="primary" @click="deleteUserModalAction">Close</Button>
        </template>
    </Modal>

</template>

<style scoped>
/* Custom styles if needed */
</style>
