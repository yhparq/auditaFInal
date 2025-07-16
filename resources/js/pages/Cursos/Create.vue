<!-- resources/js/Pages/Cursos/Create.vue -->
<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <div>
      <!-- Header Section -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Crear Nuevo Curso</h1>
        <p class="text-gray-600 dark:text-gray-400">Completa la información del curso para el aula virtual AUDITA 2025</p>
      </div>

      <!-- Form -->
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <form @submit.prevent="submit" enctype="multipart/form-data">
          <div class="p-6 space-y-6">
            <!-- Información Básica -->
            <div class="bg-blue-50 dark:bg-blue-900/50 rounded-lg p-4 border border-blue-200 dark:border-blue-700">
              <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-4">Información Básica</h3>
              
              <!-- Nombre del Curso -->
              <div class="mb-4">
                <label for="nombre_curso" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                  Nombre del Curso *
                </label>
                <input
                  id="nombre_curso"
                  type="text"
                  v-model="form.nombre_curso"
                  class="w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                  placeholder="Ej: Introducción a Laravel"
                  required
                >
                <div v-if="errors.nombre_curso" class="text-red-600 dark:text-red-400 text-sm mt-1">
                  {{ errors.nombre_curso }}
                </div>
              </div>

              <!-- Descripción -->
              <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                  Descripción
                </label>
                <textarea
                  id="descripcion"
                  v-model="form.descripcion"
                  rows="4"
                  class="w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                  placeholder="Describe el contenido y objetivos del curso..."
                ></textarea>
                <div v-if="errors.descripcion" class="text-red-600 dark:text-red-400 text-sm mt-1">
                  {{ errors.descripcion }}
                </div>
              </div>
            </div>

            <!-- Fecha y Horario -->
            <div class="bg-orange-50 dark:bg-orange-900/50 rounded-lg p-4 border border-orange-200 dark:border-orange-700">
              <h3 class="text-lg font-semibold text-orange-900 dark:text-orange-100 mb-4">Fecha y Horario</h3>
              
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Fecha -->
                <div>
                  <label for="fecha_curso" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Fecha del Curso *
                  </label>
                  <input
                    id="fecha_curso"
                    type="date"
                    v-model="form.fecha_curso"
                    class="w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                    required
                  >
                  <div v-if="errors.fecha_curso" class="text-red-600 dark:text-red-400 text-sm mt-1">
                    {{ errors.fecha_curso }}
                  </div>
                </div>

                <!-- Hora Inicio -->
                <div>
                  <label for="hora_inicio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Hora de Inicio
                  </label>
                  <input
                    id="hora_inicio"
                    type="time"
                    v-model="form.hora_inicio"
                    class="w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                  >
                  <div v-if="errors.hora_inicio" class="text-red-600 dark:text-red-400 text-sm mt-1">
                    {{ errors.hora_inicio }}
                  </div>
                </div>

                <!-- Hora Fin -->
                <div>
                  <label for="hora_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Hora de Fin
                  </label>
                  <input
                    id="hora_fin"
                    type="time"
                    v-model="form.hora_fin"
                    class="w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                  >
                  <div v-if="errors.hora_fin" class="text-red-600 dark:text-red-400 text-sm mt-1">
                    {{ errors.hora_fin }}
                  </div>
                </div>
              </div>
            </div>

            <!-- Recursos del Curso -->
            <div class="bg-green-50 dark:bg-green-900/50 rounded-lg p-4 border border-green-200 dark:border-green-700">
              <h3 class="text-lg font-semibold text-green-900 dark:text-green-100 mb-4">Recursos del Curso</h3>
              
              <!-- Link de Reunión -->
              <div class="mb-4">
                <label for="link_reunion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                  Link de Reunión *
                </label>
                <input
                  id="link_reunion"
                  type="url"
                  v-model="form.link_reunion"
                  class="w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                  placeholder="https://meet.google.com/xxx-xxxx-xxx"
                  required
                >
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                  URL de Google Meet, Zoom u otra plataforma de videoconferencia
                </p>
                <div v-if="errors.link_reunion" class="text-red-600 dark:text-red-400 text-sm mt-1">
                  {{ errors.link_reunion }}
                </div>
              </div>

              <!-- Material PDF -->
              <div>
                <label for="material_pdf" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                  Material del Curso (PDF)
                </label>
                <div class="relative">
                  <input
                    id="material_pdf"
                    type="file"
                    @change="handleFileUpload"
                    accept=".pdf"
                    class="w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                  >
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                  Archivo PDF con el material del curso (máximo 10MB)
                </p>
                <div v-if="errors.material_pdf" class="text-red-600 dark:text-red-400 text-sm mt-1">
                  {{ errors.material_pdf }}
                </div>
                
                <!-- Preview del archivo seleccionado -->
                <div v-if="selectedFile" class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/50 rounded-lg border border-blue-200 dark:border-blue-700">
                  <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm text-blue-800 dark:text-blue-200 font-medium">{{ selectedFile.name }}</span>
                    <span class="text-xs text-blue-600 dark:text-blue-400">({{ formatFileSize(selectedFile.size) }})</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Estado -->
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Estado del Curso</h3>
              
              <div class="flex items-center">
                <input
                  id="activo"
                  type="checkbox"
                  v-model="form.activo"
                  class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700"
                >
                <label for="activo" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                  Curso activo (visible en el aula virtual)
                </label>
              </div>
              <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Solo los cursos activos serán visibles para los participantes
              </p>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 rounded-b-lg">
            <div class="flex justify-end space-x-4">
              <Link 
                :href="route('cursos.index')"
                class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200 font-medium"
              >
                Cancelar
              </Link>
              <button
                type="submit"
                :disabled="processing"
                class="px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg hover:from-orange-600 hover:to-orange-700 transition-all duration-200 font-medium shadow-lg transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed flex items-center space-x-2"
              >
                <svg v-if="processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>{{ processing ? 'Creando...' : 'Crear Curso' }}</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

// Props
const props = defineProps({
  errors: Object
})

// State
const processing = ref(false)
const selectedFile = ref(null)

// Breadcrumbs
const breadcrumbs = [
  { title: 'Cursos', href: '/cursos' },
  { title: 'Crear Curso', href: '/cursos/create' },
]

// Form data
const form = reactive({
  nombre_curso: '',
  descripcion: '',
  fecha_curso: '',
  hora_inicio: '',
  hora_fin: '',
  link_reunion: '',
  material_pdf: null,
  activo: true
})

// Methods
const handleFileUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    selectedFile.value = file
    form.material_pdf = file
  }
}

const formatFileSize = (bytes) => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}

const submit = () => {
  processing.value = true
  
  const formData = new FormData()
  
  // Agregar todos los campos del formulario
  Object.keys(form).forEach(key => {
    if (form[key] !== null && form[key] !== '') {
      if (key === 'activo') {
        formData.append(key, form[key] ? '1' : '0')
      } else {
        formData.append(key, form[key])
      }
    }
  })

  router.post(route('cursos.store'), formData, {
    onFinish: () => {
      processing.value = false
    },
    onError: (errors) => {
      console.error('Errores de validación:', errors)
    }
  })
}
</script><!-- resources/js/Pages/Cursos/Create.vue -->


<style scoped>
/* Estilos personalizados para el input de archivo */
input[type="file"]::-webkit-file-upload-button {
  visibility: hidden;
}

input[type="file"]::before {
  content: 'Seleccionar archivo';
  display: inline-block;
  background: linear-gradient(top, #f9f9f9, #e3e3e3);
  border: 1px solid #999;
  border-radius: 3px;
  padding: 5px 8px;
  outline: none;
  white-space: nowrap;
  cursor: pointer;
  text-shadow: 1px 1px #fff;
  font-weight: 700;
  font-size: 10pt;
}

input[type="file"]:hover::before {
  border-color: black;
}

input[type="file"]:active::before {
  background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
}
</style>