<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    label: String,
    color: String,
})

const classStyle = computed(() => {
    let style = 'px-2 py-1  flex items-center rounded'
    if (props.color != null) {
        style += ` bg-${props.color}-200`
    } else {
        style += 'bg-gray-200'
    }
    return style
}) 
</script>

<template>
<button :class="classStyle">
    <slot />
</button>
</template>