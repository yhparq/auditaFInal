<template>
    <section id="confe" class="bg-white py-16 px-4">
        <div class="max-w-7xl mx-auto text-center mb-8">
            <h2 class="text-3xl font-extrabold uppercase text-black">Conferencistas</h2>
            <div class="mt-2 w-24 h-1 mx-auto bg-[#ffb300] relative">
                <div class="absolute left-0 top-0 w-1/2 h-1 bg-gray-300"></div>
            </div>
        </div>

        <Carousel v-bind="config" class="max-w-7xl mx-auto">



            <Slide v-for="(expositor, index) in expositores" :key="index">
                <a :href="expositor.perfil" target="_blank" rel="noopener noreferrer"
                    class="block px-4 py-6 transition duration-300 hover:scale-[1.08]">
                    <div
                        class="relative w-[230px] h-[260px] bg-[#fffdf5] border border-[#00367e] rounded-xl shadow-md p-4 flex flex-col items-center justify-between hover:shadow-2xl transition-all duration-500 mx-auto">
                        <!-- Imagen de la bandera -->
                        <img v-if="expositor.bandera" :src="expositor.bandera" alt="Bandera"
                            class="w-6 h-4 absolute top-2 right-2 rounded shadow-sm object-cover" />

                        <!-- Imagen del expositor -->
                        <div class="w-32 h-32 rounded-full overflow-hidden border-2 border-[#00367e] shadow mb-4">
                            <img :src="expositor.foto" alt="foto expositor" class="w-full h-full object-cover" />
                        </div>

                        <!-- Nombre y cargo -->
                        <div class="text-center">
                            <h3 class="font-bold text-[#00367e] text-sm leading-tight">{{ expositor.nombre }}</h3>
                            <p class="text-xs text-gray-600 mt-1">{{ expositor.cargo }}</p>
                        </div>
                    </div>
                </a>
            </Slide>




        </Carousel>
    </section>
</template>

<script setup lang="ts">
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide } from 'vue3-carousel'

interface Expositor {
    nombre: string
    cargo: string
    foto: string
}

const expositores: Expositor[] = [
    {
        nombre: 'Mg. CPC. Luis Pretel Gaona',
        cargo: 'Socio de auditoría DELOITTE',
        foto: '/images/ponentes/luis_petrel.png',
        perfil: '/pdfs/datos_ponentes/01.LUIS_PRETEL.png',
        bandera: '/images/peru.png'
    },
    {
        nombre: 'Mg. CPC. Alex Cuzcano Cuzcano',
        cargo: 'Socio director de auditoría y asesoría contable en Global CPA Consultores',
        foto: '/images/ponentes/alex_cuzcano.png',
        perfil: '/pdfs/datos_ponentes/02.ALEX CUZCANO.png',
        bandera: '/images/peru.png'
    },
    {
        nombre: 'CPC. Eduardo Alejos Palomino',
        cargo: 'Socio de Auditoría KPMG',
        foto: '/images/ponentes/eduardo_alejos.png',
        perfil: '/pdfs/datos_ponentes/03.EDUARDO ALEJOS.png',
        bandera: '/images/peru.png'
    },
    {
        nombre: 'Mg. Pablo Gabriel Fudim',
        cargo: 'Consultor independiente de la Contraloría General del Estado República de Ecuador',
        foto: '/images/ponentes/pablo_fudim.png',
        perfil: '/pdfs/datos_ponentes/04.PABLO FUDIM.png',
        bandera: '/images/argentina.webp'
    },
    {
        nombre: 'Dr. CPC. Luciano Tinoco Palacios',
        cargo: 'Miembro del Centro Nacional de Investigación de las Ciencias Contables de la JDCCPP',
        foto: '/images/ponentes/luciano_tinoco.png',
        perfil: '/pdfs/datos_ponentes/05.LUCIANO TINOCO.png',
        bandera: '/images/peru.png'
    },
    {
        nombre: 'Mg. CPC. Marco Saldivar García',
        cargo: 'Presidente del Consejo Directivo del Programa de Inversión Responsable',
        foto: '/images/ponentes/marco_saldivar.png',
        perfil: '/pdfs/datos_ponentes/06.MARCO ZALDIVAR.png',
        bandera: '/images/peru.png'
    },
    {
        nombre: 'L.C.A. Maria Rodriguez Uribe',
        cargo: 'Directora de Auditoría Forense de Cumplimiento Financiero en Auditoría Superior de la Federación de México',
        foto: '/images/ponentes/maria_uribe.png',
        perfil: 'public/pdfs/datos_ponentes/07.MARIA RODRIGUEZ.png',
        bandera: '/images/mexico.png'
    },
    {
        nombre: 'Dr. Ronny Gutiérrez Castillo',
        cargo: 'Ejecutivo de Gestión I - Especialista VII  Gerencia Regional de Control de Puno en la Contraloría General de la República',
        foto: '/images/ponentes/rony_castillo.png',
        perfil: '/pdfs/datos_ponentes/08.RONNY GUTIERREZ.png',
        bandera: '/images/peru.png'
    },
    {
        nombre: 'Lic. Franco Portocarrero Estrada',
        cargo: 'Gerente Senior de Auditoría PWC',
        foto: '/images/ponentes/franco_estrada.png',
        perfil: '/pdfs/datos_ponentes/10.FRANCO PORTOCARRERO.png',
        bandera: '/images/peru.png'
    },
    {
        nombre: 'Dr. CPC. Ismael Lavilla Torres',
        cargo: 'Jefe del Órgano de Control Institucional de la Autoridad Autónoma de Majes',
        foto: '/images/ponentes/ismael_torres.png',
        perfil: '/pdfs/datos_ponentes/09.ISMAEL LAVILLA.png',
        bandera: '/images/peru.png'
    },
    {
        nombre: 'Mg. Hernán Pablo Casinelli',
        cargo: 'Presidente del Grupo Latinoamericano de Emisores de Normas de Información Financiera (GLENIF)',
        foto: '/images/ponentes/hernan_pablo.png',
        perfil: '/pdfs/datos_ponentes/11.HERNAN CASINELLI.png',
        bandera: '/images/argentina.webp'
    },
    {
        nombre: 'Mg. CPC. Jorge Maldonado Alarcón',
        cargo: 'Director del Instituto de Auditores Internos del Perú',
        foto: '/images/ponentes/jorge.png',
        perfil: '/pdfs/datos_ponentes/12.JORGE MALDONADO.png',
        bandera: '/images/peru.png'
    },
]



const config = {
    // height: 120,
    itemsToShow: 5,
    gap: 5,
    autoplay: 3000,
    wrapAround: true,
    pauseAutoplayOnHover: true,


    breakpointMode: 'carousel',

    // Breakpoints are mobile-first
    // Any settings not specified will fall back to the carousel's default settings
    breakpoints: {
        // 300px and up
        300: {
            itemsToShow: 1,
            snapAlign: 'center',
        },
        // 400px and up
        400: {
            itemsToShow: 2,
            snapAlign: 'start',
        },
        // 500px and up
        500: {
            itemsToShow: 5,
            snapAlign: 'start',
        },
    },
}






</script>
