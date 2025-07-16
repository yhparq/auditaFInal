<template>
    <Head :title="photo.filename" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ photo.filename }}</h1>
                <p class="text-gray-600 dark:text-gray-400">Detalles de la fotografía</p>
            </div>

            <!-- Contenido principal -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Imagen principal -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Vista Previa</h3>
                        </div>
                        <div class="p-6">
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 text-center">
                                <img
                                    :src="photo.url"
                                    :alt="photo.filename"
                                    class="max-w-full max-h-96 mx-auto rounded-lg shadow-lg cursor-pointer"
                                    @click="openFullscreen"
                                />
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Click para ver en pantalla completa</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel lateral con información y acciones -->
                <div class="space-y-6">
                    <!-- Información de la foto -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Información</h3>
                        </div>
                        <div class="p-6">
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre del archivo</dt>
                                    <dd class="text-sm text-gray-900 dark:text-white mt-1">{{ photo.filename }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ruta del archivo</dt>
                                    <dd class="text-sm text-gray-900 dark:text-white mt-1 break-all">{{ photo.file_path }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de subida</dt>
                                    <dd class="text-sm text-gray-900 dark:text-white mt-1">{{ formatDate(photo.created_at) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Última actualización</dt>
                                    <dd class="text-sm text-gray-900 dark:text-white mt-1">{{ formatDate(photo.updated_at) }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Acciones</h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <!-- Ver en galería pública -->
                            <a
                                :href="route('gallery.index')"
                                class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Ver en Galería Pública
                            </a>

                            <!-- Descargar -->
                            <a
                                :href="photo.url"
                                download
                                class="w-full flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Descargar Imagen
                            </a>

                            <!-- Editar -->
                            <Link
                                :href="route('photos.edit', photo.id)"
                                class="w-full flex items-center justify-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition-colors"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Editar Foto
                            </Link>

                            <!-- Eliminar -->
                            <button
                                @click="confirmDelete"
                                class="w-full flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Eliminar Foto
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de confirmación para eliminar -->
        <div v-if="showDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="mt-3 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mt-4">¿Eliminar foto?</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            ¿Estás seguro de que deseas eliminar la foto "{{ photo.filename }}"? Esta acción no se puede deshacer.
                        </p>
                    </div>
                    <div class="items-center px-4 py-3 space-x-3">
                        <button
                            @click="showDeleteModal = false"
                            class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300"
                        >
                            Cancelar
                        </button>
                        <button
                            @click="deletePhoto"
                            class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300"
                        >
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de pantalla completa -->
        <div v-if="showFullscreen" class="fixed inset-0 bg-black bg-opacity-95 z-50 flex items-center justify-center p-4">
            <div class="relative max-w-full max-h-full">
                <button
                    @click="closeFullscreen"
                    class="absolute top-4 right-4 text-white hover:text-gray-300 z-10 text-3xl"
                >
                    ✕
                </button>
                <img
                    :src="photo.url"
                    :alt="photo.filename"
                    class="max-w-full max-h-screen object-contain"
                />
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

const props = defineProps({
    photo: Object
})

const showDeleteModal = ref(false)
const showFullscreen = ref(false)

const breadcrumbs = [
    { title: 'Fotos', href: '/photos' },
    { title: props.photo.filename, href: `/photos/${props.photo.id}` },
]

const confirmDelete = () => {
    showDeleteModal.value = true
}

const deletePhoto = () => {
    router.delete(route('photos.destroy', props.photo.id), {
        onSuccess: () => {
            router.visit(route('photos.index'))
        }
    })
}

const openFullscreen = () => {
    showFullscreen.value = true
    document.body.style.overflow = 'hidden'
}

const closeFullscreen = () => {
    showFullscreen.value = false
    document.body.style.overflow = 'auto'
}

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}
</script>