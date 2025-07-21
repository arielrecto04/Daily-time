<script setup>
import { SideBar } from '@/components';
import { HeaderBar } from '@/components';
</script>

<template>
    <div class="flex h-screen">
        <div class="w-64">
            <SideBar />
        </div>
        <div class="flex-1">
            <HeaderBar />
            <div class="p-5 flex flex-col gap-5 overflow-y-auto h-[calc(100vh-10rem)]">
                <slot />
            </div>
        </div>
    </div>
</template>
