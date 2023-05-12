<script setup>
import { ref, watch } from 'vue';

const show = ref(false)
const items = ref([])
const message = ref('')
const resolved = ref(null)
const rejected = ref(null)
const open = async (text, datas) => {
    show.value = true
    message.value = text
    return new Promise((resolve, reject) => {
        resolved.value = resolve
        rejected.value = reject
    })
}

const okey = () => {
    resolved.value(true)
}
const nope = () => {
    resolved.value(false)
}

defineExpose({
    open
})
</script>

<template>
    <div class="overlay fixed top-0 right-0 bottom-0 left-0 z-50 bg-black bg-opacity-50 flex items-center justify-center" @click.self="show=false" v-if="show" >
        <div class="dialog min-w-[400px] min-h-[400px]  rounded shadow bg-white">
            <h1>Dialog {{ message }}</h1>
            <button @click="okey">OKE</button>
            <button @click="nope">Nope</button>
        </div>
    </div>
</template>