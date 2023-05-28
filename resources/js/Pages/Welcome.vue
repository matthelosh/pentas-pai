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
            <img src="img/foto-gpai.jpg" alt="Foto GPAI" class="shadow-lg object-cover mx-auto">
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