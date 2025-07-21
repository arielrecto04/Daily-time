<script setup>
import { useLeaveTypeStore, useUsersStore, useAuthStore } from '@/stores'
import { storeToRefs } from 'pinia';
import { onMounted, ref } from 'vue';
import { PaperClipIcon, XMarkIcon } from '@heroicons/vue/24/outline'


const leaveTypeStore = useLeaveTypeStore();
const { leaveTypes } = storeToRefs(leaveTypeStore);
const { user } = storeToRefs(useAuthStore());

const usersStore = useUsersStore();
const { users } = storeToRefs(usersStore);


const leaveApplication = ref({
    leave_type_id: '',
    start_date: '',
    end_date: '',
    reason: '',
    status: 'pending',
    attachments: [],
    employee_id: user.value.id,
})

const isSubmitting = ref(false);

onMounted(() => {
    leaveTypeStore.fetchLeaveTypes();
    usersStore.fetchUsers();
})

const handleFileChange = (event) => {

    leaveApplication.value.attachments.push(...event.target.files);

}

const handleSubmit = () => {
    try {
        isSubmitting.value = true;
        leaveTypeStore.createLeaveApplication(leaveApplication.value);
    } catch (error) {
        console.log(error);
    } finally {
        isSubmitting.value = false;
    }
}

const removeAttachment = (index) => {
    leaveApplication.value.attachments.splice(index, 1);
}

const resetForm = () => {
    leaveApplication.value = {
        leave_type_id: '',
        start_date: '',
        end_date: '',
        reason: '',
        status: 'pending',
        attachments: [],
        employee_id: '',
    }
}

</script>

<template>
    <div class="px-4 sm:px-6 lg:px-8 pt-10 pb-6">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Create Leave Application</h1>
        <p class="mt-2 text-base text-gray-600">Create a new leave application to request time off from work.</p>

        <div class="p-6 sm:p-8 rounded-xl">
            <form @submit.prevent="handleSubmit" class="space-y-6">

                <!-- Leave Type & Dates -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="leave_type" class="block text-sm font-medium text-gray-700 mb-1">Leave Type</label>
                        <select id="leave_type" v-model="leaveApplication.leave_type_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option disabled value="">Select a type</option>

                            <option v-for="leaveType in leaveTypes" :key="leaveType.id" :value="leaveType.id">
                                {{ leaveType.name }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-1">Employee
                            ID</label>
                        <select id="employee_id" v-model="leaveApplication.employee_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option disabled value="">Select an employee</option>

                            <option :value="user.id" selected>
                                {{ user.name }}
                            </option>

                            <option v-for="user in users.filter((user) => user.id !== user.id)" :key="user.id"
                                :value="user.id">
                                {{ user.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" id="start_date" v-model="leaveApplication.start_date"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" id="end_date" v-model="leaveApplication.end_date"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <!-- Reason for Leave -->
                <div>
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                    <textarea id="reason" v-model="leaveApplication.reason" rows="6"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Please provide a brief reason for your leave..."></textarea>
                </div>

                <!-- File Attachment -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Attachment (Optional)</label>
                    <div v-if="!leaveApplication.attachment"
                        class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                viewBox="0 0 48 48" aria-hidden="true">
                                <path
                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="attachment"
                                    class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload a file</span>
                                    <input id="attachment" name="attachments[]" multiple type="file"
                                        @change="handleFileChange" class="sr-only">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, PDF up to 10MB</p>
                        </div>
                    </div>
                    <!-- File Preview -->
                    <template v-if="leaveApplication.attachments.length > 0">
                        <template v-for="attachment, index in leaveApplication.attachments" :key="attachment.name">
                            <div class="mt-2 flex items-center justify-between bg-gray-50 p-3 rounded-lg border">

                                <div class="flex items-center truncate">
                                    <PaperClipIcon class="h-5 w-5 text-gray-500 flex-shrink-0" />
                                    <span class="ml-2 text-sm font-medium text-gray-800 truncate">{{ attachment.name
                                        }}</span>
                                </div>
                                <button @click="removeAttachment(index)" type="button"
                                    class="ml-4 p-1 rounded-full hover:bg-gray-200">
                                    <XMarkIcon class="h-5 w-5 text-gray-600" />
                                </button>
                            </div>
                        </template>
                    </template>
                </div>

                <!-- Form Footer & Submit Button -->
                <div class="border-t border-gray-200 pt-5">
                    <div class="flex justify-end">
                        <router-link to="/leave-application" @click="resetForm" type="button"
                            class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Cancel
                        </router-link>
                        <button type="submit" :disabled="isSubmitting"
                            class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50">
                            <svg v-if="isSubmitting" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            {{ isSubmitting ? 'Submitting...' : 'Submit Application' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


</template>
