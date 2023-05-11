<script setup>
import { XCircleIcon } from '@heroicons/vue/20/solid';
import VueQrcode from '@chenfengyuan/vue-qrcode';
import { imgUrl } from '@/Plugins/misc';
const props = defineProps({
    lomba: Object
})

const printMe = () => {
    window.print()
}

const sideBg = (kode) => {
    let bg = 'bg-lime-200'
    switch(kode) {
        default:
            bg = 'bg-lime-200'
            break
        case "lcc":
            bg = 'bg-red-200'
            break
        case "pdc":
            bg = 'bg-green-200'
            break
        case "adz":
            bg = 'bg-teal-200'
            break
        case "mtq":
            bg = 'bg-green-200'
            break
        case "mhq":
            bg = 'bg-sky-200'
            break
        case "bjr":
            bg = 'bg-orange-200'
            break
    }
    return bg+' bg-opacity-90'
}

// const parseImg = (url) => {
    
//     if (url.includes('=')) {
//         let splited = url.split('=')
//         return `https://drive.google.com/uc?export=view&id=${splited[splited.length-1]}`
//     } else {
//         return url
//     }
// }
</script>

<template>
<div class="w-full bg-white rounded shadow print:shadow-none relative pt-10 print:pt-0">
    <div class="toolbar h-10 bg-[#fefefe] shadow items-center p-2 print:hidden flex justify-between absolute w-full z-10 top-0">
        Kartu Peserta {{ props.lomba.label }}
        <div class="toolbar-items flex gap-2">
            <button class="bg-sky-400 text-white px-2 rounded shadow hover:bg-sky-600" @click="printMe">
                Cetak
            </button>
            <XCircleIcon class="text-red-600 h-6 cursor-pointer" @click="$emit('close')" />
        </div>
    </div>
    <div class="w-full grid grid-cols-2 gap-3 p-3 relative">
        <div v-for="(peserta,p) in props.lomba.pesertas" :key="p" class=" border-gray-800 border shadow print:shadow-none print:w-[9cm] print:h-[12cm] print:break-inside-avoid print:my-8 print:mx-4 h-[12cm] w-[9cm] mx-auto grid grid-cols-4 relative bg-[url('/img/kartupeserta-bg.png')] bg-cover">
            <div class="left h-full relative block pt-5" :class="sideBg(lomba.kode)">
                <h1 class="text-uppercase whitespace-nowrap uppercase mt-6 font-extrabold text-4xl rotate-90 text-black">{{ lomba.label }}</h1>
                <h1 class="text-6xl font-extrabold absolute bg-white aspect-square w-24 text-center  rounded-lg bottom-2 -right-6 border-2 border-black flex justify-center items-center">{{ p+1 }}</h1>
            </div>
            <div class="col-span-3">
                <div class="logo flex gap-1 items-end justify-center mt-6">
                    <img src="/img/kkg.png" alt="Logo KKG" class="h-10">
                    <div class="logo--text">
                        <h3 class="my-0 leading-4 font-bold text-sm">PENTAS PAIS 2023</h3>
                        <h2 class="my-0 lh leading-4 text-xs">KKG PAI KECAMATAN WAGIR</h2>
                    </div>
                </div>
                <div class="foto w-full my-4">
                    <img :src="imgUrl(peserta.foto)" alt="Foto" class=" aspect-square object-cover rounded-full w-[150px] mx-auto object-center">
                </div>
                <div class="identitas w-full px-2">
                    <h2 class="uppercase text-center leading-4 font-bold">{{ peserta.nama }}</h2>
                    <h3 class="text-center leading-4">No. {{ peserta.nisn }}</h3>
                    <h4 class="uppercase text-center leading-4 mt-4 font-bold">{{ peserta.sekolah.nama }}</h4>
                </div>
                <vue-qrcode :value="`peserta?nisn=${peserta.nisn}`" :options="{width: 100, color: {light: '#fefefeee', dark: '#347f67'}}" class="absolute bottom-2 right-2"></vue-qrcode>
            </div>
        </div>
    </div>
</div>
</template>