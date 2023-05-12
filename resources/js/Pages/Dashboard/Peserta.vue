<script setup>
import { Head, usePage, router } from '@inertiajs/vue3';
import Dash from '@/Layout/Dash.vue';
import { ref, computed, onMounted, watch } from 'vue';
import * as _ from 'lodash-es';
import axios from 'axios';
import {read, utils} from 'xlsx'
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiDelete } from '@mdi/js';

import DialogBox from '@/Components/General/DialogBox.vue';
import ImportTable from '@/Components/Peserta/ImportTable.vue';

const $page = usePage()
const currentPage = ref(1)
const search = ref(null)
const pesertas = ref($page.props.pesertas)

const filter = () => {
    pesertas.value = $page.props.pesertas.filter((peserta) => {
        return peserta.nama.toLowerCase().includes(search.value.toLowerCase()) || peserta.nisn.toLowerCase().includes(search.value.toLowerCase()) || peserta.sekolah.nama.toLowerCase().includes(search.value.toLowerCase())
    })
}
const datas = computed(() => {
    let length = pesertas.value.length
    let pages =  _.chunk(pesertas.value, 10)

    return {current: pages[currentPage.value-1], pageCount: pages.length, total: length}
})
const fixData = async () => {
    await axios.post(route('dashboard.peserta.attach'), {pesertas: JSON.stringify($page.props.pesertas)})
            .then(res => {
                router.reload({only: ['pesertas']})
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
        // console.log(utils.sheet_to_json(wb.Sheets[wb.SheetNames[0]]))
        const resp = await importTable.value.open("Cek Calon Peserta", calons).then(res => console.log(res))
        // console.log(resp)
                            
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
const selectOne = ($event, nisn) => {
    if ($event.target.checked) {
        let foundIndex = pesertas.value.findIndex(el => el.nisn == nisn)
        selected.value.splice(foundIndex,0, pesertas.value[foundIndex])
    } else {
        let foundIndex = selected.value.findIndex(el => el.nisn == nisn)
        selected.value.splice(foundIndex, 1)
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
                        _.remove(pesertas.value, (current) => {
                            return current.id == dataId
                        })
                    })
            }
        })
    
}
</script> 

<template>
<DialogBox ref="dialog" />
<ImportTable ref="importTable" />
<Head title="Data Peserta" />
<Dash>
<div class="w-full bg-white">
    <div class="toolbar w-full h-12 bg-gray-50 rounded shadow flex items-center px-3 justify-between print:hidden">
        <h1>Data Peserta</h1>
        <div class="toolbar-items flex items-center gap-2">
            <input type="file" name="filePeserta" id="filePeserta" ref="filePeserta" @change="onFilePicked" class="hidden" accept=".xlsx, .xls, .ods, .csv" />
            <label for="select" class="mx-3">
                <input type="checkbox" name="select" id="select" class="rounded" v-model="select" />
                Pilih Data
            </label>
            <button class="bg-green-400 hover:bg-green-600 active:bg-orange-400 text-white py-1 px-2 rounded" @click="$refs.filePeserta.click()">{{ btnImporText }}</button>
            <button class="bg-sky-400 hover:bg-sky-600 text-white px-2 py-1 rounded shadow uppercase flex items-center active:bg-sky-800" @click="fixData">perbaikan</button>
            <input type="text" placeholder="Cari" class="h-8 rounded" v-model="search" @keyup.enter="filter" />
        </div>
    </div>
    <div class="content w-full bg-white p-3 mt-2">
        
        <table class="table w-full border-collapse">
            <caption><h1>Data Peserta Lomba</h1></caption>
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
                        <input type="checkbox" name="select" id="select" class="rounded"  :checked="checked(data.nisn)" v-if="select" @change="selectOne($event, data.nisn)" />
                    </td>
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
                    <td class="text-center border p-2 print:hidden">
                        <button class="p-0 text-red-400 hover:text-red-600 active:text-orange-400" @click="hapus(data.id)">
                            <SvgIcon type="mdi" :path="mdiDelete" :size="18" />
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="w-full bg-gray-200 flex items-center justify-between pl-3 print:hidden">
            <div class="flex items-center gap-1">
                Total: {{ datas.total }}
            </div>
            Jml Halaman: {{ datas.pageCount }}
            <div class="flex items-center h-full ">
                <button @click="currentPage-=1" class="flex justify-center w-8 border border-gray-500">&lt;</button>
                <button v-for="b in datas.pageCount" :key="b" class="flex justify-center w-8 border border-gray-500" :class="b == currentPage ? 'bg-sky-600 text-white': ''" @click="currentPage=b">{{ b }}</button>
                <button @click="currentPage+=1" class="flex justify-center w-8 border border-gray-500">&gt;</button>
            </div>
        </div>
    </div>

    
</div>
</Dash>
</template>