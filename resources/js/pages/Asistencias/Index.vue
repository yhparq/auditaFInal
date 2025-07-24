<!-- resources/js/Pages/Asistencias/Index.vue -->
<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <div>
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Control de Asistencia</h1>
        <p class="text-gray-600 dark:text-gray-400">Escanee DNI para registrar asistencia</p>
      </div>

      <!-- Stats -->
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
        <div class="flex justify-between items-center">
          <div class="text-center flex-1">
            <div class="text-4xl font-bold text-blue-600 dark:text-blue-400">{{ total }}</div>
            <div class="text-gray-600 dark:text-gray-400">Asistencias de Hoy</div>
          </div>
          <div>
            <button
              @click="exportarExcel"
              class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors duration-200"
              :disabled="total === 0"
            >
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
              <span>Exportar Excel</span>
            </button>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Scanner -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
          <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">
            Lectora de DNI
          </h2>

          <input
            type="text"
            v-model="dni"
            @keyup.enter="verificarDni"
            @input="procesarEscaneo"
            class="w-full px-4 py-3 text-lg border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white mb-4"
            placeholder="Escanee o ingrese DNI..."
            :disabled="loading"
            ref="dniInput"
          >

          <!-- Resultado -->
          <div v-if="resultado" :class="[
            'p-4 rounded-lg',
            resultado.success
              ? 'bg-green-50 dark:bg-green-900 text-green-800 dark:text-green-200'
              : 'bg-red-50 dark:bg-red-900 text-red-800 dark:text-red-200'
          ]">
            <div class="font-medium">{{ resultado.message }}</div>
            <div v-if="resultado.participante" class="mt-2">
              <strong>{{ resultado.participante.nombre }}</strong><br>
              DNI: {{ resultado.participante.dni }}
            </div>
          </div>
        </div>

        <!-- Lista de Asistencias -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
              Asistencias Hoy
            </h2>
            <button
              @click="cargarAsistencias"
              class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300"
            >
              🔄
            </button>
          </div>

          <div class="max-h-96 overflow-y-auto">
            <div v-if="asistencias.length === 0" class="text-center py-8 text-gray-500 dark:text-gray-400">
              No hay asistencias registradas
            </div>

            <div v-else class="space-y-3">
              <div
                v-for="asistencia in asistencias"
                :key="asistencia.id"
                class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg"
              >
                <div class="flex justify-between items-start">
                  <div class="flex-1">
                    <div class="font-medium text-gray-900 dark:text-white">
                      {{ asistencia.nombre }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                      DNI: {{ asistencia.dni }}
                    </div>
                    <div v-if="asistencia.tipo" class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                      {{ asistencia.tipo }}
                    </div>
                  </div>
                  <div class="text-sm text-gray-600 dark:text-gray-300 text-right">
                    <div>{{ formatearHora(asistencia.hora) }}</div>
                    <div class="text-xs text-gray-400">{{ asistencia.fecha }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabla simple -->
      <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
          <h3 class="text-lg font-medium text-gray-900 dark:text-white">
            Registro de Asistencias
          </h3>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                  Participante
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                  DNI
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                  Tipo
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                  Fecha
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                  Hora
                </th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
              <tr v-if="asistencias.length === 0">
                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                  No hay asistencias registradas
                </td>
              </tr>
              <tr v-else v-for="asistencia in asistencias" :key="'table-' + asistencia.id" class="hover:bg-gray-50 dark:hover:bg-gray-700">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900 dark:text-white">
                    {{ asistencia.nombre }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900 dark:text-white">
                    {{ asistencia.dni }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span v-if="asistencia.tipo" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                    {{ asistencia.tipo }}
                  </span>
                  <span v-else class="text-gray-400">-</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900 dark:text-white">
                    {{ asistencia.fecha }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900 dark:text-white">
                    {{ formatearHora(asistencia.hora) }}
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import axios from 'axios'

// Props
const props = defineProps({
  asistencias: {
    type: Array,
    default: () => []
  },
  total: {
    type: Number,
    default: 0
  }
})

// State
const dni = ref('')
const loading = ref(false)
const resultado = ref(null)
const asistencias = ref(props.asistencias || [])
const total = ref(props.total || 0)
const dniInput = ref(null)

// Breadcrumbs
const breadcrumbs = [
  { title: 'Asistencias', href: '/asistencias' },
]

// Configurar axios
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')

// Methods
const verificarDni = async () => {
  if (!dni.value.trim()) return

  loading.value = true
  resultado.value = null

  try {
    const response = await axios.post('/asistencias/verificar', {
      dni: dni.value.trim()
    })

    resultado.value = response.data
    dni.value = ''

    // Actualizar lista SIEMPRE (exitoso o no)
    await cargarAsistencias()

    // Limpiar resultado después de 3 segundos
    setTimeout(() => {
      resultado.value = null
    }, 3000)

  } catch (error) {
    console.error('Error:', error)
    resultado.value = {
      success: false,
      message: 'Error de conexión'
    }
    // Actualizar lista incluso si hay error
    await cargarAsistencias()
  } finally {
    loading.value = false
    enfocarInput()
  }
}

const cargarAsistencias = async () => {
  try {
    const response = await axios.get('/asistencias/hoy')
    if (response.data.success) {
      asistencias.value = response.data.asistencias
      total.value = response.data.total
    }
  } catch (error) {
    console.error('Error cargando asistencias:', error)
  }
}

const limpiarResultado = () => {
  if (resultado.value) {
    resultado.value = null
  }
}

const enfocarInput = () => {
  nextTick(() => {
    if (dniInput.value) {
      dniInput.value.focus()
    }
  })
}

const formatearHora = (hora) => {
  if (!hora) return ''

  // Si viene en formato H:i:s, cortamos los segundos
  if (hora.includes(':') && hora.split(':').length === 3) {
    return hora.substring(0, 5) // HH:MM
  }

  // Si viene en formato timestamp largo
  if (hora.includes('T')) {
    return new Date(hora).toLocaleTimeString('es-ES', {
      hour: '2-digit',
      minute: '2-digit'
    })
  }

  return hora
}

const exportarExcel = () => {
  if (total.value === 0) {
    alert('No hay asistencias para exportar')
    return
  }

  // Crear URL de descarga directa
  const fecha = new Date().toISOString().split('T')[0]
  const url = `/asistencias/exportar?fecha=${fecha}`

  // Abrir directamente en nueva ventana para forzar descarga
  window.open(url, '_blank')
}

// Lifecycle
onMounted(() => {
  enfocarInput()

  // Actualizar cada 5 segundos
  setInterval(() => {
    cargarAsistencias()
  }, 5000)
})
</script>
