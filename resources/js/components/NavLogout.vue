<script setup lang="ts">
import { type LucideIcon } from 'lucide-vue-next';

import { SidebarGroup, SidebarMenu, SidebarMenuButton, SidebarMenuItem, useSidebar } from '@/components/ui/sidebar';

import { type SharedData } from '@/types';
import { Link, router, usePage } from '@inertiajs/vue3';

const handleLogout = () => {
    router.flushAll();
};

defineProps<{
    logout: {
        name: string;
        url: string;
        icon: LucideIcon;
        isActive?: boolean;
    }[];
}>();

const page = usePage<SharedData>();

const { isMobile } = useSidebar();
</script>

<template>
    <SidebarGroup class="group-data-[collapsible=icon]:hidden">
        <SidebarMenu>
            <SidebarMenuItem v-for="item in logout" :key="item.name">
                <SidebarMenuButton as-child :is-active="item.url === page.url">
                    <Link :href="item.url" method="post" @click="handleLogout" as="button">
                        <component :is="item.icon" />
                        <span>{{ item.name }}</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
