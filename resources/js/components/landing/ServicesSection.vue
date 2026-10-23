<script setup lang="ts">
import { ArrowUpRight, Sparkles } from '@lucide/vue';
import {
    fallbackServiceIcon,
    serviceDescriptions as descriptions,
    serviceIcons as icons,
} from '@/lib/services';

defineProps<{
    services: string[];
    serviceImages: Record<string, string>;
}>();

const emit = defineEmits<{
    select: [service: string];
}>();
</script>

<template>
    <section id="servicios" class="relative bg-white py-20 sm:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="mx-auto max-w-2xl text-center">
                <p
                    class="text-xs font-semibold tracking-[0.28em] text-luda-rose uppercase"
                >
                    Nuestros servicios
                </p>
                <h2
                    class="mt-3 text-3xl font-semibold tracking-tight text-luda-plum sm:text-4xl"
                >
                    Especialidades para cada etapa de tu sonrisa
                </h2>
                <p class="mt-4 text-base leading-relaxed text-luda-ink/65">
                    Un equipo multidisciplinario y tecnología actual para que
                    recibas el tratamiento que necesitas en un solo lugar.
                </p>
            </div>

            <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <article
                    v-for="(service, index) in services"
                    :key="service"
                    class="group relative flex flex-col overflow-hidden rounded-3xl border border-luda-plum/5 bg-white shadow-[0_20px_60px_-44px_rgba(51,0,31,0.4)] transition duration-300 hover:-translate-y-1 hover:border-luda-blush/60 hover:shadow-[0_28px_60px_-30px_rgba(227,2,145,0.35)]"
                >
                    <div
                        v-if="serviceImages[service]"
                        class="relative aspect-[16/10] overflow-hidden bg-luda-mist"
                    >
                        <img
                            :src="serviceImages[service]"
                            :alt="service"
                            class="size-full object-cover transition duration-500 group-hover:scale-105"
                            loading="lazy"
                        />
                        <span
                            class="absolute top-3 left-3 rounded-full bg-white/85 px-2 py-0.5 text-[10px] font-semibold text-luda-plum backdrop-blur"
                        >
                            0{{ index + 1 }}
                        </span>
                    </div>

                    <div class="flex flex-1 flex-col p-6">
                        <div class="flex items-start justify-between gap-3">
                            <span
                                class="flex size-12 items-center justify-center rounded-2xl bg-luda-mist text-luda-rose transition duration-300 group-hover:bg-luda-rose group-hover:text-white"
                            >
                                <component
                                    :is="icons[service] ?? fallbackServiceIcon"
                                    class="size-6"
                                />
                            </span>
                            <span
                                class="text-xs font-semibold text-luda-plum/10"
                            >
                                0{{ index + 1 }}
                            </span>
                        </div>

                        <h3 class="mt-5 text-lg font-semibold text-luda-plum">
                            {{ service }}
                        </h3>
                        <p
                            class="mt-2 flex-1 text-sm leading-relaxed text-luda-ink/60"
                        >
                            {{ descriptions[service] ?? '' }}
                        </p>
                        <a
                            href="#agendar"
                            class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-luda-rose transition hover:gap-2.5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-luda-rose/30"
                            @click="emit('select', service)"
                        >
                            Agendar este servicio
                            <ArrowUpRight class="size-4" />
                        </a>
                    </div>
                </article>

                <article
                    class="relative flex flex-col justify-between overflow-hidden rounded-3xl bg-luda-plum p-6 text-white shadow-xl shadow-luda-plum/20"
                >
                    <div
                        class="absolute -top-16 -right-10 size-40 rounded-full bg-luda-blush/20 blur-2xl"
                        aria-hidden="true"
                    ></div>
                    <div class="relative">
                        <span
                            class="flex size-12 items-center justify-center rounded-2xl bg-white/10 text-luda-blush ring-1 ring-white/15"
                        >
                            <Sparkles class="size-6" />
                        </span>
                        <h3 class="mt-5 text-lg font-semibold">
                            ¿No sabes qué necesitas?
                        </h3>
                        <p class="mt-2 text-sm leading-relaxed text-white/60">
                            Agenda una valoración y te ayudamos a elegir el
                            tratamiento ideal para ti.
                        </p>
                    </div>
                    <a
                        href="#agendar"
                        class="relative mt-5 inline-flex items-center gap-2 text-sm font-semibold text-luda-blush transition hover:text-white"
                    >
                        Solicitar valoración
                        <ArrowUpRight class="size-4" />
                    </a>
                </article>
            </div>
        </div>
    </section>
</template>
