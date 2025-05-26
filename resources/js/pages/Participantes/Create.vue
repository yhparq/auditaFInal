<script setup>
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({ admin: Boolean });

const form = useForm({
    nombres: '',
    apellidos: '',
    dni: '',
    departamento: '',
    provincia: '',
    distrito: '',
    direccion_actual: '',
    tipo_participante: 'individual',
    codigo_pago: '',
    foto_voucher: null,
    comprobante: 'boleta',
    numero_ruc: '',
    nombre_corporativo: '',
    estado: false, // Inactivo por defecto
});

function handleFile(e) {
    const file = e.target.files[0];
    if (file) {
        form.foto_voucher = file;
    }
}

function submit() {
    const url = props.admin ? '/participantes' : '/registro';
    form.post(url);
}

async function buscarDni() {
  if (form.dni.length === 8) {
    try {
      const res = await axios.get(`/api/dni/${form.dni}`);
      form.nombres = res.data.data.nombres;
      form.apellidos = `${res.data.data.apellido_paterno} ${res.data.data.apellido_materno}`;
    } catch (err) {
      form.nombres = '';
      form.apellidos = '';
      alert('DNI no encontrado');
    }
  }
}



</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 px-4">
        <div class="w-full max-w-3xl bg-white dark:bg-gray-800 p-8 rounded-lg shadow">
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-6">
                Participante
            </h1>

            <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-5">
                <!-- Nombres y Apellidos -->

                <!-- DNI -->
                <div>
                    <label class="block text-sm text-gray-700 dark:text-gray-200">DNI</label>
                    <input v-model="form.dni" @blur="() => buscarDni(index)" type="text" maxlength="8" minlength="8" required
                        class="w-full mt-1 p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">



                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-200">Nombres</label>
                        <input v-model="form.nombres" type="text" required
                            class="w-full mt-1 p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-200">Apellidos</label>
                        <input v-model="form.apellidos" type="text" required
                            class="w-full mt-1 p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
                    </div>
                </div>


                <!-- Ubicación -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-200">Departamento</label>
                        <input v-model="form.departamento" required
                            class="w-full mt-1 p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-200">Provincia</label>
                        <input v-model="form.provincia" required
                            class="w-full mt-1 p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-200">Distrito</label>
                        <input v-model="form.distrito" required
                            class="w-full mt-1 p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
                    </div>
                </div>

                <!-- Dirección -->
                <div>
                    <label class="block text-sm text-gray-700 dark:text-gray-200">Dirección Actual</label>
                    <input v-model="form.direccion_actual"
                        class="w-full mt-1 p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
                </div>

                <!-- Tipo de Participante -->
                <div>
                    <label class="block text-sm text-gray-700 dark:text-gray-200">Tipo de Participante</label>
                    <select v-model="form.tipo_participante"
                        class="w-full mt-1 p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="individual">Individual</option>
                        <option value="corporativo">Corporativo</option>
                    </select>
                </div>

                <!-- Código de Pago -->
                <div>
                    <label class="block text-sm text-gray-700 dark:text-gray-200">Código de Pago</label>
                    <input v-model="form.codigo_pago" required
                        class="w-full mt-1 p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
                </div>

                <!-- Comprobante -->
                <div>
                    <label class="block text-sm text-gray-700 dark:text-gray-200">Comprobante</label>
                    <select v-model="form.comprobante"
                        class="w-full mt-1 p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="boleta">Boleta</option>
                        <option value="factura">Factura</option>
                    </select>
                </div>

                <!-- RUC (solo si se elige factura) -->
                <div v-if="form.comprobante === 'factura'">
                    <label class="block text-sm text-gray-700 dark:text-gray-200">Número de RUC</label>
                    <input v-model="form.numero_ruc" maxlength="11" minlength="11" required
                        class="w-full mt-1 p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
                </div>

                <!-- Nombre del Corporativo (solo si se elige tipo corporativo) -->
                <div v-if="form.tipo_participante === 'corporativo'">
                    <label class="block text-sm text-gray-700 dark:text-gray-200">Nombre del Corporativo</label>
                    <input v-model="form.nombre_corporativo" required
                        class="w-full mt-1 p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
                </div>

                <!-- Foto del Voucher -->
                <div>
                    <label class="block text-sm text-gray-700 dark:text-gray-200">Foto del Voucher</label>
                    <input type="file" @change="handleFile" accept="image/*"
                        class="w-full mt-1 p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
                </div>

                <!-- Botón -->
                <div class="text-center">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
