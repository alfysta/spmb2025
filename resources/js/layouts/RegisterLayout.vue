<script setup lang="ts">
import RegisterLayout from '@/layouts/auth/AuthRegisterLayout.vue';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <RegisterLayout :title="title" :description="description">
        <slot />
    </RegisterLayout>
</template>
