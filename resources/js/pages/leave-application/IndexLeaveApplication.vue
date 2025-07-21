<script setup>
import { Table, Button } from '@/components';
import { PencilIcon, TrashIcon } from '@heroicons/vue/24/outline'
const columns = [
    { label: 'Name', key: 'name' },
    { label: 'Email', key: 'email' },
    { label: 'Role', key: 'role' },
];

const rows = [
    { name: 'John Doe', email: 'john@example.com', role: 'Admin' },
    { name: 'Jane Smith', email: 'jane@example.com', role: 'User' },
    { name: 'Bob Johnson', email: 'bob@example.com', role: 'Admin' },
];

const handleEdit = (row) => {
    console.log(row);
}

const handleDelete = (row) => {
    console.log(row);
}

</script>


<template>
    <Table :columns="columns" :rows="rows" >

        <template #actions="{ row }">
            <Button @click="handleEdit(row)" variant="primary">
                <PencilIcon class="w-5 h-5" />
            </Button>
            <Button @click="handleDelete(row)" variant="danger">
                <TrashIcon class="w-5 h-5" />
            </Button>
        </template>
    </Table>

</template>
