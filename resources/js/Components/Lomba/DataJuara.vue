<script setup >
import { ref, onMounted } from 'vue'; 
import { Head, router } from '@inertiajs/vue3';
import axios from 'axios';
import { XCircleIcon, PrinterIcon, ArrowPathIcon } from '@heroicons/vue/20/solid';
import PiagamJuara from './PiagamJuara.vue';
import FormJuara from './FormJuara.vue';
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiFileExcel, mdiClose } from '@mdi/js';
import { read, utils, write, writeFileXLSX } from 'xlsx';
import {saveAs} from 'file-saver'

const props = defineProps({
    lomba: Object,
})
const mode = ref('list')
const datas = ref([])
const loading = ref(false)
const list = async() => {
    loading.value = true
    await axios.post(route('juara.index'))
                .then(res => {
                    datas.value = res.data.juaras
                    loading.value = false
                })
}

const selectedJuara = ref(null)
const cetak = (juara) => {
    
    mode.value = 'piagam'
    selectedJuara.value = juara
}

const dialog = ref(false)

const closeForm = () => {
    dialog.value = false
    router.reload({only: ['juaras']})
}

const importDatas = ref([])
const fileName = ref('Impor Data')
const onFileJuaraPicked = (e) => {
    let file = e.target.files[0]
    fileName.value = file.name
    mode.value = 'impor'

    let reader = new FileReader()
    reader.onload = async (e) => {
        let wb = await read(e.target.result)
        importDatas.value = await utils.sheet_to_json(wb.Sheets[wb.SheetNames[0]])

    }
    reader.readAsArrayBuffer(file)
}

// Download Excel
const unduh = () => {
    let wb = utils.book_new()
    wb.Props = {
        Title: 'Data Juara Pentas PAIS',
        Subject: "Laporan",
        Author: "KKG PAI Wagir",
        CreatedDate: new Date()
    }
    wb.SheetNames.push("Data Juara")
    let ws = utils.json_to_sheet(datas.value)
    wb.Sheets["Data Juara"] = ws

    let wbout = write(wb, {bookType: 'xlsx', type: 'binary'})
    // saveAs(new Blob([s2ab(wbout)], {type: "application/octet-stream"}), "Juara Pentas Pais 2023.xlsx")
    writeFileXLSX(wb, "Juara Pentas PAIS.xlsx")
}

const impor = async () => {
    await axios.post(route('juara.impor'), {data: JSON.stringify(importDatas.value)})
                .then(res => {
                    mode='list'
                    list()
                }).catch(err => console.log(err))
}

onMounted(() => {
    list()
})
</script>

<template>
<div class="w-full bg-white">
    <Head title="Data Juara" />
    <div class="toolbar bg-white h-12 p-2 flex items-center justify-between shadow print:hidden sticky top-0">
        <span>
            Data Juara
        </span>
        <div class="toolbar-items flex items-center gap-1">
            <input type="file" name="fileJuara" ref="fileJuara" @change="onFileJuaraPicked" accept=".xlsx, .xls, .ods, .csv" class="hidden">
            <button class="bg-green-400 hover:bg-green-600 active:bg-orange-400 text-white py-1 px-2 flex items-center rounded" @click="unduh">
                Download
            </button>
            <button class="bg-green-400 hover:bg-green-600 active:bg-orange-400 text-white py-1 px-2 flex items-center rounded" @click="$refs.fileJuara.click()">
                <SvgIcon type="mdi" :path="mdiFileExcel" />
                {{ fileName }}
            </button>
            <button class="bg-teal-400 hover:bg-teal-600 active:bg-orange-400 text-white py-1 px-2 rounded" @click="list">
                <ArrowPathIcon class="h-6 text-white" />
            </button>
            <button class="bg-teal-400 hover:bg-teal-600 active:bg-orange-400 text-white py-1 px-2 rounded" @click="dialog = true">Baru</button>
            <XCircleIcon class="text-red-600 h-8 hover:text-red-800 active:text-orange-400 cursor-pointer" @click="$emit('close')" />
        </div>
    </div>
    <div class="w-full p-6 print:p-0 min-h-[80vh]">
        <FormJuara v-if="dialog" @close="closeForm" />
        <Transition type="fade" >
        <PiagamJuara v-if="mode == 'piagam'" :juara="selectedJuara" @close="mode = 'list'" />
        <div class="table table-responsive w-full ease-linear transition-all" :class="loading ? 'bg-gray-50' : ''" v-else-if="mode == 'list'">
            <table class="table border border-collapse w-full">
                <thead>
                    <tr class="bg-sky-100">
                        <th class="border border-gray-600 py-2">No</th>
                        <th class="border border-gray-600 py-2">NISN</th>
                        <th class="border border-gray-600 py-2">Nama</th>
                        <th class="border border-gray-600 py-2">JK</th>
                        <th class="border border-gray-600 py-2">Lomba</th>
                        <th class="border border-gray-600 py-2">Peringkat</th>
                        <th class="border border-gray-600 py-2">Nilai</th>
                        <th class="border border-gray-600 py-2">Lembaga</th>
                        <th class="border border-gray-600 py-2 print:hidden">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, i) in datas" :key="i">
                        <td class="text-center py-1 px-2 border border-gray-600">{{ i+1 }}</td>
                        <td class="text-center py-1 px-2 border border-gray-600">{{ item.peserta.nisn }}</td>
                        <td class="py-1 px-2 border border-gray-600">{{ item.peserta.nama }}</td>
                        <td class="text-center py-1 px-2 border border-gray-600">{{ item.peserta.jk }}</td>
                        <td class="text-center py-1 px-2 border border-gray-600">{{ item.bidang.label}}</td>
                        <td class="text-center py-1 px-2 border border-gray-600">{{ item.peringkat}}</td>
                        <td class="text-center py-1 px-2 border border-gray-600">{{ item.nilai }}</td>
                        <td class=" py-1 px-2 border border-gray-600">{{ item.peserta.sekolah.nama }}</td>
                        <td class="text-center py-1 px-2 border border-gray-600 print:hidden">
                            <button class="px-2 py-1 rounded-md hover:bg-sky-600 active:bg-orange-400 bg-sky-400 text-white flex items-center mx-auto" @click="cetak(item)">
                                <PrinterIcon class="text-white h-6" />
                                Cetak
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="w-full border bg-gray-100" v-else-if="mode=='impor'">
            <div class="toolbar bg-gray-100 h-12 w-full flex items-center justify-between p-3 sticky top-12 shadow-md">
                Data Juara
                <div class="toolbar-items flex items-center gap-1">
                    <button class="bg-green-400 hover:bg-green-600 active:bg-orange-400 text-white py-1 px-2 flex items-center rounded" @click="impor">
                        Simpan
                    </button>
                    <button class="aspect-square bg-red-400 text-white h-8 flex items-center justify-center rounded" @click="mode='list';fileName = 'Impor Data'">
                        <SvgIcon type="mdi" :path="mdiClose" />
                    </button>
                </div>
            </div>
            <div class="w-full bg-white">
                <table class="table table-responsive w-full border border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2">No</th>
                            <th class="border p-2">Id</th>
                            <th class="border p-2">NISN</th>
                            <th class="border p-2">Kode Lomba</th>
                            <th class="border p-2">Kode Bidang Lomba</th>
                            <th class="border p-2">Peringkat</th>
                            <th class="border p-2">Nilai</th>
                            <th class="border p-2">Ketarangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data,d) in importDatas" :key="d" class="odd:bg-gray-100">
                            <td class="text-center py-1 px-2 border">{{ d+1 }}</td>
                            <td class="text-center py-1 px-2 border">{{ data.id }}</td>
                            <td class="text-center py-1 px-2 border">{{ data.peserta_id }}</td>
                            <td class="text-center py-1 px-2 border">{{ data.lomba_id }}</td>
                            <td class="text-center py-1 px-2 border">{{ data.bidang_id }}</td>
                            <td class="text-center py-1 px-2 border">{{ data.peringkat }}</td>
                            <td class="text-center py-1 px-2 border">{{ data.nilai }}</td>
                            <td class="text-center py-1 px-2 border">{{ data.keterangan }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </Transition>
    </div>
</div>
</template>