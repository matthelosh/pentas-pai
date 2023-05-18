<script setup>
import Dash from '@/Layout/Dash.vue';
import { ref, defineAsyncComponent } from 'vue';
import { CheckCircleIcon } from '@heroicons/vue/20/solid';
import { Head, router, usePage} from '@inertiajs/vue3';
import axios from 'axios';

const page = usePage()

const AlertBox  = defineAsyncComponent(() => import('@/Components/General/AlertBox.vue'))
const alertBox = ref(null)

const DialogBox = defineAsyncComponent(() => import('@/Components/General/DialogBox.vue'))
const dialogBox = ref(null)

const toggleStatus = async (lomba) => {
    if(lomba.status == '1') {
        alertBox.value.open("Error", "Lomba "+lomba.label+" sudah aktif.")
        return false
    }
    if (await dialogBox.value.open("Aktifkan Lomba "+lomba.label+"?")) {
        if (!lomba.sekolah_id) {
            alertBox.value.open("Error", "Tentukan Lokasi Perlombaan Dulu")
            return false
        }
        axios.put(route('lomba.activate', {id: lomba.id}))
            .then(res => {
                router.reload({only: ['lombas']})
                alertBox("Ok", `${lomba.label} diaktifkan.`)
            }).catch(err => console.log(err))
    }
} 
</script>

<template>
<Head title="Data Perlombaan" />
<DialogBox ref="dialogBox" />
<AlertBox ref="alertBox" />
<Dash>
<div class="w-full bg-white">
    <div class="toolbar bg-gray-100 h-12 flex items-center justify-between p-3 sticky top-0 print:hidden">
        <span>Data Lomba</span>
        <div class="toolbar-items flex items-center">

        </div>
    </div>
    <div class="content">
        <table class="table w-full border border-collapse">
            <caption class="text-center text-xl font-bold my-2">Data Lomba</caption>
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-3 border-b border-e border-gray-400">No</th>
                    <th class="py-2 px-3 border-b border-e border-gray-400">Label</th>
                    <th class="py-2 px-3 border-b border-e border-gray-400">Tahun</th>
                    <th class="py-2 px-3 border-b border-e border-gray-400">Lokasi</th>
                    <th class="py-2 px-3 border-b border-gray-400 print:hidden">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <tr class="odd:bg-gray-100" v-for="(lomba,l) in page.props.lombas" :key="l">
                    <td class="border-e border-gray-400 text-center">{{ l+1 }}</td>
                    <td class="border-e border-gray-400 px-3">{{ lomba.label }}</td>
                    <td class="border-e border-gray-400 text-center">{{ lomba.tahun }}</td>
                    <td class="border-e border-gray-400 px-3">
                        <select name="lokasi_id" >
                            <option value="0">Pilih Lokasi</option>
                            <option v-for="(sekolah,s) in $page.props.sekolahs" :key="s" :value="sekolah.npsn" :selected="sekolah.npsn == lomba.lokasi_id">{{ sekolah.nama }}</option>
                        </select>
                    </td>
                    <td class="border-e border-gray-400 text-center">
                        <button>
                            <CheckCircleIcon class="h-8" :class="lomba.status == '1' ? 'text-lime-400':'text-gray-200'" @click="toggleStatus(lomba)" />
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</Dash>
</template>