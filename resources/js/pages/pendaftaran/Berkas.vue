<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

import { useForm, usePage } from '@inertiajs/vue3';

import { Button } from '@/components/ui/button';
import { type SharedData, type User } from '@/types';
import { Link, router } from '@inertiajs/vue3';
import { FileInput, LoaderCircle } from 'lucide-vue-next';
import { ref } from 'vue';

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

const berkas = page.props.berkas[0];

defineProps({
    user: Object,
    student: Object,
    berkas: Object,
});

const form = useForm({
    name: user.name,
    email: user.email,
    kartu_keluarga: berkas.kartu_keluarga,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Berkas Persyaratan',
        href: '/persyaratan',
    },
    {
        title: 'Biodata',
        href: '/persyaratan',
    },
];

const previewkk = ref(null);

const handleKK = (event) => {
    const kartu_keluarga = event.target.files[0];
    if (!kartu_keluarga) {
        return;
    }
    form.kartu_keluarga = kartu_keluarga;
    previewkk.value = URL.createObjectURL(kartu_keluarga);
};

const submit = () => {
    router.post(`persyaratan`, {
        _method: 'patch',
        user_id: form.user_id,
        kartu_keluarga: form.kartu_keluarga,
    });
};
</script>

<template>
    <Head title="Berkas Persyaratan" />

    <AppLayout :breadcrumbs="breadcrumbs">
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
                <form @submit.prevent="submit">
                    <div class="pt-8">
                        <div class="flex flex-col gap-3 text-sm">
                            <p class="font-medium">Kartu Keluarga</p>
                            <div class="flex h-10">
                                <div class="flex w-full items-center rounded-lg border-[1px] border-[#D1D5DB]">
                                    <input
                                        v-if="!berkas.kartu_keluarga"
                                        class="text-primary component-secondary flex cursor-pointer items-center justify-start gap-2 rounded-lg px-[24px] py-[10px] text-sm transition ease-in-out hover:scale-99 md:px-6 md:py-2.5"
                                        aria-describedby="file_input_help"
                                        id="file_input"
                                        type="file"
                                        @change="handleKK"
                                        @input="form.kartu_keluarga = $event.target.files[0]"
                                    />
                                    <p v-if="berkas.kartu_keluarga" class="ml-4 font-medium">Kartu Keluarga Telah Terupload</p>
                                </div>
                                <div class="ml-2.5 flex gap-x-2">
                                    <a
                                        :href="previewkk ? previewkk : '/storage/' + berkas.kartu_keluarga"
                                        v-if="previewkk ? previewkk : berkas.kartu_keluarga"
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
                                    <button
                                        class="border-primary dark:border-primary flex w-32 cursor-pointer items-center justify-start gap-2 rounded-lg bg-green-600 px-[24px] py-[10px] text-center text-sm text-white transition ease-in-out hover:scale-95 md:px-6 md:py-2.5"
                                    >
                                        Upload
                                    </button>
                                </div>
                            </div>
                            <p class="flex items-center">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    aria-hidden="true"
                                    role="img"
                                    class="iconify iconify--tabler aspect-square w-6 text-lg text-amber-600"
                                    width="1em"
                                    height="1em"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        fill="currentColor"
                                        d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1-19.995.324L2 12l.004-.28C2.152 6.327 6.57 2 12 2m.01 13l-.127.007a1 1 0 0 0 0 1.986L12 17l.127-.007a1 1 0 0 0 0-1.986zM12 7a1 1 0 0 0-.993.883L11 8v4l.007.117a1 1 0 0 0 1.986 0L13 12V8l-.007-.117A1 1 0 0 0 12 7"
                                    ></path></svg
                                >Tipe File untuk kartu Keluarga adalah*.pdf (MAX. 2Mb). Pastikan dokumen yang diupload terlihat jelas dan bisa
                                terbaca."
                            </p>
                        </div>
                    </div>

                    <p class="mt-8 text-lg leading-7 font-bold">Dokumen Calon Peserta</p>
                    <div class="mt-5">
                        <div class="flex flex-col gap-3 text-sm">
                            <input class="hidden" type="file" accept=".pdf" /><input name="ijazah" class="hidden" />
                            <p class="font-medium">Ijazah SMP/ Sederajat / Paket B / Ijazah luar negeri</p>
                            <div class="flex h-10">
                                <div class="flex w-full items-center rounded-lg border-[1px] border-[#D1D5DB]">
                                    <div
                                        class="block max-w-[200px] truncate px-3 sm:max-w-full"
                                        title="Ijazah SMP/ Sederajat / Paket B / Ijazah luar negeri"
                                    >
                                        Ijazah SMP/ Sederajat / Paket B / Ijazah luar negeri
                                    </div>
                                </div>
                                <div class="ml-2.5 flex gap-x-2">
                                    <button
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
                                        </div></button
                                    ><button
                                        class="border-primary dark:border-primary flex w-32 cursor-pointer items-center justify-start gap-2 rounded-lg bg-green-600 px-[24px] py-[10px] text-center text-sm text-white transition ease-in-out hover:scale-95 md:px-6 md:py-2.5"
                                    >
                                        Upload
                                    </button>
                                </div>
                            </div>
                            <p class="flex items-center">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    aria-hidden="true"
                                    role="img"
                                    class="iconify iconify--tabler aspect-square w-6 text-lg text-amber-600"
                                    width="1em"
                                    height="1em"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        fill="currentColor"
                                        d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1-19.995.324L2 12l.004-.28C2.152 6.327 6.57 2 12 2m.01 13l-.127.007a1 1 0 0 0 0 1.986L12 17l.127-.007a1 1 0 0 0 0-1.986zM12 7a1 1 0 0 0-.993.883L11 8v4l.007.117a1 1 0 0 0 1.986 0L13 12V8l-.007-.117A1 1 0 0 0 12 7"
                                    ></path></svg
                                >Pastikan dokumen yang diupload terlihat jelas dan bisa terbaca."
                            </p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <div class="flex flex-col gap-3 text-sm">
                            <input class="hidden" type="file" accept=".pdf" /><input
                                name="akta_kelahiran"
                                class="hidden"
                                value="general/USR000-022073-250528311111yBCHY/USR000-022073-250528311111yBCHY_general_024853.pdf"
                            />
                            <p class="font-medium">Akta kelahiran</p>
                            <div class="flex h-10">
                                <div class="flex w-full items-center rounded-lg border-[1px] border-[#D1D5DB]">
                                    <div class="block max-w-[200px] truncate px-3 sm:max-w-full" title="Akta kelahiran">Akta kelahiran</div>
                                </div>
                                <div class="ml-2.5 flex gap-x-2">
                                    <button
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
                                        </div></button
                                    ><button
                                        class="border-primary dark:border-primary flex w-32 cursor-pointer items-center justify-start gap-2 rounded-lg bg-green-600 px-[24px] py-[10px] text-center text-sm text-white transition ease-in-out hover:scale-95 md:px-6 md:py-2.5"
                                    >
                                        Upload
                                    </button>
                                </div>
                            </div>
                            <p class="flex items-center">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    aria-hidden="true"
                                    role="img"
                                    class="iconify iconify--tabler aspect-square w-6 text-lg text-amber-600"
                                    width="1em"
                                    height="1em"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        fill="currentColor"
                                        d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1-19.995.324L2 12l.004-.28C2.152 6.327 6.57 2 12 2m.01 13l-.127.007a1 1 0 0 0 0 1.986L12 17l.127-.007a1 1 0 0 0 0-1.986zM12 7a1 1 0 0 0-.993.883L11 8v4l.007.117a1 1 0 0 0 1.986 0L13 12V8l-.007-.117A1 1 0 0 0 12 7"
                                    ></path></svg
                                >Pastikan dokumen yang diupload terlihat jelas dan bisa terbaca."
                            </p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <div class="flex flex-col gap-3 text-sm">
                            <input class="hidden" type="file" accept=".pdf" /><input
                                name="ktp_wali"
                                class="hidden"
                                value="general/USR000-022073-250528311111yBCHY/USR000-022073-250528311111yBCHY_general_024857.pdf"
                            />
                            <p class="font-medium">KTP Wali</p>
                            <div class="flex h-10">
                                <div class="flex w-full items-center rounded-lg border-[1px] border-[#D1D5DB]">
                                    <div class="block max-w-[200px] truncate px-3 sm:max-w-full" title="KTP Wali">KTP Wali</div>
                                </div>
                                <div class="ml-2.5 flex gap-x-2">
                                    <button
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
                                        </div></button
                                    ><button
                                        class="border-primary dark:border-primary flex w-32 cursor-pointer items-center justify-start gap-2 rounded-lg bg-green-600 px-[24px] py-[10px] text-center text-sm text-white transition ease-in-out hover:scale-95 md:px-6 md:py-2.5"
                                    >
                                        Upload
                                    </button>
                                </div>
                            </div>
                            <p class="flex items-center">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    aria-hidden="true"
                                    role="img"
                                    class="iconify iconify--tabler aspect-square w-6 text-lg text-amber-600"
                                    width="1em"
                                    height="1em"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        fill="currentColor"
                                        d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1-19.995.324L2 12l.004-.28C2.152 6.327 6.57 2 12 2m.01 13l-.127.007a1 1 0 0 0 0 1.986L12 17l.127-.007a1 1 0 0 0 0-1.986zM12 7a1 1 0 0 0-.993.883L11 8v4l.007.117a1 1 0 0 0 1.986 0L13 12V8l-.007-.117A1 1 0 0 0 12 7"
                                    ></path></svg
                                >Pastikan dokumen yang diupload terlihat jelas dan bisa terbaca."
                            </p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <div class="flex flex-col gap-3 text-sm">
                            <input class="hidden" type="file" accept=".pdf" /><input
                                name="stjm"
                                class="hidden"
                                value="general/USR000-022073-250528311111yBCHY/USR000-022073-250528311111yBCHY_general_024904.pdf"
                            />
                            <p class="font-medium">Dokumen Surat Tanggung Jawab Mutlak</p>
                            <div class="flex h-10">
                                <div class="flex w-full items-center rounded-lg border-[1px] border-[#D1D5DB]">
                                    <div class="block max-w-[200px] truncate px-3 sm:max-w-full" title="Dokumen Surat Tanggung Jawab Mutlak">
                                        Dokumen Surat Tanggung Jawab Mutlak
                                    </div>
                                </div>
                                <div class="ml-2.5 flex gap-x-2">
                                    <button
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
                                        </div></button
                                    ><button
                                        class="border-primary dark:border-primary flex w-32 cursor-pointer items-center justify-start gap-2 rounded-lg bg-green-600 px-[24px] py-[10px] text-center text-sm text-white transition ease-in-out hover:scale-95 md:px-6 md:py-2.5"
                                    >
                                        Upload
                                    </button>
                                </div>
                            </div>
                            <p class="flex items-center">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    aria-hidden="true"
                                    role="img"
                                    class="iconify iconify--tabler aspect-square w-6 text-lg text-amber-600"
                                    width="1em"
                                    height="1em"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        fill="currentColor"
                                        d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1-19.995.324L2 12l.004-.28C2.152 6.327 6.57 2 12 2m.01 13l-.127.007a1 1 0 0 0 0 1.986L12 17l.127-.007a1 1 0 0 0 0-1.986zM12 7a1 1 0 0 0-.993.883L11 8v4l.007.117a1 1 0 0 0 1.986 0L13 12V8l-.007-.117A1 1 0 0 0 12 7"
                                    ></path></svg
                                >Pastikan dokumen yang diupload terlihat jelas dan bisa terbaca."
                            </p>
                        </div>
                    </div>

                    <p class="mt-8 text-lg leading-7 font-bold">Data Raport Siswa</p>

                    <div class="mt-5 mb-5 grid grid-cols-1 gap-y-5">
                        <div class="flex flex-col gap-3 text-sm">
                            <input class="hidden" type="file" accept=".pdf" /><input
                                name="raport"
                                class="hidden"
                                value="general/USR000-022073-250528311111yBCHY/USR000-022073-250528311111yBCHY_general_024912.pdf"
                            />
                            <p class="font-medium">Scan Nilai Rapor dari semester 1 (Satu) s/d 5 (Lima). digabungkan dalam 1 file .pdf</p>
                            <div class="flex h-10">
                                <div class="flex w-full items-center rounded-lg border-[1px] border-[#D1D5DB]">
                                    <div
                                        class="block max-w-[200px] truncate px-3 sm:max-w-full"
                                        title="Scan Nilai Rapor dari semester 1 (Satu) s/d 5 (Lima). digabungkan dalam 1 file .pdf"
                                    >
                                        Scan Nilai Rapor dari semester 1 (Satu) s/d 5 (Lima). digabungkan dalam 1 file .pdf
                                    </div>
                                </div>
                                <div class="ml-2.5 flex gap-x-2">
                                    <button
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
                                        </div></button
                                    ><button
                                        class="border-primary dark:border-primary flex w-32 cursor-pointer items-center justify-start gap-2 rounded-lg bg-green-600 px-[24px] py-[10px] text-center text-sm text-white transition ease-in-out hover:scale-95 md:px-6 md:py-2.5"
                                    >
                                        Upload
                                    </button>
                                </div>
                            </div>
                            <p class="flex items-center">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    aria-hidden="true"
                                    role="img"
                                    class="iconify iconify--tabler aspect-square w-6 text-lg text-amber-600"
                                    width="1em"
                                    height="1em"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        fill="currentColor"
                                        d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1-19.995.324L2 12l.004-.28C2.152 6.327 6.57 2 12 2m.01 13l-.127.007a1 1 0 0 0 0 1.986L12 17l.127-.007a1 1 0 0 0 0-1.986zM12 7a1 1 0 0 0-.993.883L11 8v4l.007.117a1 1 0 0 0 1.986 0L13 12V8l-.007-.117A1 1 0 0 0 12 7"
                                    ></path></svg
                                >Pastikan dokumen yang diupload terlihat jelas dan bisa terbaca."
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-x-6">
                        <div class="mb-5">
                            <div class="mb-2 text-sm font-medium">Kelas VII / 7 (Semester Ganjil)</div>
                            <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                <div class="flex gap-2">
                                    <div class="flex-1">
                                        <input
                                            name="semester_1"
                                            type="number"
                                            placeholder="Masukan Semester 1"
                                            class="w-full border-none bg-transparent p-0 text-sm focus:border-none focus:ring-0 focus:outline-none"
                                        />
                                    </div>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Masukkan Nilai Rata-Rata Rapor Semester 1</p>
                        </div>
                        <div class="mb-5">
                            <div class="mb-2 text-sm font-medium">Kelas VII / 7 (Semester Genap)</div>
                            <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                <div class="flex gap-2">
                                    <div class="flex-1">
                                        <input
                                            name="semester_2"
                                            type="number"
                                            placeholder="Masukan Semester 2"
                                            class="w-full border-none bg-transparent p-0 text-sm focus:border-none focus:ring-0 focus:outline-none"
                                        />
                                    </div>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Masukkan Nilai Rata-Rata Rapor Semester 2</p>
                        </div>
                        <div class="mb-5">
                            <div class="mb-2 text-sm font-medium">Kelas VIII / 8 (Semester Ganjil)</div>
                            <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                <div class="flex gap-2">
                                    <div class="flex-1">
                                        <input
                                            name="semester_3"
                                            type="number"
                                            placeholder="Masukan Semester 3"
                                            class="w-full border-none bg-transparent p-0 text-sm focus:border-none focus:ring-0 focus:outline-none"
                                        />
                                    </div>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Masukkan Nilai Rata-Rata Rapor Semester 3</p>
                        </div>
                        <div class="mb-5">
                            <div class="mb-2 text-sm font-medium">Kelas VIII / 8 (Semester Genap)</div>
                            <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                <div class="flex gap-2">
                                    <div class="flex-1">
                                        <input
                                            name="semester_4"
                                            type="number"
                                            placeholder="Masukan Semester 4"
                                            class="w-full border-none bg-transparent p-0 text-sm focus:border-none focus:ring-0 focus:outline-none"
                                        />
                                    </div>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Masukkan Nilai Rata-Rata Rapor Semester 4</p>
                        </div>
                        <div class="mb-5">
                            <div class="mb-2 text-sm font-medium">Kelas IX / 9 (Semester Ganjil)</div>
                            <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                <div class="flex gap-2">
                                    <div class="flex-1">
                                        <input
                                            name="semester_5"
                                            type="number"
                                            placeholder="Masukan Semester 5"
                                            class="w-full border-none bg-transparent p-0 text-sm focus:border-none focus:ring-0 focus:outline-none"
                                        />
                                    </div>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Masukkan Nilai Rata-Rata Rapor Semester 5</p>
                        </div>
                    </div>

                    <p class="mt-5 text-lg leading-7 font-bold">Dokumen Jalur Domisili</p>

                    <div class="grid-col-1 mt-5 mb-8 grid gap-y-5">
                        <div class="flex flex-col gap-3 text-sm">
                            <input class="hidden" type="file" accept=".pdf" /><input name="home_image" class="hidden" />
                            <p class="font-medium">Foto tampak depan rumah</p>
                            <div class="flex h-10">
                                <div class="flex w-full items-center rounded-lg border-[1px] border-[#D1D5DB]">
                                    <div class="block max-w-[200px] truncate px-3 sm:max-w-full" title="Foto tampak depan rumah">
                                        Foto tampak depan rumah
                                    </div>
                                </div>
                                <div class="ml-2.5 flex gap-x-2">
                                    <button
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
                                        </div></button
                                    ><button
                                        class="border-primary dark:border-primary flex w-32 cursor-pointer items-center justify-start gap-2 rounded-lg bg-green-600 px-[24px] py-[10px] text-center text-sm text-white transition ease-in-out hover:scale-95 md:px-6 md:py-2.5"
                                    >
                                        Upload
                                    </button>
                                </div>
                            </div>
                            <p class="flex items-center">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    aria-hidden="true"
                                    role="img"
                                    class="iconify iconify--tabler aspect-square w-6 text-lg text-amber-600"
                                    width="1em"
                                    height="1em"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        fill="currentColor"
                                        d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1-19.995.324L2 12l.004-.28C2.152 6.327 6.57 2 12 2m.01 13l-.127.007a1 1 0 0 0 0 1.986L12 17l.127-.007a1 1 0 0 0 0-1.986zM12 7a1 1 0 0 0-.993.883L11 8v4l.007.117a1 1 0 0 0 1.986 0L13 12V8l-.007-.117A1 1 0 0 0 12 7"
                                    ></path></svg
                                >Pastikan dokumen yang diupload terlihat jelas dan bisa terbaca."
                            </p>
                        </div>
                        <div class="mb-5">
                            <div class="mb-2 text-sm font-medium">Detail alamat rumah</div>
                            <div class="mb-2 rounded-xl border-[1px] border-[#059669] bg-[#ECFDF5] px-4 py-2">
                                <div class="flex gap-2">
                                    <textarea
                                        name="home_sign"
                                        placeholder="Masukan Detail Alamat Rumah"
                                        class="w-full rounded-xl border-[#059669] bg-[#ECFDF5] px-4 py-2 text-sm focus:border-none focus:ring-0 focus:outline-none"
                                    ></textarea>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500">Contoh: Tembok Warna Putih, Pagar Warna Coklat. Bersebelahan dengan Alfa Midi</p>
                        </div>
                    </div>

                    <Button type="submit" class="mt-4 w-1/4" :tabindex="4" :disabled="form.processing">
                        <FileInput />
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        Update Data
                    </Button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
