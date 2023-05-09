<script setup>
import { ref, computed, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import PCard from '@/Components/General/PCard.vue';
import PImage from '../General/PImage.vue';
import axios from 'axios';

const lombas = ref([])


const listLomba = async () => {
    await axios.post('/lomba')
        .then(res => {
            lombas.value = res.data.lombas[0]
        }).catch(err => console.log(err))
}

const jml = computed(() => {
    if(lombas.value.bidangs) {
        let jml = lombas.value.bidangs.reduce(
            (ac, cv) => (ac + cv.pesertas.length),
            0
        )

        return jml
    }
    // return lombas.value
})

onMounted(() => {
    listLomba()
})
</script>

<template>
<div class="grid grid-cols-2 md:grid-cols-3 gap-2 z-0 md:px-10">
    <div class="w-full h-52 flex items-center justify-center col-span-2 md:col-span-3">
        <span class="text-center relative">
            <h3 class="font-bold text-2xl">
                <small>KKG PAI Kec. Wagir</small>
                <br />
                {{ lombas.label }}
            </h3>
            Jumlah Peserta:
            <h2 class="text-8xl font-extrabold text-white">{{jml}}<small class="absolute bottom-3 text-lg font-ultrabold text-sky-600 -translate-x-6">Orang</small></h2>
        </span>
    </div>
    <p-card v-for="(bidang,l) in lombas.bidangs" :key="l">
        <template #title>{{bidang.label}}</template>
        <template #body>
            {{ bidang.pesertas.length }}
        </template>
    </p-card>
    <div class="w-full flex justify-center col-span-2 md:col-span-3 md:mt-6">
        <Link as="button" class="bg-sky-600 text-white py-2 px-4 rounded shadow hover:shadow-lg hover:bg-sky-800" :href="route('peserta')">Lihat Peserta</Link>
    </div>
</div>
</template>