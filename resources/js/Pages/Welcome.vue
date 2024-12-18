<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Halo from '@/Components/Welcome/Halo.vue';
import Front from '@/Layout/Front.vue';
const tes = (e) => {
    let navList = document.querySelector('ul#nav-list')
    navList.classList.toggle('hidden')
}
</script>

<template>
<Head title="Marhaban" />
<Front>
    <Halo />
    <div class="w-full p-4 md:p-10">
        <div class="w-auto bg-white p-2 md:p-8 shadow relative rounded-lg">
            <a href="https://lh3.googleusercontent.com/pw/AP1GczOC6anPjeWNzjsTigrlowc7-Yij3cCFsIVC8Om-fJ2VlphYRd-N3Kkk4DR2AdnkZrS7n4sGXV24HXouhmwZbAUAAX6D2vqgkhD0c564npQKxqXAOQI=w2400?source=screenshot.guru"> <img src="https://lh3.googleusercontent.com/pw/AP1GczOC6anPjeWNzjsTigrlowc7-Yij3cCFsIVC8Om-fJ2VlphYRd-N3Kkk4DR2AdnkZrS7n4sGXV24HXouhmwZbAUAAX6D2vqgkhD0c564npQKxqXAOQI=w600-h315-p-k" /> </a>
        </div>
    </div>
</Front>

</template>

<style scoped>
ul.nav-list {
    transform: translateY('-100%');
    transition: all .35s ease-in;
}
</style>