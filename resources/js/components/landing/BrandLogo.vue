<script setup lang="ts">
import { ref, watch } from 'vue';
import BrandWordmark from './BrandWordmark.vue';

const props = withDefaults(
    defineProps<{
        src?: string;
        alt?: string;
        tone?: 'dark' | 'light';
        imgClass?: string;
    }>(),
    {
        src: '',
        alt: 'Diseñando Sonrisas',
        tone: 'dark',
        imgClass: 'h-10 w-auto max-w-[220px] object-contain',
    },
);

const failed = ref(false);

watch(
    () => props.src,
    () => {
        failed.value = false;
    },
);
</script>

<template>
    <img
        v-if="src && !failed"
        :src="src"
        :alt="alt"
        :class="imgClass"
        @error="failed = true"
    />
    <BrandWordmark v-else :tone="tone" />
</template>
