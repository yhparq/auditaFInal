<template>
    <Head title="Galería de Fotos" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Galería de Fotos</h1>
                <p class="text-gray-600 dark:text-gray-400">Gestión completa de todas las fotografías del sistema</p>
            </div>



            <!-- Actions Bar -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        <Link
                            :href="route('photos.create')"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Subir Foto
                        </Link>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <input
                                v-model="form.search"
                                @input="search"
                                type="text"
                                placeholder="Buscar fotos..."
                                class="w-64 px-4 py-2 pl-10 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                            />
                            <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Fotos -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Lista Completa de Fotos</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Gestión y administración de todas las fotografías</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Vista Previa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nombre del Archivo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ruta del Archivo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tamaño</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Fecha de Subida</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Última Actualización</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <tr v-for="photo in photos.data" :key="photo.id" class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <!-- Vista Previa -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="relative group">
                                            <img
                                                :src="photo.url"
                                                :alt="photo.filename"
                                                class="w-16 h-16 object-cover rounded-lg border-2 border-gray-200 dark:border-gray-600 hover:border-blue-500 transition-colors cursor-pointer"
                                                @click="openPreview(photo)"
                                            />
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition-all flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Nombre del Archivo -->
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ photo.filename }}</div>
                                </td>
                                
                                <!-- Ruta del Archivo -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-500 dark:text-gray-400 max-w-xs">
                                        <div class="truncate" :title="photo.file_path">{{ photo.file_path }}</div>
                                    </div>
                                </td>
                                
                                <!-- Tamaño -->
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                        {{ formatFileSize(photo.file_size || 0) }}
                                    </span>
                                </td>
                                
                                <!-- Fecha de Subida -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ formatDate(photo.created_at) }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ formatTimeAgo(photo.created_at) }}
                                    </div>
                                </td>
                                
                                <!-- Última Actualización -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ formatDate(photo.updated_at) }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ formatTimeAgo(photo.updated_at) }}
                                    </div>
                                </td>
                                
                                <!-- Acciones -->
                                <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                                    <Link
                                        :href="route('photos.show', photo.id)"
                                        class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 transition-colors"
                                    >
                                        Ver
                                    </Link>
                                    <Link
                                        :href="route('photos.edit', photo.id)"
                                        class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded text-white bg-indigo-600 hover:bg-indigo-700 transition-colors"
                                    >
                                        Editar
                                    </Link>
                                    <button
                                        @click="confirmDelete(photo)"
                                        class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 transition-colors"
                                    >
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Empty State -->
                <div v-if="photos.data.length === 0" class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No hay fotos subidas</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Cuando subas fotografías aparecerán aquí.</p>
                    <Link
                        :href="route('photos.create')"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700"
                    >
                        Subir Primera Foto
                    </Link>
                </div>

                <!-- Paginación -->
                <div v-if="photos.links && photos.links.length > 3" class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    <nav class="flex items-center justify-between">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <Link
                                v-if="photos.prev_page_url"
                                :href="photos.prev_page_url"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                            >
                                Anterior
                            </Link>
                            <Link
                                v-if="photos.next_page_url"
                                :href="photos.next_page_url"
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                            >
                                Siguiente
                            </Link>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    Mostrando
                                    <span class="font-medium">{{ photos.from }}</span>
                                    a
                                    <span class="font-medium">{{ photos.to }}</span>
                                    de
                                    <span class="font-medium">{{ photos.total }}</span>
                                    resultados
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                                    <Link
                                        v-for="link in photos.links"
                                        :key="link.label"
                                        :href="link.url"
                                        v-html="link.label"
                                        :class="[
                                            'relative inline-flex items-center px-2 py-2 border text-sm font-medium',
                                            link.active
                                                ? 'z-10 bg-blue-50 border-blue-500 text-blue-600'
                                                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                            !link.url ? 'cursor-not-allowed opacity-50' : 'cursor-pointer'
                                        ]"
                                    />
                                </nav>
                            </div>
                        </div>
                    </nav>
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
                            ¿Estás seguro de que deseas eliminar la foto "{{ photoToDelete?.filename }}"? Esta acción no se puede deshacer.
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

        <!-- Modal de vista previa -->
        <div v-if="showPreviewModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 overflow-y-auto h-full w-full z-50">
            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="relative max-w-4xl max-h-full">
                    <button
                        @click="showPreviewModal = false"
                        class="absolute top-4 right-4 text-white hover:text-gray-300 z-10"
                    >
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    <img
                        v-if="previewPhoto"
                        :src="previewPhoto.url"
                        :alt="previewPhoto.filename"
                        class="max-w-full max-h-screen object-contain rounded-lg"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

const props = defineProps({
    photos: Object,
    filters: Object
})

const form = reactive({
    search: props.filters.search || ''
})

const showDeleteModal = ref(false)
const photoToDelete = ref(null)
const showPreviewModal = ref(false)
const previewPhoto = ref(null)

const breadcrumbs = [
    { title: 'Galería de Fotos', href: '/photos' },
]

const search = () => {
    router.get(route('photos.index'), form, {
        preserveState: true,
        preserveScroll: true
    })
}

const confirmDelete = (photo) => {
    photoToDelete.value = photo
    showDeleteModal.value = true
}

const deletePhoto = () => {
    if (photoToDelete.value) {
        router.delete(route('photos.destroy', photoToDelete.value.id), {
            preserveScroll: true,
            onSuccess: () => {
                showDeleteModal.value = false
                photoToDelete.value = null
            }
        })
    }
}

const openPreview = (photo) => {
    previewPhoto.value = photo
    showPreviewModal.value = true
}

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

const formatTimeAgo = (dateString) => {
    const date = new Date(dateString)
    const now = new Date()
    const diffInHours = Math.floor((now - date) / (1000 * 60 * 60))
    
    if (diffInHours < 1) return 'Hace menos de 1 hora'
    if (diffInHours < 24) return `Hace ${diffInHours} hora${diffInHours > 1 ? 's' : ''}`
    
    const diffInDays = Math.floor(diffInHours / 24)
    if (diffInDays < 7) return `Hace ${diffInDays} día${diffInDays > 1 ? 's' : ''}`
    
    const diffInWeeks = Math.floor(diffInDays / 7)
    return `Hace ${diffInWeeks} semana${diffInWeeks > 1 ? 's' : ''}`
}

const formatFileSize = (bytes) => {
    if (bytes === 0) return '0 Bytes'
    const k = 1024
    const sizes = ['Bytes', 'KB', 'MB', 'GB']
    const i = Math.floor(Math.log(bytes) / Math.log(k))
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}

const isRecent = (dateString) => {
    const date = new Date(dateString)
    const now = new Date()
    const diffInDays = Math.floor((now - date) / (1000 * 60 * 60 * 24))
    return diffInDays <= 7
}

const isThisWeek = (dateString) => {
    const date = new Date(dateString)
    const now = new Date()
    const startOfWeek = new Date(now.setDate(now.getDate() - now.getDay()))
    return date >= startOfWeek
}

const getTotalSize = () => {
    return props.photos.data.reduce((total, photo) => {
        return total + (photo.file_size || 0)
    }, 0)
}
</script>