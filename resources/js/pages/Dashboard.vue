<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl md:min-h-min">
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <div class="bg-card text-card-foreground rounded-xl border shadow">
                        <div class="flex flex-row items-center justify-between space-y-0 gap-y-1.5 p-6 pb-2">
                            <h3 class="text-sm font-medium tracking-tight">Total Revenue</h3>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth="2"
                                class="text-muted-foreground h-4 w-4"
                            >
                                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="text-2xl font-bold">$45,231.89</div>
                            <p class="text-muted-foreground text-xs">+20.1% from last month</p>
                        </div>
                    </div>
                    <div class="bg-card text-card-foreground rounded-xl border shadow">
                        <div class="flex flex-row items-center justify-between space-y-0 gap-y-1.5 p-6 pb-2">
                            <h3 class="text-sm font-medium tracking-tight">Subscriptions</h3>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth="2"
                                class="text-muted-foreground h-4 w-4"
                            >
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="text-2xl font-bold">+2350</div>
                            <p class="text-muted-foreground text-xs">+180.1% from last month</p>
                        </div>
                    </div>
                    <div class="bg-card text-card-foreground rounded-xl border shadow">
                        <div class="flex flex-row items-center justify-between space-y-0 gap-y-1.5 p-6 pb-2">
                            <h3 class="text-sm font-medium tracking-tight">Sales</h3>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth="2"
                                class="text-muted-foreground h-4 w-4"
                            >
                                <rect width="20" height="14" x="2" y="5" rx="2"></rect>
                                <path d="M2 10h20"></path>
                            </svg>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="text-2xl font-bold">+12,234</div>
                            <p class="text-muted-foreground text-xs">+19% from last month</p>
                        </div>
                    </div>
                    <div class="bg-card text-card-foreground rounded-xl border shadow">
                        <div class="flex flex-row items-center justify-between space-y-0 gap-y-1.5 p-6 pb-2">
                            <h3 class="text-sm font-medium tracking-tight">Active Now</h3>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth="2"
                                class="text-muted-foreground h-4 w-4"
                            >
                                <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                            </svg>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="text-2xl font-bold">+573</div>
                            <p class="text-muted-foreground text-xs">+201 since last hour</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                    <PlaceholderPattern />
                </div>
                <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                    <PlaceholderPattern />
                </div>
                <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                    <PlaceholderPattern />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
