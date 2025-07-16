<!-- resources/js/Pages/Cursos/Index.vue -->
<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <div>
      <!-- Header Section -->
      <div class="mb-8 flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Gestión de Cursos</h1>
          <p class="text-gray-600 dark:text-gray-400">Administra todos los cursos del aula virtual AUDITA 2025</p>
        </div>
        <Link 
          :href="route('cursos.create')" 
          class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 py-3 rounded-lg hover:from-orange-600 hover:to-orange-700 transition-all duration-200 shadow-lg transform hover:scale-105 flex items-center space-x-2"
        >
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
          </svg>
          <span>Nuevo Curso</span>
        </Link>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
          <div class="flex items-center">
            <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
              <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Cursos</p>
              <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ cursos.total || cursos.data.length }}</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
          <div class="flex items-center">
            <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
              <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Activos</p>
              <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                {{ cursos.data.filter(c => c.activo).length }}
              </p>
            </div>
          </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
          <div class="flex items-center">
            <div class="p-2 bg-orange-100 dark:bg-orange-900 rounded-lg">
              <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Próximos</p>
              <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                {{ cursos.data.filter(c => new Date(c.fecha_curso) > new Date()).length }}
              </p>
            </div>
          </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
          <div class="flex items-center">
            <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg">
              <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Con Material</p>
              <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                {{ cursos.data.filter(c => c.material_pdf).length }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Filters and Search -->
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Search -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buscar cursos</label>
            <div class="relative">
              <input
                type="text"
                v-model="searchQuery"
                @input="search"
                placeholder="Buscar por nombre o descripción..."
                class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
              >
              <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
              </svg>
            </div>
          </div>

          <!-- Filter -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Filtrar por</label>
            <select
              v-model="selectedFilter"
              @change="applyFilter"
              class="w-full py-3 px-4 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
            >
              <option value="">Todos los cursos</option>
              <option value="proximos">Próximos</option>
              <option value="hoy">Hoy</option>
              <option value="pasados">Pasados</option>
              <option value="activos">Activos</option>
              <option value="inactivos">Inactivos</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Success Message -->
      <div v-if="$page.props.flash?.success" class="mb-6">
        <div class="bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg">
          {{ $page.props.flash.success }}
        </div>
      </div>

      <!-- Courses Grid -->
      <div v-if="cursos.data.length > 0" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
          <h3 class="text-lg font-medium text-gray-900 dark:text-white">Lista de Cursos</h3>
          <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Gestión completa de todos los cursos</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 p-6">
          <div 
            v-for="curso in cursos.data"
            :key="curso.id"
            class="bg-gray-50 dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
          >
            <!-- Card Header -->
            <div class="p-6 border-b border-gray-100 dark:border-gray-600">
              <div class="flex justify-between items-start mb-3">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white line-clamp-2">
                  {{ curso.nombre_curso }}
                </h3>
                <span :class="[
                  'px-2 py-1 rounded-full text-xs font-medium',
                  curso.activo ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                ]">
                  {{ curso.activo ? 'Activo' : 'Inactivo' }}
                </span>
              </div>
              
              <p v-if="curso.descripcion" class="text-sm text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                {{ curso.descripcion }}
              </p>

              <!-- Course Info -->
              <div class="space-y-2">
                <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                  <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                  </svg>
                  <span class="font-medium">{{ formatDate(curso.fecha_curso) }}</span>
                </div>
                
                <div v-if="curso.hora_inicio" class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                  <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                  </svg>
                  <span>{{ formatTime(curso.hora_inicio) }} - {{ formatTime(curso.hora_fin) }}</span>
                </div>

                <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                  <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                  </svg>
                  <span class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 cursor-pointer" @click="openLink(curso.link_reunion)">
                    Ver reunión
                  </span>
                </div>

                <div v-if="curso.material_pdf" class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                  <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                  </svg>
                  <span class="text-green-600 dark:text-green-400">Material disponible</span>
                </div>
              </div>
            </div>

            <!-- Card Actions -->
            <div class="p-4 bg-gray-100 dark:bg-gray-600 rounded-b-xl">
              <div class="flex space-x-2">
                <Link 
                  :href="route('cursos.show', curso.id)"
                  class="flex-1 bg-blue-600 text-white text-center py-2 px-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 text-sm font-medium"
                >
                  Ver
                </Link>
                <Link 
                  :href="route('cursos.edit', curso.id)"
                  class="flex-1 bg-orange-500 text-white text-center py-2 px-3 rounded-lg hover:bg-orange-600 transition-colors duration-200 text-sm font-medium"
                >
                  Editar
                </Link>
                <button
                  @click="confirmDelete(curso)"
                  class="flex-1 bg-red-600 text-white py-2 px-3 rounded-lg hover:bg-red-700 transition-colors duration-200 text-sm font-medium"
                >
                  Eliminar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 text-center py-12">
        <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No hay cursos</h3>
        <p class="mt-2 text-gray-500 dark:text-gray-400">Comienza creando tu primer curso.</p>
        <Link 
          :href="route('cursos.create')" 
          class="mt-4 inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors duration-200"
        >
          <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
          </svg>
          Crear Curso
        </Link>
      </div>

      <!-- Pagination -->
      <div v-if="cursos.links && cursos.links.length > 3" class="flex justify-center">
        <nav class="flex space-x-2">
          <template v-for="(link, index) in cursos.links" :key="index">
            <Link
              v-if="link.url"
              :href="link.url"
              :class="[
                'px-4 py-2 rounded-lg border text-sm font-medium transition-colors duration-200',
                link.active 
                  ? 'bg-blue-600 text-white border-blue-600' 
                  : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700'
              ]"
              v-html="link.label"
            />
            <span
              v-else
              :class="[
                'px-4 py-2 rounded-lg border text-sm font-medium',
                'bg-gray-100 dark:bg-gray-700 text-gray-400 border-gray-300 dark:border-gray-600 cursor-not-allowed'
              ]"
              v-html="link.label"
            />
          </template>
        </nav>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Confirmar eliminación</h3>
        <p class="text-gray-600 dark:text-gray-300 mb-6">
          ¿Estás seguro de que quieres eliminar el curso "{{ cursoToDelete?.nombre_curso }}"? 
          Esta acción no se puede deshacer.
        </p>
        <div class="flex space-x-4">
          <button
            @click="deleteConfirmed"
            class="flex-1 bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors duration-200"
          >
            Eliminar
          </button>
          <button
            @click="cancelDelete"
            class="flex-1 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 py-2 px-4 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors duration-200"
          >
            Cancelar
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

// Props
const props = defineProps({
  cursos: Object,
  filters: Object
})

// State
const searchQuery = ref(props.filters.search || '')
const selectedFilter = ref(props.filters.filter || '')
const showDeleteModal = ref(false)
const cursoToDelete = ref(null)

// Breadcrumbs
const breadcrumbs = [
  { title: 'Cursos', href: '/cursos' },
]

// Methods
const search = () => {
  router.get(route('cursos.index'), {
    search: searchQuery.value,
    filter: selectedFilter.value
  }, {
    preserveState: true,
    replace: true
  })
}

const applyFilter = () => {
  router.get(route('cursos.index'), {
    search: searchQuery.value,
    filter: selectedFilter.value
  }, {
    preserveState: true,
    replace: true
  })
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const formatTime = (time) => {
  if (!time) return ''
  return new Date(`2000-01-01T${time}`).toLocaleTimeString('es-ES', {
    hour: '2-digit',
    minute: '2-digit'
  })
}

const openLink = (url) => {
  window.open(url, '_blank')
}

const confirmDelete = (curso) => {
  cursoToDelete.value = curso
  showDeleteModal.value = true
}

const deleteConfirmed = () => {
  router.delete(route('cursos.destroy', cursoToDelete.value.id), {
    onSuccess: () => {
      showDeleteModal.value = false
      cursoToDelete.value = null
    }
  })
}

const cancelDelete = () => {
  showDeleteModal.value = false
  cursoToDelete.value = null
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>