<script setup lang="ts">
import DataTable from '@/Components/DataTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    users: Object,
    filters: Object,
});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Data Users',
        href: '/users',
    },
];
</script>

<template>
    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl md:min-h-min">
                <DataTable
                    :data="users"
                    :search="filters.search"
                    :per-page="filters.per_page"
                    route-name="users.index"
                    search-placeholder="Cari nama atau NISN"
                >
                    <template #default="{ data, from }">
                        <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                            <thead class="bg-card text-xs text-gray-700 uppercase dark:bg-gray-600 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-3 py-3">No</th>
                                    <th scope="col" class="px-3 py-3">Nama dan Email</th>
                                    <th scope="col" class="px-3 py-3">NISN</th>
                                    <th scope="col" class="px-3 py-3">Tempat Tanggal Lahir</th>
                                    <th scope="col" class="px-3 py-3">Status</th>
                                    <th scope="col" class="px-3 py-3">Created at</th>
                                    <th scope="col" class="px-3 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(user, index) in data"
                                    :key="user.id"
                                    class="dark:bg-card border-b border-gray-200 bg-white hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-100"
                                >
                                    <td class="px-3 py-2">{{ from + index }}</td>
                                    <th scope="row" class="flex items-center px-3 py-2 whitespace-nowrap text-gray-900 dark:text-white">
                                        <img v-if="user.image" class="h-10 w-10 rounded-full" :src="/storage/ + user.image" alt="{{ user.name }}" />
                                        <img v-else="user.image" class="h-10 w-10 rounded-full" src="/images/avatar.png" alt="{{ user.name }}" />
                                        <div class="ps-3">
                                            <div class="text-base font-semibold">{{ user.name }}</div>
                                            <div class="font-normal text-gray-500">{{ user.email }}</div>
                                        </div>
                                    </th>
                                    <td class="px-3 py-2">{{ user.nisn }}</td>
                                    <td class="px-3 py-2">
                                        <div class="flex items-center">
                                            <div class="me-2 h-2.5 w-2.5 rounded-full bg-green-500"></div>
                                            {{ user.tempat_lahir }}, {{ formatDate(user.tanggal_lahir) }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-2">
                                        <div class="flex items-center">
                                            <div class="me-2 h-2.5 w-2.5 rounded-full bg-green-500"></div>
                                            {{ user.status == 1 ? 'admin' : 'siswa' }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-2">{{ formatDate(user.created_at) }}</td>

                                    <td class="px-3 py-2">
                                        <a href="#" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Edit user</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </template>
                </DataTable>
            </div>
        </div>
    </AppLayout>
</template>
