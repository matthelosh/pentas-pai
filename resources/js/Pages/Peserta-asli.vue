<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
// import { Inertia } from '@inertiajs/vue3';
import Front from '@/Layout/Front.vue';
import _ from 'lodash';
import Pagination from '@/Components/General/Pagination.vue';

const page = usePage()
const mode = ref('list')
const parseImg = (url) => {
    let splited = url.split('=')
    if (splited.length > 0) {
        return `https://drive.google.com/uc?export=view&id=${splited[splited.length-1]}`
    } else {
        return url
    }
}

const search = ref('')

const selectedPeserta = ref({})

const detail = (siswa) => {
    selectedPeserta.value = siswa
    mode.value = 'detail'
    console.log(selectedPeserta.value)
}

watch(search, (value) => {
    axios.get("/peserta?filter="+value, {
        preserveState: true,
        replace: true
    })
})

// const lomba = (lomba_id) => {}

// const pesertas = computed(() => {
//     return _.orderBy(page.props.pesertas.data, 'lomba_id')
// })
</script>
<template>
<Head title="Data Peserta" />
<Front>
<TransitionGroup type="slide">
    <div class="bg-white w-full p-2 md:p-5 rounded shadow overflow-x-scroll" key="list" v-if="mode == 'list'">
        <div class="flex justify-end">
            <form action="/peserta" method="get">
                <input type="text" placeholder="Cari" class="rounded shadow print:hidden;" name="filter" v-model="search
            " >
            </form>
        </div>
        <table class="table-auto w-full border-collapse">
            <caption class="mb-5">
                <h2 class=" font-extrabold text-lg">Data Peserta Lomba Pentas PAIS</h2>
                <h1 class="text-2xl font-extrabold">{{ new Date().getFullYear() }}</h1>
            </caption>
            <thead class=" bg-sky-200">
                <tr>
                    <th class="border px-2 py-2">No</th>
                    <th class="border px-2 py-2">NISN</th>
                    <th class="border px-2 py-2">Nama</th>
                    <th class="border px-2 py-2">JK</th>
                    <th class="border px-2 py-2">Sekolah</th>
                    <th class="border px-2 py-2">Bidang Lomba</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(peserta,p) in page.props.pesertas.data" :key="p">
                    <td class="border px-2 py-2 text-center">{{ p+1 }}</td>
                    <td class="border px-2 py-2">{{peserta.nisn}}</td>
                    <td class="border px-2 py-2 flex items-center">
                        <img :src="parseImg(peserta.foto)" alt="Foto" class="rounded-full aspect-square w-10 shadow object-cover mr-1 cursor-pointer" @click="detail(peserta)" />
                        <!-- {{ peserta.foto }} -->
                        <span @click="detail(peserta)" class="cursor-pointer">{{peserta.nama}}</span>
                    </td>
                    <td class="border px-2 py-2">{{ peserta.jk }}</td>
                    <td class="border px-2 py-2">{{peserta.sekolah.nama}}</td>
                    <td class="border px-2 py-2">{{peserta.lomba_id}}</td>
                </tr>
                <!-- <p>{{ page.props.pesertas }}</p> -->
            </tbody>
        </table>
        <Pagination class="mt-6" :links="page.props.pesertas.links" />
    </div>
    <div v-if="mode == 'detail'" key="detail" class="w-full">
        <div class="w-full flex justify-end my-5 px-10">
            <button class="py-2 px-3 bg-white rounded shadow" @click="mode = 'list'">Tutup</button>
        </div>
        <div class="md:mx-10 bg-white shadow rounded-lg p-8 flex  flex-wrap gap-5">
            <img :src="parseImg(selectedPeserta.foto)" alt="Foto" class="rounded flex-grow md:flex-grow-0 border border-gray-300 w-64 shadow object-cover mr-1" />
            <div class="bg-[#fefefe] shadow flex-grow p-5 md:p-10">
                <h1>NAMA: {{ selectedPeserta.nama }}</h1>
                <h1>NISN: {{ selectedPeserta.nisn }}</h1>
                <h1>ASAL SEKOLAH: {{ selectedPeserta.sekolah.nama }}</h1>
                <h1>LOMBA: {{ selectedPeserta.lomba_id }}</h1>
            </div>
        </div>
        
    </div>
    </TransitionGroup>
</Front>
</template>