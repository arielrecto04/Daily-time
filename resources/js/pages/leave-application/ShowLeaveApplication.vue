<script setup>
import { ref, onMounted } from 'vue';
import { useLeaveApplicationStore } from '@/stores/useLeaveApplicationStore';
import { storeToRefs } from 'pinia';
import { useRoute } from 'vue-router';
import { PaperClipIcon, ClockIcon, CalendarIcon, UserIcon } from '@heroicons/vue/24/outline';
import moment from 'moment';

const route = useRoute();
const leaveApplicationStore = useLeaveApplicationStore();
const { leaveApplication, isLoading } = storeToRefs(leaveApplicationStore);

const statusColors = {
  pending: 'bg-yellow-100 text-yellow-800',
  approved: 'bg-green-100 text-green-800',
  rejected: 'bg-red-100 text-red-800'
};

onMounted(async () => {
  await leaveApplicationStore.fetchLeaveApplication(route.params.id);
});
</script>

<template>
  <div class="w-full">
    <div v-if="isLoading || !leaveApplication" class="flex justify-center items-center h-64">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
    </div>

    <div v-else class="bg-white rounded-lg shadow">
      <!-- Header Section -->
      <div class="border-b border-gray-200 px-6 py-4">
        <div class="flex justify-between items-start">
          <div>
            <h2 class="text-2xl font-bold text-gray-900">Leave Application Details</h2>
            <p class="mt-1 text-sm text-gray-500">
              Submitted on {{ moment(leaveApplication?.created_at).format('MMMM D, YYYY') }}
            </p>
          </div>
          <span :class="[
            statusColors[leaveApplication?.status],
            'px-3 py-1 rounded-full text-sm font-medium capitalize'
          ]">
            {{ leaveApplication?.status }}
          </span>
        </div>
      </div>

      <!-- Content Section -->
      <div class="px-6 py-4">
        <!-- Applicant Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <div class="space-y-4">
            <div>
              <div class="flex items-center mb-2">
                <UserIcon class="h-5 w-5 text-gray-400 mr-2" />
                <h3 class="text-sm font-medium text-gray-500">Applicant</h3>
              </div>
              <p class="text-base font-medium text-gray-900">{{ leaveApplication?.name }}</p>
            </div>
            <div>
              <div class="flex items-center mb-2">
                <ClockIcon class="h-5 w-5 text-gray-400 mr-2" />
                <h3 class="text-sm font-medium text-gray-500">Leave Type</h3>
              </div>
              <p class="text-base font-medium text-gray-900">{{ leaveApplication?.leave_type?.name }}</p>
            </div>
          </div>

          <div class="space-y-4">
            <div>
              <div class="flex items-center mb-2">
                <CalendarIcon class="h-5 w-5 text-gray-400 mr-2" />
                <h3 class="text-sm font-medium text-gray-500">Duration</h3>
              </div>
              <p class="text-base font-medium text-gray-900">
                {{ moment(leaveApplication?.start_date).format('MMMM D, YYYY') }} -
                {{ moment(leaveApplication?.end_date).format('MMMM D, YYYY') }}
              </p>
              <p class="text-sm text-gray-500 mt-1">
                Total Days: {{ leaveApplication?.total_days }}
              </p>
            </div>
          </div>
        </div>

        <!-- Description -->
        <div class="mb-6">
          <h3 class="text-sm font-medium text-gray-500 mb-2">Description</h3>
          <div class="prose max-w-none mt-2" v-html="leaveApplication?.descriptions"></div>
        </div>

        <!-- Attachments -->
        <div v-if="leaveApplication?.attachments?.length">
          <h3 class="text-sm font-medium text-gray-500 mb-2">Attachments</h3>
          <ul class="divide-y divide-gray-200 border border-gray-200 rounded-lg">
            <li v-for="attachment in leaveApplication?.attachments ?? []" :key="attachment?.id"
                class="flex items-center justify-between py-3 px-4 hover:bg-gray-50">
              <div class="flex items-center">
                <PaperClipIcon class="h-5 w-5 text-gray-400" />
                <span class="ml-2 text-sm text-gray-900">{{ attachment?.name }}</span>
              </div>
              <button class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                Download
              </button>
            </li>
          </ul>
        </div>

        <!-- Approval Timeline -->
        <!-- <div class="mt-8">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Approval Timeline</h3>
          <div class="flow-root">
            <ul class="-mb-8">
              <li v-for="(event, index) in leaveApplication?.approval_history ?? []" :key="index">
                <div class="relative pb-8">
                  <span v-if="index !== leaveApplication?.approval_history?.length - 1"
                        class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                        aria-hidden="true"></span>
                  <div class="relative flex space-x-3">
                    <div>
                      <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                        <UserIcon class="h-5 w-5 text-white" />
                      </span>
                    </div>
                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                      <div>
                        <p class="text-sm text-gray-500">
                          {{ event.action }} by <span class="font-medium text-gray-900">{{ event.user }}</span>
                        </p>
                      </div>
                      <div class="text-sm text-gray-500">
                        <time>{{ moment(event.date).format('MMM D, YYYY') }}</time>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div> -->
      </div>

      <!-- Actions Footer -->
      <!-- <div class="border-t border-gray-200 px-6 py-4">
        <div class="flex justify-end space-x-3">
          <router-link
            to="/leave-application"
            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
          >
            Back to List
          </router-link>
          <button
            v-if="leaveApplication.status === 'pending'"
            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"
          >
            Edit Application
          </button>
        </div>
      </div> -->
    </div>
  </div>
</template>


