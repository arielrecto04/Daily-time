<script setup>
import { ref } from 'vue';
import { AuthLayout } from '@/Layouts';
import { UserGroupIcon, ArrowLeftIcon, PlusCircleIcon } from '@heroicons/vue/24/outline'
import { Card2 } from '@/components'
const stats = ref([
    { name: 'Total Leave Days', value: '15', change: '+2.5%', changeType: 'increase', icon: UserGroupIcon, color: 'bg-blue-100 text-blue-600' },
    { name: 'Used Leave Days', value: '8', change: '+1.2%', changeType: 'increase', icon: UserGroupIcon, color: 'bg-green-100 text-green-600' },
    { name: 'Remaining Leave Days', value: '7', change: '-0.5%', changeType: 'decrease', icon: UserGroupIcon, color: 'bg-red-100 text-red-600' },
    { name: 'Pending Approvals', value: '3', change: '+2', changeType: 'increase', icon: UserGroupIcon, color: 'bg-yellow-100 text-yellow-600' },
]);

const quickActions = [
    { name: 'Apply for Leave', icon: 'plus-circle', route: '/leave-application/apply', },
    { name: 'Leave Balance', icon: 'scale', route: '/leave-application/balance' },
    { name: 'Leave Policy', icon: 'document-text', route: '/leave-application/policy' },
    { name: 'Team Calendar', icon: 'calendar', route: '/leave-application/calendar' },
];

</script>

<template>
    <AuthLayout>
        <div class="min-h-screen w-full ">
            <!-- Header -->
            <div class="px-4 sm:px-6 lg:px-8 pt-10 pb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Leave Management</h1>
                        <p class="mt-2 text-base text-gray-600">Manage your leave requests, balance, and policies in one
                            place.</p>
                    </div>
                    <div>
                        <template v-if="$route.path === '/leave-application/list'">
                            <router-link to='/leave-application/create'
                                class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                <PlusCircleIcon class="w-5 h-5 mr-2" />
                                Apply for Leave
                            </router-link>
                        </template>
                        <template v-else>
                            <router-link to='/leave-application'
                                class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                <ArrowLeftIcon class="w-5 h-5 mr-2" />
                                Back
                            </router-link>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-10">
                    <Card2 v-for="stat in stats" :key="stat.name" :stat="stat" :color="stat.color" />
                </div>
            </div>

            <!-- Main Content Grid -->


            <!-- Router View for Child Pages -->
            <main class="px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow rounded-xl border border-gray-100 min-h-[400px] p-6">
                    <router-view />
                </div>
            </main>

        </div>
    </AuthLayout>
</template>

<style scoped>
.fas {
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
}
</style>
