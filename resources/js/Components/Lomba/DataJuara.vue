<script setup >
import { ref, onMounted } from 'vue'; 
import { Head, router } from '@inertiajs/vue3';
import axios from 'axios';
import { XCircleIcon, PrinterIcon, ArrowPathIcon } from '@heroicons/vue/20/solid';
import PiagamJuara from './PiagamJuara.vue';
import FormJuara from './FormJuara.vue';

const props = defineProps({
    lomba: Object,
})
const mode = ref('list')
const datas = ref([])

const list = async() => {
    await axios.post(route('juara.index'))
                .then(res => {
                    datas.value = res.data.juaras
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
        </Transition>
    </div>
</div>
</template>