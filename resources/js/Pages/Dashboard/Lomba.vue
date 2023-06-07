<script setup>
import Dash from '@/Layout/Dash.vue';
import { ref, defineAsyncComponent } from 'vue';
import { CheckCircleIcon } from '@heroicons/vue/20/solid';
import { Head, router, usePage} from '@inertiajs/vue3';
import axios from 'axios';
import * as _ from 'lodash-es';
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiMinusCircle } from '@mdi/js';
const PBtn = defineAsyncComponent(() => import('@/Components/General/PBtn.vue'))
const page = usePage()

const mode = ref('list')

// Form Lomba
const formLomba = ref(false)
const FormLomba = defineAsyncComponent(() => import('@/Components/Lomba/FormLomba.vue'))
const closeLomba = () => {
    formLomba.value = false
    selectedLomba.value = null
    router.reload({only: ['lombas']})
}

// Ruwet
const selectedLokasi = ref(null)

const AlertBox  = defineAsyncComponent(() => import('@/Components/General/AlertBox.vue'))
const alertBox = ref(null)

const DialogBox = defineAsyncComponent(() => import('@/Components/General/DialogBox.vue'))
const dialogBox = ref(null)

const bidangs = (pesertas) => {
    return _.groupBy(pesertas, 'lomba_id')
}

const onSelectedLokasi = (e) => {
    selectedLokasi.value = e.target.value
}

const toggleStatus = async (lomba) => {
    if(lomba.status == '1') {
        alertBox.value.open("Error", "Lomba "+lomba.label+" sudah aktif.")
        return false
    }
    if (await dialogBox.value.open("Aktifkan Lomba "+lomba.label+"?")) {
        if (!lomba.sekolah) {
            alertBox.value.open("Error", "Tentukan lokasi lomba")
            // console.log(lomba)
            return false
        } else {
            selectedLokasi.value = lomba.lokasi_id
        }
        axios.put(route('lomba.activate', {id: lomba.id}), {lokasi_id: selectedLokasi.value})
            .then(res => {
                router.reload({only: ['lombas']})
                alertBox.value.open("Ok", `${lomba.label} diaktifkan.`)
            }).catch(err => console.log(err))
    }
} 

const removeBidang = async (bidang, lomba) => {
    if (await dialogBox.value.open("Hapus Bidang "+ bidang.label + " pada " + lomba.label+"?")) {
        axios.delete(route('bidang.destroy', {id: bidang.id}))
                .then(res => {
                    router.reload({only: ['lombas']})
                    alertBox.value.open("Ok", res.data.msg)
                })
        console.log(bidang, lomba)
    }
}

// Panitia
const Panitia = defineAsyncComponent(() => import('@/Pages/Dashboard/Panitia.vue'))
const selectedLomba = ref(null)
const panitiaMode = ref('')

const viewPanitia = (lomba) => {
    selectedLomba.value = lomba
    mode.value = 'panitia'
    panitiaMode.value = 'view'
}
const createPanitia = (lomba) => {
    selectedLomba.value = lomba
    mode.value = 'panitia'
    panitiaMode.value = 'create'
}

const editLomba = (lomba) => {
     formLomba.value = true
     selectedLomba.value = lomba
}

</script>

<template>
<Head title="Data Perlombaan" />
<DialogBox ref="dialogBox" />
<AlertBox ref="alertBox" />
<FormLomba :show="formLomba" @close="closeLomba" :lomba="selectedLomba" v-if="formLomba" />
<Dash title="Data Lomba">
    <Panitia v-if="mode=='panitia'" :lomba="selectedLomba" @close="mode = 'list'" />
    <div class="w-full bg-white my-4 md:mt-0 rounded-xl overflow-hidden" v-if="mode == 'list'">
        <div class="toolbar bg-gray-100 h-12 flex items-center justify-between p-3 sticky top-0 print:hidden">
            <span></span>
            <div class="toolbar-items flex items-center">
                <p-btn color="sky" @click="formLomba = true">
                    Baru
                </p-btn>
            </div>
        </div>
        <div class="content w-full bg-white p-3 mt-2 ">
            <div class="overflow-x-auto w-full border">
                <table class="w-[100%] table table-responsive border-collapse ">
                    <caption class="text-center text-xl font-bold my-2">Data Lomba</caption>
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="py-2 px-3 ">No</th>
                            <th class="py-2 px-3 ">Label</th>
                            <th class="py-2 px-3 hidden md:block">Tahun</th>
                            <th class="py-2 px-3 ">Bidang Lomba dan Peserta</th>
                            <th class="py-2 px-3 ">Lokasi</th>
                            <th class="py-2 px-3 ">Panitia</th>
                            <th class="py-2 px-3 print:hidden">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd:bg-gray-100 hover:bg-lime-50" v-for="(lomba,l) in page.props.lombas" :key="l">
                            <td class="text-center">{{ l+1 }}</td>
                            <td class="px-3 text-sky-800 hover:underline hover:cursor-pointer" @click="editLomba(lomba)">{{ lomba.label }}</td>
                            <td class="text-center hidden md:block">{{ lomba.tahun }}</td>
                            <td class="px-3">
                                <ul v-if="lomba.bidangs" > 
                                    <li v-for="(bidang,b) in lomba.bidangs" :key="b" class="my-1 group flex items-center">
                                        {{ bidang.label }} &nbsp; <span class="text-orange-400 font-bold"> [{{ bidang.pesertas.length }} orang]</span>
                                        <button class=" group-hover:inline-block hidden" @click="removeBidang(bidang, lomba)">
                                            <SvgIcon type="mdi" :path="mdiMinusCircle" class="text-red-600" />
                                        </button>
                                    </li>
                                </ul>    
                            </td>
                            <td class="px-3">
                                {{ lomba.sekolah.nama }}
                            </td>
                            <td class="px-3">
                                <button class="py-1 px-2 bg-sky-400 hover:bg-sky-600 active:bg-orange-400 text-white rounded" @click="viewPanitia(lomba)" v-if="lomba.panitias.length > 0">Lihat</button>
                                <button class="py-1 px-2 bg-sky-400 hover:bg-sky-600 active:bg-orange-400 text-white rounded" @click="createPanitia(lomba)" v-else>Buat</button>
                            </td>
                            <td class="text-center">
                                <button>
                                    <CheckCircleIcon class="h-8" :class="lomba.status == '1' ? 'text-lime-400':'text-gray-200'" @click="toggleStatus(lomba)" />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</Dash>
</template>