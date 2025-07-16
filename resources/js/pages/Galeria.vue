<template>
    <AuditaLayout>
        <!-- Header de la galería - MÁS PEQUEÑO -->
        <!-- <section class="bg-gradient-to-br from-[#00367e] to-[#ae1f22] text-white py-8 px-4">
            <div class="max-w-6xl mx-auto text-center">
                <h1 class="text-3xl md:text-4xl font-extrabold mb-2">Galería AUDITA 2025</h1>
                <p class="text-lg mb-4 opacity-90">Revive los mejores momentos del evento</p>
            </div>
        </section> -->

        <!-- Header de la galería - MÁS PEQUEÑO -->
        <section class="bg-gradient-to-br from-[#00367e] to-[#ae1f22] text-white py-8 px-4">
            <div class="max-w-6xl mx-auto text-center">
                <h1 class="text-3xl md:text-4xl font-extrabold mb-2">Galería AUDITA 2025</h1>
                <p class="text-lg mb-4 opacity-90">Revive los mejores momentos del evento</p>
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

                <!-- Galería estilo grid SIMÉTRICO -->
                <div v-if="photos.data && photos.data.length > 0" class="photo-grid-symmetric">
                    <div
                        v-for="(photo, index) in photos.data"
                        :key="photo.id"
                        class="photo-card cursor-pointer transition-all duration-300 hover:scale-105 hover:z-10"
                        @click="abrirModal(photo)"
                    >
                        <img
                            :src="photo.url"
                            :alt="photo.filename"
                            class="w-full h-full object-cover rounded-lg"
                            @error="handleImageError($event, photo)"
                            @load="handleImageLoad($event, photo)"
                            loading="lazy"
                        />
                    </div>
                </div>

                <!-- Estado vacío -->
                <div v-else class="text-center py-20">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-2xl font-medium text-gray-900 mb-2">No hay fotos disponibles</h3>
                    <p class="text-gray-500 mb-8">Las fotos del evento estarán disponibles aquí.</p>
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

        <!-- Modal para vista completa - ESTILO INSTAGRAM -->
        <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-95 flex items-center justify-center z-50 p-4" @click="cerrarModal">
            <div class="relative max-w-5xl w-full h-full flex items-center justify-center" @click.stop>
                <!-- Botón cerrar -->
                <button 
                    @click="cerrarModal"
                    class="absolute top-4 right-4 z-30 text-white hover:text-red-400 transition-colors"
                >
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Navegación anterior -->
                <button 
                    v-if="currentIndex > 0"
                    @click="navegarFoto(-1)"
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white hover:text-blue-300 transition-colors z-30 bg-black bg-opacity-30 rounded-full p-3"
                >
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                <!-- Navegación siguiente -->
                <button 
                    v-if="currentIndex < photos.data.length - 1"
                    @click="navegarFoto(1)"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white hover:text-blue-300 transition-colors z-30 bg-black bg-opacity-30 rounded-full p-3"
                >
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Imagen principal -->
                <div class="flex flex-col max-h-full">
                    <img
                        :src="selectedPhoto.url"
                        :alt="selectedPhoto.filename"
                        class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-2xl"
                    />
                    
                    <!-- Info bar en la parte inferior -->
                    <div class="mt-4 bg-gradient-to-r from-black/80 to-gray-900/80 backdrop-blur-sm text-white p-4 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-white">{{ selectedPhoto.filename }}</h3>
                                <p class="text-gray-300 text-sm">
                                    {{ formatDate(selectedPhoto.created_at) }}
                                </p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="text-blue-300 text-sm font-medium bg-blue-900/30 px-3 py-1 rounded-full">
                                    {{ currentIndex + 1 }} / {{ photos.data.length }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuditaLayout>
</template>

<script setup>
import { ref } from 'vue'
import AuditaLayout from '@/layouts/AuditaLayout.vue'

// Props
const props = defineProps({
    photos: Object
})

// Reactive data
const showModal = ref(false)
const selectedPhoto = ref(null)
const currentIndex = ref(0)

// Methods
const abrirModal = (photo) => {
    selectedPhoto.value = photo
    currentIndex.value = props.photos.data.findIndex(p => p.id === photo.id)
    showModal.value = true
    document.body.style.overflow = 'hidden'
}

const handleImageError = (event, photo) => {
    console.error('Error al cargar imagen:', {
        url: event.target.src,
        photo: photo,
        file_path: photo.file_path
    })
    // Imagen placeholder simple
    event.target.style.display = 'none'
    event.target.parentElement.innerHTML = `
        <div class="w-full h-full bg-gray-200 flex items-center justify-center rounded-lg">
            <span class="text-gray-500 text-sm">Imagen no disponible</span>
        </div>
    `
}

const handleImageLoad = (event, photo) => {
    console.log('Imagen cargada correctamente:', {
        url: event.target.src,
        photo: photo,
        naturalWidth: event.target.naturalWidth,
        naturalHeight: event.target.naturalHeight
    })
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
/* Grid SIMÉTRICO para fotos */
.photo-grid-symmetric {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    grid-auto-rows: 250px;
}

.photo-card {
    border-radius: 16px;
    overflow: hidden;
    position: relative;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    background: white;
    border: 3px solid #e5e7eb; /* Borde gris claro */
}

/* Responsive para grid simétrico */
@media (max-width: 1024px) {
    .photo-grid-symmetric {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 16px;
        grid-auto-rows: 200px;
    }
}

@media (max-width: 768px) {
    .photo-grid-symmetric {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 12px;
        grid-auto-rows: 180px;
    }
}

@media (max-width: 640px) {
    .photo-grid-symmetric {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        grid-auto-rows: 160px;
    }
}

/* Efecto hover mejorado */
.photo-card:hover {
    transform: scale(1.05) translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
    border-color: #3b82f6; /* Borde azul al hover */
    z-index: 10;
}

/* Asegurar que las imágenes llenen completamente su contenedor */
.photo-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
}

.photo-card:hover img {
    transform: scale(1.1);
}

/* Backdrop blur mejorado */
.backdrop-blur-sm {
    backdrop-filter: blur(4px);
}

.backdrop-blur-md {
    backdrop-filter: blur(8px);
}
</style>