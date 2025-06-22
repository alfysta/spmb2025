<script setup lang="ts">
import { type LucideIcon } from 'lucide-vue-next';

import { SidebarGroup, SidebarMenu, SidebarMenuButton, SidebarMenuItem, useSidebar } from '@/components/ui/sidebar';

import { type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

defineProps<{
    projects: {
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
            <SidebarMenuItem v-for="item in projects" :key="item.name">
                <SidebarMenuButton as-child :is-active="item.url === page.url">
                    <Link :href="item.url">
                        <component :is="item.icon" />
                        <span>{{ item.name }}</span>
                    </Link>
                </SidebarMenuButton>
                <!-- <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <SidebarMenuAction show-on-hover>
                            <MoreHorizontal />
                            <span class="sr-only">More</span>
                        </SidebarMenuAction>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent class="w-48 rounded-lg" :side="isMobile ? 'bottom' : 'right'" :align="isMobile ? 'end' : 'start'">
                        <DropdownMenuItem>
                            <Folder class="text-muted-foreground" />
                            <span>View Project</span>
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                            <Forward class="text-muted-foreground" />
                            <span>Share Project</span>
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem>
                            <Trash2 class="text-muted-foreground" />
                            <span>Delete Project</span>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu> -->
            </SidebarMenuItem>
            <!-- <SidebarMenuItem>
                <SidebarMenuButton class="text-sidebar-foreground/70">
                    <MoreHorizontal class="text-sidebar-foreground/70" />
                </SidebarMenuButton>
            </SidebarMenuItem> -->
        </SidebarMenu>
    </SidebarGroup>
</template>
