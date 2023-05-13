<script setup>
import { ref, computed, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';
import { DoughnutChart, PieChart, LineChart, BarChart, PolarAreaChart } from 'vue-chart-3';
import { Chart, registerables } from "chart.js";
import ChartDataLabels from 'chartjs-plugin-datalabels'
Chart.register(...registerables);

import * as _ from 'lodash-es'
import { ArrowLeftIcon, ArrowRightIcon } from '@heroicons/vue/20/solid';
import Report from './Report.vue';

const lombas = ref([])
const sekolahs = ref([])

const chartByBidang = ref({
    labels: [],
      datasets: [
        {
          data: [],
          backgroundColor: ['#545863', '#2AA0B0', '#00E8FC', '#7DABA1', '#F96E46', '#F99B46', '#F9C846', '#FCD695', '#FFE3E3'],
        },
      ],
})

const chartByBidangOptions = ref({
    plugins: {
        datalabels: {
            color: '#ffffff'
        },
        legend: {
            position: 'bottom',
        },
        title: {
            display: true,
            text: 'Grafik Peserta Berdasarkan Bidang Lomba'
        }
    }
})


const listSekolah = async () => {
    await axios.post(route('sekolah.index'))
                .then(res => {
                    sekolahs.value = res.data.sekolahs
                }).catch( err => console.log(err))
} 

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

const sekolahPage = ref(1)
const dataSekolahs = computed(() => {
    let pages = _.chunk(sekolahs.value, 5)
    return {current: pages[sekolahPage.value-1], pageCount: pages.length}
})

const reportSekolah = computed(() => {
    return _.groupBy(sekolahs.value, 'npsn')
})

const byBidangs = (datas) => {
    return _.groupBy(datas, 'lomba_id')
}

const report = ref(null)

const lihat = (sekolah) => {
    report.value.open(`Peserta ${sekolah.nama}`, sekolah)
}

onMounted(() => {
    listLomba()
    listSekolah()
})
</script>

<template>
<Report ref="report" />
<div class="w-full md:w-3/4 mx-auto relative">
    <h1 class="text-center text-2xl md:text-4xl my-4 font-extrabold">{{lombas.label}}</h1>
    <div class="w-full grid grid-cols-1 gap-3">
        <PolarAreaChart :chartData="chartByBidang" :plugins="[ChartDataLabels]" :options="chartByBidangOptions" class="bg-white" />
        <div class="w-full md:w-2/4 md:mx-auto">
            <h3 class="text-center text-gray-800">Klik Sekolah Anda untuk melihat Data Peserta</h3>
            <div class="h-12 text-white flex items-center justify-between px-2 my-1 border cursor-pointer"  
                v-for="(sekolah, s) in dataSekolahs.current" 
                :key="s" 
                :style="`width: 100%;
                background-image: linear-gradient(to right, #307845 ${ Math.ceil(((sekolah.pesertas ? sekolah.pesertas.length : 0)/17)*100) }%, transparent ${100 - Math.ceil(((sekolah.pesertas ? sekolah.pesertas.length : 0)/17)*100)}%);
                background-repeat: no-repeat
                background-size: ${ Math.ceil(((sekolah.pesertas ? sekolah.pesertas.length : 0)/17)*100) }% 100%;`"
                @click="lihat(sekolah)"
            >
                <span>
                    {{ sekolah.nama }}: {{ sekolah.pesertas.length }} Orang    
                    ({{Math.ceil(((sekolah.pesertas ? sekolah.pesertas.length : 0)/17)*100) }}%)
                </span>
                <ArrowRightIcon class="h-8 text-white" />
            </div>
            <div class="flex justify-between">
                <button class="bg-white px-5 py-1" @click="sekolahPage = sekolahPage > 1 ? (sekolahPage - 1) : 1">
                    <ArrowLeftIcon class="h-8 text-gray-400 hover:text-gray-200 active:text-gray-600"  />
                </button>
                <button class="bg-white px-5 py-1" @click="sekolahPage = sekolahPage < dataSekolahs.pageCount ? (sekolahPage + 1) : dataSekolahs.pageCount">
                    <ArrowRightIcon class="h-8 text-gray-400 hover:text-gray-200 active:text-gray-600" />
                </button>
            </div>
        </div>
    </div>
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