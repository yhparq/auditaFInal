<template>
    <Header />

    <!-- Espacio para el contenido -->
    <main class="">
      <slot />
    </main>

    <Footer />
</template>

<script setup lang="ts">
import Header from '@/components/Header.vue'
import Footer from '@/components/Footer.vue'
</script>
