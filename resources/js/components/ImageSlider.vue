<template>
  <Carousel v-bind="config">
    <Slide v-for="(image, index) in images" :key="index">
      <div class="w-full aspect-[16/9] md:aspect-auto md:h-[93vh] relative">
        <img
          :src="image"
          class="absolute inset-0 w-full h-full object-cover md:object-fill"
          alt="slider"
        />
      </div>
    </Slide>
  </Carousel>
</template>

<script setup lang="ts">
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide } from 'vue3-carousel'

const images = [
  '/images/slider1.png',
  '/images/slider2.png',
]

const config = {
  itemsToShow: 1,
  wrapAround: true,
  autoplay: 4000,
  pauseAutoplayOnHover: true,
  breakpoints: {
    300: { itemsToShow: 1 },
    768: { itemsToShow: 1 }
  }
}
</script>
