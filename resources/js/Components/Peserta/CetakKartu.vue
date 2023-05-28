<script setup>
import { ref, computed, onMounted } from 'vue';
import { XCircleIcon } from '@heroicons/vue/20/solid';
import VueQrcode from '@chenfengyuan/vue-qrcode';
import { imgUrl } from '@/Plugins/misc';
import * as _ from 'lodash-es';
const props = defineProps({
    lomba: Object
})

onMounted(() => {
    // alert(props.lomba.kategori)
    let datas = []
    props.lomba.pesertas.forEach((item, index) => {
        item.no = index+1
        datas.push(item)
    })
    pesertas.value = datas
})
const printMe = () => {
    window.print()
}

const sideBg = (kode) => {
    let bg = 'bg-lime-800'
    switch(kode) {
        default:
            bg = 'bg-lime-800'
            break
        case "lcc":
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
    let Pesertas = props.lomba.pesertas.filter(item => item.sekolah_id == e.target.value)
    let datas = []
    Pesertas.forEach((item,index) => {
        datas.push(item)
    })

    pesertas.value = Pesertas

}

const sekolahs = computed(() => {
    return props.lomba.pesertas.map(item => item.sekolah).filter(
        (thing, index, self) => index === self.findIndex((t) => t.npsn === thing.npsn)
    )
    
    
})

const sekolah = ref('0')

const items = computed(() => {
    // return props.lomba.kategori == 'regu' ? _.groupBy(pesertas.value, "sekolah_id") : pesertas.value
    let groups = _.groupBy(pesertas.value, "sekolah_id")
    if (props.lomba.kategori == 'regu') {
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
<div class="w-full bg-white rounded shadow print:shadow-none relative pt-10 print:pt-0">
    <div class="toolbar h-10 bg-[#fefefe] shadow items-center p-2 print:hidden flex justify-between absolute w-full z-10 top-0">
        Kartu Peserta {{ props.lomba.label }}
        <div class="toolbar-items flex gap-2">
            <select name="sekolah_id" v-model="sekolah" @change="filterSekolah" class="py-0">
                <option value="0">Pilih Sekolah</option>
                <option v-for="(sekolah,s) in sekolahs" :key="s" :value="sekolah.npsn">{{ sekolah.nama }}</option>
            </select>

            <button class="bg-sky-400 text-white px-2 rounded shadow hover:bg-sky-600" @click="printMe">
                Cetak
            </button>
            <XCircleIcon class="text-red-600 h-6 cursor-pointer" @click="$emit('close')" />
        </div>
    </div>
    <div class="w-full grid grid-cols-3 gap-1 print:gap-2 print:p-0 p-3 relative" v-if="props.lomba.kategori !== 'regu'">
        <div v-for="(peserta,p) in items" :key="p" class=" border-gray-800 border shadow print:shadow-none  print:break-inside-avoid print:my-1 print:mx-0 mx-auto grid grid-cols-4 relative bg-[url('/img/kartupeserta-bg.png')] bg-cover w-full h-[500px] print:h-[350px]" >
            <div class="left h-full relative block pt-5" :class="sideBg(lomba.kode)">
                <h1 class="absolute text-uppercase whitespace-nowrap uppercase top-12 font-extrabold w-[100%] text-4xl rotate-90 text-white">{{ lomba.label }}</h1>
                <h1 class="text-4xl font-extrabold absolute bg-white aspect-square w-16 text-center  rounded-lg bottom-2 -right-6 border-2 border-black flex justify-center items-center">{{ peserta.no }}</h1>
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
                    <div class="left h-full relative flex flex-col justify-between p-4  items-center" :class="sideBg(lomba.kode)">
                        <h1 class="text-uppercase whitespace-nowrap uppercase  font-extrabold w-[100%] text-4xl print:text-2xl text-white" style="writing-mode: vertical-lr;">{{ lomba.label }}</h1>
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