<script setup>
import { useForm } from '@inertiajs/vue3'
import axios from 'axios'
import AuditaLayout from '@/layouts/AuditaLayout.vue'
import { ref, watchEffect } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const successMessage = ref(page.props.flash?.success || null)

watchEffect(() => {
    if (successMessage.value) {
        setTimeout(() => {
            successMessage.value = null
        }, 4000)
    }
})

const props = defineProps({ admin: Boolean })

const form = useForm({
    nombres: '',
    apellidos: '',
    dni: '',
    correo: '',
    celular: '',
    colegio_departamental: '',
    departamento: '',
    provincia: '',
    distrito: '',
    direccion_actual: '',
    tipo_participante_categoria: '',
    modalidad_participacion: '',
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
        <!-- Mensaje de éxito -->
        <div v-if="successMessage" 
             class="fixed top-6 right-6 z-50 bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-xl shadow-xl backdrop-blur-sm">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="font-medium">{{ successMessage }}</span>
            </div>
        </div>

        <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold text-slate-900 mb-4">Registro de Participante</h1>
                    <p class="text-lg text-slate-600 max-w-2xl mx-auto">Complete el formulario con sus datos personales y de participación</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Formulario Principal -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
                                <h2 class="text-2xl font-semibold text-white">Información del Participante</h2>
                            </div>

                            <form @submit.prevent="submit" enctype="multipart/form-data" class="p-8 space-y-8">
                                <!-- Información Personal -->
                                <div class="space-y-6">
                                    <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-2">Información Personal</h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-slate-700">DNI</label>
                                            <input v-model="form.dni" @blur="buscarDni" type="text" maxlength="8" minlength="8" required
                                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-slate-900" 
                                                placeholder="12345678" />
                                            <div v-if="form.errors.dni" class="text-red-600 text-sm">{{ form.errors.dni }}</div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-slate-700">Nombres</label>
                                            <input v-model="form.nombres" type="text" required
                                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-slate-900" 
                                                placeholder="Juan Carlos" />
                                            <div v-if="form.errors.nombres" class="text-red-600 text-sm">{{ form.errors.nombres }}</div>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-slate-700">Apellidos</label>
                                            <input v-model="form.apellidos" type="text" required
                                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-slate-900" 
                                                placeholder="Pérez García" />
                                            <div v-if="form.errors.apellidos" class="text-red-600 text-sm">{{ form.errors.apellidos }}</div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-slate-700">Correo Electrónico</label>
                                            <input v-model="form.correo" type="email" required
                                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-slate-900" 
                                                placeholder="juan@ejemplo.com" />
                                            <div v-if="form.errors.correo" class="text-red-600 text-sm">{{ form.errors.correo }}</div>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-slate-700">Número de Celular</label>
                                            <input v-model="form.celular" type="text" required
                                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-slate-900" 
                                                placeholder="987654321" />
                                            <div v-if="form.errors.celular" class="text-red-600 text-sm">{{ form.errors.celular }}</div>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-slate-700">Colegio Departamental <span class="text-slate-500">(Opcional)</span></label>
                                        <select v-model="form.colegio_departamental"
                                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-slate-900">
                                            <option value="">NO PERTENEZCO A NINGÚN COLEGIO DEPARTAMENTAL</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE AMAZONAS">COLEGIO DE CONTADORES PÚBLICOS DE AMAZONAS</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE ANCASH">COLEGIO DE CONTADORES PÚBLICOS DE ANCASH</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE APURIMAC">COLEGIO DE CONTADORES PÚBLICOS DE APURIMAC</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE AREQUIPA">COLEGIO DE CONTADORES PÚBLICOS DE AREQUIPA</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE AYACUCHO">COLEGIO DE CONTADORES PÚBLICOS DE AYACUCHO</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE CAJAMARCA">COLEGIO DE CONTADORES PÚBLICOS DE CAJAMARCA</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE CALLAO">COLEGIO DE CONTADORES PÚBLICOS DE CALLAO</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE CUSCO">COLEGIO DE CONTADORES PÚBLICOS DE CUSCO</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE HUANCAVELICA">COLEGIO DE CONTADORES PÚBLICOS DE HUANCAVELICA</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE HUÁNUCO">COLEGIO DE CONTADORES PÚBLICOS DE HUÁNUCO</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE ICA">COLEGIO DE CONTADORES PÚBLICOS DE ICA</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE JUNÍN">COLEGIO DE CONTADORES PÚBLICOS DE JUNÍN</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE LA LIBERTAD">COLEGIO DE CONTADORES PÚBLICOS DE LA LIBERTAD</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE LAMBAYEQUE">COLEGIO DE CONTADORES PÚBLICOS DE LAMBAYEQUE</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE LIMA">COLEGIO DE CONTADORES PÚBLICOS DE LIMA</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE LORETO">COLEGIO DE CONTADORES PÚBLICOS DE LORETO</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE MADRE DE DIOS">COLEGIO DE CONTADORES PÚBLICOS DE MADRE DE DIOS</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE MOQUEGUA">COLEGIO DE CONTADORES PÚBLICOS DE MOQUEGUA</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE PASCO">COLEGIO DE CONTADORES PÚBLICOS DE PASCO</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE PIURA">COLEGIO DE CONTADORES PÚBLICOS DE PIURA</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE PUNO">COLEGIO DE CONTADORES PÚBLICOS DE PUNO</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE SAN MARTÍN">COLEGIO DE CONTADORES PÚBLICOS DE SAN MARTÍN</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE TACNA">COLEGIO DE CONTADORES PÚBLICOS DE TACNA</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE TUMBES">COLEGIO DE CONTADORES PÚBLICOS DE TUMBES</option>
                                            <option value="COLEGIO DE CONTADORES PÚBLICOS DE UCAYALI">COLEGIO DE CONTADORES PÚBLICOS DE UCAYALI</option>
                                        </select>
                                        <div v-if="form.errors.colegio_departamental" class="text-red-600 text-sm">{{ form.errors.colegio_departamental }}</div>
                                    </div>
                                </div>

                                <!-- Ubicación -->
                                <div class="space-y-6">
                                    <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-2">Ubicación</h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-slate-700">Departamento</label>
                                            <input v-model="form.departamento" required 
                                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-slate-900" 
                                                placeholder="Lima" />
                                            <div v-if="form.errors.departamento" class="text-red-600 text-sm">{{ form.errors.departamento }}</div>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-slate-700">Provincia</label>
                                            <input v-model="form.provincia" required 
                                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-slate-900" 
                                                placeholder="Lima" />
                                            <div v-if="form.errors.provincia" class="text-red-600 text-sm">{{ form.errors.provincia }}</div>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-slate-700">Distrito</label>
                                            <input v-model="form.distrito" required 
                                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-slate-900" 
                                                placeholder="Miraflores" />
                                            <div v-if="form.errors.distrito" class="text-red-600 text-sm">{{ form.errors.distrito }}</div>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-slate-700">Dirección Actual <span class="text-slate-500">(Opcional)</span></label>
                                        <textarea v-model="form.direccion_actual" rows="2"
                                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-slate-900" 
                                            placeholder="Ingrese su dirección completa"></textarea>
                                    </div>
                                </div>

                                <!-- Tipo de Participación -->
                                <div class="space-y-6">
                                    <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-2">Tipo de Participación</h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-slate-700">Categoría de Participante</label>
                                            <select v-model="form.tipo_participante_categoria" required 
                                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-slate-900">
                                                <option value="">Seleccionar categoría</option>
                                                <option value="pleno">Participante Pleno</option>
                                                <option value="observador">Observador</option>
                                                <option value="estudiante">Estudiante</option>
                                            </select>
                                            <div v-if="form.errors.tipo_participante_categoria" class="text-red-600 text-sm">{{ form.errors.tipo_participante_categoria }}</div>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-slate-700">Modalidad de Participación</label>
                                            <select v-model="form.modalidad_participacion" required 
                                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-slate-900">
                                                <option value="">Seleccionar modalidad</option>
                                                <option value="presencial">Presencial</option>
                                                <option value="virtual">Virtual</option>
                                            </select>
                                            <div v-if="form.errors.modalidad_participacion" class="text-red-600 text-sm">{{ form.errors.modalidad_participacion }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información de Pago -->
                                <div class="space-y-6">
                                    <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-2">Información de Pago</h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-slate-700">Código de Pago</label>
                                            <input v-model="form.codigo_pago" required 
                                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-slate-900" 
                                                placeholder="Código de operación" />
                                            <div v-if="form.errors.codigo_pago" class="text-red-600 text-sm">{{ form.errors.codigo_pago }}</div>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-slate-700">Tipo de Comprobante</label>
                                            <select v-model="form.comprobante" 
                                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-slate-900">
                                                <option value="boleta">Boleta</option>
                                                <option value="factura">Factura</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div v-if="form.comprobante === 'factura'" class="space-y-2">
                                        <label class="block text-sm font-medium text-slate-700">Número de RUC</label>
                                        <input v-model="form.numero_ruc" maxlength="11" minlength="11" required
                                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-slate-900" 
                                            placeholder="20123456789" />
                                        <div v-if="form.errors.numero_ruc" class="text-red-600 text-sm">{{ form.errors.numero_ruc }}</div>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-slate-700">Foto del Voucher <span class="text-slate-500"></span></label>
                                        <div class="relative">
                                            <input type="file" @change="handleFile" accept="image/*"
                                                class="w-full px-4 py-3 border-2 border-dashed border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                        </div>
                                        <div v-if="form.errors.foto_voucher" class="text-red-600 text-sm">{{ form.errors.foto_voucher }}</div>
                                    </div>
                                </div>

                                <!-- Botón de Envío -->
                                <div class="pt-6 border-t border-slate-200">
                                    <button type="submit" :disabled="form.processing"
                                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <span v-if="form.processing" class="flex items-center justify-center">
                                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Procesando...
                                        </span>
                                        <span v-else>Registrar Participante</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Panel Informativo -->
                    <div class="space-y-6">
                        <!-- Información Importante -->
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-4">
                                <h3 class="text-lg font-semibold text-white flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    Información Importante
                                </h3>
                            </div>
                            <div class="p-6">
                                <ul class="space-y-3 text-sm text-slate-700">
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 text-green-500 mt-1 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        El DNI debe tener 8 dígitos válidos
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 text-green-500 mt-1 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        El correo electrónico debe ser válido y único
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 text-green-500 mt-1 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        El Colegio Departamental es opcional
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 text-green-500 mt-1 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Seleccione correctamente su tipo y modalidad
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 text-green-500 mt-1 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Para factura es obligatorio el RUC
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 text-green-500 mt-1 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Suba una imagen clara del voucher
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Métodos de Pago -->
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-500 px-6 py-4">
                                <h3 class="text-lg font-semibold text-white flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                    </svg>
                                    Métodos de Pago
                                </h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <!-- Yape -->
                                <div class="bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-xl p-4">
                                    <div class="flex items-center mb-2">
                                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-white text-sm font-bold">Y</span>
                                        </div>
                                        <h4 class="font-semibold text-slate-900">Yape</h4>
                                    </div>
                                    <div class="text-sm text-slate-700 space-y-1">
                                        <p><span class="font-medium">Nombre:</span> Benjamín Avendaño</p>
                                        <p><span class="font-medium">Celular:</span> 978785287</p>
                                    </div>
                                </div>

                                <!-- BCP -->
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-4">
                                    <div class="flex items-center mb-2">
                                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-white text-xs font-bold">BCP</span>
                                        </div>
                                        <h4 class="font-semibold text-slate-900">Banco de Crédito del Perú</h4>
                                    </div>
                                    <div class="text-sm text-slate-700 space-y-1">
                                        <p><span class="font-medium">Cuenta:</span> 495-06703997-0-91</p>
                                        <p><span class="font-medium">CCI:</span> 002-49510670399709106</p>
                                    </div>
                                </div>

                                <!-- Nota importante -->
                                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-amber-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <div class="text-sm text-amber-800">
                                            <p class="font-medium mb-1">Importante:</p>
                                            <p>El <strong>código de pago</strong> es el número de operación del Yape o transferencia bancaria.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuditaLayout>
</template>