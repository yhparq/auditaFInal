<template>
    <AuditaLayout>
        <!-- Header de la galería -->
        <section class="bg-gradient-to-br from-[#00367e] to-[#ae1f22] text-white py-16 px-4">
            <div class="max-w-6xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Galería AUDITA 2025</h1>
                <p class="text-xl mb-8 opacity-90">Revive los mejores momentos del evento</p>
                
                <!-- Buscador -->
                <div class="max-w-md mx-auto">
                    <div class="relative">
                        <input
                            v-model="form.search"
                            @input="search"
                            type="text"
                            placeholder="Buscar fotos..."
                            class="w-full px-4 py-3 pl-10 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-white focus:border-transparent"
                        />
                        <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </section>

        <!-- Galería de fotos -->
        <section class="bg-gray-50 py-16 px-4 min-h-screen">
            <div class="max-w-7xl mx-auto">
                
                <!-- Contador de fotos -->
                <div class="text-center mb-8" v-if="photos.data && photos.data.length > 0">
                    <p class="text-gray-600">
                        Mostrando {{ photos.from }} - {{ photos.to }} de {{ photos.total }} fotografías
                    </p>
                </div>

                <!-- Grid de fotos -->
                <div v-if="photos.data && photos.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    <div
                        v-for="photo in photos.data"
                        :key="photo.id"
                        class="group relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-all duration-300 cursor-pointer bg-white"
                        @click="abrirModal(photo)"
                    >
                        <!-- Imagen -->
                        <div class="aspect-square bg-gray-200">
                            <img
                                :src="photo.url"
                                :alt="photo.filename"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                loading="lazy"
                            />
                        </div>
                        
                        <!-- Overlay con información -->
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition-opacity duration-300 flex items-end">
                            <div class="p-4 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                <p class="font-medium text-sm truncate">{{ photo.filename }}</p>
                                <p class="text-xs opacity-75">{{ formatDate(photo.created_at) }}</p>
                            </div>
                        </div>

                        <!-- Icono de zoom -->
                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="bg-black bg-opacity-50 rounded-full p-2">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estado vacío -->
                <div v-else class="text-center py-20">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-2xl font-medium text-gray-900 mb-2">
                        {{ form.search ? 'No se encontraron fotos' : 'Próximamente' }}
                    </h3>
                    <p class="text-gray-500 mb-8">
                        {{ form.search 
                            ? `No hay resultados para "${form.search}"` 
                            : 'Las fotos del evento estarán disponibles aquí.' 
                        }}
                    </p>
                    <a 
                        href="/" 
                        class="inline-flex items-center px-6 py-3 bg-[#00367e] hover:bg-[#ae1f22] text-white font-medium rounded-lg transition-colors"
                    >
                        Volver al inicio
                    </a>
                </div>

                <!-- Paginación -->
                <div v-if="photos.links && photos.links.length > 3" class="mt-12">
                    <nav class="flex items-center justify-center">
                        <div class="flex items-center space-x-1">
                            <a
                                v-for="link in photos.links"
                                :key="link.label"
                                :href="link.url"
                                v-html="link.label"
                                :class="[
                                    'px-4 py-2 text-sm font-medium border rounded-md transition-colors',
                                    link.active
                                        ? 'bg-[#00367e] text-white border-[#00367e]'
                                        : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50',
                                    !link.url ? 'cursor-not-allowed opacity-50' : 'cursor-pointer'
                                ]"
                            />
                        </div>
                    </nav>
                </div>
            </div>
        </section>

        <!-- Modal para vista completa -->
        <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-95 z-50 flex items-center justify-center p-4">
            <div class="relative max-w-6xl max-h-full w-full">
                <!-- Botones de navegación y cierre -->
                <div class="absolute top-4 right-4 flex items-center space-x-2 z-10">
                    <!-- Descargar -->
                    <a
                        v-if="selectedPhoto"
                        :href="selectedPhoto.url"
                        download
                        class="bg-black bg-opacity-50 hover:bg-opacity-70 text-white p-3 rounded-full transition-colors"
                        title="Descargar"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </a>
                    <!-- Cerrar -->
                    <button
                        @click="cerrarModal"
                        class="bg-black bg-opacity-50 hover:bg-opacity-70 text-white p-3 rounded-full transition-colors"
                        title="Cerrar"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Navegación izquierda -->
                <button
                    v-if="currentIndex > 0"
                    @click="navegarFoto(-1)"
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-70 text-white p-3 rounded-full transition-colors z-10"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                <!-- Navegación derecha -->
                <button
                    v-if="currentIndex < photos.data.length - 1"
                    @click="navegarFoto(1)"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-70 text-white p-3 rounded-full transition-colors z-10"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Imagen principal -->
                <div class="flex items-center justify-center h-full">
                    <img
                        v-if="selectedPhoto"
                        :src="selectedPhoto.url"
                        :alt="selectedPhoto.filename"
                        class="max-w-full max-h-full object-contain rounded-lg"
                    />
                </div>

                <!-- Información de la foto -->
                <div class="absolute bottom-4 left-4 right-4 text-white">
                    <div class="bg-black bg-opacity-50 rounded-lg p-4">
                        <h3 class="font-medium text-lg mb-1">{{ selectedPhoto?.filename }}</h3>
                        <div class="flex items-center justify-between text-sm opacity-75">
                            <span>{{ formatDate(selectedPhoto?.created_at) }}</span>
                            <span>{{ currentIndex + 1 }} de {{ photos.data?.length }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuditaLayout>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import AuditaLayout from '@/layouts/AuditaLayout.vue'

// Props
const props = defineProps({
    photos: Object,
    filters: Object
})

// Reactive data
const form = reactive({
    search: props.filters?.search || ''
})

const showModal = ref(false)
const selectedPhoto = ref(null)
const currentIndex = ref(0)

// Methods
const search = () => {
    router.get(route('gallery.index'), form, {
        preserveState: true,
        preserveScroll: true
    })
}

const abrirModal = (photo) => {
    selectedPhoto.value = photo
    currentIndex.value = props.photos.data.findIndex(p => p.id === photo.id)
    showModal.value = true
    document.body.style.overflow = 'hidden'
}

const cerrarModal = () => {
    showModal.value = false
    selectedPhoto.value = null
    document.body.style.overflow = 'auto'
}

const navegarFoto = (direction) => {
    const newIndex = currentIndex.value + direction
    if (newIndex >= 0 && newIndex < props.photos.data.length) {
        currentIndex.value = newIndex
        selectedPhoto.value = props.photos.data[newIndex]
    }
}

const formatDate = (dateString) => {
    if (!dateString) return ''
    return new Date(dateString).toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

// Cerrar modal con tecla Escape
const handleKeydown = (event) => {
    if (!showModal.value) return
    
    if (event.key === 'Escape') {
        cerrarModal()
    } else if (event.key === 'ArrowLeft') {
        navegarFoto(-1)
    } else if (event.key === 'ArrowRight') {
        navegarFoto(1)
    }
}

// Event listeners
document.addEventListener('keydown', handleKeydown)
</script>

<style scoped>
/* Animaciones suaves */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Efectos hover mejorados */
.group:hover .group-hover\:scale-105 {
    transform: scale(1.05);
}

.group:hover .group-hover\:translate-y-0 {
    transform: translateY(0);
}

.group:hover .group-hover\:opacity-100 {
    opacity: 1;
}

.group:hover .group-hover\:bg-opacity-60 {
    background-opacity: 0.6;
}
</style>