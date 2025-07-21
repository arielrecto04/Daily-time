<script setup>
import { ref, watch } from 'vue';
import { useRouter } from 'vue-router';
import { BuildingLibraryIcon, UserGroupIcon, ClockIcon, CalendarDaysIcon, PaperAirplaneIcon, CogIcon, ChevronDoubleDownIcon, ChevronDoubleUpIcon } from '@heroicons/vue/24/outline'

// const currentPath = ref('/dashboard');

// const mockRouter = {
//   currentRoute: {
//     value: {
//       path: currentPath,
//     }
//   },
//   push: (path) => {
//     currentPath.value = path;
//   }
// };

const submenuParentIndex = ref(null);

const router = useRouter();
const menu = ref([
    {
        name: 'Dashboard',
        href: '/dashboard',
        icon: BuildingLibraryIcon,
        isActive: false,
        children: []
    },
    {
        name: 'Users',
        href: '/users',
        icon: UserGroupIcon,
        isActive: false,
        children: []
    },
    {
        name: 'Time Record',
        href: '/time-record',
        icon: ClockIcon,
        isActive: false,
        children: []
    },
    {
        name: 'Attendance',
        href: '/attendance',
        icon: CalendarDaysIcon,
        isActive: false,
        children: []
    },
    {
        name: 'Leave Application',
        href: '/leave-application',
        icon: PaperAirplaneIcon,
        isActive: false,
        children: []
    },
    {
        name: 'Departments',
        href: '/departments',
        icon: BuildingLibraryIcon,
        isActive: false,
        children: []
    },
    {
        name: 'Settings',
        href: '/settings',
        icon: CogIcon,
        isActive: false,
        children: [{
            name: 'Leave Type',
            href: '/settings/leave-types',
            icon: PaperAirplaneIcon,
            isActive: false
        }]
    },
]);


const submenuAction = (index) => {
    submenuParentIndex.value = submenuParentIndex.value === index ? null : index;
};


const updateMenu = () => {
    menu.value = menu.value.map((item) => {
        item.isActive = item.href === router.currentRoute.value.path;
        return item;
    });
};

updateMenu();
watch(() => router.currentRoute.value.path, () => {
    updateMenu();
}, { deep: true });

</script>

<template>
    <div class="flex flex-col h-screen w-64 bg-white border-r border-gray-200">

        <div class="flex items-center justify-start h-20 px-6 border-b border-gray-200">
            <a href="#" class="text-2xl font-bold text-blue-600">TimeFlow</a>
        </div>
        <nav class="flex-grow px-4 py-6">
            <ul class="flex flex-col space-y-2">
                <li v-for="item in menu" :key="item.name">

                    <router-link :to="item.href"
                        class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200" :class="{
                            'bg-blue-50 text-blue-600 font-semibold': item.isActive,
                            'text-gray-600 hover:bg-gray-100 hover:text-gray-900': !item.isActive
                        }">


                        <div class="flex items-center grow">
                            <span class="w-8 text-center">
                                <component :is="item.icon" class="w-6 h-6" />
                            </span>
                            <span class="ml-2">{{ item.name }}</span>
                        </div>
                        <button @click="submenuAction(item.index)" class="ml-2" v-if="item.children.length > 0">
                            <ChevronDoubleUpIcon v-if="submenuParentIndex === item.index" class="w-6 h-6" />
                            <ChevronDoubleDownIcon v-else class="w-6 h-6" />
                        </button>

                    </router-link>
                    <transition name="fade" mode="out-in" enter-active-class="transition duration-300 ease-in"
                        leave-active-class="transition duration-400 ease-out opacity-0"
                        enter-from-class="opacity-0" leave-to-class="opacity-0">
                        <ul v-if="item.children.length > 0" class="ml-4" v-show="submenuParentIndex === item.index">
                            <li v-for="child in item.children" :key="child.name">
                                <router-link :to="child.href"
                                    class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200"
                                    :class="{
                                        'bg-blue-50 text-blue-600 font-semibold': child.isActive,
                                        'text-gray-600 hover:bg-gray-100 hover:text-gray-900': !child.isActive
                                    }">
                                    <span class="w-8 text-center">
                                        <component :is="child.icon" class="w-6 h-6" />
                                    </span>
                                    <span class="ml-2">{{ child.name }}</span>
                                </router-link>
                            </li>
                        </ul>
                    </transition>
                </li>
            </ul>
        </nav>
        <div class="px-4 py-5 border-t border-gray-200">
            <div class="flex items-center">
                <img class="h-10 w-10 rounded-full object-cover"
                    src="https://placehold.co/100x100/e2e8f0/334155?text=AV" alt="User avatar">
                <div class="ml-3">
                    <p class="text-sm font-semibold text-gray-800">Alex Ray</p>
                    <a href="#" class="text-xs text-gray-500 hover:text-blue-600">View profile</a>
                </div>
                <button class="ml-auto p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-gray-800">
                    <i class="fa fa-rr-sign-out-alt"></i>
                </button>
            </div>
        </div>
    </div>
</template>
