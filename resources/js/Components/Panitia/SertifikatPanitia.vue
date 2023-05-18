<script setup>
import { ref, onMounted } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import { XCircleIcon, PrinterIcon, Bars3Icon } from '@heroicons/vue/20/solid';
import VueQrcode from '@chenfengyuan/vue-qrcode';
import { imgUrl } from '@/Plugins/misc';
import axios from 'axios';

onMounted(() => {
    list()
})

const page = usePage()
const props = defineProps({
    lomba: Object
})

const mode = ref('list')


const panitias = ref('')

const list = async () => {
    await axios.post(route('panitia.index')).then(res => {
            panitias.value = res.data.panitias

        })
}

const selectedPanitia = ref({})

const viewSertificate = (panitia) => {
    mode.value = 'cetak'
    selectedPanitia.value = panitia
}

const cetak = () => {
    window.print()
}

const nama = (nama) => {
    return nama.toLowerCase()
}
</script>

<template>
<Head title="Sertifikat Peserta" />
<div class="w-full bg-white">
    <div class="toolbar w-full h-12  bg-white flex items-center justify-between p-3 shadow sticky top-0 z-10 print:hidden">
        <span class="toolbar-title">
            Sertifikat Panitia
        </span>
        <div class="toolbar-items flex items-center gap-2">
            <button class="bg-sky-400 hover:bg-sky-600 active:bg-orange-400 text-white flex gap-1 items-center py-1 px-2 rounded" @click="mode='list'">
                Lihat
                <Bars3Icon class="h-8" />
            </button>
            <button class="bg-sky-400 hover:bg-sky-600 active:bg-orange-400 text-white flex gap-1 items-center py-1 px-2 rounded" @click="cetak">
                Cetak
                <PrinterIcon class="h-8" />
            </button>
            <button class="bg-red-400 hover:bg-red-600 active:bg-orange-400 text-white aspect-square rounded-full" @click="$emit('close')">
                <XCircleIcon class="h-8" />
            </button>
        </div>
    </div>
    <div class="content">
        <table class="table w-full bg-white border border-collapse" v-if="mode == 'list'">
            <caption class="text-xl my-4">Data Panitia Lomba </caption>
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-3 text-gray-800 border-e border-gray-400">No</th>
                    <th class="py-2 px-3 text-gray-800 border-e border-gray-400">NIP</th>
                    <th class="py-2 px-3 text-gray-800 border-e border-gray-400">Nama</th>
                    <th class="py-2 px-3 text-gray-800 border-e border-gray-400">JK</th>
                    <th class="py-2 px-3 text-gray-800 border-e border-gray-400">Lembaga</th>
                    <th class="py-2 px-3 text-gray-800 print:hidden">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <tr class="odd:bg-gray-100" v-for="(panitia,p) in panitias" :key="p">
                    <td class="text-center py-1 px-2 border-e border-gray-400">{{ p+1 }}</td>
                    <td class="py-1 px-2 border-e border-gray-400">{{ panitia.guru.nip }}</td>
                    <td class="py-1 px-2 border-e border-gray-400">{{ panitia.guru.nama }}</td>
                    <td class="py-1 px-2 border-e border-gray-400">{{ panitia.guru.jk }}</td>
                    <td class="py-1 px-2 border-e border-gray-400">{{ panitia.guru.sekolah ? panitia.guru.sekolah.nama : '-' }}</td>
                    <td class="py-1 px-2 print:hidden text-center" >
                        <button class="py-1 px-2 rounded hover:bg-green-600 active:bg-orange-400 bg-green-400 text-white" @click="viewSertificate(panitia)">Cetak</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="paper mx-auto mt-4 print:m-0 bg-white bg-[url('/img/sertifikat-panitia.jpg')] bg-cover h-[210mm] w-[297mm] p-10 relative break-after-page print:shadow-none rounded" v-if="mode=='cetak'">
            <img src="/img/kkgpaimalangkab.png" alt="Logo KKG" class="absolute h-20 top-2">
            <img src="/img/logo.png" alt="Logo KKG" class="absolute left-32 top-6 w-20" />
            <h1 style="font-family:Dancing Script!important;" class="text-6xl text-center mt-20">Sertifikat</h1>
            <h1 style="font-family:Dancing Script!important;" class="text-xl text-center">No: {{selectedPanitia.guru.nip}}</h1>
            <h2 class="text-center mt-6 text-xl">Diberikan Kepada:</h2>
            <div class="flex justify-center items-end w-10/12 mx-auto gap-4">
                <div class="bio">
                    <h1 class="nama text-[3.2rem]  mt-4 underline capitalize" style="font-family: Pacifico!important;">{{nama(selectedPanitia.guru.nama)}}</h1>
                    <h4 class="sekolah text-xl  text-center">{{selectedPanitia.guru.sekolah ? selectedPanitia.guru.sekolah.nama : '-'}}</h4>
                    <h4 class="peringkat text-4xl text-center mt-4">Sebagai {{ selectedPanitia.jabatan }}</h4>
                </div>
            </div>
            <p class="mt-4 mx-20 text-lg">pada kegiatan <span class="font-extrabold">{{ $page.props.lomba.label }}</span> yang diselenggarakan oleh KKG PAI Kecamatan Wagir. Semoga dapat menjadi motivasi di masa depan.</p>
            <div class="grid grid-cols-3 w-10/12 mx-auto">
                <div class="relative">
                    <p class="text-center mt-14">Penanggung Jawab</p>
                    <img src="/img/stempel.png" alt="Stempel" class="absolute h-32 left-[10%] -translate-y-4 mix-blend-multiply">
                    <img src="/img/ttd-kkg.png" alt="Ketua" class="left-[50%] h-16 mix-blend-multiply absolute -translate-x-8">
                    <p class="text-center underline font-extrabold mt-14">Hasan Lutfi, S.PdI., M. PdI.</p>
                    <p class="text-center">NIP. 19760115 200501 1 002</p>
                </div>
                <div></div>
                <div class="relative">
                    <p class="text-center mt-8">Wagir, 16 Mei 2023</p>
                    <p class="text-center">Ketua Panitia</p>
                    <img src="/img/ttd-ketua.png" alt="Ketua" class="left-[50%] h-20 mix-blend-multiply absolute -translate-x-10">
                    <p class="text-center underline font-extrabold mt-14">Choiri Machmudi, S. Ag., M. Pd.</p>
                    <p class="text-center">NIP. 19760115 200501 1 002</p>
                </div>
            </div>
            
            <div class="absolute bottom-2 left-6 print:relative">
                <vue-qrcode :value="`https://pentaspais.kkgpaiwagir.or.id/verifikasi/sertifikat?id=${selectedPanitia.guru.nip}`" :options="{width: 75}"  class="shadow rounded" />
                <span class="text-teal-800 bg-white bg-opacity-50">https://pentaspais.kkgpaiwagir.or.id</span>
            </div>
            
        </div>
    </div>

</div>
</template>