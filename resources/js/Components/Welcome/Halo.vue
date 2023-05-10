<script setup>
import { ref, computed, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import PCard from '@/Components/General/PCard.vue';
import PImage from '../General/PImage.vue';
import axios from 'axios';
import { DoughnutChart, PieChart } from 'vue-chart-3';
import { Chart, registerables } from "chart.js";
Chart.register(...registerables);

const lombas = ref([])

const chartByBidang = ref({
    labels: [],
      datasets: [
        {
          data: [],
          backgroundColor: ['#545863', '#2AA0B0', '#00E8FC', '#7DABA1', '#F96E46', '#F99B46', '#F9C846', '#FCD695', '#FFE3E3'],
        },
      ],
})

const listLomba = async () => {
    await axios.post('/lomba')
        .then(res => {
            let lomba = res.data.lombas[0]
            lombas.value = lomba
            let labels = []
            let datas = []

            lomba.bidangs.forEach((bidang,b) => {
                labels.push(bidang.label)
                datas.push(bidang.pesertas.length)
            })
            chartByBidang.value.labels = labels
            chartByBidang.value.datasets[0].data = datas
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
<div class="w-full md:w-2/4 mx-auto bg-white shadow p-5 rounded">
    <h1 class="text-center text-2xl">{{lombas.label}}</h1>
    <h1 class="text-center text-lg">Grafik Peserta Berdasarkan Bidang Lomba</h1>
    <PieChart :chartData="chartByBidang" />
</div>
<div class="grid grid-cols-2 md:grid-cols-3 gap-2 z-0 md:px-5">
    <div class="w-full h-52 flex items-center justify-center col-span-2 md:col-span-3">
        <Link as="span" class="text-center relative cursor-pointer" :href="route('peserta')">
            Jumlah Peserta:
            <h2 class="text-8xl font-extrabold text-white">{{jml}}<small class="absolute bottom-3 text-lg font-ultrabold text-sky-600 -translate-x-6">Orang</small></h2>
            
        </Link>
    </div>
</div>
</template>