<script setup>
import { DropDown } from '@/components'

const props = defineProps({
    department: {
        type: Object,
        required: true,
    },
});


</script>


<template>
    <div :key="department.id"
        class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col">
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <div class="flex items-center">
                <span :style="{ backgroundColor: department.color }" class="w-3 h-3 rounded-full mr-3"></span>
                <h2 class="text-base font-semibold text-gray-800 truncate">{{ department.name }}</h2>
            </div>
        </div>
        <div class="p-4 flex-grow">
            <p class="text-sm text-gray-500">Department Head</p>
            <p class="text-sm font-medium text-gray-700">{{ department.head }}</p>
        </div>
        <div class="p-4 bg-gray-50 rounded-b-lg border-t">
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-4 h-4 mr-1.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
                    <path
                        d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.095a1.23 1.23 0 00.41-1.412A9.99 9.99 0 0010 12a9.99 9.99 0 00-6.535 2.493z" />
                </svg>
                <span>{{ department.members }} Members</span>
            </div>
        </div>
        <slot name="actions"></slot>    
    </div>
</template>
