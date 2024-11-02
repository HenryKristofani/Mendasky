<template>
    <main class="flex flex-col text-base rounded-none max-w-[400px]">
        <h1 class="z-10 self-center mt-0 text-3xl font-semibold text-center text-neutral-900">Login</h1>
        <form @submit.prevent="submit">
            <div class="mt-12">
                <label for="email" class="block text-sm font-medium tracking-wide text-neutral-900">
                    Email address
                </label>
                <input
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
                    class="w-full px-3 py-3 mt-1 rounded bg-zinc-100 text-neutral-900"
                    placeholder="Email address"
                />
            </div>
            <div class="mt-5">
                <label for="password" class="block text-sm font-medium tracking-wide text-neutral-900">
                    Password
                </label>
                <input
                    id="password"
                    type="password"
                    v-model="form.password"
                    required
                    class="w-full px-3 py-3 mt-1 rounded bg-zinc-100 text-neutral-900"
                    placeholder="Password"
                />
            </div>
            <div class="flex justify-between mt-5 text-sm text-neutral-600">
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="stayLoggedIn" v-model="form.remember" class="w-5 h-5 border border-stone-300 rounded-md" />
                    <label for="stayLoggedIn">Biarkan saya tetap masuk</label>
                </div>
                <a href="#" class="font-medium text-blue-500">Lupa password?</a>
            </div>
            <button type="submit" class="w-full px-5 py-3 mt-5 text-white bg-cyan-700 rounded-md">
                Login
            </button>
        </form>
    </main>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
