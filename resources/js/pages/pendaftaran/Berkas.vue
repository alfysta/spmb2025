<script>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

import { Button } from '@/components/ui/button';
import { useForm, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { FileInput, LoaderCircle } from 'lucide-vue-next';

export default {
    data() {
        return {
            dragging: false,
            berkas: [],
        };
    },
    components: {
        AppLayout,
        Link,
        Head,
        Button,
        FileInput,
        LoaderCircle,
        useForm,
        usePage,
    },
    methods: {
        onSelectedFiles($event) {
            let files = [...$event.target.files];
            this.uploadFiles(files);
            this.$refs.files.value = null;
        },
        uploadFiles(files) {
            files.forEach((file) => {
                this.berkas.unshift({
                    file: file,
                    progress: 0,
                    error: null,
                    uploaded: false,
                    preview_url: null,
                    id: null,
                });
            });

            this.berkas
                .filter((berkas) => !berkas.uploaded)
                .forEach((berkas) => {
                    let form = new FormData();
                    form.append('file', berkas.file);

                    axios
                        .post(this.route('pendaftaran.updateBerkas'), form, {
                            onUploadProgress: (event) => {
                                berkas.progress = Math.round((event.loaded * 100) / event.total);
                            },
                        })
                        .then(({ data }) => {
                            berkas.uploaded = true;
                            berkas.id = data.id;
                            berkas.preview_url = data.preview_url;
                        })
                        .catch((error) => {
                            berkas.error = `Upload fail. Please try again later.`;

                            if (error?.response.status === 422) {
                                berkas.error = error.response.data.errors.file[0];
                            }
                        });
                });
        },
    },
};
</script>

<template>
    <Head title="Berkas Persyaratan" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div>
                <ul class="mt-4 flex border-b">
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
                        <Link
                            :href="route('pendaftaran.show')"
                            class="text-primary !text-primary relative mr-5 block cursor-pointer appearance-none border border-transparent py-5 text-center font-semibold dark:border-transparent dark:text-slate-400"
                            >Umum
                            <hr class="border-primary absolute -bottom-[2px] left-0 w-full border-b-2"
                        /></Link>
                    </li>

                    <li
                        class="flex-1 focus-visible:outline-none"
                        id="headlessui-tabs-tab-:r0:"
                        role="tab"
                        aria-selected="false"
                        tabindex="-1"
                        data-headlessui-state=""
                        aria-controls="headlessui-tabs-panel-:r4:"
                    >
                        <Link
                            :href="route('pendaftaran.show')"
                            class="text-primary !text-primary relative mr-5 block cursor-pointer appearance-none border border-transparent py-5 text-center dark:border-transparent dark:text-slate-400"
                            >Khusus</Link
                        >
                    </li>
                </ul>
                <div class="pt-8">
                    <div class="flex flex-col gap-3 text-sm">
                        <p class="font-medium">Kartu Keluarga</p>
                        <div class="flex h-10">
                            <div class="flex w-full items-center rounded-lg border-[1px] border-[#D1D5DB]">
                                <label
                                    class="inline-flex h-9 items-center rounded border border-zinc-900 bg-white px-4 text-sm font-medium text-gray-700 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2"
                                >
                                    Pilih File
                                    <input ref="files" @input="onSelectedFiles" type="file" name="files" class="sr-only" />
                                </label>
                                <li v-for="(item, index) in berkas" :key="index" class="flex items-center space-x-2 p-3">
                                    <div class="h-9 w-9 flex-shrink-0 bg-gray-300">
                                        <img :src="item.preview_url" class="h-full w-full rounded" :alt="item.file.name" />
                                    </div>

                                    <div class="flex-1 truncate text-sm text-gray-700">{{ item.file.name }}</div>

                                    <div
                                        v-if="!item.uploaded && !item.error"
                                        class="relative flex h-full w-full items-center justify-center overflow-hidden rounded-full bg-gray-200 shadow-inner"
                                    >
                                        <div
                                            class="absolute top-0 left-0 inline-block w-full bg-indigo-600"
                                            :style="`width: ${item.progress}%`"
                                        ></div>
                                        <div class="text-shadow relative z-10 text-center text-xs font-semibold text-white drop-shadow">
                                            {{ item.progress }}%
                                        </div>
                                    </div>

                                    <div v-if="item.error" class="text-sm text-red-600">{{ item.error }}</div>
                                    <a target="_blank" :href="item.preview_url" v-if="item.uploaded" class="text-sm text-indigo-600 underline">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            aria-hidden="true"
                                            role="img"
                                            class="iconify iconify--tabler mr-0.5 text-xl"
                                            width="1em"
                                            height="1em"
                                            viewBox="0 0 24 24"
                                        >
                                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0-4 0"></path>
                                                <path d="M21 12q-3.6 6-9 6t-9-6q3.6-6 9-6t9 6"></path>
                                            </g>
                                        </svg>
                                    </a>
                                </li>
                            </div>
                            <div class="ml-2.5 flex gap-x-2">
                                <a
                                    target="_blank"
                                    class="border-primary text-primary dark:border-primary component-secondary flex cursor-pointer items-center justify-start gap-2 rounded-lg border px-[24px] py-[10px] text-sm transition ease-in-out hover:scale-95 md:px-6 md:py-2.5"
                                >
                                    <div>
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            aria-hidden="true"
                                            role="img"
                                            class="iconify iconify--tabler mr-0.5 text-lg"
                                            width="1em"
                                            height="1em"
                                            viewBox="0 0 24 24"
                                        >
                                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0-4 0"></path>
                                                <path d="M21 12q-3.6 6-9 6t-9-6q3.6-6 9-6t9 6"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
