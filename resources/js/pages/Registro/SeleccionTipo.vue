<script setup>
import { router } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'
import { ref, watchEffect } from 'vue'
import AuditaLayout from '@/layouts/AuditaLayout.vue'

const page = usePage()
const successMessage = ref(page.props.flash?.success || null)

watchEffect(() => {
    if (successMessage.value) {
        setTimeout(() => {
            successMessage.value = null
        }, 5000)
    }
})

function seleccionar(tipo) {
    router.visit(`/registro/${tipo}`)
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
            <div class="max-w-6xl mx-auto">
                
                <!-- Header Section -->
                <div class="text-center mb-16">
                    <div class="mb-6">
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-[#00367e] uppercase tracking-tight mb-4">
                            Participa con nosotros
                        </h1>
                        <div class="w-24 h-1 bg-gradient-to-r from-[#ae1f22] to-[#00367e] mx-auto rounded-full"></div>
                    </div>
                    <p class="text-lg sm:text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed">
                        Forma parte de la <span class="font-bold text-[#00367e]">AUDITA 2025</span>, el evento más importante en Auditoría. 
                        Elige tu tipo de inscripción y únete a miles de profesionales.
                    </p>
                </div>

                <!-- Cards de Selección -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
                    
                    <!-- Inscripción Individual -->
                    <div class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-slate-200">
                        <div class="p-8 sm:p-10">
                            <div class="text-center mb-8">
                                <div class="w-20 h-20 bg-gradient-to-br from-[#ae1f22] to-[#d63384] rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <h3 class="text-2xl sm:text-3xl font-bold text-[#00367e] mb-4">Inscripción Individual</h3>
                                <p class="text-slate-600 text-base sm:text-lg leading-relaxed">
                                    Perfecto para profesionales independientes que buscan actualizar sus conocimientos y networking personalizado.
                                </p>
                            </div>
                            
                            <div class="space-y-4 mb-8">
                                <div class="flex items-center text-slate-700">
                                    <svg class="w-5 h-5 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Registro rápido y sencillo
                                </div>
                                <div class="flex items-center text-slate-700">
                                    <svg class="w-5 h-5 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Certificado personalizado
                                </div>
                                <div class="flex items-center text-slate-700">
                                    <svg class="w-5 h-5 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Acceso completo al evento
                                </div>
                            </div>
                            
                            <button
                                @click="seleccionar('individual')"
                                class="w-full px-8 py-4 bg-gradient-to-r from-[#ae1f22] to-[#d63384] hover:from-[#8c191a] hover:to-[#b02a5b] text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] text-lg"
                            >
                                Comenzar Inscripción Individual
                            </button>
                        </div>
                    </div>

                    <!-- Inscripción Corporativa -->
                    <div class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-slate-200">
                        <div class="p-8 sm:p-10">
                            <div class="text-center mb-8">
                                <div class="w-20 h-20 bg-gradient-to-br from-[#00367e] to-[#4f46e5] rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm3 1h6v4H7V5zm8 8v2a1 1 0 01-1 1H6a1 1 0 01-1-1v-2h10z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <h3 class="text-2xl sm:text-3xl font-bold text-[#00367e] mb-4">Inscripción Corporativa</h3>
                                <p class="text-slate-600 text-base sm:text-lg leading-relaxed">
                                    Ideal para empresas que desean capacitar a múltiples colaboradores con descuentos especiales.
                                </p>
                            </div>
                            
                            <div class="space-y-4 mb-8">
                                <div class="flex items-center text-slate-700">
                                    <svg class="w-5 h-5 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Registro de múltiples participantes
                                </div>
                                <div class="flex items-center text-slate-700">
                                    <svg class="w-5 h-5 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Tarifas corporativas especiales
                                </div>
                                <div class="flex items-center text-slate-700">
                                    <svg class="w-5 h-5 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Gestión centralizada de pagos
                                </div>
                            </div>
                            
                            <button
                                @click="seleccionar('corporativo')"
                                class="w-full px-8 py-4 bg-gradient-to-r from-[#00367e] to-[#4f46e5] hover:from-[#002c66] hover:to-[#3730a3] text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] text-lg"
                            >
                                Comenzar Inscripción Corporativa
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Video Tutorial Section
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-200">
                    <div class="bg-gradient-to-r from-[#00367e] to-[#4f46e5] px-8 py-6">
                        <div class="flex items-center justify-center">
                            <svg class="w-8 h-8 text-white mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                            </svg>
                            <h3 class="text-2xl sm:text-3xl font-bold text-white">Video Tutorial de Inscripción</h3>
                        </div>
                        <p class="text-blue-100 text-center mt-3 text-lg">
                            Aprende paso a paso cómo completar tu registro de manera exitosa
                        </p>
                    </div>
                    
                    <div class="p-8">
                        <div class="aspect-video w-full overflow-hidden rounded-2xl shadow-lg bg-slate-100">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/Ebme3gCsjXw"
                                title="Video Tutorial Inscripción AUDITA 2025"
                                frameborder="0"
                                allowfullscreen
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            ></iframe>
                        </div>
                        
                        <div class="mt-6 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-6">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-amber-500 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-amber-800 mb-2">💡 Consejos para tu inscripción:</h4>
                                    <ul class="text-amber-700 space-y-1 text-sm">
                                        <li>• Ten a la mano tu DNI y datos personales</li>
                                        <li>• Prepara el voucher de pago antes de comenzar</li>
                                        <li>• Verifica que tu correo electrónico sea correcto</li>
                                        <li>• Para inscripciones corporativas, ten la lista de participantes lista</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> -->
                <!-- </div> -->
            </div>
        </div>
    </AuditaLayout>
</template>