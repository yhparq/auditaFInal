<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    participantes: Array
});

function eliminar(id) {
    if (confirm('¿Deseas eliminar este participante?')) {
        router.delete(`/participantes/${id}`);
    }
}

const breadcrumbs = [
    { title: 'Participantes Individuales', href: '/participantes/individuales' },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Participantes Corporativos</h1>
                <p class="text-gray-600 dark:text-gray-400">Gestión completa de todos los participantes registrados individualmente</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ participantes.length }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Activos</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ participantes.filter(p => p.estado).length }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-red-100 dark:bg-red-900 rounded-lg">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Inactivos</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ participantes.filter(p => !p.estado).length }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Con Voucher</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ participantes.filter(p => p.foto_voucher).length }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla Completa de Participantes -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Lista Completa de Participantes</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Información detallada de todos los campos</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-[2400px] divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nombres</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Apellidos</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">DNI</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Correo</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Celular</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Colegio Departamental</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Departamento</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Provincia</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Distrito</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Dirección</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipo Participante</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Categoría</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Modalidad</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Corporativo</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Código Pago</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Voucher</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Comprobante</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">RUC</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Estado</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Creado</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actualizado</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <tr v-for="p in participantes" :key="p.id" class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <!-- Nombres -->
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ p.nombres }}</td>
                                
                                <!-- Apellidos -->
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ p.apellidos }}</td>
                                
                                <!-- DNI -->
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                        {{ p.dni }}
                                    </span>
                                </td>
                                
                                <!-- Correo -->
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white max-w-xs">
                                    <div class="truncate" :title="p.correo">{{ p.correo || '—' }}</div>
                                </td>
                                
                                <!-- Celular -->
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    {{ p.celular || '—' }}
                                </td>
                                
                                <!-- Colegio Departamental -->
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white max-w-xs">
                                    <div class="truncate" :title="p.colegio_departamental">{{ p.colegio_departamental || '—' }}</div>
                                </td>
                                
                                <!-- Departamento -->
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ p.departamento }}</td>
                                
                                <!-- Provincia -->
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ p.provincia }}</td>
                                
                                <!-- Distrito -->
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ p.distrito }}</td>
                                
                                <!-- Dirección -->
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white max-w-xs">
                                    <div class="truncate" :title="p.direccion_actual">{{ p.direccion_actual }}</div>
                                </td>
                                
                                <!-- Tipo Participante -->
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ p.tipo_participante || '—' }}
                                    </span>
                                </td>
                                
                                <!-- Categoría -->
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        {{ p.tipo_participante_categoria || '—' }}
                                    </span>
                                </td>
                                
                                <!-- Modalidad -->
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                        {{ p.modalidad_participacion || '—' }}
                                    </span>
                                </td>
                                
                                <!-- Corporativo -->
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white max-w-xs">
                                    <div v-if="p.nombre_corporativo" class="truncate" :title="p.nombre_corporativo">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                            {{ p.nombre_corporativo }}
                                        </span>
                                    </div>
                                    <span v-else class="text-gray-400 italic">—</span>
                                </td>
                                
                                <!-- Código Pago -->
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                        {{ p.codigo_pago }}
                                    </span>
                                </td>
                                
                                <!-- Voucher -->
                                <td class="px-4 py-3">
                                    <div v-if="p.foto_voucher" class="flex items-center">
                                        <a :href="`/storage/${p.foto_voucher}`" target="_blank" rel="noopener noreferrer" class="group relative">
                                            <img :src="`/storage/${p.foto_voucher}`" alt="Voucher"
                                                class="w-12 h-12 object-cover rounded-lg border-2 border-gray-200 dark:border-gray-600 hover:border-blue-500 transition-colors cursor-pointer" />
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition-all flex items-center justify-center">
                                                <svg class="w-3 h-3 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                </svg>
                                            </div>
                                        </a>
                                    </div>
                                    <div v-else class="flex items-center">
                                        <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Comprobante -->
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        {{ p.comprobante }}
                                    </span>
                                </td>
                                
                                <!-- RUC -->
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    <span v-if="p.numero_ruc" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        {{ p.numero_ruc }}
                                    </span>
                                    <span v-else class="text-gray-400 italic">—</span>
                                </td>
                                
                                <!-- Estado -->
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                        :class="p.estado 
                                            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' 
                                            : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'">
                                        <svg class="w-1.5 h-1.5 mr-1" :class="p.estado ? 'text-green-400' : 'text-red-400'" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3"/>
                                        </svg>
                                        {{ p.estado ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                
                                <!-- Creado -->
                                <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400">
                                    {{ new Date(p.created_at).toLocaleDateString('es-PE') }}
                                </td>
                                
                                <!-- Actualizado -->
                                <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400">
                                    {{ new Date(p.updated_at).toLocaleDateString('es-PE') }}
                                </td>
                                
                                <!-- Acciones -->
                                <td class="px-4 py-3 text-right text-sm font-medium space-x-1">
                                    <Link :href="`/participantes/${p.id}/edit`"
                                        class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                                        Editar
                                    </Link>
                                    <button @click="eliminar(p.id)"
                                        class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 transition-colors">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Empty State -->
                <div v-if="participantes.length === 0" class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No hay participantes registrados</h3>
                    <p class="text-gray-500 dark:text-gray-400">Cuando se registren participantes individuales aparecerán aquí.</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>