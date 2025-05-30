<script setup lang="ts">
import type { SidebarProps } from '@/components/ui/sidebar';

import NavMain from '@/components/NavMain.vue';
import NavProjects from '@/components/NavProjects.vue';
import NavUser from '@/components/NavUser.vue';

import TeamSwitcher from '@/components/TeamSwitcher.vue';
import { BookOpen, Bot, Frame, GalleryVerticalEnd, Map, PieChart, Settings2, SquareTerminal } from 'lucide-vue-next';

import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarRail } from '@/components/ui/sidebar';

import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';

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
            name: 'Berkas Pendaftaran',
            url: '/pendaftaran',
            icon: PieChart,
        },
        {
            name: 'Travel',
            url: '#',
            icon: Map,
        },
    ],

    navMain: [
        {
            title: 'Dashboard',
            url: '#',
            icon: SquareTerminal,
            isActive: true,
            items: [
                {
                    title: 'History',
                    url: '#',
                },
                {
                    title: 'Starred',
                    url: '#',
                },
                {
                    title: 'Settings',
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
                {
                    title: 'Quantum',
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
                {
                    title: 'Get Started',
                    url: '#',
                },
                {
                    title: 'Tutorials',
                    url: '#',
                },
                {
                    title: 'Changelog',
                    url: '#',
                },
            ],
        },
        {
            title: 'Settings',
            url: '#',
            icon: Settings2,
            items: [
                {
                    title: 'General',
                    url: '#',
                },
                {
                    title: 'Team',
                    url: '#',
                },
                {
                    title: 'Billing',
                    url: '#',
                },
                {
                    title: 'Limits',
                    url: '#',
                },
            ],
        },
    ],
};
</script>

<template>
    <ScrollArea>
        <Sidebar v-bind="props">
            <SidebarHeader>
                <TeamSwitcher :teams="data.teams" />
            </SidebarHeader>
            <SidebarContent>
                <NavProjects :projects="data.projects" />
                <NavMain :items="data.navMain" />
            </SidebarContent>
            <SidebarFooter>
                <NavUser />
            </SidebarFooter>
            <SidebarRail />
        </Sidebar>
        <ScrollBar orientation="vertical" />
    </ScrollArea>
</template>
