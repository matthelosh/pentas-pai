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


const pesertas = ref('')

const list = async () => {
    await axios.post(route('dashboard.peserta.index', {
            _query: {bidang: props.lomba.kode}
        })).then(res => {
            pesertas.value = res.data.pesertas.filter(item => {
                if(page.props.auth.user.level == 'admin') {
                    return item
                } else {
                    return item.sekolah_id == page.props.sekolahs[0].npsn
                }
            })

        })
}

const selectedPeserta = ref({})
const setLomba = (peserta) => {
    let lombas = peserta.bidangs.filter(item => item.kode == props.lomba.kode)
    return peserta.bidangs.length > 0 ? lombas[0] : 'Tidak Ikut lomba'
}

const viewSertificate = (peserta) => {
    mode.value = 'cetak'
    selectedPeserta.value = peserta
    headTitle.value = 'Sertifikat Peserta '+props.lomba.label+' - ' + peserta.nama
}

const cetak = () => {
    window.print()
}

const nama = (nama) => {
    return nama.toLowerCase()
}

const headTitle = ref('Sertifikat Peserta')
</script>

<template>
<Head :title="headTitle" />
<div class="w-full bg-white">
    <div class="toolbar w-full h-12  bg-white flex items-center justify-between p-3 shadow sticky top-0 z-10 print:hidden">
        <span class="toolbar-title">
            Sertifikat Peserta Lomba {{ lomba.label }}
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
            <caption class="text-xl my-4">Data Peserta Bidang Lomba {{ lomba.label }}</caption>
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-3 text-gray-800 border-e border-gray-400">No</th>
                    <th class="py-2 px-3 text-gray-800 border-e border-gray-400">NISN</th>
                    <th class="py-2 px-3 text-gray-800 border-e border-gray-400">Nama</th>
                    <th class="py-2 px-3 text-gray-800 border-e border-gray-400">JK</th>
                    <th class="py-2 px-3 text-gray-800 border-e border-gray-400">Sekolah</th>
                    <th class="py-2 px-3 text-gray-800 border-e border-gray-400">Bidang Lomba</th>
                    <th class="py-2 px-3 text-gray-800 print:hidden">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <tr class="odd:bg-gray-100 hover:bg-lime-100" v-for="(peserta,p) in pesertas" :key="p">
                    <td class="text-center py-1 px-2 border-e border-gray-400">{{ p+1 }}</td>
                    <td class="py-1 px-2 border-e border-gray-400">{{ peserta.nisn }}</td>
                    <td class="py-1 px-2 border-e border-gray-400">{{ peserta.nama }}</td>
                    <td class="py-1 px-2 border-e border-gray-400">{{ peserta.jk }}</td>
                    <td class="py-1 px-2 border-e border-gray-400">{{ peserta.sekolah.nama }}</td>
                    <td class="py-1 px-2 border-e border-gray-400 text-center">{{ setLomba(peserta).label }}</td>
                    <td class="py-1 px-2 print:hidden text-center" >
                        <button class="py-1 px-2 rounded hover:bg-green-600 active:bg-orange-400 bg-green-400 text-white" @click="viewSertificate(peserta)">Cetak</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="paper mx-auto print:m-0 bg-white bg-[url('/img/piagam-peserta.jpg')] bg-cover h-[210mm] w-[297mm] p-10 relative break-after-page print:shadow-none rounded" v-if="mode=='cetak'">
            <img src="/img/kkgpaimalangkab.png" alt="Logo KKG" class="absolute h-20">
            <img src="/img/logo.png" alt="Logo KKG" class="absolute left-32 mt-4 w-20" />
            <h1 style="font-family:Dancing Script!important;" class="text-6xl text-center mt-20">Sertifikat</h1>
            <h2 class="text-center mt-6 text-xl">Diberikan Kepada:</h2>
            <div class="flex justify-center items-center w-10/12 mx-auto gap-4">
                <img :src="imgUrl(selectedPeserta.foto)" alt="Foto" class="aspect-square border-4 border-gray-800 rounded-full h-40 object-cover object-center">
                <div class="bio">
                    <h1 class="nama text-[3.2rem]  mt-4 capitalize" style="font-family: Pacifico!important; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{nama(selectedPeserta.nama)}}</h1>
                    <h4 class="sekolah text-xl mt-4">{{selectedPeserta.sekolah.nama}}</h4>
                    <h4 class="peringkat text-4xl mt-4">Sebagai Peserta</h4>
                </div>
            </div>
            <p class="mt-4 mx-20">dalam perlombaan <span class="font-extrabold">{{ lomba.label }}</span> pada kegiatan <span class="font-extrabold">{{ $page.props.lomba.label }}</span> yang diselenggarakan oleh KKG PAI Kecamatan Wagir. Semoga dapat menjadi motivasi di masa depan.</p>
            <div class="grid grid-cols-3 w-10/12 mx-auto">
                <div class="relative">
                    <p class="text-center mt-14">Ketua KKG PAI Kec. Wagir</p>
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
                <vue-qrcode :value="`https://pentaspais.kkgpaiwagir.or.id/verifikasi/sertifikat?id=${selectedPeserta.nisn}`" :options="{width: 75}"  class="shadow" />
                <span class="text-teal-800 bg-white bg-opacity-50">https://pentaspais.kkgpaiwagir.or.id</span>
            </div>
            
        </div>
    </div>

</div>
</template>