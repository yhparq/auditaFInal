<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import axios from 'axios'
import AuditaLayout from '@/layouts/AuditaLayout.vue'
import { watchEffect } from 'vue'
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
        correo: '',
        celular: '',
        colegio_departamental: '',
        departamento: '',
        provincia: '',
        distrito: '',
        direccion_actual: '',
        tipo_participante: 'corporativo',
        tipo_participante_categoria: '',
        modalidad_participacion: '',
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
    // Validación básica antes de enviar
    if (!form.nombre_corporativo) {
        alert('Por favor, ingrese el nombre del corporativo')
        return
    }

    // Validar que todos los participantes tengan los campos requeridos
    for (let i = 0; i < form.participantes.length; i++) {
        const p = form.participantes[i]
        if (!p.dni || p.dni.length !== 8) {
            alert(`El DNI del participante ${i + 1} es requerido y debe tener 8 dígitos`)
            return
        }
        if (!p.nombres) {
            alert(`Los nombres del participante ${i + 1} son requeridos`)
            return
        }
        if (!p.apellidos) {
            alert(`Los apellidos del participante ${i + 1} son requeridos`)
            return
        }
        if (!p.correo) {
            alert(`El correo del participante ${i + 1} es requerido`)
            return
        }
        if (!p.celular) {
            alert(`El celular del participante ${i + 1} es requerido`)
            return
        }
        if (!p.departamento) {
            alert(`El departamento del participante ${i + 1} es requerido`)
            return
        }
        if (!p.provincia) {
            alert(`La provincia del participante ${i + 1} es requerida`)
            return
        }
        if (!p.distrito) {
            alert(`El distrito del participante ${i + 1} es requerido`)
            return
        }
        if (!p.tipo_participante_categoria) {
            alert(`El tipo de participante ${i + 1} es requerido`)
            return
        }
        if (!p.modalidad_participacion) {
            alert(`La modalidad de participación del participante ${i + 1} es requerida`)
            return
        }
        if (!p.codigo_pago) {
            alert(`El código de pago del participante ${i + 1} es requerido`)
            return
        }
        if (p.comprobante === 'factura' && (!p.numero_ruc || p.numero_ruc.length !== 11)) {
            alert(`El RUC del participante ${i + 1} es requerido y debe tener 11 dígitos`)
            return
        }
    }

    // Asignar datos corporativos a cada participante
    form.participantes.forEach(p => {
        p.nombre_corporativo = form.nombre_corporativo
        if (form.voucher_global) {
            p.foto_voucher = form.voucher_global
        }
    })

    // Usar el método post normal de Inertia
    form.post('/registro', {
        preserveScroll: true,
        onSuccess: () => {
            iniciado.value = false
            cantidad.value = 1
            form.reset()
            alert('Participantes registrados exitosamente')
        },
        onError: (errors) => {
            console.error('Errores de validación:', errors)
            if (errors.participantes) {
                alert('Hay errores en los datos de los participantes. Revise los campos marcados en rojo.')
            } else {
                alert('Error al registrar participantes. Revise los datos e intente nuevamente.')
            }
        }
    })
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
                    <h1 class="text-4xl font-bold text-slate-900 mb-4">Inscripción Corporativa</h1>
                    <p class="text-lg text-slate-600 max-w-2xl mx-auto">Registre múltiples participantes de su organización</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Formulario Principal -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                                <h2 class="text-2xl font-semibold text-white">Registro Corporativo</h2>
                            </div>

                            <div class="p-8">
                                <!-- Paso 1: Cantidad -->
                                <div v-if="!iniciado" class="text-center space-y-6">
                                    <div class="space-y-4">
                                        <label class="block text-xl font-semibold text-slate-900">¿Cuántos participantes desea registrar?</label>
                                        <div class="flex justify-center">
                                            <input v-model="cantidad" type="number" min="1" max="50"
                                                class="w-32 p-4 border-2 border-slate-300 rounded-xl text-center text-lg font-semibold text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" />
                                        </div>
                                    </div>
                                    <button @click="iniciar"
                                        class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                                        Continuar con {{ cantidad }} participante{{ cantidad > 1 ? 's' : '' }}
                                    </button>
                                </div>

                                <!-- Paso 2: Formularios -->
                                <div v-else class="space-y-8">
                                    <!-- Información Corporativa -->
                                    <div class="space-y-6">
                                        <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-2">Información Corporativa</h3>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div class="space-y-2">
                                                <label class="block text-sm font-medium text-slate-700">Nombre del Corporativo *</label>
                                                <input v-model="form.nombre_corporativo" required
                                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900"
                                                    placeholder="Nombre de la empresa u organización" />
                                            </div>
                                            <div class="space-y-2">
                                                <label class="block text-sm font-medium text-slate-700">Foto del Voucher <span class="text-slate-500">(Opcional)</span></label>
                                                <input type="file" @change="handleGlobalFile" accept="image/*"
                                                    class="w-full px-4 py-3 border-2 border-dashed border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Lista de Participantes -->
                                    <div class="space-y-6">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-lg font-semibold text-slate-900">Participantes</h3>
                                            <span class="text-sm text-slate-500">{{ form.participantes.length }} participante{{ form.participantes.length > 1 ? 's' : '' }}</span>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                            <div v-for="(p, index) in form.participantes" :key="index"
                                                class="bg-slate-50 border border-slate-200 rounded-xl p-6 space-y-4">
                                                <div class="flex items-center justify-between mb-4">
                                                    <h4 class="text-lg font-semibold text-slate-900">Participante {{ index + 1 }}</h4>
                                                    <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm font-bold">
                                                        {{ index + 1 }}
                                                    </div>
                                                </div>

                                                <div class="space-y-3">
                                                    <!-- DNI -->
                                                    <div class="space-y-1">
                                                        <label class="block text-xs font-medium text-slate-600">DNI *</label>
                                                        <input v-model="p.dni" @blur="() => buscarDni(index)" 
                                                            type="text" maxlength="8" minlength="8" required
                                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900"
                                                            placeholder="12345678" />
                                                    </div>

                                                    <!-- Nombres y Apellidos -->
                                                    <div class="grid grid-cols-2 gap-3">
                                                        <div class="space-y-1">
                                                            <label class="block text-xs font-medium text-slate-600">Nombres *</label>
                                                            <input v-model="p.nombres" required
                                                                class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900"
                                                                placeholder="Juan Carlos" />
                                                        </div>
                                                        <div class="space-y-1">
                                                            <label class="block text-xs font-medium text-slate-600">Apellidos *</label>
                                                            <input v-model="p.apellidos" required
                                                                class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900"
                                                                placeholder="Pérez García" />
                                                        </div>
                                                    </div>

                                                    <!-- Email y Celular -->
                                                    <div class="grid grid-cols-2 gap-3">
                                                        <div class="space-y-1">
                                                            <label class="block text-xs font-medium text-slate-600">Correo *</label>
                                                            <input v-model="p.correo" type="email" required
                                                                class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900"
                                                                placeholder="juan@ejemplo.com" />
                                                        </div>
                                                        <div class="space-y-1">
                                                            <label class="block text-xs font-medium text-slate-600">Celular *</label>
                                                            <input v-model="p.celular" required
                                                                class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900"
                                                                placeholder="987654321" />
                                                        </div>
                                                    </div>

                                                    <!-- Colegio Departamental -->
                                                    <div class="space-y-1">
                                                        <label class="block text-xs font-medium text-slate-600">Colegio Departamental</label>
                                                        <select v-model="p.colegio_departamental"
                                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900">
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
                                                    </div>

                                                    <!-- Ubicación -->
                                                    <div class="grid grid-cols-3 gap-2">
                                                        <div class="space-y-1">
                                                            <label class="block text-xs font-medium text-slate-600">Departamento *</label>
                                                            <input v-model="p.departamento" required
                                                                class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900"
                                                                placeholder="Lima" />
                                                        </div>
                                                        <div class="space-y-1">
                                                            <label class="block text-xs font-medium text-slate-600">Provincia *</label>
                                                            <input v-model="p.provincia" required
                                                                class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900"
                                                                placeholder="Lima" />
                                                        </div>
                                                        <div class="space-y-1">
                                                            <label class="block text-xs font-medium text-slate-600">Distrito *</label>
                                                            <input v-model="p.distrito" required
                                                                class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900"
                                                                placeholder="Miraflores" />
                                                        </div>
                                                    </div>

                                                    <!-- Dirección -->
                                                    <div class="space-y-1">
                                                        <label class="block text-xs font-medium text-slate-600">Dirección <span class="text-slate-400">(Opcional)</span></label>
                                                        <input v-model="p.direccion_actual" 
                                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900"
                                                            placeholder="Dirección completa" />
                                                    </div>

                                                    <!-- Tipo y Modalidad -->
                                                    <div class="grid grid-cols-2 gap-3">
                                                        <div class="space-y-1">
                                                            <label class="block text-xs font-medium text-slate-600">Tipo *</label>
                                                            <select v-model="p.tipo_participante_categoria" required
                                                                class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900">
                                                                <option value="">Seleccionar</option>
                                                                <option value="pleno">Pleno</option>
                                                                <option value="observador">Observador</option>
                                                                <option value="estudiante">Estudiante</option>
                                                            </select>
                                                        </div>
                                                        <div class="space-y-1">
                                                            <label class="block text-xs font-medium text-slate-600">Modalidad *</label>
                                                            <select v-model="p.modalidad_participacion" required
                                                                class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900">
                                                                <option value="">Seleccionar</option>
                                                                <option value="presencial">Presencial</option>
                                                                <option value="virtual">Virtual</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Pago y Comprobante -->
                                                    <div class="grid grid-cols-2 gap-3">
                                                        <div class="space-y-1">
                                                            <label class="block text-xs font-medium text-slate-600">Código de Pago *</label>
                                                            <input v-model="p.codigo_pago" required
                                                                class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900"
                                                                placeholder="Código de operación" />
                                                        </div>
                                                        <div class="space-y-1">
                                                            <label class="block text-xs font-medium text-slate-600">Comprobante</label>
                                                            <select v-model="p.comprobante"
                                                                class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900">
                                                                <option value="boleta">Boleta</option>
                                                                <option value="factura">Factura</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- RUC si es factura -->
                                                    <div v-if="p.comprobante === 'factura'" class="space-y-1">
                                                        <label class="block text-xs font-medium text-slate-600">Número de RUC</label>
                                                        <input v-model="p.numero_ruc" maxlength="11" minlength="11"
                                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900"
                                                            placeholder="20123456789" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botones de Acción -->
                                    <div class="flex justify-between items-center pt-6 border-t border-slate-200">
                                        <button @click="iniciado = false"
                                            class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-xl transition-colors">
                                            ← Volver
                                        </button>
                                        <button @click="submit" :disabled="form.processing"
                                            class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                            <span v-if="form.processing" class="flex items-center">
                                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                Procesando...
                                            </span>
                                            <span v-else>Registrar {{ form.participantes.length }} Participante{{ form.participantes.length > 1 ? 's' : '' }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
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
                                        Cada <strong>DNI</strong> debe tener 8 dígitos válidos
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 text-green-500 mt-1 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Los <strong>correos</strong> deben ser únicos para cada participante
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 text-green-500 mt-1 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Seleccione <strong>tipo y modalidad</strong> para cada participante
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 text-green-500 mt-1 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Para <strong>factura</strong> es obligatorio el RUC
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 text-green-500 mt-1 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Puede subir un <strong>voucher global</strong> para todos los participantes
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