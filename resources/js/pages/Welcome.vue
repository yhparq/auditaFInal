<template>
    <AuditaLayout>

        <ImageSlider />



        <section class="bg-white py-16 px-4">
            <div class="max-w-6xl mx-auto text-center mb-12">
                <h2 class="text-4xl font-extrabold text-[#00367e] uppercase">Bienvenidos a todos</h2>
                <div class="mt-2 w-24 h-1 mx-auto bg-[#ffb300] relative">
                    <div class="absolute left-0 top-0 w-1/2 h-1 bg-gray-300"></div>
                </div>
            </div>

            <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <!-- Video -->
                <div class="aspect-video w-full">
                    <iframe class="w-full h-full rounded-lg shadow-md" src="https://www.youtube.com/embed/Ebme3gCsjXw"
                        title="Video Audita" frameborder="0" allowfullscreen></iframe>
                </div>

                <!-- Texto -->
                <div class="text-left px-2">
                    <h3 class="text-2xl font-bold text-[#00367e] mb-4">¡Puno te saluda!</h3>
                    <p class="text-gray-700 leading-relaxed">
                        El Colegio de Contadores Públicos de Puno y la Junta de Decanos de los Colegios de Contadores
                        del Perú - JDCCPP, invitan a los Contadores Públicos, profesionales, empresarios, estudiantes y
                        ciudadanía, regional y nacional, a participar en la <span
                            class="font-semibold text-[#00367e]">“XI Convención Nacional de Auditoría – AUDITA
                            2025”</span>, a realizarse los días 26, 27 y 28 de julio de 2025.
                    </p>
                </div>
            </div>
        </section>












        <section id="material" class="bg-white py-16 px-4">
            <div class="max-w-7xl mx-auto text-center mb-12">
                <h2 class="text-3xl font-extrabold text-[#00367e] uppercase">Material de Audita</h2>
                <div class="mt-2 w-24 h-1 mx-auto bg-[#ffb300] relative">
                    <div class="absolute left-0 top-0 w-1/2 h-1 bg-gray-300"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-8 max-w-3xl mx-auto">
                <div v-for="item in items" :key="item.title" class="text-center group">
                    <a :href="item.pdf" download target="_blank" class="block hover:scale-105 transition duration-300">
                        <img :src="item.image" alt="preview" class="w-full h-auto rounded-lg shadow-md" />
                    </a>
                    <div class="mt-4">
                        <h3 class="text-md font-semibold text-[#00367e]">{{ item.title }}</h3>
                        <p class="text-sm text-gray-500">Descarga .PDF</p>
                    </div>
                </div>
            </div>
        </section>









        <section class="flex flex-col md:flex-row w-full">
            <!-- Bloque izquierdo -->
            <div class="bg-[#00367e] text-white flex items-center justify-center px-6 py-12 md:w-1/3 w-full">
                <div>
                    <h2 class="text-3xl font-bold leading-snug">PUNO<br /><span class="text-white">TURISTICO</span></h2>
                    <p class="mt-2 text-sm">Una ciudad bella y mágica.</p>
                </div>
            </div>

            <!-- Galería: sin espacios, 100% ancho y altura fija -->
            <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 w-full md:w-2/3 h-[200px]">
                <div v-for="(img, i) in images" :key="i" class="w-full h-full overflow-hidden">
                    <img :src="img" alt="Puno"
                        class="w-full h-full object-cover grayscale hover:grayscale-0 transition duration-500" />
                </div>
            </div>
        </section>





        <section id="tarifas" class="bg-[#f9f9f9] py-16 px-4">
            <div class="max-w-6xl mx-auto text-center mb-12">
                <h2 class="text-3xl font-extrabold text-[#00367e] uppercase">Inversión</h2>
                <div class="mt-2 w-24 h-1 mx-auto bg-[#ffb300] relative">
                    <div class="absolute left-0 top-0 w-1/2 h-1 bg-gray-300"></div>
                </div>
                <p class="mt-4 text-sm text-gray-600 max-w-xl mx-auto">
                    Los derechos de inscripción se abonarán en cuenta de ahorros a nombre del CPC. BENJAMIN FELIX
                    AVENDAÑO GORDILLO, director de Administración Financiera, Contabilidad y Presupuesto del Colegio de
                    Contadores Públicos de Puno.
                </p>
            </div>


            <!-- precios -->
            <div class="flex flex-col space-y-6 max-w-6xl mx-auto">
                <div v-for="plan in planes" :key="plan.tipo"
                    class="bg-white rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:shadow-2xl hover:scale-[1.02] flex flex-col md:flex-row">
                    <!-- Imagen -->
                    <img :src="plan.imagen" class="w-full md:w-1/3 h-64 object-cover" />

                    <!-- Contenido -->
                    <div class="flex flex-col justify-between p-6 flex-grow">
                        <!-- Título -->
                        <div :class="['py-2 text-white text-center font-bold text-lg uppercase rounded', plan.bg]">
                            {{ plan.tipo }}
                        </div>

                        <!-- Descripción -->
                        <p class="text-sm text-gray-600 my-4">{{ plan.descripcion }}</p>

                        <!-- Precios -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Presencial -->
                            <div>
                                <p class="font-semibold text-sm text-gray-800">Presencial</p>
                                <div class="flex justify-between text-sm text-gray-600 mt-1">
                                    <span>Hasta 30 junio:</span>
                                    <span class="text-[#ae1f22] font-bold">S/ {{ plan.presencial.hasta30junio }}</span>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Desde 01 julio:</span>
                                    <span class="text-[#ae1f22] font-bold">S/ {{ plan.presencial.desde01julio }}</span>
                                </div>
                            </div>

                            <!-- Virtual -->
                            <div>
                                <p class="font-semibold text-sm text-gray-800">Virtual</p>
                                <div class="flex justify-between text-sm text-gray-600 mt-1">
                                    <span>Hasta 30 junio:</span>
                                    <span class="text-[#ae1f22] font-bold">S/ {{ plan.virtual.hasta30junio }}</span>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Desde 01 julio:</span>
                                    <span class="text-[#ae1f22] font-bold">S/ {{ plan.virtual.desde01julio }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Descuento -->
                        <div class="bg-gray-200 text-center text-sm p-2 font-semibold text-gray-700 mt-4">
                            {{ plan.descuento }}
                        </div>

                        <!-- Ver más -->
                        <div class="text-sm mt-4">
                            <p class="font-semibold text-[#00367e] mb-1">¿Qué se les brinda?</p>
                            <ul class="list-disc list-inside text-gray-600">
                                <li @click="abrirModalParticipante(plan.tipo)"
                                    class="cursor-pointer text-[#00367e] hover:underline">
                                    Ver más
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal Tailwind dinámico mejorado -->
            <div v-if="mostrarModalBeneficios"
                class="fixed inset-0 z-50 bg-black/60 flex items-center justify-center px-4 py-8 overflow-y-auto">
                <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl relative animate-fadeIn border">
                    <!-- Encabezado de color -->
                    <div class="text-center text-white text-xl font-bold py-4 rounded-t-2xl" :class="{
                        'bg-[#ae1f22]': tipoPlanModal === 'PLENO',
                        'bg-[#00367e]': tipoPlanModal === 'OBSERVADOR',
                        'bg-[#ffb300] text-[#00367e]': tipoPlanModal === 'ESTUDIANTE'
                    }">
                        Beneficios para {{ tipoPlanModal }}
                    </div>

                    <!-- Botón de cierre -->
                    <button class="absolute top-4 right-4 text-gray-500 hover:text-red-600 text-2xl"
                        @click="cerrarModalBeneficios" aria-label="Cerrar modal">
                        ✕
                    </button>

                    <!-- Contenido del modal -->
                    <div class="p-6">
                        <!-- Presencial -->
                        <div v-if="planSeleccionado?.presencial?.beneficios" class="mb-6">
                            <h3 class="text-lg font-semibold text-[#00367e] mb-2">Modalidad Presencial</h3>
                            <ul class="list-disc list-inside text-gray-700 space-y-1 pl-2 text-sm sm:text-base">
                                <li v-for="(item, i) in planSeleccionado.presencial.beneficios" :key="'pres-' + i">
                                    {{ item }}
                                </li>
                            </ul>
                        </div>

                        <!-- Virtual -->
                        <div v-if="planSeleccionado?.virtual?.beneficios">
                            <h3 class="text-lg font-semibold text-[#00367e] mb-2">Modalidad Virtual</h3>
                            <ul class="list-disc list-inside text-gray-700 space-y-1 pl-2 text-sm sm:text-base">
                                <li v-for="(item, i) in planSeleccionado.virtual.beneficios" :key="'virt-' + i">
                                    {{ item }}
                                </li>
                            </ul>
                        </div>

                        <!-- Botón de inscripción -->
                        <div class="text-center mt-8">
                            <a href="/registro"
                                class="inline-block bg-[#00367e] hover:bg-[#001f4d] text-white font-semibold py-2 px-6 rounded-full transition duration-300">
                                Inscribirse ahora
                            </a>
                        </div>
                    </div>
                </div>
            </div>




        </section>


        <section class="bg-gray-100 py-16 px-4">
            <div class="max-w-5xl mx-auto">
                <!-- Título -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-extrabold uppercase text-[#00367e]">Medios de Pago</h2>
                    <div class="mt-2 w-24 h-1 mx-auto bg-[#ffb300] relative">
                        <div class="absolute left-0 top-0 w-1/2 h-1 bg-gray-400"></div>
                    </div>
                    <p class="mt-3 text-sm text-gray-600">Elige el método de pago que más te convenga</p>
                </div>

                <!-- Métodos de pago -->
                <div class="space-y-8">
                    <!-- Yape -->
                    <div
                        class="flex items-center bg-white border-l-4 border-[#00367e] rounded-md shadow-sm group hover:bg-[#00367e] hover:shadow-lg transition-all duration-300 ease-in-out p-6">
                        <img src="/images/yape.jpg" alt="Yape"
                            class="w-16 h-16 object-contain mr-6 transition-transform duration-300 ease-in-out group-hover:scale-105" />
                        <div>
                            <h3
                                class="text-lg font-bold text-[#00367e] group-hover:text-white mb-1 transition-colors duration-300">
                                Billetera Digital (Yape)
                            </h3>
                            <p class="text-sm text-gray-700 group-hover:text-white transition-colors duration-300">
                                <strong>A nombre de:</strong> Benjamín Avendaño
                            </p>
                            <p class="text-sm text-gray-700 group-hover:text-white transition-colors duration-300">
                                <strong>Número de celular:</strong> 978785287
                            </p>
                        </div>
                    </div>

                    <!-- BCP -->
                    <div
                        class="flex items-center bg-white border-l-4 border-[#ffb300] rounded-md shadow-sm group hover:bg-[#ffb300] hover:shadow-lg transition-all duration-300 ease-in-out p-6">
                        <img src="/images/bcp.webp" alt="BCP"
                            class="w-16 h-16 object-contain mr-6 transition-transform duration-300 ease-in-out group-hover:scale-105" />
                        <div>
                            <h3
                                class="text-lg font-bold text-[#00367e] group-hover:text-white mb-1 transition-colors duration-300">
                                Banco de Crédito del Perú (BCP)
                            </h3>
                            <p class="text-sm text-gray-700 group-hover:text-white transition-colors duration-300">
                                <strong>Cuenta de ahorros en soles:</strong> 495-06703997-0-91
                            </p>
                            <p class="text-sm text-gray-700 group-hover:text-white transition-colors duration-300">
                                <strong>CCI:</strong> 002-49510670399709106
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>




        <section class="bg-[#ae1f22] text-white py-12 px-4">
            <div class="max-w-5xl mx-auto text-center">
                <div ref="citaRef" :class="[
                    'relative inline-block transition-all duration-700 ease-out',
                    enPantalla ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-12'
                ]">
                    <p class="text-xl md:text-2xl lg:text-3xl italic font-serif leading-relaxed px-4">
                        <span class="text-5xl font-bold align-top select-none">“</span>
                        Auditoría y ética en la era digital: prevención de la corrupción con tecnología y transparencia
                        <span class="text-5xl font-bold align-top select-none">”</span>
                    </p>
                    <div class="h-1 w-24 bg-white/60 mx-auto mt-4 rounded-full"></div>
                </div>
            </div>
        </section>










        <ExpositoresSlider />



        <section id="temas" class="bg-white py-16 px-4 w-full">
            <div class="w-full max-w-screen-2xl mx-auto">
                <!-- Título -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-extrabold uppercase text-gray-900">Temario</h2>
                    <div class="mt-2 w-24 h-1 mx-auto bg-[#ffb300] relative">
                        <div class="absolute left-0 top-0 w-1/2 h-1 bg-gray-300"></div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Lateral -->
                    <div class="bg-[#ae1f22] text-white p-6 rounded shadow col-span-1">
                        <h3 class="text-lg font-semibold">Eje Temático</h3>
                        <h4 class="text-2xl font-bold">AUDITA 2025</h4>
                        <p class="text-sm mt-2">LA AUDITORÍA ILUMINA EL CAMINO HACIA LA TRANSPARENCIA Y LA INTEGRIDAD
                            FINANCIERA, PREVINIENDO LA CORRUPCIÓN</p>
                    </div>

                    <!-- Temas -->
                    <div class="md:col-span-3 space-y-10">
                        <!-- Tema 1 -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                            <div class="overflow-hidden rounded-lg">
                                <img src="/images/info2.jpg" alt="tema1"
                                    class="rounded-lg w-full h-48 object-cover transform transition duration-500 hover:scale-105">
                            </div>
                            <div>
                                <h4 class="text-[#00367e] font-bold text-sm uppercase mb-1">Eje Temático Nº 1:</h4>
                                <p class="text-[#ae1f22] font-bold text-lg leading-snug">NORMATIVA INTERNACIONAL,
                                    REGULACIÓN Y ESTÁNDARES DE AUDITORÍA Y CALIDAD</p>
                                <button @click="abrirModal(0)"
                                    class="mt-3 bg-[#ae1f22] hover:bg-[#00367e] text-white text-sm font-medium py-1 px-4 rounded transition">
                                    Ver Temas
                                </button>


                            </div>
                        </div>

                        <!-- Eje Temático 2 -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                            <div>
                                <h4 class="text-[#00367e] font-bold text-sm uppercase mb-1">Eje Temático Nº 2:</h4>
                                <p class="text-[#ae1f22] font-bold text-lg leading-snug">INNOVACIÓN, TRANSFORMACIÓN
                                    DIGITAL Y TECNOLOGÍAS DISRUPTIVAS EN AUDITORÍA</p>
                                <button @click="abrirModal(1)"
                                    class="mt-3 bg-[#ae1f22] hover:bg-[#00367e] text-white text-sm font-medium py-1 px-4 rounded transition">
                                    Ver Temas
                                </button>
                            </div>
                            <div class="overflow-hidden rounded-lg">
                                <img src="/images/info3.jpg" alt="tema2"
                                    class="rounded-lg w-full h-48 object-cover transform transition duration-500 hover:scale-105">
                            </div>
                        </div>

                        <!-- Eje Temático 3 -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                            <div class="overflow-hidden rounded-lg">
                                <img src="/images/info1.jpg" alt="tema3"
                                    class="rounded-lg w-full h-48 object-cover transform transition duration-500 hover:scale-105">
                            </div>
                            <div>
                                <h4 class="text-[#00367e] font-bold text-sm uppercase mb-1">Eje Temático Nº 3:</h4>
                                <p class="text-[#ae1f22] font-bold text-lg leading-snug">ÉTICA PROFESIONAL,
                                    TRANSPARENCIA, GOBERNANZA Y AUDITORÍA DE SOSTENIBILIDAD</p>
                                <button @click="abrirModal(2)"
                                    class="mt-3 bg-[#ae1f22] hover:bg-[#00367e] text-white text-sm font-medium py-1 px-4 rounded transition">
                                    Ver Temas
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>





            <!-- Modales con Headless UI -->
            <!-- Modales con Headless UI con contenido completo -->
            <TransitionRoot appear :show="modalActivo !== null" as="template">
                <Dialog as="div" class="relative z-50" @close="cerrarModal">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0"
                        enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100"
                        leave-to="opacity-0">
                        <div class="fixed inset-0 bg-black/40" />
                    </TransitionChild>

                    <div class="fixed inset-0 flex items-center justify-center p-4">
                        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100" leave="ease-in duration-200"
                            leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
                            <DialogPanel
                                class="w-full max-w-3xl bg-white rounded-lg p-6 shadow-xl text-left overflow-y-auto max-h-[90vh]">

                                <!-- Modal Tema 1 -->
                                <div v-if="modalActivo === 0">
                                    <DialogTitle class="text-2xl font-bold uppercase text-[#00367e] mb-4">Eje Temático
                                        Nº 1: NORMATIVA INTERNACIONAL, REGULACIÓN Y ESTÁNDARES DE AUDITORÍA Y CALIDAD
                                    </DialogTitle>
                                    <ul class="list-disc pl-5 space-y-2 text-gray-700 text-sm">
                                        <li>Aplicación de las Normas Internacionales de Auditoría (NIA) y el
                                            fortalecimiento del escepticismo profesional. Normatividad y estándares
                                            internacionales de auditoría.</li>
                                        <li>Implementación de las Normas Internacionales de Gestión de Calidad (NIGC 1 y
                                            2) y la promoción de una cultura de calidad en las firmas.</li>
                                        <li>Manual del IAASB: principales cambios normativos y su aplicación en la
                                            práctica profesional. Norma de Competencia: Gestionar el Proceso de
                                            Auditoría Financiera en los sectores público y privado.</li>
                                        <li>Rol del auditor interno frente al sistema PLAFT, la oficialía de
                                            cumplimiento y los delitos financieros.</li>
                                    </ul>
                                </div>

                                <!-- Modal Eje Temático 2 -->
                                <div v-else-if="modalActivo === 1">
                                    <DialogTitle class="text-2xl font-bold uppercase text-[#00367e] mb-4">Eje Temático
                                        Nº 2:
                                        INNOVACIÓN, TRANSFORMACIÓN DIGITAL Y TECNOLOGÍAS DISRUPTIVAS EN AUDITORÍA
                                    </DialogTitle>
                                    <ul class="list-disc pl-5 space-y-2 text-gray-700 text-sm">
                                        <li>Aplicaciones prácticas de inteligencia artificial generativa, big data,
                                            blockchain y ciberseguridad en auditoría. Automatización inteligente y
                                            robotización de procesos de auditoría (RPA, plataformas digitales, software
                                            especializado).</li>
                                        <li>Auditoría forense digital: Investigación de fraudes y delitos económicos con
                                            tecnologías avanzadas. Rol de la UIF y cumplimiento del marco GAFI en
                                            auditoría: enfoque basado en riesgos y supervisión.</li>
                                        <li>Innovación Tecnológica en la Auditoría: Un enfoque desde la investigación
                                            científica. </li>
                                    </ul>
                                </div>

                                <!-- Modal Eje Temático 3 -->
                                <div v-else-if="modalActivo === 2">
                                    <DialogTitle class="text-2xl font-bold uppercase text-[#00367e] mb-4">Eje Temático
                                        Nº 3: ÉTICA PROFESIONAL, TRANSPARENCIA, GOBERNANZA Y AUDITORÍA DE SOSTENIBILIDAD
                                    </DialogTitle>
                                    <ul class="list-disc pl-5 space-y-2 text-gray-700 text-sm">
                                        <li>Auditoría como herramienta de prevención y control de actos de corrupción:
                                            enfoque en integridad institucional. Gobierno corporativo, auditoría de
                                            cumplimiento y gestión de riesgos regulatorios.</li>
                                        <li>El control gubernamental y la corrupción en el Perú y América Latina.
                                        </li>
                                        <li>Ética profesional, independencia del auditor y salvaguardas frente a los
                                            conflictos de interés.
                                        </li>
                                        <li>Auditoría de Sostenibilidad, cumplimiento ESG y reportes de información
                                            financiera.
                                        </li>
                                        <li>Impacto del control interno en la gestión pública. El control preventivo,
                                            simultáneo y posterior como instrumentos para prevenir los actos de
                                            corrupción en el país.</li>
                                    </ul>
                                </div>

                                <!-- Botón cerrar -->
                                <div class="text-right mt-6">
                                    <button @click="cerrarModal"
                                        class="bg-[#00367e] hover:bg-[#ae1f22] text-white px-4 py-2 rounded transition">
                                        Cerrar
                                    </button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </Dialog>
            </TransitionRoot>



        </section>







        <section class="bg-white py-16 px-4">
            <div class="max-w-6xl mx-auto text-center mb-12">
                <h2 class="text-3xl font-extrabold text-black uppercase">Documentos</h2>
                <div class="mt-2 w-24 h-1 mx-auto bg-[#ffb300] relative">
                    <div class="absolute left-0 top-0 w-1/2 h-1 bg-gray-300"></div>
                </div>
                <p class="mt-4 text-sm text-gray-600">Descarga la Documentación del AUDITA 2025.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div v-for="(doc, i) in documentos" :key="i" class="flex flex-col items-center text-center">
                    <a :href="doc.pdf" target="_blank">
                        <img :src="doc.imagen" alt="documento"
                            class="w-64 h-auto shadow-md rounded hover:scale-105 transition" />
                    </a>
                    <div class="mt-4 flex items-start space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#00367e]" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M12 16.5l4-4h-3V4h-2v8.5H8l4 4z" />
                            <path d="M20 18H4v2h16v-2z" />
                        </svg>
                        <div class="text-sm text-left">
                            <p class="font-semibold text-[#00367e]">{{ doc.titulo }}</p>
                            <p class="text-gray-500">Descarga .PDF</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>




        <section class="bg-[#f9f9f9] py-16 px-4">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-3xl font-extrabold uppercase text-center text-black capitalize">Trabajos de
                    Investigación</h2>
                <div class="mt-2 w-24 h-1 mx-auto bg-[#ffb300] relative">
                    <div class="absolute left-0 top-0 w-1/2 h-1 bg-gray-300"></div>
                </div>

                <div class="mt-10 flex flex-col md:flex-row items-center justify-center gap-10">
                    <!-- Imagen -->
                    <div class="w-full max-w-xl px-4">
                        <img src="/images/baner1.png" alt="Reglamento"
                            class="rounded shadow w-full h-auto transform transition duration-500 hover:scale-105" />
                    </div>
                    <!-- Info -->
                    <div class="w-full md:w-1/3 text-center md:text-left">
                        <div class="mb-16">

                            <p class="text-lg font-semibold text-[#00367e]">Fecha Límite de Recepción:</p>
                            <p class="text-md font-bold text-gray-800 mb-4">Viernes 20 de junio 2025</p>
                        </div>

                        <h3 class="font-semibold text-gray-700 mb-2">Monto de la premiación:</h3>
                        <div class="text-sm text-gray-700 space-y-2 max-w-sm mx-auto md:mx-0 mb-10">
                            <div class="border-t pt-2">Primer Puesto: <strong>S/ 4,000.00</strong></div>
                            <div class="border-t pt-2">Segundo Puesto: <strong>S/ 3,000.00</strong></div>
                            <div class="border-t pt-2">Tercer Puesto: <strong>S/ 2,000.00</strong></div>
                        </div>

                        <p class="text-sm text-gray-600 mt-6">
                            Ver más detalle en el
                            <a href="/pdfs/reglamento-audita2025.pdf" class="text-blue-600 hover:underline"
                                target="_blank">Reglamento de Audita 2025</a>
                            y en el
                            <a href="/pdfs/reglamento-investigacion.pdf" class="text-blue-600 hover:underline"
                                target="_blank">Reglamento de Trabajos de Investigación</a>.
                        </p>

                        <p class="text-sm text-blue-700 mt-2 font-bold">
                            Enviar los trabajos al correo:
                            <a href="mailto:investigacion@ccppap.org.pe"
                                class="underline font-normal">ctnauditoria@jdccpp.org.pe</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>












        <section id="info" class="bg-white py-16 px-4">
            <div class="max-w-6xl mx-auto text-center mb-12">
                <h2 class="text-3xl font-extrabold text-black uppercase">Información General</h2>
                <div class="mt-2 w-24 h-1 mx-auto bg-[#ffb300] relative">
                    <div class="absolute left-0 top-0 w-1/2 h-1 bg-gray-300"></div>
                </div>
            </div>

            <!-- Contador -->
            <div class="text-center mb-12">
                <p class="text-sm text-gray-600 mb-1 tracking-wide uppercase">Faltan:</p>
                <p class="text-4xl font-extrabold text-[#00367e] font-mono tracking-widest">{{ tiempoRestante }}</p>
            </div>

            <!-- Información -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 text-center max-w-6xl mx-auto">
                <div
                    class="bg-white p-6 rounded-lg border-t-4 border-transparent shadow-md hover:shadow-xl hover:border-[#00367e] transform hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="text-[#b58900] mb-3 text-5xl">📅</div>
                    <h3 class="font-bold text-gray-800 text-lg mb-1">Fechas</h3>
                    <p class="text-sm text-gray-600">24, 25 y 26 de julio 2025</p>
                </div>

                <div @click="abrirModalHora"
                    class="bg-[#f9f9f9] p-6 rounded shadow transition duration-300 hover:shadow-xl hover:scale-105 hover:border-t-4 hover:border-[#00367e] hover:bg-white cursor-pointer">
                    <div class="text-[#b58900] mb-2 text-4xl">👥</div>
                    <h3 class="font-bold text-gray-800">Hora</h3>
                    <p class="text-sm text-gray-600">L–V 09:00 hrs. <br />Sáb. 9:00 hrs.</p>
                </div>

                <div
                    class="bg-white p-6 rounded-lg border-t-4 border-transparent shadow-md hover:shadow-xl hover:border-[#00367e] transform hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="text-[#b58900] mb-3 text-5xl">🖥️</div>
                    <h3 class="font-bold text-gray-800 text-lg mb-1">Modalidad</h3>
                    <p class="text-sm text-gray-600">Presencial | Virtual</p>
                </div>

                <a href="https://www.google.com/maps?q=Centro+de+Convenciones+UNA+PUNO" target="_blank"
                    rel="noopener noreferrer"
                    class="bg-white p-6 rounded-lg border-t-4 border-transparent shadow-md hover:shadow-xl hover:border-[#00367e] transform hover:-translate-y-1 transition-all duration-300 cursor-pointer block">
                    <div class="text-[#b58900] mb-3 text-5xl">📍</div>
                    <h3 class="font-bold text-gray-800 text-lg mb-1">Lugar</h3>
                    <p class="text-sm text-gray-600">Salón de eventos de la UNA PUNO (Centro de Convenciones)</p>
                </a>

            </div>






            <div v-if="mostrarModalHora" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center px-4">
                <div class="bg-white max-w-md w-full rounded-lg shadow-lg p-6 relative animate-fadeIn">
                    <button @click="cerrarModalHora"
                        class="absolute top-2 right-3 text-gray-500 hover:text-red-500 text-xl">
                        ✕
                    </button>

                    <h2 class="text-lg font-bold text-[#00367e] mb-4 bg-[#ffb300] text-white py-2 px-4 rounded">
                        Detalles del Horario
                    </h2>

                    <div class="text-sm text-gray-700 space-y-2">
                        <p><strong>Fechas del evento:</strong> 24, 25 y 26 de julio</p>
                        <p><strong>Horario:</strong></p>
                        <ul class="list-disc list-inside">
                            <li>Lunes a Viernes: 09:00 a 13:00 hrs. y 15:00 a 19:00 hrs.</li>
                            <li>Sábados: 09:00 a 12:00 hrs.</li>
                        </ul>
                    </div>
                </div>
            </div>

        </section>
















        <section id="contacto" class="relative h-[400px] md:h-[500px] overflow-hidden">
            <!-- Mapa interactivo -->
            <iframe class="absolute inset-0 w-full h-full grayscale hover:grayscale-0 transition duration-500"
                loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3838.584692358328!2d-70.01236118225954!3d-15.825837905726935!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x915d69ebbb2ab6e3%3A0x574b1be61f54d86b!2sCENTRO%20DE%20CONVENCIONES!5e0!3m2!1ses-419!2spe!4v1747224815176!5m2!1ses-419!2spe"></iframe>



            <!-- Capa superior -->
            <div class="absolute inset-0 bg-black/30 z-10"></div>

            <!-- Contenido -->
            <div
                class="relative z-20 max-w-4xl mx-auto h-full flex flex-col justify-center items-center px-4 text-center">
                <h2 class="text-3xl font-extrabold uppercase text-white">Contáctanos</h2>
                <div class="mt-2 w-24 h-1 bg-[#ffb300] relative">
                    <div class="absolute left-0 top-0 w-1/2 h-1 bg-gray-300"></div>
                </div>

                <!-- Caja flotante -->
                <div class="bg-white rounded shadow-lg mt-8 p-6 max-w-xl w-full">
                    <p class="text-gray-800 font-semibold text-lg mb-2">¿Tienes alguna duda?</p>
                    <p class="text-sm text-gray-600">
                        Es muy importante que el participante pueda resolver todas sus dudas sobre la
                        <strong>XI Convención Nacional de Auditoría, AUDITA 2025</strong>. Comunícate al
                        <strong>978785287</strong> o escríbenos por WhatsApp.
                    </p>

                    <a href="https://wa.me/51978785287" target="_blank"
                        class="inline-flex items-center mt-4 bg-[#28a745] hover:bg-[#218838] text-white font-semibold px-5 py-2 rounded transition">
                        <!-- Icono SVG de WhatsApp -->
                        <svg class="w-5 h-5 mr-2 fill-white" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16 0C7.164 0 0 6.99 0 15.607c0 2.75.784 5.361 2.285 7.652L0 32l9.03-2.446A15.86 15.86 0 0016 31.214c8.836 0 16-6.99 16-15.607S24.836 0 16 0zm0 29.143a13.72 13.72 0 01-6.993-1.902l-.5-.296-5.34 1.448 1.429-5.213-.326-.538A13.335 13.335 0 012.286 15.61c0-7.407 6.145-13.437 13.714-13.437S29.714 8.203 29.714 15.61 23.569 29.143 16 29.143zm7.327-10.007c-.281-.14-1.654-.82-1.911-.914-.256-.093-.444-.14-.633.14-.187.28-.724.913-.886 1.102-.163.187-.325.21-.606.07-.281-.14-1.188-.437-2.263-1.393-.836-.743-1.4-1.663-1.563-1.943-.163-.28-.017-.432.123-.572.126-.124.281-.325.422-.487.14-.163.187-.28.281-.467.093-.187.047-.35-.023-.497-.07-.14-.898-2.17-1.23-2.975-.325-.794-.654-.687-.886-.7-.233-.007-.49-.01-.747-.01s-.69.093-1.053.467c-.363.374-1.39 1.36-1.39 3.314s1.421 3.842 1.618 4.11c.196.28 2.795 4.287 6.857 5.665.958.328 1.702.524 2.283.673.958.233 1.83.202 2.524.123.768-.093 2.37-.978 2.707-1.922.336-.943.336-1.751.237-1.922-.093-.175-.345-.28-.724-.467z" />
                        </svg>

                        Charlemos
                    </a>
                </div>

            </div>
        </section>



        <section class="bg-gradient-to-br from-[#fff9ec] to-white text-[#00367e] py-16 px-4">
            <div class="max-w-6xl mx-auto text-center mb-12">
                <h2 class="text-3xl font-extrabold uppercase">Información Turística</h2>
                <div class="mt-2 w-24 h-1 mx-auto bg-[#ffb300] relative">
                    <div class="absolute left-0 top-0 w-1/2 h-1 bg-gray-300"></div>
                </div>
                <p class="mt-4 text-sm text-gray-700">Disfruta tu estadía en Puno con nuestras recomendaciones</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Destinos Turísticos -->
                <a href="https://drive.google.com/file/d/DESTINOS_ID" target="_blank"
                    class="bg-white hover:bg-[#fffbf1] border border-[#ffb300] text-[#00367e] p-6 rounded-xl shadow-md hover:shadow-lg transition flex items-center gap-4">
                    <div class="text-4xl">🗺️</div>
                    <div>
                        <h3 class="font-bold text-lg">Destinos Turísticos</h3>
                        <p class="text-sm text-gray-600">Archivo con los lugares turísticos recomendados.</p>
                    </div>
                </a>

                <!-- Hoteles Recomendados -->
                <a href="/pdfs/hotel.pdf" target="_blank"
                    class="bg-white hover:bg-[#fffbf1] border border-[#00367e] text-[#00367e] p-6 rounded-xl shadow-md hover:shadow-lg transition flex items-center gap-4">
                    <div class="text-4xl">🏨</div>
                    <div>
                        <h3 class="font-bold text-lg">Hoteles Recomendados</h3>
                        <p class="text-sm text-gray-600">Lista PDF con hospedajes sugeridos en Puno.</p>
                    </div>
                </a>
            </div>
        </section>









        <section class="bg-[#f9f9f9] py-12 overflow-hidden">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold uppercase text-[#00367e]">Auspiciadores</h2>
            </div>

            <Carousel class="max-w-7xl mx-auto" v-bind="config">
                <Slide v-for="(logo, index) in logos" :key="index">
                    <div class="flex items-center justify-center h-24 py-5 my-1">
                        <img :src="logo" alt="logo" class="h-14 object-contain" />
                    </div>
                </Slide>
            </Carousel>
        </section>



        <!-- Botones flotantes -->
        <div class="fixed bottom-6 right-6 flex flex-col items-end space-y-3 z-50 text-sm font-semibold">
            <!-- Botón de WhatsApp -->
            <a href="https://wa.me/51978785287" target="_blank"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-lg shadow-lg flex flex-col items-center text-center transition w-44">
                <div class="flex items-center justify-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-white" viewBox="0 0 24 24">
                        <path
                            d="M12 0C5.383 0 0 5.383 0 12c0 2.121.553 4.106 1.514 5.832L0 24l6.408-1.482A11.938 11.938 0 0 0 12 24c6.617 0 12-5.383 12-12S18.617 0 12 0zm0 22.059c-1.853 0-3.637-.504-5.196-1.455l-.371-.218-3.805.879.812-3.711-.24-.382A9.954 9.954 0 0 1 2.059 12C2.059 6.486 6.486 2.059 12 2.059S21.941 6.486 21.941 12 17.514 21.941 12 21.941zm5.357-7.987c-.235-.117-1.387-.683-1.602-.76-.215-.079-.372-.118-.53.117-.157.235-.608.76-.745.918-.137.157-.274.176-.509.058-.235-.118-.993-.366-1.891-1.167-.699-.622-1.17-1.391-1.306-1.626-.137-.235-.015-.362.103-.48.106-.105.235-.274.353-.412.118-.137.157-.235.235-.392.078-.157.039-.294-.02-.412-.058-.117-.53-1.272-.726-1.743-.196-.47-.394-.412-.53-.421-.137-.009-.294-.01-.451-.01-.157 0-.412.059-.627.274s-.824.804-.824 1.96.844 2.273.96 2.431c.118.157 1.657 2.549 4.02 3.57.562.243.999.388 1.34.497.563.178 1.075.153 1.48.093.452-.068 1.387-.566 1.583-1.113.196-.548.196-1.018.137-1.113-.058-.098-.215-.157-.451-.274z" />
                    </svg>
                    <span>WhatsApp</span>
                </div>
                <span class="text-xs italic mt-1 opacity-80">Haz clic aquí</span>
            </a>

            <!-- Botón de registro -->
            <a href="/registro"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg shadow-lg text-center flex flex-col items-center w-44 transition">
                <span>¡Regístrate y participa!</span>
                <span class="text-xs italic mt-1 opacity-80">Haz clic aquí</span>
            </a>
        </div>





    </AuditaLayout>
</template>

<script setup lang="ts">



import AuditaLayout from '@/layouts/AuditaLayout.vue'
import ImageSlider from '@/components/ImageSlider.vue'
import ExpositoresSlider from '@/components/ExpositoresSlider.vue'


import {
    ref,
    onMounted,
    onBeforeUnmount
} from 'vue'



import 'vue3-carousel/carousel.css'
import {
    Carousel,
    Slide,
    Pagination,
    Navigation
} from 'vue3-carousel'



import {
    Dialog,
    DialogPanel,
    DialogTitle,
    DialogDescription,
    TransitionRoot,
    TransitionChild,
} from '@headlessui/vue'


const modalActivo = ref<number | null>(null)


function abrirModal(index: number) {
    modalActivo.value = index
}

function cerrarModal() {
    modalActivo.value = null
}

const mostrarModalHora = ref(false)
const abrirModalHora = () => { mostrarModalHora.value = true }
const cerrarModalHora = () => { mostrarModalHora.value = false }


const mostrarModalBeneficios = ref(false)
const tipoPlanModal = ref('')
const planSeleccionado = ref<any>(null)

function abrirModalParticipante(tipo: string) {
    tipoPlanModal.value = tipo
    planSeleccionado.value = planes.find(p => p.tipo === tipo)
    mostrarModalBeneficios.value = true
}

function cerrarModalBeneficios() {
    mostrarModalBeneficios.value = false
}


interface Item {
    title: string
    image: string
    pdf: string
}






const items: Item[] = [{
    title: 'Conoce AUDITA 2025',
    image: '/images/003.png',
    pdf: '/pdfs/que-es-audita.pdf',
},

{
    title: 'Programa AUDITA 2025',
    image: '/images/005.png',
    pdf: '/pdfs/programa-audita.pdf',
},
]



const images = [
    '/images/puno1.jpg',
    '/images/puno2.webp',
    '/images/puno3.webp',
    '/images/puno4.jpg',
    '/images/puno5.jpg',
    '/images/puno6.webp',
]



const planes = [
    {
        tipo: 'PARTICIPANTE PLENO',
        imagen: '/images/precio3.jpg',
        bg: 'bg-[#ae1f22]',
        descripcion: 'Contadores Públicos que están inscritos en su respectivo Colegio Departamental. Participan con todos los derechos y obligaciones.',
        presencial: {
            hasta30junio: 315,
            desde01julio: 350,
            beneficios: [
                '12 conferencias magistrales',
                'Credencial',
                'Coffee break',
                'Cartapacio AUDITA',
                'Block de notas AUDITA',
                'Lapicero',
                'Jueves 24: Noche Puneña',
                'Viernes 25: Copa Titikaka',
                'Sábado 26: Almuerzo de Confraternidad',
                'Domingo 27: Tour Turístico',
                'Acceso a Aula Virtual y la información completa',
                'Certificado',
            ],
        },
        virtual: {
            hasta30junio: 270,
            desde01julio: 300,
            beneficios: [
                '12 conferencias magistrales',
                'Acceso a Aula Virtual',
                'Certificado',
            ],
        },
        descuento: '10% de descuento hasta el 30 de junio',
    },
    {
        tipo: 'PARTICIPANTE OBSERVADOR',
        imagen: '/images/precio1.jpg',
        bg: 'bg-[#00367e]',
        descripcion: 'Empresarios, profesionales de otras ramas del conocimiento, así como los bachilleres, egresados y otras personas interesadas.',
        presencial: {
            hasta30junio: 270,
            desde01julio: 300,
            beneficios: [
                '12 conferencias magistrales',
                'Credencial',
                'Coffee break',
                'Cartapacio AUDITA',
                'Block de notas AUDITA',
                'Lapicero',
                'Jueves 24: Noche Puneña',
                'Viernes 25: Copa Titikaka',
                'Acceso a Aula Virtual y la información completa',
                'Certificado',
            ],
        },
        virtual: {
            hasta30junio: 225,
            desde01julio: 250,
            beneficios: [
                '12 conferencias magistrales',
                'Acceso a Aula Virtual',
                'Certificado',
            ],
        },
        descuento: '10% de descuento hasta el 30 de junio',
    },
    {
        tipo: 'PARTICIPANTE ESTUDIANTE',
        imagen: '/images/precio2.jpg',
        bg: 'bg-[#ffb300]',
        descripcion: 'Estudiantes que se encuentren cursando estudios de nivel superior en Ciencias Contables y afines.',
        presencial: {
            hasta30junio: 90,
            desde01julio: 100,
            beneficios: [
                '12 conferencias magistrales',
                'Credencial',
                'Coffee break',
                'Block de notas AUDITA',
                'Lapicero',
                'Jueves 24: Noche Puneña',
                'Viernes 25: Copa Titikaka',
                'Acceso a Aula Virtual y la información completa',
                'Certificado',
            ],
        },
        virtual: {
            hasta30junio: 45,
            desde01julio: 50,
            beneficios: [
                '12 conferencias magistrales',
                'Acceso a Aula Virtual',
                'Certificado',
            ],
        },
        descuento: '10% de descuento hasta el 30 de junio',
    },
]


const expandedTipo = ref<string | null>(null)

function toggleCard(tipo: string) {
    expandedTipo.value = expandedTipo.value === tipo ? null : tipo
}








const documentos = [{
    titulo: 'Reglamento AUDITA 2025',
    imagen: '/images/002.png',
    pdf: '/pdfs/reglamento-audita2025.pdf',
},
{
    titulo: 'Reglamento Trabajos de Investigación',
    imagen: '/images/001.png',
    pdf: '/pdfs/reglamento-investigacion-audita2025.pdf',
},
]










const tiempoRestante = ref('')
const fechaEvento = new Date('2025-07-24T09:00:00') // 24 de agosto de 2025, 09:00 hrs

const actualizarContador = () => {
    const ahora = new Date()
    const diferencia = fechaEvento.getTime() - ahora.getTime()

    if (diferencia <= 0) {
        tiempoRestante.value = '¡El evento ha comenzado!'
        return
    }

    const dias = Math.floor(diferencia / (1000 * 60 * 60 * 24))
    const horas = Math.floor((diferencia / (1000 * 60 * 60)) % 24)
    const minutos = Math.floor((diferencia / (1000 * 60)) % 60)
    const segundos = Math.floor((diferencia / 1000) % 60)

    tiempoRestante.value = `${dias} días, ${horas}h ${minutos}m ${segundos}s`
}

let intervalo: ReturnType<typeof setInterval>

onMounted(() => {
    actualizarContador()
    intervalo = setInterval(actualizarContador, 1000)
})

onBeforeUnmount(() => {
    clearInterval(intervalo)
})







const logos = [
    '/images/logo6.png',
    '/images/logo.png',
    '/images/logo2.png',
    '/images/logo7.png',
    // '/images/logo4.png',
    '/images/logo3.png',
    '/images/logo5.png',
]


const enPantalla = ref(false)
const citaRef = ref<HTMLElement | null>(null)

let observer: IntersectionObserver

onMounted(() => {
    observer = new IntersectionObserver(
        ([entry]) => {
            enPantalla.value = entry.isIntersecting
        },
        {
            threshold: 0.6, // visible al menos 60%
        }
    )

    if (citaRef.value) {
        observer.observe(citaRef.value)
    }
})

onBeforeUnmount(() => {
    if (citaRef.value) observer.unobserve(citaRef.value)
})





const config = {
    height: 120,
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


<style scoped>
@keyframes typewriter {
    from {
        width: 0;
    }

    to {
        width: 100%;
    }
}

.animate-typewriter {
    animation: typewriter 8s steps(100) 1 forwards;
    overflow: hidden;
    white-space: nowrap;
}


@keyframes fadeInRight {
    0% {
        opacity: 0;
        transform: translateX(3rem);
    }

    100% {
        opacity: 1;
        transform: translateX(0);
    }
}

.animate-fade-in-right {
    animation: fadeInRight 1s ease-out forwards;
}




@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(1rem);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
}
</style>
