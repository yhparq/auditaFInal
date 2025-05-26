<script setup>
import { useForm } from '@inertiajs/vue3'
import axios from 'axios'
import AuditaLayout from '@/layouts/AuditaLayout.vue'

const props = defineProps({ admin: Boolean })

const form = useForm({
    nombres: '',
    apellidos: '',
    dni: '',
    departamento: '',
    provincia: '',
    distrito: '',
    direccion_actual: '',
    codigo_pago: '',
    foto_voucher: null,
    comprobante: 'boleta',
    numero_ruc: '',
    nombre_corporativo: '',
    estado: false,
    tipo_participante: 'individual',
})

function handleFile(e) {
    const file = e.target.files[0]
    if (file) form.foto_voucher = file
}

function submit() {
    const url = props.admin ? '/participantes' : '/registro1'
    form.post(url)
}

async function buscarDni() {
    if (form.dni.length === 8) {
        try {
            const res = await axios.get(`/api/dni/${form.dni}`)
            form.nombres = res.data.data.nombres
            form.apellidos = `${res.data.data.apellido_paterno} ${res.data.data.apellido_materno}`
        } catch {
            form.nombres = ''
            form.apellidos = ''
        }
    }
}
</script>

<template>
    <AuditaLayout>
        <div class="min-h-screen bg-gradient-to-br from-[#eaf2fb] via-[#fef9ef] to-white py-16 px-4">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Formulario -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl p-8 border border-gray-200">
                    <h1 class="text-3xl font-extrabold text-[#00367e] text-center mb-8 uppercase">
                        Registro de Participante
                    </h1>

                    <form @submit.prevent="submit" enctype="multipart/form-data"
                        class="space-y-6 text-gray-800 text-sm">
                        <div>
                            <label class="block font-semibold mb-1">DNI</label>
                            <input v-model="form.dni" @blur="buscarDni" type="text" maxlength="8" minlength="8" required
                                class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#00367e]" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-semibold mb-1">Nombres</label>
                                <input v-model="form.nombres" type="text" required
                                    class="w-full p-3 border rounded-lg" />
                            </div>
                            <div>
                                <label class="block font-semibold mb-1">Apellidos</label>
                                <input v-model="form.apellidos" type="text" required
                                    class="w-full p-3 border rounded-lg" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block font-semibold mb-1">Departamento</label>
                                <input v-model="form.departamento" required class="w-full p-3 border rounded-lg" />
                            </div>
                            <div>
                                <label class="block font-semibold mb-1">Provincia</label>
                                <input v-model="form.provincia" required class="w-full p-3 border rounded-lg" />
                            </div>
                            <div>
                                <label class="block font-semibold mb-1">Distrito</label>
                                <input v-model="form.distrito" required class="w-full p-3 border rounded-lg" />
                            </div>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Dirección Actual</label>
                            <input v-model="form.direccion_actual" class="w-full p-3 border rounded-lg" />
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Código de Pago</label>
                            <input v-model="form.codigo_pago" required class="w-full p-3 border rounded-lg" />
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Tipo de Comprobante</label>
                            <select v-model="form.comprobante" class="w-full p-3 border rounded-lg">
                                <option value="boleta">Boleta</option>
                                <option value="factura">Factura</option>
                            </select>
                        </div>

                        <div v-if="form.comprobante === 'factura'">
                            <label class="block font-semibold mb-1">Número de RUC</label>
                            <input v-model="form.numero_ruc" maxlength="11" minlength="11" required
                                class="w-full p-3 border rounded-lg" />
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Foto del Voucher</label>
                            <input type="file" @change="handleFile" accept="image/*"
                                class="w-full p-3 border rounded-lg bg-white" />
                        </div>

                        <div class="text-center pt-4">
                            <button type="submit"
                                class="px-10 py-3 bg-[#00367e] hover:bg-[#002c66] text-white font-semibold rounded-full shadow-lg transition">
                                Guardar Participante
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Card Informativo -->
                <!-- Card Informativo -->
                <div class="bg-[#fff9ec] border-l-4 border-[#ffb300] rounded-xl p-6 shadow-lg h-fit">
                    <h3 class="text-xl font-bold text-[#00367e] mb-4">📝 Información Importante</h3>
                    <ul class="text-sm text-gray-800 space-y-3 list-disc list-inside mb-6">
                        <li>El <strong>DNI</strong> debe tener 8 dígitos válidos.</li>
                        <li>Revise cuidadosamente sus datos antes de guardar.</li>
                        <li>Si solicita <strong>factura</strong>, debe ingresar el RUC.</li>
                        <li>Recuerde subir la imagen clara del <strong>voucher</strong>.</li>
                    </ul>

                    <!-- Métodos de pago -->
                    <div class="space-y-4 text-sm text-gray-800">
                        <h4 class="text-lg font-bold text-[#00367e] mb-2">💳 Métodos de Pago</h4>

                        <!-- Yape -->
                        <div class="bg-white border-l-4 border-[#00367e] rounded-md p-4 shadow-sm">
                            <p class="font-semibold mb-1">Billetera Digital (Yape)</p>
                            <p><strong>Nombre:</strong> Benjamín Avendaño</p>
                            <p><strong>Número de celular:</strong> 978785287</p>
                        </div>

                        <!-- BCP -->
                        <div class="bg-white border-l-4 border-[#ffb300] rounded-md p-4 shadow-sm">
                            <p class="font-semibold mb-1">Banco de Crédito del Perú (BCP)</p>
                            <p><strong>Cuenta en soles:</strong> 495-06703997-0-91</p>
                            <p><strong>CCI:</strong> 002-49510670399709106</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuditaLayout>
</template>
