<script setup lang="ts">
import ToastEditor from '@/Components/ToastEditor.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import '@toast-ui/editor/dist/toastui-editor.css';
import axios from 'axios';
import { FileInput, LoaderCircle } from 'lucide-vue-next';
import Swal from 'sweetalert2';

defineProps({ categories: Array });

const form = useForm({
    title: '',
    body: '',
    category_id: '',
    thumbnails: '',
});

const uploadThumbnail = async (e) => {
    const file = e.target.files[0];
    if (!file) return;

    const data = new FormData();
    data.append('thumbnail', file);
    data.append('oldThumbnail', form.thumbnails);

    try {
        const res = await axios.post('/posts/upload-thumbnail', data);
        form.thumbnails = res.data.path;
        Swal.fire('Berhasil', 'Upload Thumbnails Berhasil', 'success');
    } catch (e) {
        Swal.fire('Error', 'Gagal upload gambar.', 'error');
    }
};

const submit = () => {
    form.post('/posts', {
        onSuccess: () => {
            Swal.fire('Sukses', 'Data berhasil disimpan', 'success');
        },
        onError: () => {
            Swal.fire('Gagal', 'Periksa kembali input Anda.', 'error');
        },
    });
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Daftar Artikel',
        href: '/posts',
    },
    {
        title: 'Create Artikel',
        href: '/posts/create',
    },
];
</script>

<template>
    <Head title="Post Create" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <ul class="mt-2 flex border-b">
                <li
                    class="flex-1 focus-visible:outline-none"
                    id="headlessui-tabs-tab-:r2:"
                    role="tab"
                    aria-selected="true"
                    tabindex="0"
                    data-headlessui-state="selected"
                    aria-controls="headlessui-tabs-panel-:r6:"
                    data-selected=""
                >
                    <span
                        class="text-primary !text-primary relative block appearance-none border border-transparent text-2xl font-bold dark:border-transparent dark:text-slate-400"
                        >Buat Artikel
                        <hr class="border-primary absolute -bottom-[2px] left-0 w-full border-b"
                    /></span>
                </li>
            </ul>
            <form @submit.prevent="submit">
                <!-- Judul -->
                <div class="mb-5">
                    <div class="mb-2 text-sm font-medium">Judul</div>
                    <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                        <div class="flex gap-2">
                            <div class="flex-1">
                                <input
                                    placeholder="Judul Artikel"
                                    class="w-full border-none bg-transparent p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none"
                                    v-model="form.title"
                                />
                            </div>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500"></p>
                </div>
                <!-- Kategori -->

                <!-- Body -->
                <div class="mb-5">
                    <ToastEditor v-model="form.body" />
                </div>

                <div class="mb-5">
                    <div class="mb-2 text-sm font-medium">Kategori</div>
                    <div class="mb-2 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2 lg:w-96">
                        <div class="flex">
                            <div class="flex-1">
                                <select
                                    class="w-full p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none dark:bg-zinc-950"
                                    v-model="form.category_id"
                                >
                                    <option selected value="">Pilih Kategori</option>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500"></p>
                </div>

                <!-- Thumbnail -->
                <div class="mb-5">
                    <div class="mb-2 text-sm font-medium">Thumbnails</div>
                    <input
                        class="border-primary text-primary dark:border-primary component-secondary w-full cursor-pointer items-center justify-start gap-2 rounded-lg border px-[24px] py-[8px] text-sm transition ease-in-out hover:scale-99 md:px-6 md:py-2.5"
                        type="file"
                        id="foto"
                        @change="uploadThumbnail"
                        accept="image/*"
                    />
                    <div v-if="form.thumbnails" class="mt-4">
                        <img :src="`/storage/${form.thumbnails}`" class="h-50 w-50 rounded-lg object-cover" />
                    </div>
                </div>

                <!-- Submit -->
                <Button type="submit" class="mt-4 w-1/4 transition ease-in-out hover:scale-97" :tabindex="4" :disabled="form.processing">
                    <FileInput />
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Create Data
                </Button>
            </form>
        </div>
    </AppLayout>
</template>
