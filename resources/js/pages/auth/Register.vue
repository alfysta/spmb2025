<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import RegisterLayout from '@/layouts/RegisterLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
    name: '',
    email: '',
    nisn: '',
    tempat_lahir: '',
    tanggal_lahir: '',
    nik: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <RegisterLayout
        title="Buat Akun Pendaftaran"
        description="Silakan isi formulir di bawah ini untuk pendaftaran akun SPMB SMA Negeri 1 Moilong Tahun 2025."
    >
        <Head title="Register" />

        <form @submit.prevent="submit" class="flex flex-col" novalidate>
            <div class="grid">
                <div class="grid auto-rows-min gap-4 sm:grid-cols-1 md:grid-cols-2">
                    <div class="grid gap-4 p-2">
                        <Label for="name">Nama Lengkap</Label>
                        <Input
                            id="name"
                            type="text"
                            required
                            autofocus
                            :tabindex="1"
                            autocomplete="name"
                            v-model="form.name"
                            placeholder="Nama Lengkap"
                        />
                        <InputError :message="form.errors.name" />
                    </div>

                    <div class="grid gap-4 p-2">
                        <Label for="nisn">NISN</Label>
                        <Input
                            id="nisn"
                            type="text"
                            required
                            :tabindex="2"
                            autocomplete="nisn"
                            v-model="form.nisn"
                            placeholder="Nomor Induk Siswa Nasional"
                        />
                        <InputError :message="form.errors.nisn" />
                    </div>

                    <div class="grid gap-4 p-2">
                        <Label for="nik">NIK</Label>
                        <Input id="nik" type="text" required :tabindex="2" autocomplete="nik" v-model="form.nik" placeholder="NIK" />
                        <InputError :message="form.errors.nik" />
                    </div>

                    <div class="grid gap-4 p-2">
                        <Label for="tempat_lahir">Tempat Lahir</Label>
                        <Input
                            id="tempat_lahir"
                            type="text"
                            required
                            :tabindex="2"
                            autocomplete="tempat_lahir"
                            v-model="form.tempat_lahir"
                            placeholder="Tempat Lahir"
                        />
                        <InputError :message="form.errors.tempat_lahir" />
                    </div>

                    <div class="grid gap-4 p-2">
                        <Label for="tanggal_lahir">Tanggal Lahir</Label>
                        <Input
                            id="tanggal_lahir"
                            type="date"
                            required
                            :tabindex="2"
                            autocomplete="tanggal_lahir"
                            v-model="form.tanggal_lahir"
                            placeholder="Tanggal Lahir"
                        />
                        <InputError :message="form.errors.tempat_lahir" />
                    </div>

                    <div class="grid gap-4 p-2">
                        <Label for="email">Email address</Label>
                        <Input
                            id="email"
                            type="email"
                            required
                            :tabindex="2"
                            autocomplete="email"
                            v-model="form.email"
                            placeholder="email@example.com"
                        />
                        <InputError :message="form.errors.email" />
                    </div>

                    <div class="grid gap-4 p-2">
                        <Label for="password">Password</Label>
                        <Input
                            id="password"
                            type="password"
                            required
                            :tabindex="3"
                            autocomplete="new-password"
                            v-model="form.password"
                            placeholder="Password"
                        />
                        <InputError :message="form.errors.password" />
                    </div>

                    <div class="grid gap-4 p-2">
                        <Label for="password_confirmation">Confirm password</Label>
                        <Input
                            id="password_confirmation"
                            type="password"
                            required
                            :tabindex="4"
                            autocomplete="new-password"
                            v-model="form.password_confirmation"
                            placeholder="Confirm password"
                        />
                        <InputError :message="form.errors.password_confirmation" />
                    </div>
                </div>

                <Button type="submit" class="mt-4 w-full" tabindex="5" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Buat Akun
                </Button>
            </div>

            <div class="text-muted-foreground mt-4 text-center text-sm">
                Sudah Punya Akun ?
                <TextLink :href="route('login')" class="underline underline-offset-4" :tabindex="6">Log in</TextLink>
            </div>
        </form>
    </RegisterLayout>
</template>
