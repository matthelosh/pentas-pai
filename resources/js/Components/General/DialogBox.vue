<script setup>
import { ref } from 'vue';

const show = ref(false)
let items = ref([])
const open = (text, datas) => {
    items.value = datas
}

defineExpose({
    open
})
</script>

<template>
    <div class="overlay fixed top-0 right-0 bottom-0 left-0 z-50 bg-black bg-opacity-50 flex items-center justify-center" @click="$emit('close')" v-if="show">
        <div class="dialog min-w-[400px] min-h-[400px]  rounded shadow bg-white">
            <h1>Dialog</h1>
        </div>
    </div>
</template>