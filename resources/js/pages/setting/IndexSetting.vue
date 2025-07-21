<script setup>
import { ref, computed, shallowRef } from 'vue';
import { UserCircleIcon, ShieldCheckIcon, BellIcon, Cog6ToothIcon, CreditCardIcon } from '@heroicons/vue/24/outline';
import { AuthLayout } from '@/layouts'; // Assuming you have this layout component



const settingsTabs = [
    { leaveType: 'Leave Type', href: '/settings/leave-type', icon: Cog6ToothIcon },
    { leaveType: 'Profile', href: '/settings/profile', icon: UserCircleIcon },
    { leaveType: 'Security', href: '/settings/security', icon: ShieldCheckIcon },
    { leaveType: 'Notification', href: '/settings/notification', icon: BellIcon },
    { leaveType: 'Payment', href: '/settings/payment', icon: CreditCardIcon },
];

const activeTab = shallowRef(settingsTabs[0]);

const selectTab = (tab) => {
  activeTab.value = tab;
};
</script>

<template>
  <AuthLayout>
    <div class="sm:p-6 lg:p-8 min-h-full">
      <div class="w-full h-full">

        <div class="mb-8">
          <h1 class="text-3xl font-bold text-gray-900">Settings</h1>
          <p class="text-sm text-gray-500 mt-1">Manage your account settings and preferences.</p>
        </div>

        <div class="flex flex-col gap-2 h-full">


          <aside class="">
            <nav class="space-y-1 flex items-center gap-2">
              <router-link
                v-for="tab in settingsTabs"
                :key="tab.leaveType"
                @click.prevent="selectTab(tab)"

                :class="[
                  'group flex items-center px-3 py-2 text-sm font-medium rounded-md border-b-2 transition-colors',
                  activeTab.leaveType === tab.leaveType
                    ? 'bg-indigo-50 border-indigo-600 text-indigo-700 hover:bg-indigo-100'
                    : 'border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-900'
                ]"
                :to="tab.href"
              >
                <component
                  :is="tab.icon"
                  :class="[
                    'mr-3 flex-shrink-0 h-6 w-6',
                    activeTab.leaveType === tab.leaveType ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500'
                  ]"
                  aria-hidden="true"
                />
                <span class="truncate">{{ tab.leaveType }}</span>
              </router-link>
            </nav>
          </aside>

          <main class="hover:bg-gray-50 transition-colors duration-200 p-6 rounded-lg shadow h-full overflow-auto">
                <router-view></router-view>
          </main>
        </div>
      </div>
    </div>
  </AuthLayout>
</template>

<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: opacity 0.2s ease, transform 0.2s ease;
}

.fade-slide-enter-from,
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(10px);
}
</style>
