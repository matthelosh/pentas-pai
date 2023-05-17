<script setup>
import SvgIcon from '@jamescoyle/vue-icon';
import { Head, usePage } from '@inertiajs/vue3';
import { mdiClose, mdiFilePdfBox } from '@mdi/js';
import { ref, onMounted } from 'vue';
import { imgUrl } from '@/Plugins/misc';
import VueQrcode from '@chenfengyuan/vue-qrcode';
import axios from 'axios';
const props = defineProps({lomba:Object, juara: Object})
const background = ref('/img/piagam-juara.png')
const page = usePage()
import html2pdf from 'html2pdf.js'

const bidang = ref('')

const bidangId = ref('0')
const bidangs = ref([
    {kode: 'bjr', label: 'Banjari'},
    {kode: 'adz', label: 'Adzan'},
    {kode: 'lcc', label: 'Cerdas Cermat'},
    {kode: 'mhq', label: 'MHQ'},
    {kode: 'mtp', label: 'MTQ'},
    {kode: 'pdc', label: 'Pildacil'},
])

const juaras = ref([])
const list = async () => {
    await axios.post(route('juara.index', {
            _query: {lomba: bidangId.value}
        }))
        .then(res => {
            let datas = res.data.juaras.filter(item => {
                if(page.props.auth.user.level !== 'admin') {
                    return item.peserta.sekolah_id == page.props.sekolahs[0].npsn
                } else {
                    return item
                }
            })

            juaras.value = datas
        })
}

const nama = (nama) => {
    let lower = nama.toLowerCase()
    return lower
}

const onBidangSelected = (e) => {
    let items = bidangs.value.filter(b => b.kode == e.target.value)
    bidang.value = items[0].label
    list()
}

const unduh = () => {
    let elements = document.querySelectorAll(".paper")
    elements.forEach((elemen,i) => {
        let nama = elemen.querySelector(".nama").innerText
        html2pdf().set({
            margin:       0,
            filename:     'Piagam Juara '+nama,
            image:        { type: 'jpeg', quality: 1 },
            html2canvas:  { scale: 2, useCors: true },
            pageBreak: {mode: ['css']},
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
        }).from(elemen).save()
    })
}

onMounted(() => {
    if (props.lomba ) {
        bidangId.value = props.lomba.kode
        bidang.value = props.lomba.label
        list()
    } else {
        juaras.value[0] = props.juara
    }
    
})
</script>

<template>
    <div class="w-full bg-white">
        <Head title="Piagam Juara" />
        <div class="toolbar bg-white h-12 flex items-center p-3 justify-between shadow print:hidden sticky top-0 z-10">
            <span>Piagam Juara Lomba {{ lomba ? lomba.label : props.juara.peserta.nama }}</span>
            <div class="toolbar-items flex gap-1 items-center">
                <button class="py-1 px-2 text-white bg-sky-400 hover:bg-sky-600 active:bg-orange-400 flex items-center rounded-md" @click="unduh" >
                    Download
                    <SvgIcon type="mdi" :path="mdiFilePdfBox" class="h-8" />    
                </button>

                <select class="pl-2 pr-8 h-10 rounded" name="bidangs" v-model="bidangId" @change="onBidangSelected">
                    <option v-for="(bidang,i) in bidangs" :key="i" :value="bidang.kode">{{ bidang.label }}</option>
                </select> 
                <SvgIcon type="mdi" :path="mdiClose" @click="$emit('close')" class="text-red-400 h-12 cursor-pointer" />
            </div>
        </div>
        <div class="content p-2 print:p-0 print:m-0 bg-gray-400 print:bg-transparent min-h-[70vh] grid grid-cols-1">
            <h1 class="text-6xl text-center text-red-50" v-if="juaras.length < 1"><small>Belum Ada Juara Di Bidang</small> <br /> {{ bidang }}</h1>
            <div class="grid grid-cols-1 gap-3 print:gap-0">
                <div class="paper mx-auto print:m-0 bg-white bg-[url('/img/piagam-juara.png')] bg-cover h-[210mm] w-[297mm] p-10 relative break-after-page print:shadow-none rounded" v-for="(juara,j) in juaras" :key="j">
                    <img src="/img/kkg.png" alt="Logo KKG" class="absolute h-20">
                    <img src="/img/logo.png" alt="Logo KKG" class="absolute left-32 mt-4 w-20" />
                    <h1 style="font-family:Dancing Script!important;" class="text-6xl text-center mt-20">Piagam Penghargaan</h1>
                    <h2 class="text-center mt-6 text-xl">Diberikan Kepada:</h2>
                    <div class="flex justify-center items-end w-10/12 mx-auto gap-4">
                        <img :src="imgUrl(juara.peserta.foto)" alt="Foto" class="aspect-square border-4 border-gray-800 rounded-full h-40">
                        <div class="bio">
                            <h1 class="nama text-[3.2rem]  mt-4 capitalize" style="font-family: Pacifico!important;">{{nama(juara.peserta.nama)}}</h1>
                            <h4 class="sekolah text-xl mt-4">{{juara.peserta.sekolah.nama}}</h4>
                            <h4 class="sekolah text-4xl mt-4">Sebagai Juara {{ juara.peringkat }}</h4>
                        </div>
                    </div>
                    <p class="mt-4 mx-20">dalam perlombaan <span class="font-extrabold">{{ lomba ? lomba.label : juara.bidang.label }}</span> pada kegiatan <span class="font-extrabold">{{ $page.props.lomba.label }}</span> yang diselenggarakan oleh KKG PAI Kecamatan Wagir. Semoga dapat menjadi motivasi di masa depan.</p>
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
                        <vue-qrcode :value="`https://pentaspais.kkgpaiwagir.or.id/verifikasi/piagam?id=${juara.id}`" :options="{width: 75}"  class="shadow" />
                        <span class="text-teal-800 bg-white bg-opacity-50">https://pentaspais.kkgpaiwagir.or.id</span>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Pacifico:wght@400;500;600;700&display=swap');

h1.title {
    font-family: 'Dancing Script', cursive !important;
}

</style>