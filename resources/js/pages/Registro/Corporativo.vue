<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import axios from 'axios'
import AuditaLayout from '@/layouts/AuditaLayout.vue'

const cantidad = ref(1)
const iniciado = ref(false)

const form = useForm({
    nombre_corporativo: '',
    voucher_global: null,
    participantes: [],
})

function iniciar() {
    form.participantes = Array.from({ length: cantidad.value }, () => ({
        nombres: '',
        apellidos: '',
        dni: '',
        departamento: '',
        provincia: '',
        distrito: '',
        direccion_actual: '',
        tipo_participante: 'corporativo',
        codigo_pago: '',
        foto_voucher: null,
        comprobante: 'boleta',
        numero_ruc: '',
        estado: false,
    }))
    iniciado.value = true
}

function handleGlobalFile(e) {
    form.voucher_global = e.target.files[0]
}

async function buscarDni(index) {
    const dni = form.participantes[index].dni
    if (dni.length === 8) {
        try {
            const res = await axios.get(`/api/dni/${dni}`)
            form.participantes[index].nombres = res.data.data.nombres
            form.participantes[index].apellidos = `${res.data.data.apellido_paterno} ${res.data.data.apellido_materno}`
        } catch (err) {
            form.participantes[index].nombres = ''
            form.participantes[index].apellidos = ''
            alert('DNI no encontrado')
        }
    }
}

function submit() {
    form.participantes.forEach(p => {
        p.nombre_corporativo = form.nombre_corporativo
        p.foto_voucher = form.voucher_global
    })

    const formData = new FormData()
    formData.append('nombre_corporativo', form.nombre_corporativo)

    if (form.voucher_global) {
        formData.append('voucher_global', form.voucher_global)
    }

    form.participantes.forEach((p, i) => {
        Object.entries(p).forEach(([key, value]) => {
            formData.append(`participantes[${i}][${key}]`, value)
        })
    })

    form.post('/registro', {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            iniciado.value = false
            form.reset()
        },
    })
}
</script>

<template>
    <AuditaLayout>
        <div class="min-h-screen bg-gradient-to-br from-[#eaf2fb] via-[#fef9ef] to-[#ffffff] py-16 px-4">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Formulario -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl p-8 border border-gray-200">
                    <h1 class="text-3xl font-extrabold text-[#00367e] text-center mb-8 uppercase">Inscripción
                        Corporativa</h1>

                    <!-- Paso 1 -->
                    <div v-if="!iniciado" class="text-center">
                        <label class="block text-lg text-gray-800 mb-4 font-medium">¿Cuántos participantes desea
                            registrar?</label>
                        <input v-model="cantidad" type="number" min="1"
                            class="w-32 mx-auto p-3 border rounded-lg text-center text-gray-800 focus:ring-2 focus:ring-[#00367e]" />
                        <div class="mt-6">
                            <button @click="iniciar"
                                class="px-6 py-2 bg-[#ae1f22] hover:bg-[#8c191a] text-white font-semibold rounded-full shadow transition">
                                Continuar
                            </button>
                        </div>
                    </div>

                    <!-- Paso 2 -->
                    <div v-else>
                        <!-- Nombre del Corporativo -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Nombre del Corporativo</label>
                            <input v-model="form.nombre_corporativo" required
                                class="w-full p-3 border rounded-lg bg-white text-gray-800 focus:ring-2 focus:ring-[#00367e]" />
                        </div>

                        <!-- Voucher único -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Foto del Voucher (una sola
                                vez)</label>
                            <input type="file" @change="handleGlobalFile" accept="image/*"
                                class="w-full p-3 border rounded-lg bg-white text-gray-800 focus:ring-2 focus:ring-[#00367e]" />
                        </div>

                        <!-- Participantes -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div v-for="(p, index) in form.participantes" :key="index"
                                class="bg-[#f9f9f9] rounded-xl shadow-md p-6 border border-gray-200">
                                <h2 class="text-lg font-bold text-[#00367e] mb-4">Participante {{ index + 1 }}</h2>

                                <div class="space-y-3 text-sm text-gray-800">
                                    <input v-model="p.dni" @blur="() => buscarDni(index)" placeholder="DNI"
                                        class="w-full p-2 border rounded focus:ring-2 focus:ring-[#00367e]" />
                                    <input v-model="p.nombres" placeholder="Nombres"
                                        class="w-full p-2 border rounded" />
                                    <input v-model="p.apellidos" placeholder="Apellidos"
                                        class="w-full p-2 border rounded" />
                                    <input v-model="p.departamento" placeholder="Departamento"
                                        class="w-full p-2 border rounded" />
                                    <input v-model="p.provincia" placeholder="Provincia"
                                        class="w-full p-2 border rounded" />
                                    <input v-model="p.distrito" placeholder="Distrito"
                                        class="w-full p-2 border rounded" />
                                    <input v-model="p.direccion_actual" placeholder="Dirección"
                                        class="w-full p-2 border rounded" />
                                    <input v-model="p.codigo_pago" placeholder="Código de Pago"
                                        class="w-full p-2 border rounded" />
                                    <select v-model="p.comprobante" class="w-full p-2 border rounded">
                                        <option value="boleta">Boleta</option>
                                        <option value="factura">Factura</option>
                                    </select>
                                    <input v-if="p.comprobante === 'factura'" v-model="p.numero_ruc"
                                        placeholder="Número de RUC" class="w-full p-2 border rounded" />
                                </div>
                            </div>
                        </div>

                        <!-- Botón Final -->
                        <div class="text-center mt-10">
                            <button @click="submit"
                                class="px-10 py-3 bg-[#00367e] hover:bg-[#002c66] text-white font-semibold rounded-full shadow-lg transition">
                                Registrar Participantes
                            </button>
                        </div>
                    </div>
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
