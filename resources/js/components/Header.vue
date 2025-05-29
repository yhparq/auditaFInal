<template>
  <header class="bg-[#00367e] text-white sticky top-0 w-full z-50 shadow-md">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex items-center justify-between">
      <h1 class="text-3xl font-bold text-[#ffb300]">AUDITA 2025</h1>
      <button @click="toggleMenu" class="md:hidden text-white focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
      <ul class="hidden md:flex space-x-6 text-sm font-medium">
        <li><a href="/#" class="hover:text-[#ffb300]">Inicio</a></li>
        <li><a href="/#material" class="hover:text-[#ffb300]">Material</a></li>
        <li><a href="/#tarifas" class="hover:text-[#ffb300]">Inversión</a></li>
        <li><a href="/#confe" class="hover:text-[#ffb300]">Conferencistas</a></li>
        <li><a href="/#temas" class="hover:text-[#ffb300]">Temario</a></li>
        <li><a href="/#info" class="hover:text-[#ffb300]">Información</a></li>
        <li><a href="/#contacto" class="hover:text-[#ffb300]">Contacto</a></li>
        <li>
          <a href="/login" class="bg-[#ffb300] text-[#00367e] px-4 py-2 rounded-md hover:bg-white transition">
            Ingresar
          </a>
        </li>
      </ul>
    </nav>

    <!-- Menú móvil -->
    <div v-if="menuOpen" class="md:hidden bg-[#00367e] text-white px-4 pb-4 shadow-md">
      <ul class="flex flex-col space-y-3">
        <li><a href="/#" class="hover:text-[#ffb300]">Inicio</a></li>
        <li><a href="/#material" class="hover:text-[#ffb300]">Material</a></li>
        <li><a href="/#tarifas" class="hover:text-[#ffb300]">Inversión</a></li>
        <li><a href="/#confe" class="hover:text-[#ffb300]">Conferencistas</a></li>
        <li><a href="/#temas" class="hover:text-[#ffb300]">Temario</a></li>
        <li><a href="/#info" class="hover:text-[#ffb300]">Información</a></li>
        <li><a href="/#contacto" class="hover:text-[#ffb300]">Contacto</a></li>
        <li>
          <a href="/login" class="bg-[#ffb300] text-[#00367e] px-4 py-2 rounded-md hover:bg-white transition">
            Ingresar
          </a>
        </li>
      </ul>
    </div>
  </header>
</template>

<script setup lang="ts">
import { ref } from 'vue'
const menuOpen = ref(false)
const toggleMenu = () => {
  menuOpen.value = !menuOpen.value
}
</script>
