<script setup lang="ts">
import Heading from './Heading.vue';

interface Props {
    titulo?: string
}

defineProps<Props>();
</script>

<template>
    <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 overflow-y-auto dark:border-sidebar-border p-5">
        <Heading v-if="titulo" :title="titulo"/>
        <slot />
    </div>
</template>