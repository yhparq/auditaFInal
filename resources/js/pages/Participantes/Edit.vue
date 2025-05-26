<template>
  <AppLayout>
    <div class="max-w-2xl mx-auto p-6 bg-white dark:bg-gray-900 shadow-md rounded-lg">
      <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Editar Participante</h1>

      <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-5">
        <!-- Nombre -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nombre</label>
          <input
            v-model="form.nombre"
            type="text"
            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm"
          />
        </div>

        <!-- Descripción -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Descripción</label>
          <textarea
            v-model="form.descripcion"
            rows="3"
            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm"
          ></textarea>
        </div>

        <!-- Estado -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Estado</label>
          <select
            v-model="form.estado"
            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm"
          >
            <option :value="1">Activo</option>
            <option :value="0">Inactivo</option>
          </select>
        </div>

        <!-- Foto -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Foto (opcional)</label>
          <input
            type="file"
            @change="handleFile"
            class="mt-1 block w-full text-sm text-gray-600 dark:text-gray-300 file:bg-blue-50 dark:file:bg-gray-700 file:text-blue-700 dark:file:text-blue-300"
          />
          <div v-if="participante.foto" class="mt-4">
            <p class="text-sm text-gray-600 dark:text-gray-300">Foto actual:</p>
            <img
              :src="`/storage/${participante.foto}`"
              alt="Foto actual"
              class="mt-2 w-24 h-24 object-cover rounded border dark:border-gray-700"
            />
          </div>
        </div>

        <!-- Botón -->
        <div class="text-right">
          <button
            type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
          >
            Actualizar
          </button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

interface Participante {
  id: number
  nombre: string
  descripcion: string
  estado: number
  foto: string | null
}

const props = defineProps<{ participante: Participante }>()

const form = useForm({
  nombre: props.participante.nombre,
  descripcion: props.participante.descripcion,
  estado: props.participante.estado,
  foto: null as File | null,
})

function handleFile(event: Event) {
  const target = event.target as HTMLInputElement
  if (target.files?.length) {
    form.foto = target.files[0]
  }
}

function submit() {
  form.post(`/admin/participantes/${props.participante.id}`, {
    _method: 'put',
  })
}
</script>
