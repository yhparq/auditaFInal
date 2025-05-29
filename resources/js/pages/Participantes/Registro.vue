<template>



  <!-- Mensaje de éxito -->
  <div v-if="successMessage"
    class="fixed top-6 right-6 z-50 bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-xl shadow-xl backdrop-blur-sm">
    <div class="flex items-center space-x-3">
      <div class="flex-shrink-0">
        <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
            clip-rule="evenodd" />
        </svg>
      </div>
      <span class="font-medium">{{ successMessage }}</span>
    </div>
  </div>


  <div class="max-w-2xl mx-auto">
    <Create :admin="false" />
  </div>
</template>

<script setup>
import Create from '@/pages/Participantes/Create.vue';
const page = usePage()
const successMessage = ref(page.props.flash?.success || null)

watchEffect(() => {
  if (successMessage.value) {
    setTimeout(() => {
      successMessage.value = null
    }, 4000)
  }
})
</script>
