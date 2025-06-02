<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

import { useForm, usePage } from '@inertiajs/vue3';

import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { type SharedData, type User } from '@/types';
import { router } from '@inertiajs/vue3';
import { FileInput, LoaderCircle } from 'lucide-vue-next';
import { ref } from 'vue';

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

const student = page.props.student[0];

defineProps({
    user: Object,
    student: Object,
});

const form = useForm({
    name: user.name,
    email: user.email,
    nisn: user.nisn,
    tempat_lahir: user.tempat_lahir,
    tanggal_lahir: user.tanggal_lahir,
    nik: user.nik,
    user_id: student.user_id,
    jenis_kelamin: student.jenis_kelamin,
    tahun_lulus: student.tahun_lulus,
    jenjang_pendidikan: student.jenjang_pendidikan,
    asal_sekolah: student.asal_sekolah,
    no_hp: student.no_hp,
    provinsi: student.provinsi,
    kabupaten: student.kabupaten,
    kecamatan: student.kecamatan,
    desa: student.desa,
    kode_pos: student.kode_pos,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Berkas Pendaftaran',
        href: '/biodata',
    },
    {
        title: 'Biodata',
        href: '/pendaftaran',
    },
];

const previewimage = ref(null);

const handleImage = (event) => {
    const foto = event.target.files[0];
    if (!foto) {
        return;
    }
    form.foto = foto;
    previewimage.value = URL.createObjectURL(foto);
};

const submit = () => {
    router.post(`biodata`, {
        _method: 'patch',
        user_id: form.user_id,
        jenis_kelamin: form.jenis_kelamin,
        tahun_lulus: form.tahun_lulus,
        jenjang_pendidikan: form.jenjang_pendidikan,
        asal_sekolah: form.asal_sekolah,
        no_hp: form.no_hp,
        provinsi: form.provinsi,
        kabupaten: form.kabupaten,
        kecamatan: form.kecamatan,
        desa: form.desa,
        kode_pos: form.kode_pos,
        foto: form.foto,
    });
};
</script>

<template>
    <Head title="Pendaftaran" />

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
                        <span
                            class="text-primary !text-primary relative mr-5 block appearance-none border border-transparent py-5 text-2xl font-bold dark:border-transparent dark:text-slate-400"
                            >Biodata
                            <hr class="border-primary absolute -bottom-[2px] left-0 w-full border-b"
                        /></span>
                    </li>
                </ul>
                <form @submit.prevent="submit">
                    <div class="pt-8">
                        <div class="mx-6 rounded-xl border-[1px] border-[#F3F4F6] shadow-xl lg:m-0 lg:rounded-none lg:border-none lg:shadow-none">
                            <div class="mt-5 flex flex-col gap-16">
                                <div class="mx-4 flex flex-col">
                                    <p class="mb-5 text-lg leading-7 font-bold">Informasi Pribadi</p>
                                    <div class="flex w-full gap-x-5">
                                        <div>
                                            <div class="flex w-[16rem] flex-col items-center justify-center rounded border px-8 py-6">
                                                <div class="text-sm">Pas Foto (3x4) cm</div>
                                                <div class="my-4 aspect-[3/4] w-full rounded-lg bg-gray-400">
                                                    <img
                                                        :src="form.foto ? previewimage : student.image_url"
                                                        v-if="student.image_url ? student.image_url : previewimage"
                                                        class="h-full w-full rounded-lg object-cover"
                                                    />
                                                </div>
                                                <input
                                                    v-if="!student.foto"
                                                    class="border-primary text-primary dark:border-primary component-secondary w-full cursor-pointer items-center justify-start gap-2 rounded-lg border px-[24px] py-[8px] text-sm transition ease-in-out hover:scale-99 md:px-6 md:py-2.5"
                                                    type="file"
                                                    id="foto"
                                                    @change="handleImage"
                                                    @input="form.foto = $event.target.files[0]"
                                                />
                                                <InputError class="mt-1 text-sm" :message="form.errors.foto" />
                                            </div>
                                        </div>
                                        <div class="grid w-full grid-cols-1 lg:gap-x-6">
                                            <div class="mb-5">
                                                <div class="mb-2 text-sm font-medium">Nama</div>
                                                <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                                    <div class="flex gap-2">
                                                        <div class="flex-1">
                                                            <input
                                                                placeholder="Masukkan Nama"
                                                                class="w-full border-none bg-transparent p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none"
                                                                disabled
                                                                v-model="form.name"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-2 text-sm text-gray-500"></p>
                                            </div>
                                            <div class="mb-5">
                                                <div class="mb-2 text-sm font-medium">NIK</div>
                                                <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                                    <div class="flex gap-2">
                                                        <div class="flex-1">
                                                            <input
                                                                placeholder="Masukkan NIK"
                                                                class="w-full border-none bg-transparent p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none"
                                                                disabled
                                                                v-model="form.nik"
                                                            />
                                                            <InputError class="mt-1 text-sm" :message="form.errors.nik" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-2 text-sm text-gray-500"></p>
                                            </div>
                                            <div class="mb-5">
                                                <div class="mb-2 text-sm font-medium">Jenis Kelamin</div>
                                                <div class="mb-2 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2 lg:w-96">
                                                    <div class="flex">
                                                        <div class="flex-1">
                                                            <select
                                                                v-model="form.jenis_kelamin"
                                                                class="w-full p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none dark:bg-zinc-950"
                                                            >
                                                                <option selected>Pilih Jenis Kelamin</option>
                                                                <option value="Laki-Laki">Laki-Laki</option>
                                                                <option value="Perempuan">Perempuan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <InputError class="mt-1 text-sm" :message="form.errors.jenis_kelamin" />
                                            </div>
                                            <div class="grid gap-x-5 sm:grid-cols-1 lg:grid-cols-2">
                                                <div class="mb-5">
                                                    <div class="mb-2 text-sm font-medium">Tempat Lahir</div>
                                                    <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                                        <div class="flex gap-2">
                                                            <div class="flex-1">
                                                                <input
                                                                    placeholder="Masukkan Tempat Lahir"
                                                                    class="w-full border-none bg-transparent p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none"
                                                                    disabled
                                                                    v-model="form.tempat_lahir"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="mt-2 text-sm text-gray-500"></p>
                                                </div>
                                                <div class="mb-5">
                                                    <div class="mb-2 text-sm font-medium">Tanggal Lahir</div>
                                                    <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                                        <div class="flex gap-2">
                                                            <div class="flex-1">
                                                                <input
                                                                    placeholder="Masukkan Tanggal Lahir"
                                                                    class="w-full border-none bg-transparent p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none"
                                                                    disabled
                                                                    v-model="form.tanggal_lahir"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="mt-2 text-sm text-gray-500"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mb-5 text-lg leading-7 font-bold">Informasi Pendidikan</p>
                                    <div>
                                        <div class="mb-5">
                                            <div class="mb-2 text-sm font-medium">NISN</div>
                                            <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                                <div class="flex gap-2">
                                                    <div class="flex-1">
                                                        <input
                                                            placeholder="Masukkan NISN"
                                                            class="w-full border-none bg-transparent p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none"
                                                            disabled
                                                            v-model="form.nisn"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-2 text-sm text-gray-500"></p>
                                        </div>
                                        <div class="mb-5">
                                            <div class="mb-2 text-sm font-medium">Jenjang Pendidikan</div>
                                            <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                                <div class="flex gap-2">
                                                    <div class="flex-1">
                                                        <input
                                                            placeholder="Masukkan Jenjang Pendidikan"
                                                            class="w-full border-none bg-transparent p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none"
                                                            v-model="form.jenjang_pendidikan"
                                                        />
                                                    </div>
                                                    <InputError class="mt-1 text-sm" :message="form.errors.jenjang_pendidikan" />
                                                </div>
                                            </div>
                                            <p class="mt-2 text-sm text-gray-500"></p>
                                        </div>
                                        <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-x-6">
                                            <div class="mb-5">
                                                <div class="mb-2 text-sm font-medium">Asal Sekolah</div>
                                                <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                                    <div class="flex gap-2">
                                                        <div class="flex-1">
                                                            <input
                                                                placeholder="Masukkan Asal Sekolah"
                                                                class="w-full border-none bg-transparent p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none"
                                                                v-model="form.asal_sekolah"
                                                            />
                                                        </div>
                                                        <InputError class="mt-1 text-sm" :message="form.errors.asal_sekolah" />
                                                    </div>
                                                </div>
                                                <p class="mt-2 text-sm text-gray-500"></p>
                                            </div>
                                            <div class="mb-5">
                                                <div class="mb-2 text-sm font-medium">Tahun Lulus</div>
                                                <div class="mb-2 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2 lg:w-96">
                                                    <div class="flex">
                                                        <div class="flex-1">
                                                            <select
                                                                v-model="form.tahun_lulus"
                                                                class="w-full p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none dark:bg-zinc-950"
                                                            >
                                                                <option selected>Tahun Lulus</option>
                                                                <option :value="new Date().getFullYear()">{{ new Date().getFullYear() }}</option>
                                                                <option :value="new Date().getFullYear() - 1">
                                                                    {{ new Date().getFullYear() - 1 }}
                                                                </option>
                                                                <option :value="new Date().getFullYear() - 2">
                                                                    {{ new Date().getFullYear() - 2 }}
                                                                </option>
                                                                <option :value="new Date().getFullYear() - 3">
                                                                    {{ new Date().getFullYear() - 3 }}
                                                                </option>
                                                                <option :value="new Date().getFullYear() - 4">
                                                                    {{ new Date().getFullYear() - 4 }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-2 text-sm text-gray-500"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mb-5 text-lg leading-7 font-bold">Kontak</p>
                                    <div>
                                        <div class="mb-5">
                                            <div class="mb-2 text-sm font-medium">Email</div>
                                            <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                                <div class="flex gap-2">
                                                    <div class="flex-1">
                                                        <input
                                                            placeholder="Masukkan Email"
                                                            class="w-full border-none bg-transparent p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none"
                                                            disabled
                                                            v-model="form.email"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-2 text-sm text-gray-500"></p>
                                        </div>
                                        <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-x-6">
                                            <div class="mb-5">
                                                <div class="mb-2 text-sm font-medium">No. Hp Aktif Calon Peserta Didik</div>
                                                <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                                    <div class="flex gap-2">
                                                        <div class="flex-1">
                                                            <input
                                                                placeholder="Masukkan No. Hp Aktif"
                                                                class="w-full border-none bg-transparent p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none"
                                                                v-model="form.no_hp"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-2 text-sm text-gray-500"></p>
                                            </div>
                                            <div class="mb-5">
                                                <div class="mb-2 text-sm font-medium">No. Hp Aktif Orang Tua / Wali</div>
                                                <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                                    <div class="flex gap-2">
                                                        <div class="flex-1">
                                                            <input
                                                                placeholder="Masukkan No. Hp Aktif Orang Tua / Wali"
                                                                class="w-full border-none bg-transparent p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-2 text-sm text-gray-500"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8">
                        <div class="mx-4 mt-5 flex flex-col gap-16">
                            <p class="text-lg leading-7 font-bold">Informasi Jalur Pendaftaran</p>
                            <div class="grid grid-cols-3 gap-x-5">
                                <div class="mb-5">
                                    <div class="mb-2 text-sm font-medium"></div>
                                    <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                        <div class="flex gap-2">
                                            <div class="flex-1">
                                                <input
                                                    class="w-full border-none bg-transparent p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none"
                                                    value="Jalur Domisili"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500"></p>
                                </div>
                                <div class="mb-5">
                                    <div class="mb-2 text-sm font-medium"></div>
                                    <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                        <div class="flex gap-2">
                                            <div class="flex-1">
                                                <input
                                                    class="w-full border-none bg-transparent p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none"
                                                    value="Nilai Rata-Rata Raport = 74"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500"></p>
                                </div>
                                <div class="mb-5">
                                    <div class="mb-2 text-sm font-medium"></div>
                                    <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                        <div class="flex gap-2">
                                            <div class="flex-1">
                                                <input
                                                    class="w-full border-none bg-transparent p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none"
                                                    value="Jarak 1725 m"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500"></p>
                                </div>
                            </div>
                            <p class="text-lg leading-7 font-bold">Data Alamat</p>
                            <div class="mt-1">
                                <div class="mt-1">
                                    <div class="my-2 rounded-lg bg-amber-50 p-4 text-sm text-amber-600">
                                        <div class="mb-2 flex items-center">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                aria-hidden="true"
                                                role="img"
                                                class="iconify iconify--tabler mr-2 aspect-square text-xl text-amber-600"
                                                width="1em"
                                                height="1em"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    fill="currentColor"
                                                    d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1-19.995.324L2 12l.004-.28C2.152 6.327 6.57 2 12 2m.01 13l-.127.007a1 1 0 0 0 0 1.986L12 17l.127-.007a1 1 0 0 0 0-1.986zM12 7a1 1 0 0 0-.993.883L11 8v4l.007.117a1 1 0 0 0 1.986 0L13 12V8l-.007-.117A1 1 0 0 0 12 7"
                                                ></path>
                                            </svg>
                                            <div class="text-base font-semibold">Perhatian</div>
                                        </div>
                                        Mohon periksa kembali alamat pada Kartu Keluarga dan pastikan sudah sesuai dengan lokasi domisili yang
                                        dipilih.
                                    </div>
                                    <div
                                        class="mx-6 mb-5 rounded-3xl border-[1px] border-[#F3F4F6] shadow-xl lg:m-0 lg:rounded-none lg:border-none lg:shadow-none"
                                    >
                                        <div class="mt-2 mb-8 flex flex-col gap-16">
                                            <div class="mx-4 flex flex-col">
                                                <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-x-6">
                                                    <div class="mb-5">
                                                        <div class="mb-2 text-sm font-medium">Provinsi</div>
                                                        <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                                            <div class="flex gap-2">
                                                                <div class="flex-1">
                                                                    <input
                                                                        placeholder="Masukkan Provinsi"
                                                                        class="w-full border-none bg-transparent p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none"
                                                                        v-model="form.provinsi"
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="mt-2 text-sm text-gray-500"></p>
                                                    </div>
                                                    <div class="mb-5">
                                                        <div class="mb-2 text-sm font-medium">Kota / Kabupaten</div>
                                                        <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                                            <div class="flex gap-2">
                                                                <div class="flex-1">
                                                                    <input
                                                                        placeholder="Masukkan Kota / Kabupaten"
                                                                        class="w-full border-none bg-transparent p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none"
                                                                        v-model="form.kabupaten"
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="mt-2 text-sm text-gray-500"></p>
                                                    </div>
                                                    <div class="mb-5">
                                                        <div class="mb-2 text-sm font-medium">Kecamatan</div>
                                                        <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                                            <div class="flex gap-2">
                                                                <div class="flex-1">
                                                                    <input
                                                                        placeholder="Masukkan Kecamatan"
                                                                        class="w-full border-none bg-transparent p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none"
                                                                        v-model="form.kecamatan"
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="mt-2 text-sm text-red-500" :message="form.errors.kecamatan" />
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-x-6">
                                                    <div class="mb-5">
                                                        <div class="mb-2 text-sm font-medium">Kelurahan</div>
                                                        <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                                            <div class="flex gap-2">
                                                                <div class="flex-1">
                                                                    <input
                                                                        placeholder="Masukkan Kelurahan / Desa"
                                                                        class="w-full border-none bg-transparent p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none"
                                                                        v-model="form.desa"
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="mt-2 text-sm text-gray-500"></p>
                                                    </div>
                                                    <div class="mb-5">
                                                        <div class="mb-2 text-sm font-medium">Alamat</div>
                                                        <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                                            <div class="flex gap-2">
                                                                <div class="flex-1">
                                                                    <input
                                                                        placeholder="Masukkan alamat"
                                                                        class="w-full border-none bg-transparent p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none"
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="mt-2 text-sm text-gray-500"></p>
                                                    </div>
                                                    <div class="mb-5">
                                                        <div class="mb-2 text-sm font-medium">Kode Pos</div>
                                                        <div class="mb-0 rounded-xl border-[1px] border-[#D1D5DB] px-4 py-2">
                                                            <div class="flex gap-2">
                                                                <div class="flex-1">
                                                                    <input
                                                                        placeholder="Masukkan Kode Pos"
                                                                        class="w-full border-none bg-transparent p-0 text-sm transition ease-in-out hover:scale-99 focus:border-none focus:ring-0 focus:outline-none"
                                                                        v-model="form.kode_pos"
                                                                    />
                                                                </div>
                                                                <InputError class="mt-1 text-sm" :message="form.errors.kode_pos" />
                                                            </div>
                                                        </div>
                                                        <p class="mt-2 text-sm text-gray-500"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <Button type="submit" class="mx-4 mt-4 w-1/4 transition ease-in-out hover:scale-97" :tabindex="4" :disabled="form.processing">
                        <FileInput />
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        Update Data
                    </Button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
