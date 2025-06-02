<template>
    <AppLayout>
        <template #header>
            <h2 class="text-xl leading-tight font-semibold text-gray-800">Add new media</h2>
        </template>

        <div class="px-4 py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    @drop.prevent="onDroppedFiles"
                    @dragover.prevent="dragging = true"
                    @dragleave.prevent="dragging = false"
                    :class="[
                        dragging ? 'border-indigo-500' : 'border-gray-400',
                        'flex flex-col items-center rounded-md border-2 border-dashed px-6 py-12',
                    ]"
                >
                    <svg class="h-12 w-12 text-gray-500" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                        <path
                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                        />
                    </svg>

                    <p class="text-xl text-gray-700">Drop files to upload</p>

                    <p class="mb-2 text-gray-700">or</p>

                    <label
                        class="inline-flex h-9 items-center rounded border border-gray-300 bg-white px-4 text-sm font-medium text-gray-700 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2"
                    >
                        Select files
                        <input ref="files" @input="onSelectedFiles" type="file" name="files" multiple class="sr-only" />
                    </label>

                    <p class="mt-4 text-xs text-gray-600">Maximum upload file size: 5MB.</p>
                </div>
            </div>

            <ul class="my-6 divide-y divide-gray-200 rounded bg-white shadow">
                <li v-for="(item, index) in media" :key="index" class="flex items-center space-x-2 p-3">
                    <div class="h-9 w-9 flex-shrink-0 bg-gray-300">
                        <img :src="item.preview_url" class="h-full w-full rounded" :alt="item.file.name" />
                    </div>

                    <div class="flex-1 truncate text-sm text-gray-700">{{ item.file.name }}</div>

                    <div
                        v-if="!item.uploaded && !item.error"
                        class="relative flex h-5 w-40 items-center justify-center overflow-hidden rounded-full bg-gray-200 shadow-inner"
                    >
                        <div class="absolute top-0 left-0 inline-block h-full bg-indigo-600" :style="`width: ${item.progress}%`"></div>
                        <div class="text-shadow relative z-10 text-center text-xs font-semibold text-white drop-shadow">{{ item.progress }}%</div>
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
            </ul>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';

export default {
    data() {
        return {
            dragging: false,
            media: [],
        };
    },
    components: {
        AppLayout,
        Link,
    },
    methods: {
        onDroppedFiles($event) {
            this.dragging = false;

            let files = [...$event.dataTransfer.items].filter((item) => item.kind === 'file').map((item) => item.getAsFile());

            this.uploadFiles(files);
        },
        onSelectedFiles($event) {
            let files = [...$event.target.files];
            this.uploadFiles(files);
            this.$refs.files.value = null;
        },
        uploadFiles(files) {
            files.forEach((file) => {
                this.media.unshift({
                    file: file,
                    progress: 0,
                    error: null,
                    uploaded: false,
                    preview_url: null,
                    id: null,
                });
            });

            this.media
                .filter((media) => !media.uploaded)
                .forEach((media) => {
                    let form = new FormData();
                    form.append('file', media.file);

                    axios
                        .post(this.route('media.store'), form, {
                            onUploadProgress: (event) => {
                                media.progress = Math.round((event.loaded * 100) / event.total);
                            },
                        })
                        .then(({ data }) => {
                            media.uploaded = true;
                            media.id = data.id;
                            media.preview_url = data.preview_url;
                        })
                        .catch((error) => {
                            media.error = `Upload fail. Please try again later.`;

                            if (error?.response.status === 422) {
                                media.error = error.response.data.errors.file[0];
                            }
                        });
                });
        },
    },
};
</script>
