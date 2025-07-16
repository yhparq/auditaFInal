<template>
    <Head title="Subir Foto" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Subir Nueva Foto</h1>
                <p class="text-gray-600 dark:text-gray-400">Agrega una nueva fotografía a la galería</p>
            </div>

            <!-- Formulario -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Información de la Foto</h3>
                </div>

                <form @submit.prevent="submit" class="p-6 space-y-6">
                    <!-- Campo de archivo -->
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Seleccionar Foto *
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <div v-if="!previewImage">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="photo" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Subir una foto</span>
                                            <input
                                                id="photo"
                                                name="photo"
                                                type="file"
                                                class="sr-only"
                                                accept="image/*"
                                                @change="handleFileUpload"
                                            />
                                        </label>
                                        <p class="pl-1">o arrastrar y soltar</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF hasta 10MB</p>
                                </div>
                                
                                <!-- Preview de la imagen -->
                                <div v-else class="relative">
                                    <img :src="previewImage" class="mx-auto h-48 w-auto rounded-lg shadow-md" alt="Preview" />
                                    <button
                                        @click="removeImage"
                                        type="button"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div v-if="form.errors.photo" class="mt-2 text-sm text-red-600">
                            {{ form.errors.photo }}
                        </div>
                    </div>

                    <!-- Campo de nombre -->
                    <div>
                        <label for="filename" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nombre de la Foto *
                        </label>
                        <input
                            id="filename"
                            v-model="form.filename"
                            type="text"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                            placeholder="Ingresa el nombre de la foto"
                            :class="{ 'border-red-500': form.errors.filename }"
                        />
                        <div v-if="form.errors.filename" class="mt-2 text-sm text-red-600">
                            {{ form.errors.filename }}
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                        <Link
                            :href="route('photos.index')"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-medium transition-colors"
                        >
                            Cancelar
                        </Link>
                        <button
                            type="submit"
                            :disabled="form.processing || !form.photo"
                            class="bg-blue-600 hover:bg-blue-700 disabled:bg-blue-300 text-white px-4 py-2 rounded-lg font-medium transition-colors inline-flex items-center"
                        >
                            <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span v-if="form.processing">Subiendo...</span>
                            <span v-else>Subir Foto</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

const previewImage = ref(null)

const breadcrumbs = [
    { title: 'Fotos', href: '/photos' },
    { title: 'Subir Foto', href: '/photos/create' },
]

const form = useForm({
    filename: '',
    photo: null
})

const handleFileUpload = (event) => {
    const file = event.target.files[0]
    if (file) {
        form.photo = file
        
        // Auto-completar el nombre del archivo sin extensión
        if (!form.filename) {
            form.filename = file.name.replace(/\.[^/.]+$/, '')
        }
        
        // Crear preview
        const reader = new FileReader()
        reader.onload = (e) => {
            previewImage.value = e.target.result
        }
        reader.readAsDataURL(file)
    }
}

const removeImage = () => {
    form.photo = null
    previewImage.value = null
    document.getElementById('photo').value = ''
}

const submit = () => {
    form.post(route('photos.store'), {
        forceFormData: true,
        onSuccess: () => {
            form.reset()
            previewImage.value = null
        }
    })
}
</script>