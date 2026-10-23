<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import ServiceImageCard from '@/components/admin/ServiceImageCard.vue';
import {
    fallbackServiceIcon,
    serviceDescriptions,
    serviceIcons,
} from '@/lib/services';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Servicios',
                href: '/admin/servicios',
            },
        ],
    },
});

defineProps<{
    services: string[];
    images: Record<string, string>;
}>();
</script>

<template>
    <Head title="Servicios" />

    <div class="flex h-full flex-1 flex-col gap-6 bg-luda-mist p-4 sm:p-6">
        <header>
            <p
                class="text-[11px] font-semibold tracking-[0.22em] text-luda-rose uppercase"
            >
                Panel administrativo
            </p>
            <h1
                class="mt-1 text-2xl font-semibold tracking-tight text-luda-plum sm:text-3xl"
            >
                Servicios
            </h1>
            <p class="mt-1.5 max-w-2xl text-sm text-luda-ink/55">
                Agrega una foto a cada servicio. Si un servicio no tiene imagen,
                en el sitio se muestra su ícono predeterminado.
            </p>
        </header>

        <div class="grid gap-4 sm:grid-cols-2">
            <ServiceImageCard
                v-for="service in services"
                :key="service"
                :servicio="service"
                :descripcion="serviceDescriptions[service] ?? ''"
                :icon="serviceIcons[service] ?? fallbackServiceIcon"
                :imagen="images[service] ?? null"
            />
        </div>
    </div>
</template>
