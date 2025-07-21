<script setup>
import { UserGroupIcon } from '@heroicons/vue/24/outline'
const props = defineProps({
    stat: {
        type: Object,
        required: true,
        default: () => ({
            name: '',
            value: '',
            change: '',
            changeType: '',
            icon: UserGroupIcon,
            color: 'bg-blue-100 text-blue-600',
        }),
    },
});

</script>


<template>
    <div class="bg-white p-6 rounded-xl shadow-md flex flex-col justify-between">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-full" :class="props.stat.color">
                <component :is="props.stat.icon" class="h-6 w-6" />
            </div>
            <span class="text-sm font-semibold"
                :class="props.stat.changeType === 'increase' ? 'text-green-600' : 'text-red-600'">
                {{ props.stat.change }}
            </span>
        </div>
        <div>
            <p class="text-gray-500 text-sm">{{ props.stat.name }}</p>
            <p class="text-2xl font-bold text-gray-900">{{ props.stat.value }}</p>
        </div>
    </div>
</template>
