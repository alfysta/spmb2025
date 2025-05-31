<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { FileInput, LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    nisn: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AuthBase title="Log in to your account" description="Silahkan masukkan NISN dan password">
        <Head title="Log in" />

        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2 transition ease-in-out hover:scale-99">
                    <Label for="nisn">NISN</Label>
                    <Input
                        id="nisn"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="nisn"
                        v-model="form.nisn"
                        placeholder="Nomor Induk Siswa Nasional"
                    />
                    <InputError :message="form.errors.nisn" />
                </div>

                <div class="grid gap-2 transition ease-in-out hover:scale-99">
                    <div class="flex items-center justify-between">
                        <Label for="password">Password</Label>
                        <TextLink v-if="canResetPassword" :href="route('password.request')" class="text-sm transition" :tabindex="5">
                            Forgot password?
                        </TextLink>
                    </div>
                    <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        v-model="form.password"
                        placeholder="Password"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="flex items-center justify-between">
                    <Label for="remember" class="flex items-center space-x-3 transition ease-in-out hover:scale-99">
                        <Checkbox id="remember" v-model="form.remember" :tabindex="3" />
                        <span>Remember me</span>
                    </Label>
                </div>

                <Button type="submit" class="mt-4 w-full py-4 transition ease-in-out hover:scale-99" :tabindex="4" :disabled="form.processing">
                    <FileInput />
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Log in
                </Button>
            </div>

            <div class="text-muted-foreground text-center text-sm transition ease-in-out hover:scale-95">
                Belum Punya Akun ?
                <TextLink :href="route('register')" :tabindex="5">Register</TextLink>
            </div>
        </form>
    </AuthBase>
</template>
