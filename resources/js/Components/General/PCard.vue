<script setup>
const props = defineProps({
    title: String,
    text: String,
    image: String,
    overlay: Boolean
})
</script>

<template>
    <div class="card w-full md:w-auto h-auto shadow bg-white p-5 rounded-lg bg-no-repeat bg-cover bg-center relative overflow-hidden" :style="`background-image: url('${image ? image : ''}')`" >
        <div class="overlay absolute z-0 top-0 right-0 bottom-0 left-0 bg-white" v-if="overlay" style="opacity: .7;">
        
        </div>
        <div class="content relative z-0">
            <h1 class="font-bold text-xl"><slot name="title"></slot></h1>
            <slot name="body"></slot>
        </div>
    </div>
</template>