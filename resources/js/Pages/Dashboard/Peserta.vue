<script setup>
import { Head, usePage, router } from '@inertiajs/vue3';
import Dash from '@/Layout/Dash.vue';
import { ref, computed, onMounted, watch } from 'vue';
import * as _ from 'lodash-es';
import axios from 'axios';
import {read, utils} from 'xlsx'
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiDelete, mdiFileExcel } from '@mdi/js';

import DialogBox from '@/Components/General/DialogBox.vue';
import ImportTable from '@/Components/Peserta/ImportTable.vue';
import { ArrowPathIcon } from '@heroicons/vue/20/solid';

import {imgUrl, paginate} from '@/Plugins/misc';
import FormPeserta from '@/Components/Peserta/FormPeserta.vue';


const $page = usePage()
const currentPage = ref(1)
const search = ref(null)
const pesertas = ref($page.props.pesertas)
const loading = ref(false)

const filter = () => {
    pesertas.value = $page.props.pesertas.filter((peserta) => {
        return peserta.nama.toLowerCase().includes(search.value.toLowerCase()) || peserta.nisn.toLowerCase().includes(search.value.toLowerCase()) || peserta.sekolah.nama.toLowerCase().includes(search.value.toLowerCase())
    })
}
const datas = computed(() => {
    // let length = pesertas.value.length
    // let pages =  _.chunk(pesertas.value, 10)

    // return {current: pages[currentPage.value-1], pageCount: pages.length, total: length}
    return paginate(pesertas.value, currentPage.value)
})
const fixData = async () => {
    loading.value = true
    await axios.post(route('dashboard.peserta.attach'), {pesertas: JSON.stringify($page.props.pesertas)})
            .then(res => {
                router.reload({only: ['pesertas']})
                loading.value = false
            })
}

// Impor
const btnImporText = ref('Ambil File')
const onFilePicked = async (ev) => {
    let file = ev.target.files[0]
    btnImporText.value = file.name

    let reader = new FileReader()

    reader.onload = async (e) => {
        let wb = await read(e.target.result)
        let calons = await utils.sheet_to_json(wb.Sheets[wb.SheetNames[0]])
        await importTable.value.open("Cek Calon Peserta", calons)
                                .then(res => {
                                    router.reload({only: ['pesertas']})
                                })
                            
    }
    reader.readAsArrayBuffer(file)
}

const importTable = ref(null)

// Select
const select  = ref(false)
const selected = ref([])
const selectedAll = (e) => {
    selected.value = e.target.checked ? pesertas.value : []
}
const checked = (nisn) => {
    let found = selected.value.filter(item => item.nisn == nisn)
    return found.length > 0 ? true : false
} 
const selectOne = ($event, selectedPeserta) => {
    if ($event.target.checked) {
        // let foundIndex = pesertas.value.findIndex(el => el.nisn == nisn)
        // selected.value.splice(foundIndex,0, pesertas.value[foundIndex])
        selected.value.push(selectedPeserta)
    } else {
        selected.value = _.remove(selected.value, el => el.nisn == selectedPeserta.nisn)
    }
}

// Hapus
const dialog = ref(null)
const hapus = async (id) => {
    await dialog.value.open("Hapus")
        .then(ok => {
            if (ok) {
                let dataId = id
                axios.delete(route('dashboard.peserta.destroy', {id: id}))
                    .then(res => {
                        router.reload({only: ['pesertas']})
                    })
           }
        })
    
}

// Edit
const formPeserta = ref(null)
const edit = async (peserta) => {
    await formPeserta.value.open(peserta)
                .then(ok => {
                    if (ok) {
                        router.reload({only: ['pesertas']})
                    }
                })
}
</script> 

<template>
<FormPeserta ref="formPeserta" />
<DialogBox ref="dialog" />
<ImportTable ref="importTable" />
<Head title="Data Peserta" />
<Dash>
<div class="w-full bg-white">
    <div class="toolbar w-full h-12 bg-gray-50 rounded shadow flex items-center px-0 md:px-3 justify-center md:justify-between print:hidden">
        <h1 class="hidden md:inline">
            <span >Data Peserta</span>
        </h1>
        <div class="toolbar-items flex items-center gap-2">
            <input type="file" name="filePeserta" id="filePeserta" ref="filePeserta" @change="onFilePicked" class="hidden" accept=".xlsx, .xls, .ods, .csv" />
            <label for="select" class="mx-3 hidden md:inline" >
                <input type="checkbox" name="select" id="select" class="rounded" v-model="select" />
                Pilih Data
            </label>
            <button class="bg-green-400 hover:bg-green-600 active:bg-orange-400 text-white py-1 px-2 rounded" @click="edit(null)" >Baru</button>
            <button class="bg-green-400 hover:bg-green-600 active:bg-orange-400 text-white py-1 px-2 rounded flex items-center" @click="$refs.filePeserta.click()">
                <span class="hidden md:inline">
                    {{ btnImporText }}
                </span>
                <SvgIcon type="mdi" :path="mdiFileExcel" />
            </button>
            <button class="bg-sky-400 hover:bg-sky-600 text-white px-2 py-1 rounded shadow uppercase flex items-center active:bg-sky-800" :disabled="loading" @click="fixData" :class="$page.props.auth.user.level !== 'admin' ? 'hidden' : ''">
                <span v-if="!loading" class="hidden md:inline">Daftarkan Bidang Lomba</span>
                <ArrowPathIcon class="w-6 text-white" :class="loading ? 'animate-spin' : ''" />
            </button>
            <input type="text" placeholder="Cari" class="h-8 rounded w-[60%] md:w-64" v-model="search" @keyup.enter="filter" />
        </div>
    </div>

    <div class="content w-full bg-white p-3 mt-2 ">
        <div class="overflow-x-auto w-full border">
            <table class="w-full table table-responsive border-collapse ">
                <caption class="text-left md:text-center p-2">
                    <h1 class="text-xl">Data Peserta {{ $page.props.lomba.label }}</h1>
                </caption>
                <thead>
                    <tr>
                        <th class="border text-center">
                            <span v-show="!select">No</span>
                            <input type="checkbox" name="select" id="select" class="rounded"  v-if="select" @change="selectedAll" />
                        </th>
                        <th class="border text-center">NISN</th>
                        <th class="border text-center">Nama</th>
                        <th class="border text-center">JK</th>
                        <th class="border text-center">Sekolah</th>
                        <th class="border text-center">Lomba</th>
                        <th class="border text-center print:hidden">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd:bg-gray-50" v-for="(data,d) in datas.current" :key="d">
                        <td class="border p-2">
                            <span v-show="!select">{{ d+1 }}</span>
                            <input type="checkbox" name="select" id="select" class="rounded"  :checked="checked(data.nisn)" v-if="select" @change="selectOne($event, data)" />
                        </td>
                        <td class="border p-2">{{ data.nisn }}</td>
                        <td class="border p-2">
                            <div class="h-full grid grid-cols-2 md:flex items-center gap-2 cursor-pointer" @click="edit(data)">
                                <img :src="imgUrl(data.foto)" alt="Foto" class="h-8 aspect-square object-cover object-top rounded-full" />
                            {{ data.nama }}
                            </div>
                            
                        </td>
                        <td class="border p-2">{{ data.jk }}</td>
                        <td class="border p-2">{{ data.sekolah.nama }}</td>
                        <td class="border p-2 flex gap-2">
                            <div class="bg-teal-200 px-2 py-1 rounded">{{ data.lomba_id }}</div>
                            <ul>
                                <li v-for="(bidang,b) in data.bidangs" :key="b">{{ b+1 }}. {{ bidang.label }}</li>
                            </ul>
                        </td>
                        <td class="text-center border p-2 print:hidden">
                            <button class="p-0 text-red-400 hover:text-red-600 active:text-orange-400" @click="hapus(data.id)">
                                <SvgIcon type="mdi" :path="mdiDelete" :size="18" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="w-full bg-gray-200 flex items-center justify-between px-3  flex-wrap print:hidden">
            <div class="flex items-center gap-1">
                Total: {{ datas.total }}
            </div>
            Jml Halaman: {{ datas.pageCount }}
            
        </div>
        <div class="w-full flex flex-wrap md:justify-end print:hidden">
                <button @click="currentPage-=1" class="flex justify-center w-8 border border-gray-500 flex-grow md:flex-grow-0" :disabled="currentPage == 1">&lt;</button>
                <button v-for="b in datas.pageCount" :key="b" class="flex justify-center w-8 border border-gray-500 flex-grow md:flex-grow-0" :class="b == currentPage ? 'bg-sky-600 text-white': ''" @click="currentPage=b">{{ b }}</button>
                <button @click="currentPage+=1" class="flex justify-center w-8 border border-gray-500 flex-grow md:flex-grow-0" :disabled="currentPage >= datas.pageCount">&gt;</button>
            </div>
    </div>

    
</div>
</Dash>
</template>