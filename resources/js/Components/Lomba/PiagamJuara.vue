<script setup>
import SvgIcon from '@jamescoyle/vue-icon';
import { Head, usePage } from '@inertiajs/vue3';
import { mdiClose } from '@mdi/js';
import { ref, onMounted } from 'vue';
import VueQrcode from '@chenfengyuan/vue-qrcode';
import axios from 'axios';
const props = defineProps({lomba:Object, juara: Object})
const background = ref('/img/piagam-juara.png')
const page = usePage()

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
                <select class="pl-2 pr-8 h-10 rounded" name="bidangs" v-model="bidangId" @change="onBidangSelected">
                    <option v-for="(bidang,i) in bidangs" :key="i" :value="bidang.kode">{{ bidang.label }}</option>
                </select> 
                <SvgIcon type="mdi" :path="mdiClose" @click="$emit('close')" class="text-red-400 h-12 cursor-pointer" />
            </div>
        </div>
        <div class="content p-2 print:p-0 print:m-0 bg-gray-400 print:bg-transparent min-h-[70vh] grid grid-cols-1">
            <h1 class="text-6xl text-center text-red-50" v-if="juaras.length < 1"><small>Belum Ada Juara Di Bidang</small> <br /> {{ bidang }}</h1>
            <div class="paper mx-auto print:m-0 bg-white bg-[url('/img/piagam-juara.png')] m-3 bg-cover h-[210mm] w-[297mm] p-8 relative break-after-page shadow-xl print:shadow-none border-8 border-gray-50 rounded" v-for="(juara,j) in juaras" :key="j">
                <img src="/img/kkg.png" alt="Logo KKG" class="absolute h-20">
                <h1 style="font-family:Dancing Script!important;" class="text-6xl text-center mt-20">Piagam Penghargaan</h1>
                <h2 class="text-center mt-14 text-xl">Diberikan Kepada:</h2>
                <h1 class="nama text-6xl text-center mt-4 capitalize" style="font-family: Pacifico!important;">{{nama(juara.peserta.nama)}}</h1>
                <h4 class="sekolah text-xl text-center mt-4">{{juara.peserta.sekolah.nama}}</h4>
                <h4 class="sekolah text-xl text-center mt-4">Sebagai Juara {{ juara.peringkat }}</h4>
                <p class="mt-8 mx-20">dalam perlombaan {{ lomba ? lomba.label : juara.bidang.label }} pada kegiatan {{ $page.props.lomba.label }} yang diselenggarakan oleh KKG PAI Kecamatan Wagir. Semoga dapat menjadi motivasi di masa depan.</p>

                <p class="text-center mt-8">Wagir, 16 Mei 2023</p>
                <p class="text-center">Ketua Panitia</p>
                <img src="/img/stempel.png" alt="Stempel" class="absolute h-32 left-[36%] -translate-y-10">
                <img src="/img/ttd-ketua.png" alt="Ketua" class="mx-auto h-16">
                <p class="text-center underline font-extrabold">Choiri Machmudi, S. Ag., M. Pd.</p>
                <p class="text-center">NIP. 19760115 200501 1 002</p>
                <div class="absolute bottom-2 left-6 print:relative">
                    <vue-qrcode :value="`https://pentaspais.kkgpaiwagir.or.id/verifikasi/piagam?id=${juara.id}`" :options="{width: 75}"  class="shadow" />
                    <span class="text-teal-800 bg-white bg-opacity-50">https://pentaspais.kkgpaiwagir.or.id</span>
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