<script setup>
import { Head, usePage, router } from '@inertiajs/vue3';
import Dash from '@/Layout/Dash.vue';
import { ref, computed, onMounted, watch, defineAsyncComponent } from 'vue';
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

const Loading = defineAsyncComponent(() => import('@/Components/General/Loading.vue'))
const AlertBox = defineAsyncComponent(() => import('@/Components/General/AlertBox.vue'))
const alertBox = ref(null)

const $page = usePage()
const currentPage = ref(1)
const search = ref(null)
const pesertas = ref($page.props.pesertas)
const loading = ref(false)

const filter = () => {
    return $page.props.pesertas.filter((peserta) => {
        return peserta.nama.toLowerCase().includes(search.value.toLowerCase()) || peserta.nisn.toLowerCase().includes(search.value.toLowerCase()) || peserta.sekolah.nama.toLowerCase().includes(search.value.toLowerCase())
    })
}
const datas = computed(() => {
    let datas = []
    if (search.value !== null) {
        datas = $page.props.pesertas.filter((peserta) => {
            return peserta.nama.toLowerCase().includes(search.value.toLowerCase()) || peserta.nisn.toLowerCase().includes(search.value.toLowerCase()) || peserta.sekolah.nama.toLowerCase().includes(search.value.toLowerCase())
        })
    } else {
        datas = $page.props.pesertas
    }
    return paginate(datas, currentPage.value)
})
const fixData = async () => {
    loading.value = true
    await axios.post(route('dashboard.peserta.attach'), {pesertas: JSON.stringify($page.props.pesertas)})
            .then(res => {
                router.reload({only: ['pesertas']})
                loading.value = false
            }).catch(err => {
                // alert(err.response.data.msg)
                alertBox.value.open("Error", err.response.data.msg)
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
                                }).catch(err => {
                                    filePeserta.value = null
                                    btnImporText.value = 'Ambil File'
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
                        alertBox.value.open("Ok", ok)
                        router.reload({only: ['pesertas']})
                }).catch(err => {
                    alertBox.value.open("Error", err)
                })
}
</script> 

<template>
<FormPeserta ref="formPeserta" />
<Loading :show="loading" v-if="loading" />
<DialogBox ref="dialog" />
<AlertBox ref="alertBox" />
<ImportTable ref="importTable" />
<Head title="Data Peserta" />
<Dash title="Data Peserta">
<div class="w-full bg-white my-4 rounded-xl overflow-hidden">
    <div class="toolbar w-full h-12 bg-gray-50 rounded shadow flex items-center px-2 md:px-3 justify-center md:justify-between print:hidden overflow-hidden">
        <h1 class="hidden md:inline">
            <!-- <span >Data Peserta</span> -->
        </h1>
        <div class="toolbar-items flex items-center gap-2">
            <input type="file" name="filePeserta" id="filePeserta" ref="filePeserta" @change="onFilePicked" class="hidden" accept=".xlsx, .xls, .ods, .csv" />
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
            <table class="w-[100%] table table-responsive border-collapse ">
                <caption class="text-left md:text-center p-2">
                    <h1 class="text-xl">{{ $page.props.lomba ? 'Data Peserta '+$page.props.lomba.label : 'Data Lomba Bellum Diisi' }}</h1>
                </caption>
                <thead>
                    <tr class="bg-gray-200"> 
                        <th class="border text-center py-2">No</th>
                        <th class="border text-center py-2 ">NISN</th>
                        <th class="border text-center py-2">Nama</th>
                        <th class="border text-center py-2">JK</th>
                        <th class="border text-center py-2">Sekolah</th>
                        <th class="border text-center py-2">Lomba</th>
                        <th class="border text-center py-2">Bidang</th>
                        <th class="border text-center py-2 print:hidden">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd:bg-gray-100 hover:bg-lime-100" v-for="(data,d) in datas.current" :key="d">
                        <td class="border p-2">
                            {{ d+1 }}
                        </td>
                        <td class="p-2 text-center">{{ data.nisn }}</td>
                        <td class="p-2 " @click="edit(data)">
                            <span class="flex items-center gap-1 flex-wrap justify-center md:justify-start cursor-pointer text-teal-800 hover:text-orange-600">
                                <img :src="imgUrl(data.foto)" alt="Foto" class="h-8 aspect-square object-cover object-top rounded-full" />
                                {{ data.nama }}
                            </span>
                        </td>
                        <td class="p-2 text-center">{{ data.jk }}</td>
                        <td class="p-2">{{ data.sekolah.nama }}</td>
                        <td class="p-2">
                            <span class="flex gap-1 flex-wrap">
                            <div class="bg-teal-200 px-2 py-1 rounded">{{ data.lomba.label }}</div>
                            
                            </span>
                        </td>
                        <td>
                            {{ data.bidang_id }}

                            <ul v-if="data.bidangs">
                                <li v-for="(bidang,b) in data.bidangs" :key="b">{{ b+1 }}. {{ bidang.label }}</li>
                            </ul>
                        </td>
                        <td class="text-center p-2 print:hidden">
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
                Total: {{ datas.dataLength }} 
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