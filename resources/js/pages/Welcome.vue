<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import pizzaBg from '@/../images/pizza-bg.jpg'; // resolves to resources/images/pizza-bg.jpg
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
    email: '',
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

    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="flex h-screen bg-[#FDFDFC] dark:bg-[#0a0a0a]">
        <div class="w-1/2 bg-cover bg-center hidden md:block" :style="{ backgroundImage: `url(${pizzaBg})` }"></div>

        <div
            class="w-full md:w-1/2 flex items-center justify-center bg-[#FDFDFC] dark:bg-[#0a0a0a] px-6 opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
            <AuthBase title="Welcome Back 🍕" description="Enter your email and password below to log in">
                <form @submit.prevent="submit" class="flex flex-col gap-6">
                    <div class="grid gap-6">
                        <div class="grid gap-2">
                            <Label for="email">Email address</Label>
                            <Input id="email" type="email" required autofocus :tabindex="1" autocomplete="email"
                                v-model="form.email" placeholder="email@example.com" />
                            <InputError :message="form.errors.email" />
                        </div>

                        <div class="grid gap-2">
                            <div class="flex items-center justify-between">
                                <Label for="password">Password</Label>
                            </div>
                            <Input id="password" type="password" required :tabindex="2" autocomplete="current-password"
                                v-model="form.password" placeholder="Password" />
                            <InputError :message="form.errors.password" />
                        </div>

                        <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                            Log in
                        </Button>
                    </div>
                </form>
            </AuthBase>
        </div>
    </div>
</template>
