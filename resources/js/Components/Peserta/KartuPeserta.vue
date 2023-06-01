<script setup>
import { ref, computed, onMounted, defineAsyncComponent } from 'vue';
import { XCircleIcon } from '@heroicons/vue/20/solid';
import VueQrcode from '@chenfengyuan/vue-qrcode';
import { imgUrl } from '@/Plugins/misc';
import * as _ from 'lodash-es';
import axios from 'axios';

const Loading = defineAsyncComponent(() => import('@/Components/General/Loading.vue'))
const loading = ref(false)
const props = defineProps({
    bidang: Object
})

onMounted(() => {
    getBidang()
})

const bidang = ref({})

const getBidang = async() => {
    loading.value = true
    await axios.post(route('bidang.show', {id: props.bidang.id}))
                .then(res => {
                    bidang.value = res.data.bidang
                    pesertas.value = res.data.bidang.pesertas
                    loading.value = false
                    // console.log(bidang.value)
                })
}

const printMe = () => {
    window.print()
}

const sideBg = (kode) => {
    let bg = 'bg-lime-800'
    switch(kode) {
        default:
            bg = 'bg-lime-800'
            break
        case kode.includes("lcc"):
            bg = 'bg-red-800'
            break
        case "pdc":
            bg = 'bg-green-800'
            break
        case "adz":
            bg = 'bg-teal-800'
            break
        case "mtq":
            bg = 'bg-green-800'
            break
        case "mhq":
            bg = 'bg-sky-800'
            break
        case "bjr":
            bg = 'bg-orange-800'
            break
    }
    return bg+' bg-opacity-90'
}

const pesertas = ref([])

const filterSekolah = (e) => {
    let Pesertas = bidang.value.pesertas.filter(item => item.sekolah_id == e.target.value)
    let datas = []
    Pesertas.forEach((item,index) => {
        datas.push(item)
    })

    pesertas.value = Pesertas

}

const sekolahs = computed(() => {
    if(bidang.value.pesertas) {
    return bidang.value.pesertas.map(item => item.sekolah).filter(
        (thing, index, self) => index === self.findIndex((t) => t.npsn === thing.npsn)
    )
    }
    
    
})

const label = computed(() => {
    let labels = bidang.value.label.split(" ")
    return bidang.value.kode.includes("bjr") ? labels[0] : labels[0]+" "+labels[1]
})

const sekolah = ref('0')

const items = computed(() => {
    let groups = _.groupBy(pesertas.value, "sekolah_id")
    if (props.bidang.kategori == 'regu') {
        let datas = []
        Object.values(groups).forEach((v,i) => {
            datas.push({no: i+1, data: v})
        })
        return datas
    } else {
        return pesertas.value
    }
})

</script>

<template>
<Loading v-if="loading" :show="loading" />
<div class="w-full bg-white rounded shadow print:shadow-none relative print:pt-0 mt-4 md:mt-0">
    <div class="toolbar h-12 bg-[#fefefe] shadow items-center p-2 print:hidden flex justify-between sticky w-full z-10 top-0">
        <span class="hidden md:block">Kartu Peserta {{ $page.props.lomba.label }}</span>
        <div class="toolbar-items  flex justify-between gap-2 items-center">
            <select name="sekolah_id" v-model="sekolah" @change="filterSekolah" class="py-1 rounded-full">
                <option value="0">Pilih Sekolah</option>
                <option v-for="(sekolah,s) in sekolahs" :key="s" :value="sekolah.npsn">{{ sekolah.nama }}</option>
            </select>

            <button class="bg-sky-400 text-white px-3 py-1 rounded-full shadow hover:bg-sky-600 hidden md:block" @click="printMe">
                Cetak
            </button>
            <XCircleIcon class="text-red-600 h-6 cursor-pointer" @click="$emit('close')" />
        </div>
    </div>
    <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-1 print:gap-2 print:p-0 p-3 relative" v-if="props.bidang.kategori !== 'regu'">
        <div v-for="(peserta,p) in items" :key="p" class=" border-gray-800 border shadow print:shadow-none  print:break-inside-avoid print:my-1 print:mx-0 mx-auto grid grid-cols-4 relative bg-[url('/img/kartupeserta-bg.png')] bg-cover w-full h-[500px] print:h-[350px]" >
            <div class="left h-full relative block pt-5" :class="sideBg(bidang.kode)">
                <h1 class="absolute text-uppercase whitespace-nowrap uppercase top-12 font-extrabold w-[100%] text-4xl rotate-90 text-white">{{ label }}</h1>
                <h1 class="text-4xl font-extrabold absolute bg-white aspect-square w-16 text-center  rounded-lg bottom-2 -right-6 border-2 border-black flex justify-center items-center">{{ p+1 }}</h1>
            </div>
            <div class="col-span-3 ">
                <div class="logo flex gap-1 items-end justify-center mt-6">
                    <img src="/img/kkg.png" alt="Logo KKG" class="h-10">
                    <div class="logo--text">
                        <h3 class="my-0 leading-4 font-bold text-sm">PENTAS PAIS 2023</h3>
                        <h2 class="my-0 leading-4 text-xs">KKG PAI KECAMATAN WAGIR</h2>
                    </div>
                </div>
                <div class="foto w-full mt-16 print:mt-2">
                    <img :src="imgUrl(peserta.foto)" alt="Foto" class=" aspect-square object-cover rounded-full w-[100px] print:w-[75px] mx-auto object-top border"  >
                </div>
                <div class="identitas w-full px-2 mt-10 print:mt-2">
                    <h2 class="uppercase text-center leading-4 font-bold text-sm">{{ peserta.nama }}</h2>
                    <h3 class="text-center leading-4 text-sm">No. {{ peserta.nisn }}</h3>
                    <h4 class="uppercase text-center leading-4 mt-4 font-bold text-sm">{{ peserta.sekolah.nama }}</h4>
                </div>
                <vue-qrcode :value="`peserta?nisn=${peserta.nisn}`" :options="{width: 75, color: {light: '#fefefeee', dark: '#347f67'}}" class="absolute bottom-2 right-2"></vue-qrcode>
            </div>
        </div>
    </div>
    <div v-else>
        <div v-for="(group,g) in items" :key="g">
            <div class="w-full grid grid-cols-3 gap-1 print:gap-2 print:p-0 p-3 relative">
                <div v-for="(peserta,p) in group.data" :key="p" class=" border-gray-800 border shadow print:shadow-none  print:break-inside-avoid print:my-1 print:mx-0 mx-auto grid grid-cols-4 relative bg-[url('/img/kartupeserta-bg.png')] bg-cover w-full h-[500px] print:h-[350px]" >
                    <div class="left h-full relative flex flex-col justify-between p-4  items-center" :class="sideBg(bidang.kode)">
                        <h1 class="text-uppercase whitespace-nowrap uppercase  font-extrabold w-[100%] text-4xl print:text-2xl text-white" style="writing-mode: vertical-lr;">{{ label }}</h1>
                        <h1 class="text-4xl bg-white aspect-square print:w-12 w-20 text-center rounded-full flex justify-center items-center">{{ group.no }}</h1>
                    </div>
                    <div class="col-span-3 ">
                        <div class="logo flex gap-1 items-end justify-center mt-6">
                            <img src="/img/kkg.png" alt="Logo KKG" class="h-10">
                            <div class="logo--text">
                                <h3 class="my-0 leading-4 font-bold text-sm">PENTAS PAIS 2023</h3>
                                <h2 class="my-0 leading-4 text-xs">KKG PAI KECAMATAN WAGIR</h2>
                            </div>
                        </div>
                        <div class="foto w-full mt-16 print:mt-2">
                            <img :src="imgUrl(peserta.foto)" alt="Foto" class=" aspect-square object-cover rounded-full w-[100px] print:w-[75px] mx-auto object-top border"  >
                        </div>
                        <div class="identitas w-full px-2 mt-10 print:mt-2">
                            <h2 class="uppercase text-center leading-4 font-bold text-sm">{{ peserta.nama }}</h2>
                            <h3 class="text-center leading-4 text-sm">No. {{ peserta.nisn }}</h3>
                            <h4 class="uppercase text-center leading-4 mt-4 font-bold text-sm">{{ peserta.sekolah.nama }}</h4>
                        </div>
                        <vue-qrcode :value="`peserta?nisn=${peserta.nisn}`" :options="{width: 75, color: {light: '#fefefeee', dark: '#020202'}}" class="absolute bottom-2 left-28"></vue-qrcode>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>