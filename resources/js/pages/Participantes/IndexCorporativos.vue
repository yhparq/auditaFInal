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
    { title: 'Participantes Corporativos', href: '/participantes/corporativos' },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Participantes Corporativos</h1>

            <Link href="/participantes/create"
                class="inline-block mb-6 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition">
            Nuevo Participante
            </Link>

            <div class="w-full overflow-x-auto rounded shadow ring-1 ring-gray-200 dark:ring-gray-700">
                <table class="min-w-[1400px] text-sm text-left text-gray-800 dark:text-gray-100">
                    <thead class="bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Nombres</th>
                            <th class="px-4 py-3 font-semibold">Apellidos</th>
                            <th class="px-4 py-3 font-semibold">DNI</th>
                            <th class="px-4 py-3 font-semibold">Departamento</th>
                            <th class="px-4 py-3 font-semibold">Provincia</th>
                            <th class="px-4 py-3 font-semibold">Distrito</th>
                            <th class="px-4 py-3 font-semibold">Dirección</th>
                            <th class="px-4 py-3 font-semibold">Código Pago</th>
                            <th class="px-4 py-3 font-semibold">Comprobante</th>
                            <th class="px-4 py-3 font-semibold">RUC</th>
                            <th class="px-4 py-3 font-semibold">Corporativo</th>
                            <th class="px-4 py-3 font-semibold">Voucher</th>
                            <th class="px-4 py-3 font-semibold">Estado</th>
                            <th class="px-4 py-3 font-semibold text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr v-for="p in participantes" :key="p.id" class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-4 py-3">{{ p.nombres }}</td>
                            <td class="px-4 py-3">{{ p.apellidos }}</td>
                            <td class="px-4 py-3">{{ p.dni }}</td>
                            <td class="px-4 py-3">{{ p.departamento }}</td>
                            <td class="px-4 py-3">{{ p.provincia }}</td>
                            <td class="px-4 py-3">{{ p.distrito }}</td>
                            <td class="px-4 py-3">{{ p.direccion_actual }}</td>
                            <td class="px-4 py-3">{{ p.codigo_pago }}</td>
                            <td class="px-4 py-3">{{ p.comprobante }}</td>
                            <td class="px-4 py-3">{{ p.numero_ruc || '—' }}</td>
                            <td class="px-4 py-3">{{ p.nombre_corporativo || '—' }}</td>
                            <td class="px-4 py-3">
                                <template v-if="p.foto_voucher">
                                    <a :href="`/storage/${p.foto_voucher}`" target="_blank" rel="noopener noreferrer">
                                        <img :src="`/storage/${p.foto_voucher}`" alt="Voucher"
                                            class="w-16 h-16 object-cover rounded border dark:border-gray-700 cursor-pointer hover:opacity-80 transition" />
                                    </a>
                                </template>
                                <span v-else class="text-gray-400 italic">Sin imagen</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full"
                                    :class="p.estado ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300'">
                                    {{ p.estado ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <Link :href="`/participantes/${p.id}/edit`"
                                    class="inline-block px-3 py-1 text-sm text-white bg-indigo-600 rounded hover:bg-indigo-700">
                                Editar
                                </Link>
                                <button @click="eliminar(p.id)"
                                    class="inline-block px-3 py-1 text-sm text-white bg-red-600 rounded hover:bg-red-700">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
