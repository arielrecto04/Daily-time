<script setup>

import { ref } from 'vue';
import { useLeaveTypeStore } from '@/stores';
import { storeToRefs } from 'pinia';
import { useToast } from '@/utils';

const leaveTypeStore = useLeaveTypeStore();
const toast = useToast();
const { error} = storeToRefs(leaveTypeStore);
const { showToast } = toast;
const emit = defineEmits(['close']);

const props = defineProps({
    leaveType: {
        type: Object,
        required: true,
        default: () => ({
            name: '',
            descriptions: '',
            is_active: true,
            is_credited: true,
        }),
    },
});



const isSubmitting = ref(false);

const submitForm = async () => {
    try {
        isSubmitting.value = true;
        if (props.leaveType?.id) {
            await leaveTypeStore.updateLeaveType(props.leaveType.id, props.leaveType);
            showToast({ icon: 'success', title: 'Leave Type updated successfully' });
            emit('close');
            return;
        }

        await leaveTypeStore.storeLeaveType(props.leaveType);
        showToast({ icon: 'success', title: 'Leave Type added successfully' });
        emit('close');

    } catch (error) {
        showToast({ icon: 'error', title: error.response.data.message });
    } finally {
        isSubmitting.value = false;
    }
};


</script>

<template>
    <div class="flex flex-col gap-4">
        <form @submit.prevent="submitForm">
            <div class="flex flex-col gap-2">
                <label for="name">Name</label>
                <input type="text" id="name" v-model="props.leaveType.name"
                    class="mt-1 block outline-none p-2 focus:border-b focus:border-blue-500">
            </div>
            <div class="flex flex-col gap-2">
                <label for="description">Description</label>

                <textarea id="description" v-model="props.leaveType.descriptions"
                    class="mt-1 block outline-none p-2 focus:border-b focus:border-blue-500 h-32 focus:bg-blue-50"></textarea>
            </div>
            <div class="flex item-center gap-5">
                <div class="flex flex-col gap-2">
                    <label for="is_active" class="text-sm font-semibold cursor-pointer">Active</label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer" v-model="props.leaveType.is_active">
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>

                    </label>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="is_credited" class="text-sm font-semibold cursor-pointer">Credited</label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer" v-model="props.leaveType.is_credited">
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>

                    </label>
                </div>
            </div>

            <div class="flex gap-4 items-center">
                <button type="button" @click="$emit('close')" class="w-full px-4 py-2 mt-4 bg-gray-200 rounded hover:bg-gray-300 duration-700">Cancel</button>
                <button type="submit" :disabled="isSubmitting" class="w-full mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 duration-700">{{
                    isSubmitting ? 'Loading...' : 'Submit' }}</button>
            </div>
        </form>
    </div>
</template>
