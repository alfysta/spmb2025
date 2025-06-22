<script setup lang="ts">
import type { SidebarProps } from '@/components/ui/sidebar';

import NavLogout from '@/components/NavLogout.vue';
import NavMain from '@/components/NavMain.vue';
import NavProjects from '@/components/NavProjects.vue';
import NavUser from '@/components/NavUser.vue';

import TeamSwitcher from '@/components/TeamSwitcher.vue';
import { BookOpen, Bot, Frame, GalleryVerticalEnd, LogOut, Map, PieChart, Settings2, SquareTerminal } from 'lucide-vue-next';

import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarRail } from '@/components/ui/sidebar';
import { usePage } from '@inertiajs/vue3';
const page = usePage();

const props = withDefaults(defineProps<SidebarProps>(), {
    collapsible: 'icon',
});

// This is sample data.
const data = {
    teams: [
        {
            name: 'SPMB',
            logo: GalleryVerticalEnd,
            plan: '2025',
        },
    ],

    projects: [
        {
            name: 'Dashboard',
            url: '/dashboard',
            icon: Frame,
        },
        {
            name: 'Biodata',
            url: '/biodata',
            icon: PieChart,
        },
        {
            name: 'Berkas Persyaratan',
            url: '/persyaratan',
            icon: Map,
        },
    ],

    navMain: [
        {
            title: 'Dashboard',
            url: '#',
            icon: SquareTerminal,
            isActive: ['/users', '/settings'].includes(page.url) ? true : false,
            items: [
                {
                    title: 'Users',
                    url: '/users',
                },
                {
                    title: 'Starred',
                    url: '#',
                },
            ],
        },
        {
            title: 'Models',
            url: '#',
            icon: Bot,
            items: [
                {
                    title: 'Genesis',
                    url: '#',
                },
                {
                    title: 'Explorer',
                    url: '#',
                },
            ],
        },
        {
            title: 'Documentation',
            url: '#',
            icon: BookOpen,
            items: [
                {
                    title: 'Introduction',
                    url: '#',
                },
            ],
        },
        {
            title: 'Settings',
            url: '#',
            icon: Settings2,
            isActive: ['/settings/profile', '/settings/password', '/settings/appearance'].includes(page.url) ? true : false,
            items: [
                {
                    title: 'Profile',
                    url: '/settings/profile',
                },
                {
                    title: 'Password',
                    url: '/settings/password',
                },
                {
                    title: 'Appearance',
                    url: '/settings/appearance',
                },
            ],
        },
    ],

    logout: [
        {
            name: 'Logout',
            url: '/logout',
            icon: LogOut,
        },
    ],
};
</script>

<template>
    <Sidebar v-bind="props">
        <SidebarHeader>
            <TeamSwitcher :teams="data.teams" />
        </SidebarHeader>
        <SidebarContent>
            <NavProjects :projects="data.projects" />
            <NavMain :items="data.navMain" />
            <NavLogout :logout="data.logout" />
        </SidebarContent>
        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
        <SidebarRail />
    </Sidebar>
</template>
