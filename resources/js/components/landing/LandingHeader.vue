<script setup lang="ts">
import { onBeforeUnmount, onMounted, ref } from 'vue';
import { CalendarDays, Clock, MapPin, Menu, Phone, X } from '@lucide/vue';
import type { ClinicPhone } from '@/types';

defineProps<{
    phones: ClinicPhone[];
}>();

const isScrolled = ref(false);
const isMenuOpen = ref(false);

const navItems = [
    { label: 'Inicio', href: '#inicio' },
    { label: 'Servicios', href: '#servicios' },
    { label: 'Atención', href: '#atencion' },
    { label: 'Agenda', href: '#agendar' },
    { label: 'Contacto', href: '#contacto' },
];

function onScroll(): void {
    isScrolled.value = window.scrollY > 16;
}

function closeMenu(): void {
    isMenuOpen.value = false;
}

onMounted(() => {
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
});

onBeforeUnmount(() => {
    window.removeEventListener('scroll', onScroll);
});
</script>

<template>
    <header class="fixed inset-x-0 top-0 z-50 px-3 pt-3 sm:px-6 sm:pt-4">
        <div
            :class="[
                'mx-auto max-w-7xl rounded-2xl border transition-all duration-300',
                isScrolled
                    ? 'border-luda-plum/10 bg-white/95 shadow-[0_24px_60px_-30px_rgba(51,0,31,0.45)] backdrop-blur-xl'
                    : 'border-white/70 bg-white/80 shadow-[0_18px_50px_-32px_rgba(51,0,31,0.4)] backdrop-blur-lg',
            ]"
        >
            <div
                class="hidden items-center justify-between gap-6 border-b border-luda-plum/5 px-6 py-2 text-[11px] font-medium text-luda-ink/60 lg:flex"
            >
                <p class="flex items-center gap-2">
                    <MapPin class="size-3.5 text-luda-rose" />
                    Jardines del Valle, Zapopan
                    <span class="text-luda-rose/40">•</span>
                    <Clock class="size-3.5 text-luda-rose" />
                    Lun a Jue 10–13 y 16–19 · Vie 16–19 · Sáb 10–13
                </p>
                <div class="flex items-center gap-5">
                    <a
                        v-for="phone in phones"
                        :key="phone.number"
                        :href="`tel:+52${phone.number}`"
                        class="flex items-center gap-1.5 transition hover:text-luda-rose"
                    >
                        <Phone class="size-3.5 text-luda-rose" />
                        {{ phone.label }}
                    </a>
                </div>
            </div>

            <nav
                class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6 lg:h-20"
                aria-label="Navegación principal"
            >
                <button
                    type="button"
                    class="flex size-10 items-center justify-center rounded-full border border-luda-plum/10 text-luda-plum transition hover:bg-luda-mist focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-luda-rose/30 lg:hidden"
                    :aria-expanded="isMenuOpen"
                    aria-controls="landing-mobile-menu"
                    aria-label="Abrir menú de navegación"
                    @click="isMenuOpen = !isMenuOpen"
                >
                    <X v-if="isMenuOpen" class="size-5" />
                    <Menu v-else class="size-5" />
                </button>

                <div class="hidden items-center gap-1 lg:flex">
                    <a
                        v-for="item in navItems"
                        :key="item.href"
                        :href="item.href"
                        class="rounded-full px-4 py-2 text-sm font-medium text-luda-ink/70 transition hover:bg-luda-mist hover:text-luda-plum focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-luda-rose/30"
                    >
                        {{ item.label }}
                    </a>
                </div>

                <div class="flex items-center gap-2">
                    <a
                        :href="`tel:+52${phones[0]?.number ?? ''}`"
                        class="flex size-10 items-center justify-center rounded-full border border-luda-plum/10 text-luda-plum transition hover:border-luda-rose/30 hover:bg-luda-mist lg:hidden"
                        aria-label="Llamar a la clínica"
                    >
                        <Phone class="size-4" />
                    </a>

                    <a
                        href="#agendar"
                        class="hidden items-center gap-2 rounded-full bg-luda-plum px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-luda-plum/20 transition hover:bg-luda-rose focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-luda-rose/50 focus-visible:ring-offset-2 sm:inline-flex"
                    >
                        <CalendarDays class="size-4" />
                        Agendar cita
                    </a>
                </div>
            </nav>

            <Transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="-translate-y-2 opacity-0"
                enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="translate-y-0 opacity-100"
                leave-to-class="-translate-y-2 opacity-0"
            >
                <div
                    v-if="isMenuOpen"
                    id="landing-mobile-menu"
                    class="border-t border-luda-plum/5 px-4 pt-2 pb-5 lg:hidden"
                >
                    <a
                        v-for="item in navItems"
                        :key="item.href"
                        :href="item.href"
                        class="flex items-center justify-between rounded-xl px-3 py-3 text-sm font-medium text-luda-ink/75 transition hover:bg-luda-mist hover:text-luda-plum"
                        @click="closeMenu"
                    >
                        {{ item.label }}
                        <span class="text-luda-rose/50">→</span>
                    </a>

                    <div class="mt-3 grid gap-2 border-t border-luda-plum/5 pt-3">
                        <a
                            v-for="phone in phones"
                            :key="phone.number"
                            :href="`tel:+52${phone.number}`"
                            class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium text-luda-rose"
                            @click="closeMenu"
                        >
                            <Phone class="size-4" />
                            {{ phone.label }}
                        </a>
                    </div>

                    <a
                        href="#agendar"
                        class="mt-3 flex items-center justify-center gap-2 rounded-xl bg-luda-plum px-4 py-3 text-sm font-semibold text-white"
                        @click="closeMenu"
                    >
                        <CalendarDays class="size-4" />
                        Agendar mi cita
                    </a>
                </div>
            </Transition>
        </div>
    </header>
</template>
