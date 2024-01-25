<script setup>
import { ref, onMounted, computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import { XCircleIcon, PrinterIcon, Bars3Icon } from '@heroicons/vue/20/solid';
import VueQrcode from '@chenfengyuan/vue-qrcode';
import { imgUrl } from '@/Plugins/misc';
import axios from 'axios';
import { paginate } from '@/Plugins/misc'

onMounted(() => {
    list()
})

const page = usePage()
const props = defineProps({
    bidang: Object
})

const mode = ref('list')


const pesertas = ref([])

const sekolahs = computed(() => {
    return pesertas.value.map(peserta => peserta.sekolah)
})

const sekolah = ref('0')
const list = async () => {
    await axios.post(route('dashboard.peserta.index', {
            _query: {bidang: props.bidang.id}
        })).then(res => {
            pesertas.value = res.data.pesertas

        })
}

const currentPage = ref(1)

const items = computed(() => {
    let datas = sekolah.value == '0' ? pesertas.value : pesertas.value.filter(peserta => peserta.sekolah_id == sekolah.value)
    return paginate(datas, currentPage.value)
})

const selectedPeserta = ref({})

const viewSertificate = (peserta) => {
    mode.value = 'cetak'
    selectedPeserta.value = peserta
    headTitle.value = 'Sertifikat Peserta '+props.lomba.label+' - ' + peserta.nama
}

const cetak = () => {
    // let paper = document.querySelector(".paper")

    // let win = window.open("","_blank", "width=1024,height=800")
    // let html = `<!doctype html>
    //             <html>
    //                 <head>
    //                     <title>Sertifikat ${page.props.lomba.label} ${props.bidang.label} - ${selectedPeserta.value.nama} - ${selectedPeserta.value.sekolah.nama} </title>  
    //                     <link href="http://pentaspai.test:5173/resources/css/app.css" rel="stylesheet" />  
    //                     <style>
                           
    //                     </style>
    //                 </head>
    //                 <body>
    //                     ${paper.outerHTML}    
    //                 </body>
    //             </html>

    // `
    // win.document.write(html)

    setTimeout(() => {
        window.print()
    }, 500)

}

const nama = (nama) => {
    return nama.toLowerCase()
}

const headTitle = ref('Sertifikat Peserta')
</script>

<template>
<Head :title="headTitle" />
<div class="w-full bg-white rounded-xl">
    <div class="toolbar w-full h-12  bg-white flex items-center justify-between p-3 shadow sticky top-0 z-10 print:hidden mt-4 md:mt-0 rounded-t-xl">
        <span class="toolbar-title hidden md:block">
            Sertifikat Peserta Lomba {{ props.bidang.label }}
        </span>
        <div class="toolbar-items flex items-center gap-2 justify-end w-full md:w-auto">
            <select name="sekolah" v-model="sekolah" class="hidden md:block">
                <option value="0">Semua Sekolah</option>
                <option v-for="(school,s) in sekolahs" :value="school.npsn">{{ school.nama }}</option>
            </select>
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
    <div class="content p-3 overflow-auto">
        <div class="table w-full" v-if="mode == 'list'">
            <table class="table w-full bg-white border border-collapse" >
                <caption class="text-xl my-4">Data Peserta Bidang Lomba {{ props.bidang.label }}</caption>
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
                    <tr class="odd:bg-gray-100 hover:bg-lime-100" v-for="(peserta,p) in items.current" :key="p">
                        <td class="text-center py-1 px-2 border-e border-gray-400">{{ p+1 }}</td>
                        <td class="py-1 px-2 border-e border-gray-400">{{ peserta.nisn }}</td>
                        <td class="py-1 px-2 border-e border-gray-400">{{ peserta.nama }}</td>
                        <td class="py-1 px-2 border-e border-gray-400">{{ peserta.jk }}</td>
                        <td class="py-1 px-2 border-e border-gray-400">{{ peserta.sekolah.nama }}</td>
                        <td class="py-1 px-2 border-e border-gray-400 text-center">{{ props.bidang.label }}</td>
                        <td class="py-1 px-2 print:hidden text-center" >
                            <button class="py-1 px-2 rounded hover:bg-green-600 active:bg-orange-400 bg-green-400 text-white" @click="viewSertificate(peserta)">Cetak</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="pagination p-1">
                <div class="w-full bg-gray-200 flex items-center justify-between px-3  flex-wrap print:hidden">
                    <div class="flex items-center gap-1">
                        Total: {{ items.dataLength }} 
                    </div>
                    Jml Halaman: {{ items.pageCount }}
                    
                </div>
                <div class="w-full flex flex-wrap md:justify-end print:hidden">
                        <button @click="currentPage-=1" class="flex justify-center w-8 border border-gray-500 flex-grow md:flex-grow-0" :disabled="currentPage == 1">&lt;</button>
                        <button v-for="b in items.pageCount" :key="b" class="flex justify-center w-8 border border-gray-500 flex-grow md:flex-grow-0" :class="b == currentPage ? 'bg-sky-600 text-white': ''" @click="currentPage=b">{{ b }}</button>
                        <button @click="currentPage+=1" class="flex justify-center w-8 border border-gray-500 flex-grow md:flex-grow-0" :disabled="currentPage >= items.pageCount">&gt;</button>
                    </div>
            </div>
        </div>

        <div class="paper" style="width:100%;padding:20px;height:21.5cm;background: url('/img/piagam-peserta.jpg');background-size: cover;" v-if="mode=='cetak'">
            <div class="logo" style="display:flex; align-items: center; justify-content: center; width: 200px; position:absolute;">
                <img src="/img/kkgpaimalangkab.png" alt="Logo KKG" style="width: 64px">
                <img src="/img/logo.png" alt="Logo Pentas PAI"  style="width: 64px" />
            </div>
            
            <h1 style="font-family:Dancing Script!important;" class="text-6xl text-center mt-20">Sertifikat</h1>
            <h2 class="text-center mt-6 text-xl">Diberikan Kepada:</h2>
            <div class="flex justify-center items-center w-10/12 mx-auto gap-4">
                <img :src="imgUrl(selectedPeserta.foto)" alt="Foto" class="aspect-square border-4 border-gray-800 rounded-full h-40 object-cover object-center">
                <div class="bio">
                    <h1 class="nama text-[3.2rem]  mt-4 capitalize" style="font-family: Pacifico!important; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{selectedPeserta.nama.toUpperCase()}}</h1>
                    <h4 class="sekolah text-xl mt-4">{{selectedPeserta.sekolah.nama}}</h4>
                    <h4 class="peringkat text-4xl mt-4">Sebagai Peserta</h4>
                </div>
            </div>
            <p class="mt-4 mx-20 text-xl text-justify">dalam perlombaan <span class="font-extrabold">{{ props.bidang.label }}</span> pada kegiatan <span class="font-extrabold">{{ $page.props.lomba.label }}</span> yang diselenggarakan oleh KKG PAI Kecamatan Wagir. Semoga dapat menjadi motivasi di masa depan.</p>
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
                <vue-qrcode :value="`https://pentaspai.kkgpaiwagir.or.id/verifikasi/sertifikat?id=${selectedPeserta.nisn}`" :options="{width: 75}"  class="shadow" />
                <span class="text-teal-800 bg-white bg-opacity-50">https://pentaspais.kkgpaiwagir.or.id</span>
            </div>
            
        </div>
    </div>

</div>
</template>