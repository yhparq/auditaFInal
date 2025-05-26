<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import Header from "@/components/Header.vue"


defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

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
    <Header/>
    <div class="h-[91vh] bg-[#00367e] flex flex-col items-center justify-center px-4 py-8 bg-cover bg-center bg-no-repeat" style="background-image: url('/images/puno2.webp')">
         <div class="absolute inset-0 bg-[#00367e]/80"></div>
        <!-- Logo y encabezado fuera del formulario -->
        <div class="text-center mb-8 z-100">
            <img src="/images/logo1.png" alt="Logo Audita" class="h-40 mx-auto mb-3" />
            <h1 class="text-2xl font-extrabold uppercase text-white">Iniciar Sesión</h1>
            <h2 class="text-base font-bold uppercase text-[#ffb300]">Audita 2025</h2>
            <div class="mt-2 w-24 h-1 mx-auto bg-[#ffb300] relative">
                <div class="absolute left-0 top-0 w-1/2 h-1 bg-white"></div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="w-full max-w-md bg-gray-100 rounded-2xl shadow-lg p-8 z-100">
            <!-- Estado del login -->
            <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="grid gap-4">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-[#00367e]">Correo electrónico</label>
                        <Input
                            id="email"
                            type="email"
                            required
                            autofocus
                            :tabindex="1"
                            autocomplete="email"
                            v-model="form.email"
                            placeholder="correo@ejemplo.com"
                            class="w-full border rounded p-2 text-black"
                        />
                        <InputError :message="form.errors.email" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-semibold text-[#00367e]">Contraseña</label>
                            <TextLink v-if="canResetPassword" :href="route('password.request')" class="text-sm text-[#00367e] underline">
                                ¿Olvidaste tu contraseña?
                            </TextLink>
                        </div>
                        <Input
                            id="password"
                            type="password"
                            required
                            :tabindex="2"
                            autocomplete="current-password"
                            v-model="form.password"
                            placeholder="********"
                            class="w-full border rounded p-2 text-black"
                        />
                        <InputError :message="form.errors.password" />
                    </div>

                    <!-- Recordarme -->
                    <div class="flex items-center">
                        <Checkbox id="remember" v-model="form.remember" :tabindex="3" />
                        <label for="remember" class="ml-2 text-sm text-gray-700">Recordarme</label>
                    </div>
                </div>

                <!-- Botón login -->
                <Button type="submit" class="w-full bg-[#00367e] hover:bg-[#002a63] text-white p-2 rounded-md font-semibold transition" :tabindex="4" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin mr-2" />
                    Iniciar Sesión
                </Button>
            </form>
        </div>
    </div>
</template>
