<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
// import { Inertia } from '@inertiajs/vue3';
import Front from '@/Layout/Front.vue';
import _ from 'lodash';
import Pagination from '@/Components/General/Pagination.vue';

const page = usePage()

const parseImg = (url) => {
    let splited = url.split('=')
    if (splited.length > 0) {
        return `https://drive.google.com/uc?export=view&id=${splited[splited.length-1]}`
    } else {
        return url
    }
}

const search = ref('')

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
    <div class="bg-white w-full p-2 md:p-5 rounded shadow overflow-x-scroll">
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
                        <img :src="parseImg(peserta.foto)" alt="Foto" class="rounded-full aspect-square w-10 shadow object-cover mr-1">
                        <!-- {{ peserta.foto }} -->
                        {{peserta.nama}}
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
</Front>
</template>