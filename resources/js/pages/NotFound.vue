<script setup>
    import { useAuthStore } from '@/stores';
    import { AuthLayout, BaseLayout } from '@/layouts';
    import { NotFoundContent } from '@/components';
    const authStore = useAuthStore();
</script>


<template>
    <template v-if="authStore.isAuthenticated">
        <AuthLayout>
            <NotFoundContent />
        </AuthLayout>
    </template>
    <template v-else>
        <BaseLayout>
            <NotFoundContent />
        </BaseLayout>
    </template>
</template>
