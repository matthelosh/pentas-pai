<script setup>
import { ref, computed } from 'vue';
const props = defineProps({
    src: String,
    ratio: String,
})

const rasio = computed(() => {
    return props.ratio == '1:1' ? 'square' : ''
})

</script>

<template>
    <div class="w-full h-full relative bg-no-repeat bg-cover bg-center" :style="`background-image: url('${src}')`" style="position: relative;" :class="rasio">
        <div class="img--content absolute top-0 right-0 bottom-0 left-0 p-3">
            <slot name="content"></slot>
        </div>
    </div>
</template>

<style scoped>
.square {
    padding-top: 100%;
}
</style>
