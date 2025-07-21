<script setup>
import { ref, computed } from 'vue';
import { useDepartmentStore } from '@/stores';
import { storeToRefs } from 'pinia';
import { useToast } from '@/utils'

const departmentStore = useDepartmentStore();

const { isLoading, error } = storeToRefs(departmentStore);

const emit = defineEmits([
    'close',
]);


const isSubmitting = ref(false);

const props = defineProps({
    department: {
        type: Object,
        required: true,
        default: () => ({
            name: '',
            description: '',
            status: '',
            color: '',
        }),
    },
});


const departmentForm = ref({
    id: props.department?.id || '',
    name: props.department?.name || '',
    description: props.department?.description || '',
    status: props.department?.status || '',
    color: props.department?.color || '',
});



const isDirty = computed(() => {
    return JSON.stringify(departmentForm.value) !== JSON.stringify(props.department);
});


const submitForm = async () => {
    try {
        isSubmitting.value = true;
        if (props.department?.id) {
            await departmentStore.updateDepartment(props.department.id, departmentForm.value);
            useToast('success', 'Department updated successfully');
            emit('close');
            return;
        }

        await departmentStore.storeDepartment(departmentForm.value);
        useToast('success', 'Department added successfully');
        emit('close');

    } catch (error) {
        console.error(error);
        useToast('error', 'Failed to add department');
    } finally {
        isSubmitting.value = false;
    }
};



</script>


<template>
    <div class="flex flex-col gap-4">
        <form @submit.prevent="submitForm" ref="form" class="flex flex-col gap-4">
            <div class="flex flex-col gap-2">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="mt-1 p-2 block w-full rounded-md border-gray-300"
                    v-model="departmentForm.name">
            </div>
            <div class="flex flex-col gap-2">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="mt-1 p-2 block w-full rounded-md border-gray-300"
                    v-model="departmentForm.description"></textarea>
            </div>
            <div class="flex flex-col gap-2">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" class="mt-1 p-2 block w-full rounded-md border-gray-300"
                    v-model="departmentForm.status">
                    <option value="">Select Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="flex flex-col gap-2">
                <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                <input type="color" id="color" name="color" class="mt-1 block w-full rounded-md border-gray-30"
                    v-model="departmentForm.color">
            </div>
            <template v-if="isDirty">
                <button type="submit" class="px-4 py-2 text-white bg-indigo-600 rounded w-full"
                    :disabled="isSubmitting">Submit</button>
            </template>
        </form>
    </div>
</template>
