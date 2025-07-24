<template>
  <div class="min-h-screen bg-gray-50 flex flex-col">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-800 to-blue-900 shadow-lg">
<!-- AÑADIR ESTE AVISO AQUÍ -->
<div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
    <div class="flex items-center justify-center space-x-3">
      <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
      </svg>
      <p class="text-sm md:text-base font-medium text-center">
        📢 <strong>Importante:</strong> Las ponencias se realizarán por <strong>Zoom</strong>.
        Es necesario tener la aplicación descargada e instalada en tu dispositivo.
      </p>
      <a
        href="https://zoom.us/download"
        target="_blank"
        class="ml-2 bg-white text-orange-600 px-3 py-1 rounded-full text-xs font-bold hover:bg-orange-50 transition-colors duration-200 flex-shrink-0"
      >
        Descargar Zoom
      </a>
    </div>
  </div>
</div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
          <div class="flex items-center space-x-4">
            <img
              src="/images/logo1.png"
              alt="Audita 2025"
              class="h-16 w-auto"
            />
            <span class="text-blue-200 text-sm hidden md:block">|</span>
            <span class="text-blue-200 text-sm hidden md:block">Aula Virtual</span>
          </div>
          <div class="flex items-center space-x-4">
            <span class="text-white text-sm md:text-base">{{ participante.nombres }} {{ participante.apellidos }}</span>
            <button
              @click="logout"
              :disabled="logoutForm.processing"
              class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 transition-colors duration-200 text-sm font-medium disabled:opacity-50"
            >
              {{ logoutForm.processing ? 'Cerrando...' : 'Cerrar Sesión' }}
            </button>
          </div>
        </div>
      </div>
    </header>



    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-grow">
      <div class="flex gap-8">
        <!-- Sidebar -->
        <div class="w-64 bg-white rounded-lg shadow-lg border border-gray-200">
          <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-blue-100 rounded-t-lg">
            <h2 class="text-xl font-semibold text-blue-900 mb-2">Fechas de Curso</h2>
            <p class="text-sm text-blue-700">Julio 2025</p>
          </div>
          <div class="p-4 space-y-3">
            <div v-if="fechasFormateadas.length === 0" class="text-center py-4 text-gray-500">
              <p class="text-sm">No hay fechas disponibles</p>
            </div>
            <button
              v-for="fecha in fechasFormateadas"
              :key="fecha.valor"
              @click="seleccionarFecha(fecha.valor)"
              :class="[
                'w-full p-4 rounded-lg border-2 transition-all duration-300 text-left group hover:shadow-md',
                fechaSeleccionada === fecha.valor
                  ? 'border-blue-500 bg-gradient-to-r from-blue-50 to-blue-100 text-blue-800 shadow-md transform scale-105'
                  : 'border-gray-200 hover:border-blue-300 text-gray-700 hover:bg-blue-50'
              ]"
            >
              <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                  <div :class="[
                    'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors duration-300',
                    fechaSeleccionada === fecha.valor
                      ? 'bg-blue-500 text-white'
                      : 'bg-gray-200 text-gray-600 group-hover:bg-blue-200'
                  ]">
                    {{ fecha.dia }}
                  </div>
                </div>
                <div>
                  <div class="font-medium text-sm">{{ fecha.mes }} 2025</div>
                  <div :class="[
                    'text-xs transition-colors duration-300',
                    fechaSeleccionada === fecha.valor ? 'text-blue-600' : 'text-gray-500'
                  ]">
                    Ver cursos
                  </div>
                </div>
              </div>
            </button>
          </div>

          <!-- Enlace a página web de Audita -->
          <div class="p-4 border-t border-gray-200">
            <a
              href="https://audita2025ccppuno.org.pe"
              target="_blank"
              class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg"
            >
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
              </svg>
              <span class="font-medium text-sm">Visitar Audita 2025</span>
            </a>
          </div>
          <!-- Enlace a galería de fotos -->
          <div class="p-4 border-t border-gray-200">
            <a
              href="/galeria"
              class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg"
            >
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
              <span class="font-medium text-sm">Galería AUDITA 2025</span>
            </a>
          </div>

        </div>

        <!-- Main Content -->
        <div class="flex-1">
          <div class="bg-white rounded-lg shadow-lg border border-gray-200">
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-blue-100 rounded-t-lg">
              <h2 class="text-2xl font-semibold text-blue-900">
                {{ fechaSeleccionada ? `Cursos del ${fechaSeleccionadaTexto}` : 'Selecciona una fecha' }}
              </h2>
              <p class="text-blue-700 text-sm mt-1">AUDITA 2025 - Programa de Capacitación</p>
            </div>

            <div class="p-6">
              <!-- No date selected -->
              <div v-if="!fechaSeleccionada" class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Selecciona una fecha</h3>
                <p class="mt-1 text-sm text-gray-500">Elige una fecha del calendario para ver los cursos disponibles.</p>
              </div>

              <!-- Loading State -->
              <div v-else-if="cargando" class="text-center py-8">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                <p class="mt-2 text-gray-600">Cargando cursos...</p>
              </div>

              <!-- Error State -->
              <div v-else-if="error" class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Error al cargar cursos</h3>
                <p class="mt-1 text-sm text-gray-500">{{ error }}</p>
                <button
                  @click="cargarCursos"
                  class="mt-3 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200 text-sm"
                >
                  Intentar de nuevo
                </button>
              </div>

              <!-- No courses -->
              <div v-else-if="cursos.length === 0" class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay cursos</h3>
                <p class="mt-1 text-sm text-gray-500">No se encontraron cursos para esta fecha.</p>
              </div>

              <!-- Courses Grid -->
              <div v-else class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div
                  v-for="curso in cursos"
                  :key="curso.id"
                  class="bg-gradient-to-br from-white to-gray-50 rounded-xl border border-gray-200 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 hover:border-blue-300"
                >
                  <!-- Course Header -->
                  <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                      {{ curso.nombre_curso }}
                    </h3>
                    <p v-if="curso.descripcion" class="text-sm text-gray-600 mb-3 line-clamp-3">
                      {{ curso.descripcion }}
                    </p>
                    <div class="flex items-center space-x-2 text-sm text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                      </svg>
                      <span class="font-medium">{{ curso.hora_inicio }} - {{ curso.hora_fin }}</span>
                    </div>
                  </div>

                  <!-- Status Badge -->
                  <div class="mb-4">
                    <span :class="getEstadoBadgeClass(curso.estado)" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold shadow-sm">
                      <span :class="getEstadoDotClass(curso.estado)" class="w-2 h-2 rounded-full mr-2"></span>
                      {{ getEstadoTexto(curso.estado) }}
                    </span>
                  </div>

                  <!-- Actions -->
                  <div class="space-y-3">
                    <!-- Download Material -->
                    <button
                      v-if="curso.material_pdf"
                      @click="descargarMaterial(curso.id)"
                      class="w-full flex items-center justify-center px-4 py-3 border border-blue-300 rounded-lg shadow-sm bg-white text-sm font-medium text-blue-700 hover:bg-blue-50 hover:border-blue-400 transition-all duration-200 group"
                    >
                      <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                      </svg>
                      Descargar Material
                    </button>

                    <!-- Access Meeting -->
                    <button
                      @click="accederReunion(curso)"
                      :disabled="!curso.puede_acceder_reunion"
                      :class="[
                        'w-full flex items-center justify-center px-4 py-3 rounded-lg shadow-sm text-sm font-medium transition-all duration-200 group',
                        curso.puede_acceder_reunion
                          ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white hover:from-orange-600 hover:to-orange-700 transform hover:scale-105'
                          : 'bg-gray-300 text-gray-500 cursor-not-allowed'
                      ]"
                    >
                      <svg class="w-4 h-4 mr-2" :class="curso.puede_acceder_reunion ? 'group-hover:scale-110 transition-transform duration-200' : ''" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
                      </svg>
                      {{ curso.puede_acceder_reunion ? 'Acceder a Reunión' : 'Reunión no disponible' }}
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer con lema y copyright -->
    <footer class="bg-gradient-to-r from-red-700 to-red-800 text-white mt-auto">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="text-center">
          <!-- Lema -->
          <blockquote class="text-sm md:text-base font-light italic leading-relaxed max-w-3xl mx-auto mb-4">
            <span class="text-lg text-orange-300 font-serif">"</span>
            Auditoría y ética en la era digital: prevención de la corrupción con tecnología y transparencia
            <span class="text-lg text-orange-300 font-serif">"</span>
          </blockquote>

          <!-- Línea decorativa -->
          <div class="w-16 h-0.5 bg-orange-300 mx-auto mb-4"></div>

          <!-- Copyright y enlaces -->
          <div class="flex flex-col md:flex-row justify-center items-center space-y-2 md:space-y-0 md:space-x-6 text-xs text-blue-200">
            <p>© 2025 AUDITA - Colegio de Contadores Públicos de Puno</p>
            <span class="hidden md:block">|</span>
            <a
              href="https://audita2025ccppuno.org.pe"
              target="_blank"
              class="hover:text-orange-300 transition-colors duration-200"
            >
              audita2025ccppuno.org.pe
            </a>
            <span class="hidden md:block">|</span>
            <p>Todos los derechos reservados</p>
          </div>
        </div>
      </div>
    </footer>

    <!-- Toast Notifications -->
    <div v-if="notificacion" class="fixed top-4 right-4 z-50">
      <div :class="[
        'p-4 rounded-md shadow-lg max-w-sm border',
        notificacion.tipo === 'error' ? 'bg-red-50 text-red-800 border-red-200' : 'bg-green-50 text-green-800 border-green-200'
      ]">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg v-if="notificacion.tipo === 'error'" class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
            <svg v-else class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium">{{ notificacion.mensaje }}</p>
          </div>
          <div class="ml-auto pl-3">
            <button @click="cerrarNotificacion" class="inline-flex text-gray-400 hover:text-gray-600">
              <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useForm, router } from '@inertiajs/vue3'

// Props recibidas desde Laravel
const props = defineProps({
  participante: Object,
  fechasDisponibles: Array
})

// Formulario para logout
const logoutForm = useForm({})

// Estado reactivo
const fechaSeleccionada = ref(null)
const cursos = ref([])
const cargando = ref(false)
const notificacion = ref(null)
const error = ref(null)

// Debug: mostrar las fechas recibidas del servidor
console.log('Fechas disponibles recibidas del servidor:', props.fechasDisponibles)

// Computadas
const fechasFormateadas = computed(() => {
  if (!props.fechasDisponibles || props.fechasDisponibles.length === 0) {
    return []
  }

  const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']

  return props.fechasDisponibles.map(fecha => {
    const date = new Date(fecha + 'T00:00:00') // Evitar problemas de zona horaria
    return {
      valor: fecha,
      dia: date.getDate(),
      mes: meses[date.getMonth()]
    }
  })
})

const fechaSeleccionadaTexto = computed(() => {
  if (!fechaSeleccionada.value) return ''
  const fecha = fechasFormateadas.value.find(f => f.valor === fechaSeleccionada.value)
  return fecha ? `${fecha.dia} de ${fecha.mes}` : ''
})

// Métodos
const seleccionarFecha = async (fecha) => {
  fechaSeleccionada.value = fecha
  await cargarCursos()
}

const cargarCursos = async () => {
  if (!fechaSeleccionada.value) {
    console.warn('No hay fecha seleccionada')
    return
  }

  console.log('Cargando cursos para fecha:', fechaSeleccionada.value)

  cargando.value = true
  error.value = null

  try {
    const response = await fetch(route('aula-virtual.cursos-por-fecha') + '?' + new URLSearchParams({
      fecha: fechaSeleccionada.value
    }), {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      }
    })

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`)
    }

    const data = await response.json()
    console.log('Respuesta del servidor:', data)

    if (data.error) {
      throw new Error(data.message || 'Error del servidor')
    }

    cursos.value = data.cursos || []
    console.log('Cursos cargados:', cursos.value.length)

  } catch (err) {
    console.error('Error al cargar cursos:', err)
    error.value = err.message || 'Error al cargar los cursos'
    mostrarNotificacion('Error al cargar los cursos: ' + err.message, 'error')
  } finally {
    cargando.value = false
  }
}

const descargarMaterial = async (cursoId) => {
  try {
    // Usar la ruta helper de Inertia si está disponible
    const url = route ? route('aula-virtual.descargar-material', cursoId) : `/aula-virtual/descargar-material/${cursoId}`
    window.open(url, '_blank')
    mostrarNotificacion('Descarga iniciada correctamente', 'success')
  } catch (error) {
    console.error('Error al descargar material:', error)
    mostrarNotificacion('Error al descargar el material', 'error')
  }
}

const accederReunion = async (curso) => {
  if (!curso.puede_acceder_reunion) {
    mostrarNotificacion('La reunión no está disponible en este momento', 'error')
    return
  }

  // Simplemente abrir el link directo
  if (curso.link_reunion) {
    window.open(curso.link_reunion, '_blank')
    mostrarNotificacion('Accediendo a la reunión...', 'success')
  } else {
    mostrarNotificacion('Link de reunión no disponible', 'error')
  }
}


const getEstadoBadgeClass = (estado) => {
  const classes = {
    'proximamente': 'bg-gradient-to-r from-yellow-400 to-yellow-500 text-white',
    'en_vivo': 'bg-gradient-to-r from-green-500 to-green-600 text-white',
    'finalizada': 'bg-gradient-to-r from-gray-400 to-gray-500 text-white'
  }
  return classes[estado] || 'bg-gradient-to-r from-gray-400 to-gray-500 text-white'
}

const getEstadoDotClass = (estado) => {
  const classes = {
    'proximamente': 'bg-yellow-300',
    'en_vivo': 'bg-green-300',
    'finalizada': 'bg-gray-300'
  }
  return classes[estado] || 'bg-gray-300'
}

const getEstadoTexto = (estado) => {
  const textos = {
    'proximamente': 'Próximamente',
    'en_vivo': 'En Vivo',
    'finalizada': 'Finalizada'
  }
  return textos[estado] || 'Desconocido'
}

const mostrarNotificacion = (mensaje, tipo = 'success') => {
  notificacion.value = { mensaje, tipo }
  // Auto-ocultar después de 5 segundos
  setTimeout(() => {
    notificacion.value = null
  }, 5000)
}

const cerrarNotificacion = () => {
  notificacion.value = null
}

const logout = () => {
  logoutForm.post(route('aula-virtual.logout'))
}

// Lifecycle - seleccionar primera fecha disponible al montar
onMounted(() => {
  if (fechasFormateadas.value.length > 0) {
    seleccionarFecha(fechasFormateadas.value[0].valor)
  }
})
</script>

<style scoped>
/* Animaciones personalizadas */
.transition-all {
  transition: all 0.2s ease-in-out;
}

/* Clamp lines para truncar texto */
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
