<script setup lang="ts">
import type { LucideIcon } from '@lucide/vue';

withDefaults(
    defineProps<{
        label: string;
        value: number;
        hint: string;
        icon: LucideIcon;
        tone?: 'plum' | 'rose' | 'blush';
    }>(),
    {
        tone: 'rose',
    },
);

const toneClasses: Record<'plum' | 'rose' | 'blush', string> = {
    plum: 'bg-luda-plum text-white',
    rose: 'bg-luda-rose text-white',
    blush: 'bg-luda-blush/25 text-luda-rose',
};
</script>

<template>
    <div
        class="relative overflow-hidden rounded-2xl border border-luda-plum/5 bg-white p-5 shadow-[0_18px_45px_-36px_rgba(51,0,31,0.5)]"
    >
        <div
            class="absolute -top-10 -right-8 size-24 rounded-full bg-luda-mist"
            aria-hidden="true"
        ></div>
        <div class="relative flex items-start justify-between gap-4">
            <div>
                <p
                    class="text-[11px] font-semibold tracking-[0.16em] text-luda-ink/45 uppercase"
                >
                    {{ label }}
                </p>
                <p class="mt-3 text-3xl font-semibold text-luda-plum">
                    {{ value }}
                </p>
                <p class="mt-1 text-xs text-luda-ink/50">{{ hint }}</p>
            </div>
            <span
                :class="[
                    'flex size-11 shrink-0 items-center justify-center rounded-xl shadow-sm',
                    toneClasses[tone],
                ]"
            >
                <component :is="icon" class="size-5" />
            </span>
        </div>
    </div>
</template>
