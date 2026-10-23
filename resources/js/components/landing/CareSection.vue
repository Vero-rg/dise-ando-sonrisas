<script setup lang="ts">
import {
    ArrowRight,
    Baby,
    Check,
    Smile,
    Sparkles,
    UserRound,
} from '@lucide/vue';

const emit = defineEmits<{
    'select-type': [type: 'adulto' | 'nino'];
}>();

const childBenefits = [
    'Primera visita sin miedo y a su ritmo',
    'Prevención, selladores y fluoruro',
    'Acompañamiento cercano para papás y mamás',
];

const adultBenefits = [
    'Ortodoncia con brackets y alineadores',
    'Prótesis fijas, removibles y coronas',
    'Odontología general y limpiezas',
];
</script>

<template>
    <section id="atencion" class="relative bg-luda-mist py-20 sm:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="mx-auto max-w-2xl text-center">
                <p
                    class="text-xs font-semibold tracking-[0.28em] text-luda-rose uppercase"
                >
                    Atención personalizada
                </p>
                <h2
                    class="mt-3 text-3xl font-semibold tracking-tight text-luda-plum sm:text-4xl"
                >
                    Un espacio para cada etapa de tu sonrisa
                </h2>
                <p class="mt-4 text-base leading-relaxed text-luda-ink/65">
                    Sabemos que las necesidades cambian con la edad. Por eso
                    adaptamos cada visita a ti y a tu familia.
                </p>
            </div>

            <div class="mt-12 grid gap-6 lg:grid-cols-2">
                <article
                    class="group relative overflow-hidden rounded-[2rem] border border-luda-blush/30 bg-linear-to-br from-white via-luda-mist to-[#f8e3ec] p-7 shadow-[0_24px_70px_-50px_rgba(51,0,31,0.5)] sm:p-9"
                >
                    <div
                        class="absolute -top-20 -right-16 size-56 rounded-full bg-luda-blush/25 blur-3xl transition group-hover:bg-luda-blush/35"
                        aria-hidden="true"
                    ></div>

                    <div class="relative flex items-center gap-3">
                        <span
                            class="flex size-14 items-center justify-center rounded-2xl bg-white text-luda-rose shadow-sm ring-1 ring-luda-plum/5"
                        >
                            <Baby class="size-7" />
                        </span>
                        <span
                            class="rounded-full bg-luda-rose/10 px-3 py-1 text-[10px] font-semibold tracking-[0.18em] text-luda-rose uppercase"
                        >
                            Para niños
                        </span>
                    </div>

                    <h3 class="relative mt-6 text-2xl font-semibold text-luda-plum">
                        Odontopediatría con paciencia y juego
                    </h3>
                    <p class="relative mt-3 text-sm leading-relaxed text-luda-ink/65">
                        Cuidamos sus primeros dientes con un trato amable,
                        explicaciones sencillas y mucha paciencia para que
                        crezcan sin miedo al dentista.
                    </p>

                    <ul class="relative mt-6 space-y-3">
                        <li
                            v-for="benefit in childBenefits"
                            :key="benefit"
                            class="flex items-start gap-3 text-sm text-luda-ink/75"
                        >
                            <span
                                class="mt-0.5 flex size-5 shrink-0 items-center justify-center rounded-full bg-luda-rose/10 text-luda-rose"
                            >
                                <Check class="size-3.5" />
                            </span>
                            {{ benefit }}
                        </li>
                    </ul>

                    <a
                        href="#agendar"
                        class="relative mt-8 inline-flex items-center gap-2 rounded-full bg-luda-plum px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-luda-plum/20 transition hover:bg-luda-rose"
                        @click="emit('select-type', 'nino')"
                    >
                        Agendar cita para mi hijo
                        <ArrowRight class="size-4" />
                    </a>
                </article>

                <article
                    class="group relative overflow-hidden rounded-[2rem] bg-linear-to-br from-luda-plum via-[#7a0d4f] to-luda-rose p-7 text-white shadow-2xl shadow-luda-plum/25 sm:p-9"
                >
                    <div
                        class="absolute -top-24 -right-20 size-64 rounded-full bg-luda-blush/20 blur-3xl"
                        aria-hidden="true"
                    ></div>
                    <div
                        class="absolute -bottom-24 -left-16 size-56 rounded-full bg-white/5 blur-2xl"
                        aria-hidden="true"
                    ></div>

                    <div class="relative flex items-center gap-3">
                        <span
                            class="flex size-14 items-center justify-center rounded-2xl bg-white/10 text-luda-blush ring-1 ring-white/15"
                        >
                            <UserRound class="size-7" />
                        </span>
                        <span
                            class="rounded-full bg-white/10 px-3 py-1 text-[10px] font-semibold tracking-[0.18em] text-luda-blush uppercase ring-1 ring-white/15"
                        >
                            Para adultos
                        </span>
                    </div>

                    <h3 class="relative mt-6 text-2xl font-semibold">
                        Tratamientos para adultos
                    </h3>
                    <p class="relative mt-3 text-sm leading-relaxed text-white/65">
                        Recupera la confianza en tu sonrisa con planes
                        personalizados que combinan salud, función y estética.
                    </p>

                    <ul class="relative mt-6 space-y-3">
                        <li
                            v-for="benefit in adultBenefits"
                            :key="benefit"
                            class="flex items-start gap-3 text-sm text-white/80"
                        >
                            <span
                                class="mt-0.5 flex size-5 shrink-0 items-center justify-center rounded-full bg-white/10 text-luda-blush"
                            >
                                <Check class="size-3.5" />
                            </span>
                            {{ benefit }}
                        </li>
                    </ul>

                    <div
                        class="relative mt-8 flex flex-wrap items-center gap-3"
                    >
                        <a
                            href="#agendar"
                            class="inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 text-sm font-semibold text-luda-plum shadow-lg shadow-black/20 transition hover:bg-luda-blush"
                            @click="emit('select-type', 'adulto')"
                        >
                            Agendar mi valoración
                            <ArrowRight class="size-4" />
                        </a>
                        <span class="flex items-center gap-1.5 text-xs text-white/50">
                            <Smile class="size-4 text-luda-blush" />
                            <Sparkles class="size-4 text-luda-blush" />
                            Sonrisas que se notan
                        </span>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>
