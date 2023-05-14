<script setup>
import { ref, onMounted, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import Dash from '@/Layout/Dash.vue';
import { DoughnutChart, PieChart } from 'vue-chart-3';
import { Chart, registerables } from "chart.js";
import Editor from '@/Components/General/Editor.vue'

const lombas = ref([])



Chart.register(...registerables);

const chartPeserta = ref({labels: [], datas: []})

const text = ref('Isi')

const testData = ref({
      labels: [],
      datasets: [
        {
          data: [],
          backgroundColor: ['#545863', '#2AA0B0', '#00E8FC', '#7DABA1', '#F96E46', '#F99B46', '#F9C846', '#FCD695', '#FFE3E3'],
        },
      ],
    });

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
            testData.value.labels = labels
            testData.value.datasets[0].data = datas
            // console.log(labels,datas)
        }).catch(err => console.log(err))
}

const editorState = ref('Kenapa')

const tes = () => {
    alert('halo ')
}

onMounted(() => {
    listLomba()
})
</script>

<template>
<Head title="Dashboard" />
<Dash>
    <div class="w-full bg-white shadow p-5 print:p-0 rounded">
        <h1 class="text-center text-2xl">{{lombas.label}}</h1>
        <h1 class="text-center text-lg">Grafik Peserta Berdasarkan Bidang Lomba</h1>
        <PieChart :chartData="testData" />
    </div>
    <div class="w-full p-5 bg-white mt-5">
        <!-- <Editor class="bg-gray-200" v-model="text" /> -->
        <!-- {{ $page.props.auth }} -->
    </div>
</Dash>
</template>