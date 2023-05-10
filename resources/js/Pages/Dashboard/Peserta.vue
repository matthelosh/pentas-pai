<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import Dash from '@/Layout/Dash.vue';
import { ref, computed, onMounted, watch } from 'vue';
import * as _ from 'lodash-es';
import axios from 'axios';
const $page = usePage()
const currentPage = ref(1)
const search = ref(null)
// const pesertas = computed(() => {
//     if (search.value == null) {
//         return $page.props.pesertas
//     } else {
//         let pattern = new RegExp(search.value, "i")
//         let items = $page.props.pesertas.filter((peserta) => {
//             return peserta.nama.includes(search.value)
//         })
//         return items
//     }
// })
const pesertas = ref($page.props.pesertas)

// watch(search, (value, oldValue) => {
//     let tes = $page.props.pesertas.filter((peserta) => {
//         if( peserta.nama.toLowerCase().includes(value.toLowerCase())) {
//             return peserta
//         }
//     })
//     pesertas.value = tes
//     // console.log(tes)
// })
const filter = () => {
    // console.log(pesertas.value)
    pesertas.value = $page.props.pesertas.filter((peserta) => {
        return peserta.nama.toLowerCase().includes(search.value.toLowerCase())
    })
    // console.log(pesertas.value)
}
const datas = computed(() => {
    let length = pesertas.value.length
    // let chunks = length > 10 ? Math.ceil(length / (length / 10)) : 1
    let pages =  _.chunk(pesertas.value, 10)

    return {current: pages[currentPage.value-1], pageCount: pages.length}
})
const fixData = async () => {
    await axios.post(route('dashboard.peserta.attach'), {pesertas: JSON.stringify($page.props.pesertas)})
            .then(res => {
                window.location.reload()
            })
}

</script> 

<template>
<Head title="Data Peserta" />
<Dash>
<div class="w-full bg-white">
    <div class="toolbar w-full h-12 bg-gray-50 rounded shadow flex items-center px-3 justify-between">
        <h1>Data Peserta</h1>
        <div class="toolbar-items flex items-center gap-2">
            <input type="text" placeholder="Cari" class="h-8 rounded" v-model="search" @keyup.enter="filter" />
            <button class="bg-sky-400 hover:bg-sky-600 text-white px-2 py-1 rounded shadow uppercase flex items-center active:bg-sky-800" @click="fixData">perbaikan</button>
        </div>
    </div>
    <div class="content w-full bg-white p-3 mt-2">
        <table class="table w-full border-collapse">
            <thead>
                <tr>
                    <th class="border text-center">No</th>
                    <th class="border text-center">NISN</th>
                    <th class="border text-center">Nama</th>
                    <th class="border text-center">JK</th>
                    <th class="border text-center">Sekolah</th>
                    <th class="border text-center">Lomba</th>
                </tr>
            </thead>
            <tbody>
                <tr class="odd:bg-gray-50" v-for="(data,d) in datas.current" :key="d">
                    <td class="border p-2">{{ d+1 }}</td>
                    <td class="border p-2">{{ data.nisn }}</td>
                    <td class="border p-2">{{ data.nama }}</td>
                    <td class="border p-2">{{ data.jk }}</td>
                    <td class="border p-2">{{ data.sekolah.nama }}</td>
                    <td class="border p-2">
                        <ul>
                            <li v-for="(bidang,b) in data.bidangs" :key="b"> {{ bidang.label }}</li>
                        </ul>
                        <!-- | {{ data.lomba_id }} -->
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="w-full bg-gray-200 flex items-center justify-between pl-3">
            Jml Halaman: {{ datas.pageCount }}
            <div class="flex items-center h-full ">
                <button @click="currentPage-=1" class="flex justify-center w-8 border border-gray-500">&lt;</button>
                <button v-for="b in datas.pageCount" :key="b" class="flex justify-center w-8 border border-gray-500" :class="b == currentPage ? 'bg-sky-600 text-white': ''" @click="currentPage=b">{{ b }}</button>
                <button @click="currentPage+=1" class="flex justify-center w-8 border border-gray-500">&gt;</button>
            </div>
        </div>
    </div>
    <!-- <div class="w-full bg-gray-200">
        {{ pesertas }}
    </div> -->
</div>
</Dash>
</template>