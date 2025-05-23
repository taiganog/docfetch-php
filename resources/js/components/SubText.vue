<script setup lang="ts">
interface Props {
    color?: string
}

defineProps<Props>();
</script>

<template>
    <div class="my-2 space-y-0.5">
        <span v-if="color" :class="'text-sm ' +  color">
            <slot />
        </span>

        <span v-else class="text-sm text-gray-600">
            <slot />
        </span>
    </div>
</template>
