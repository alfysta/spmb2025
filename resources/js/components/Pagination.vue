<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({ links: Array });
</script>

<template>
    <div class="flex flex-wrap items-center gap-1">
        <template v-for="link in links" :key="link.label">
            <span v-if="!link.url" v-html="link.label" class="px-3 py-1 text-gray-500" />
            <Link
                v-else
                :href="link.url"
                v-html="link.label"
                class="rounded border px-3 py-1 hover:bg-gray-100"
                :class="{ 'bg-blue-600 text-white': link.active }"
            />
        </template>
    </div>
</template>
