<script setup lang="ts">
import { onBeforeUnmount, ref } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import {
    ImagePlus,
    Images,
    LoaderCircle,
    Trash2,
    Upload,
    X,
} from '@lucide/vue';
import InputError from '@/components/InputError.vue';
import type { HeroImageRecord } from '@/types';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Portada',
                href: '/admin/portada',
            },
        ],
    },
});

defineProps<{
    images: HeroImageRecord[];
}>();

const MAX_BATCH = 8;

const input = ref<HTMLInputElement | null>(null);
const selected = ref<{ file: File; preview: string }[]>([]);

const form = useForm({
    imagenes: [] as File[],
});

function syncFiles(): void {
    form.imagenes = selected.value.map((item) => item.file);
}

function chooseFiles(): void {
    input.value?.click();
}

function onFilesChange(event: Event): void {
    const target = event.target as HTMLInputElement;
    const files = Array.from(target.files ?? []);
    const room = Math.max(MAX_BATCH - selected.value.length, 0);

    files.slice(0, room).forEach((file) => {
        selected.value.push({ file, preview: URL.createObjectURL(file) });
    });

    syncFiles();
    form.clearErrors();
    target.value = '';
}

function removeSelected(index: number): void {
    const [removed] = selected.value.splice(index, 1);

    if (removed) {
        URL.revokeObjectURL(removed.preview);
    }

    syncFiles();
}

function clearSelected(): void {
    selected.value.forEach((item) => URL.revokeObjectURL(item.preview));
    selected.value = [];
    form.imagenes = [];
    form.clearErrors();
}

function submit(): void {
    form.post('/admin/portada', {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => clearSelected(),
    });
}

function destroy(image: HeroImageRecord): void {
    const confirmed = window.confirm(
        '¿Eliminar esta foto de la portada? Esta acción no se puede deshacer.',
    );

    if (!confirmed) {
        return;
    }

    router.delete(`/admin/portada/${image.id}`, {
        preserveScroll: true,
    });
}

onBeforeUnmount(clearSelected);
</script>

<template>
    <Head title="Portada" />

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
                Portada
            </h1>
            <p class="mt-1.5 max-w-2xl text-sm text-luda-ink/55">
                Estas fotos son el fondo de la tarjeta principal del inicio.
                Rotan automáticamente cada 6 segundos y llevan un velo rosa
                encima para que el texto se siga leyendo. Si no subes ninguna,
                se muestra el degradado actual.
            </p>
        </header>

        <section
            class="rounded-2xl border border-luda-plum/5 bg-white p-5 shadow-[0_18px_45px_-36px_rgba(51,0,31,0.5)]"
        >
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <span
                        class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-luda-mist text-luda-rose"
                    >
                        <Images class="size-5" />
                    </span>
                    <div>
                        <p class="text-sm font-semibold text-luda-plum">
                            Fotos de la portada
                        </p>
                        <p class="text-xs text-luda-ink/55">
                            {{ images.length }}
                            {{
                                images.length === 1
                                    ? 'foto publicada'
                                    : 'fotos publicadas'
                            }}
                        </p>
                    </div>
                </div>

                <button
                    type="button"
                    class="inline-flex items-center gap-2 rounded-full border border-luda-plum/10 px-4 py-2 text-xs font-semibold text-luda-plum transition hover:border-luda-rose/40 hover:bg-luda-mist"
                    @click="chooseFiles"
                >
                    <ImagePlus class="size-3.5" />
                    Elegir fotos
                </button>
            </div>

            <input
                ref="input"
                type="file"
                accept="image/jpeg,image/png,image/webp"
                multiple
                class="sr-only"
                @change="onFilesChange"
            />

            <div
                v-if="selected.length > 0"
                class="mt-5 rounded-xl border border-luda-rose/20 bg-luda-mist/60 p-4"
            >
                <p class="text-xs font-semibold text-luda-plum">
                    Fotos por subir ({{ selected.length }})
                </p>

                <div class="mt-3 grid grid-cols-2 gap-3 sm:grid-cols-4">
                    <div
                        v-for="(item, index) in selected"
                        :key="item.preview"
                        class="group relative aspect-[4/3] overflow-hidden rounded-lg border border-luda-plum/10 bg-white"
                    >
                        <img
                            :src="item.preview"
                            alt=""
                            class="size-full object-cover"
                        />
                        <button
                            type="button"
                            class="absolute top-1.5 right-1.5 flex size-6 items-center justify-center rounded-full bg-luda-plum/85 text-white transition hover:bg-rose-600"
                            aria-label="Quitar de la lista"
                            @click="removeSelected(index)"
                        >
                            <X class="size-3.5" />
                        </button>
                    </div>
                </div>

                <div class="mt-4 flex flex-wrap items-center gap-2">
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-full bg-luda-plum px-4 py-2 text-xs font-semibold text-white transition hover:bg-luda-rose disabled:opacity-60"
                        :disabled="form.processing"
                        @click="submit"
                    >
                        <LoaderCircle
                            v-if="form.processing"
                            class="size-3.5 animate-spin"
                        />
                        <Upload v-else class="size-3.5" />
                        {{
                            form.processing
                                ? 'Subiendo…'
                                : 'Guardar fotos'
                        }}
                    </button>
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-full border border-luda-plum/10 px-4 py-2 text-xs font-semibold text-luda-ink/60 transition hover:bg-white hover:text-luda-plum disabled:opacity-60"
                        :disabled="form.processing"
                        @click="clearSelected"
                    >
                        <X class="size-3.5" />
                        Cancelar
                    </button>
                </div>
            </div>

            <InputError :message="form.errors.imagenes" class="mt-3" />

            <div
                v-if="images.length === 0 && selected.length === 0"
                class="mt-5 flex flex-col items-center justify-center gap-3 rounded-xl border border-dashed border-luda-plum/15 bg-luda-mist/60 px-6 py-10 text-center"
            >
                <span
                    class="flex size-12 items-center justify-center rounded-2xl bg-white text-luda-rose shadow-sm"
                >
                    <ImagePlus class="size-6" />
                </span>
                <p class="text-sm font-semibold text-luda-plum">
                    Aún no hay fotos de portada
                </p>
                <p class="max-w-md text-xs leading-relaxed text-luda-ink/55">
                    Mientras no subas fotos, el inicio muestra la tarjeta rosa
                    con el diente, las especialidades y el trato cálido.
                </p>
            </div>

            <div
                v-else-if="images.length > 0"
                class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4"
            >
                <div
                    v-for="(image, index) in images"
                    :key="image.id"
                    class="group relative aspect-[4/3] overflow-hidden rounded-xl border border-luda-plum/10 bg-luda-mist"
                >
                    <img
                        :src="image.url"
                        alt=""
                        class="size-full object-cover"
                        loading="lazy"
                    />
                    <span
                        class="absolute top-2 left-2 rounded-full bg-luda-plum/85 px-2 py-0.5 text-[10px] font-semibold text-white backdrop-blur"
                    >
                        {{ index + 1 }}
                    </span>
                    <button
                        type="button"
                        class="absolute top-2 right-2 flex size-8 items-center justify-center rounded-full bg-luda-plum/85 text-white transition hover:bg-rose-600"
                        title="Eliminar foto"
                        aria-label="Eliminar foto"
                        @click="destroy(image)"
                    >
                        <Trash2 class="size-4" />
                    </button>
                </div>
            </div>
        </section>
    </div>
</template>
