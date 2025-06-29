<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

import Pagination from '@/Components/Pagination.vue';
import { usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    posts: Object,
    filters: Object,
});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};

// data offset (untuk nomor urut)
const offset = computed(() => (props.posts.current_page - 1) * props.posts.per_page);

const filters = ref({
    search: props.filters?.search || '',
    per_page: props.filters?.per_page || 10,
});

const getData = () => {
    router.get('/posts', filters.value, {
        preserveState: true,
        replace: true,
    });
};

const truncate = (text, length) => {
    if (!text) return '';
    return text.length > length ? text.slice(0, length) + '...' : text;
};

const destroy = (id) => {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: 'Data yang dihapus tidak bisa dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/posts/${id}`, {
                onSuccess: () => {
                    Swal.fire('Berhasil!', usePage().props.flash.success, 'success');
                },
                onError: () => {
                    Swal.fire('Oops!', 'Terjadi kesalahan.', 'error');
                },
            });
        }
    });
};
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Daftar Artikel',
        href: '/posts',
    },
];
</script>

<template>
    <Head title="Posts" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="mb-4 flex items-center justify-between">
                <h1 class="text-xl font-bold">Daftar Artikel</h1>

                <Link href="/posts/create" class="rounded-full bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"> + Tambah Artikel </Link>
            </div>

            <!-- Filter -->
            <div class="mb-4 flex flex-col gap-4 md:flex-row md:items-center">
                <input v-model="filters.search" @input="getData" type="text" placeholder="Cari judul..." class="input" />

                <select v-model="filters.per_page" @change="getData" class="input w-32">
                    <option value="10">10 / halaman</option>
                    <option value="25">25 / halaman</option>
                    <option value="50">50 / halaman</option>
                </select>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                    <thead class="bg-card text-xs text-gray-700 uppercase dark:bg-gray-600 dark:text-gray-400">
                        <tr>
                            <th class="px-3 py-3">#</th>
                            <th class="px-3 py-3">Judul</th>
                            <th class="px-3 py-3">Kategori</th>
                            <th class="px-3 py-3">Isi</th>
                            <th class="px-3 py-3">Created</th>
                            <th class="px-3 py-3">User</th>
                            <th class="px-3 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(post, index) in posts.data"
                            :key="post.id"
                            class="dark:bg-card border-b border-gray-200 bg-white hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-100"
                        >
                            <td class="px-3 py-2">{{ index + 1 + offset }}</td>
                            <td class="px-3 py-2">{{ truncate(post.title, 100) }}</td>
                            <td class="px-3 py-2">{{ post.category?.name }}</td>
                            <td class="px-3 py-2">{{ truncate(post.body, 100) }}</td>
                            <td class="px-3 py-2">{{ formatDate(post.created_at) }}</td>
                            <td class="px-3 py-2">{{ post.user?.name }}</td>
                            <td class="px-3 py-2">
                                <Link :href="`/posts/${post.id}/edit`" class="text-blue-600 hover:underline">Edit</Link>
                                <button @click="destroy(post.id)" class="text-red-600 hover:underline">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                <Pagination :links="posts.links" />
            </div>
        </div>
    </AppLayout>
</template>
