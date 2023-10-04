<script setup>
import { onMounted, ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import Dash from '@/Layout/Dash.vue';

const positions = ref({
    clientX: undefined,
    clientY: undefined,
    movementX: 0,
    movementY: 0
})

const dragMouseDown = (e) => {
    e.preventDefault()
    const wrapper = document.querySelector(".wrapper")
    positions.value.clientX = e.clientX
    positions.value.clientY = e.clientY
    
    document.onmousemove = dragElement
    document.onmouseup = endDrag
}

const dragElement = (event) => {
    event.preventDefault()

    const draggable = document.querySelector(".draggable")
    const handler = document.querySelector(".handler")
    const wrapper = document.querySelector(".wrapper")

    positions.value.movementX = positions.value.clientX
    positions.value.movementY = positions.value.clientY
    positions.value.clientX = event.clientX
    positions.value.clientY = event.clientY

    const gaya = window.getComputedStyle(draggable)
    if(event.clientY <= wrapper.offsetTop || event.clientY >= wrapper.offsetBottom || event.clientX <= wrapper.offsetLeft || event.clientX >=wrapper.offsetRight) {

    // if(event.clientX >= window.innerWidth) {
        // alert('hi')
        draggable.style.top = draggable.style.top
        draggable.style.left = draggable.style.left
    } else {
        // handler.style.cursor = 'move'
        draggable.style.top = (positions.value.movementY - 30) +'px'
        draggable.style.left = (positions.value.movementX - (parseInt(gaya.width)+30)) +'px'
    }

    
}

const endDrag = () => {
    document.onmouseup = null
    document.onmousemove = null
}





</script>
<template>
<Head title="Pengaturan" />
<Dash title="Pengaturan ">
    <div class="wrapper w-full min-h-screen relative">
        <h1>Pengaturan</h1> 
        <div class="draggable absolute w-80 h-80 bg-white rounded-xl shadow-lg">
            <div class="handler w-full h-12 flex items-center justify-between bg-slate-600 text-white rounded-t-xl p-3 cursor-move" @mousedown="dragMouseDown">
                <h1>Drag Me</h1>
            </div>
            <div class="content p-3">
                <h1>Judul</h1>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Asperiores omnis rerum earum odit voluptas? Magni, placeat! Architecto quas tenetur at error. Ullam ipsam quo nostrum aliquam. Maxime odio suscipit debitis!</p>
            </div>
        </div>
    </div>
</Dash>
</template>