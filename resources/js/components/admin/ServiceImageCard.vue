<script setup lang="ts">
import { computed, onBeforeUnmount, ref } from 'vue';
import type { Component } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import { ImagePlus, LoaderCircle, Trash2, Upload, X } from '@lucide/vue';
import InputError from '@/components/InputError.vue';

const props = defineProps<{
    servicio: string;
    descripcion: string;
    icon: Component;
    imagen: string | null;
}>();

const input = ref<HTMLInputElement | null>(null);
const preview = ref<string | null>(null);

const form = useForm({
    servicio: props.servicio,
    imagen: null as File | null,
});

const currentImage = computed(() => preview.value ?? props.imagen);

function releasePreview(): void {
    if (preview.value) {
        URL.revokeObjectURL(preview.value);
        preview.value = null;
    }
}

function chooseFile(): void {
    input.value?.click();
}

function onFileChange(event: Event): void {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0] ?? null;

    releasePreview();
    form.clearErrors();
    form.imagen = file;
    preview.value = file ? URL.createObjectURL(file) : null;
}

function cancel(): void {
    releasePreview();
    form.imagen = null;
    form.clearErrors();

    if (input.value) {
        input.value.value = '';
    }
}

function submit(): void {
    form.post('/admin/servicios', {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => cancel(),
    });
}

function remove(): void {
    const confirmed = window.confirm(
        `¿Quitar la imagen de "${props.servicio}"? Se mostrará el ícono predeterminado.`,
    );

    if (!confirmed) {
        return;
    }

    router.delete('/admin/servicios', {
        data: { servicio: props.servicio },
        preserveScroll: true,
    });
}

onBeforeUnmount(releasePreview);
</script>

<template>
    <article
        class="relative flex flex-col rounded-2xl border border-luda-plum/5 bg-white p-5 shadow-[0_18px_45px_-36px_rgba(51,0,31,0.5)]"
    >
        <div class="flex items-start gap-4">
            <span
                class="flex size-16 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-luda-mist text-luda-rose ring-1 ring-luda-plum/5"
            >
                <img
                    v-if="currentImage"
                    :src="currentImage"
                    :alt="servicio"
                    class="size-full object-cover"
                />
                <component :is="icon" v-else class="size-7" />
            </span>

            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-luda-plum">
                    {{ servicio }}
                </p>
                <p class="mt-1 text-xs leading-relaxed text-luda-ink/55">
                    {{ descripcion }}
                </p>
            </div>
        </div>

        <input
            ref="input"
            type="file"
            accept="image/jpeg,image/png,image/webp"
            class="sr-only"
            @change="onFileChange"
        />

        <div class="mt-4 flex flex-wrap items-center gap-2">
            <template v-if="form.imagen">
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
                    Guardar imagen
                </button>
                <button
                    type="button"
                    class="inline-flex items-center gap-2 rounded-full border border-luda-plum/10 px-4 py-2 text-xs font-semibold text-luda-ink/60 transition hover:bg-luda-mist hover:text-luda-plum disabled:opacity-60"
                    :disabled="form.processing"
                    @click="cancel"
                >
                    <X class="size-3.5" />
                    Cancelar
                </button>
            </template>

            <template v-else>
                <button
                    type="button"
                    class="inline-flex items-center gap-2 rounded-full border border-luda-plum/10 px-4 py-2 text-xs font-semibold text-luda-plum transition hover:border-luda-rose/40 hover:bg-luda-mist disabled:opacity-60"
                    :disabled="form.processing"
                    @click="chooseFile"
                >
                    <ImagePlus class="size-3.5" />
                    {{ imagen ? 'Cambiar imagen' : 'Subir imagen' }}
                </button>
                <button
                    v-if="imagen"
                    type="button"
                    class="inline-flex items-center gap-2 rounded-full border border-luda-plum/10 px-4 py-2 text-xs font-semibold text-luda-ink/55 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600"
                    @click="remove"
                >
                    <Trash2 class="size-3.5" />
                    Quitar
                </button>
            </template>
        </div>

        <InputError :message="form.errors.imagen" class="mt-2" />
        <InputError :message="form.errors.servicio" class="mt-2" />
    </article>
</template>
