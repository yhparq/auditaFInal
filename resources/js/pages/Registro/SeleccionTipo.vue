<script setup>
import { router } from '@inertiajs/vue3'
import AuditaLayout from '@/layouts/AuditaLayout.vue'

function seleccionar(tipo) {
  router.visit(`/registro/${tipo}`)
}
</script>

<template>
  <AuditaLayout>
    <div class="min-h-screen bg-gradient-to-br from-[#f9f9f9] to-white py-16 px-4 flex flex-col items-center justify-center">
      <!-- Título -->
      <h2 class="text-3xl sm:text-4xl font-extrabold text-[#00367e] uppercase text-center mb-4">Participa con nosotros</h2>
      <p class="text-center text-gray-600 mb-10 text-sm sm:text-base max-w-xl">
        Forma parte de la <strong>AUDITA 2025</strong> eligiendo tu tipo de inscripción. ¡Únete al evento más importante en Auditoría!
      </p>

      <!-- Botones -->
      <div class="flex flex-col sm:flex-row gap-6 mb-16">
        <button
          @click="seleccionar('individual')"
          class="px-10 py-3 bg-[#ae1f22] text-white font-semibold rounded-xl shadow-lg hover:bg-[#8c191a] transition duration-300"
        >
          👤 Inscripción Individual
        </button>
        <button
          @click="seleccionar('corporativo')"
          class="px-10 py-3 bg-[#00367e] text-white font-semibold rounded-xl shadow-lg hover:bg-[#002c66] transition duration-300"
        >
          🏢 Inscripción Corporativa
        </button>
      </div>

      <!-- Card del video -->
      <div class="w-full max-w-3xl bg-white rounded-2xl shadow-xl p-6 border border-gray-200 hover:shadow-2xl transition">
        <h3 class="text-2xl font-bold text-[#00367e] mb-4 text-center">🎥 Video tutorial de inscripción</h3>
        <div class="aspect-video w-full overflow-hidden rounded-lg">
          <iframe
            class="w-full h-full"
            src="https://www.youtube.com/embed/Ebme3gCsjXw"
            title="Video Tutorial Inscripción"
            frameborder="0"
            allowfullscreen
          ></iframe>
        </div>
      </div>
    </div>
  </AuditaLayout>
</template>
