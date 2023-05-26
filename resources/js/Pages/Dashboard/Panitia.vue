<script setup>
import { ref, onMounted, computed } from 'vue';
import { XMarkIcon } from '@heroicons/vue/20/solid';
import axios from 'axios';
import ContextMenu from '@imengyu/vue3-context-menu';
import { vOnClickOutside } from '@vueuse/components'
import Moveable from 'vue3-moveable';
onMounted(() => {
    listGuru()
})

const emit = defineEmits(['close'])

const listGuru = async() => {
    await axios.post(route('guru.index'))
        .then(res => {
            let datas = []
            res.data.gurus.forEach(guru => {
                datas.push({nip: guru.nip, label: guru.nama})
            })
            gurus.value = datas
        })
}

const props = defineProps({
    lomba: Object
})

const gurus = ref([])

const panitia = ref({
})

const selectedJabatan = ref('')
const showGuru = (e, jabatan) => {
    e.preventDefault()
    const menu = document.querySelector(".context-menu")
    menu.classList.toggle("hidden")
    panitia.value[jabatan] = ''
    selectedJabatan.value = jabatan
    menu.style.top = `${e.y - (100)}px`
    menu.style.left = `${e.x - (window.innerWidth / 4)}px`
}

const closeMenu = (e) => {
    const menu = document.querySelector(".context-menu")
    menu.classList.add("hidden")
}

const setPanitia = (guru) => {
    panitia.value[selectedJabatan.value] = {guru_id: guru.nip, nama: guru.label}
    closeMenu()
}



const side = computed(() => {
    return (window.innerWidth/5)
})
</script>

<template>
    <div class="context-menu h-72 overflow-auto w-80 fixed hidden shadow-lg bg-gray-200 rounded border border-gray-200 z-20" style="-ms-overflow-style: none; scrollbar-width: none;" v-on-click-outside="closeMenu">
        <ul class="p-2">
            <li v-for="(guru,g) in gurus" :key="g" class="hover:bg-gray-400 hover:text-white hover:cursor-pointer"  @click="setPanitia(guru)">
                {{ g }}. {{ guru.label }}
            </li>
        </ul>
    </div>
    <div class="w-full bg-white rounded-shadow">
        <div class="toolbar h-12 flex items-center justify-between p-3 sticky top-0 bg-teal-800 text-lime-50">
            <span>
                Susunan Panitia {{ lomba.label }}
            </span> 
            <div class="toolbar-items flex items-center">
                <button @click="emit('close')">
                    <XMarkIcon class="h-8 bg-red-400 bg-opacity-30 rounded-full text-red-200 hover:bg-red-400 active:bg-orange-400" />
                </button>
            </div>
        </div>
        <div class="content w-full bg-white z-10 relative">
            <div class="absolute -z-10 top-0 right-0 bottom-0 left-0 hidden" >
                <svg width="3" height="252" class="absolute garis1" ref="garis1" :style="`left: ${(side*2)}px; top: 65px` ">
                    <line x1="0" y1="0" x2="0" y2="252" style="stroke:rgb(99, 95, 102); stroke-width: 3px;" /> 
                </svg>
                <svg width="350" height="5" class="absolute" :style="`left: ${746 - side}px; top: 170px`">
                    <line x1="0" y1="0" x2="350" y2="0" style="stroke:rgb(99, 95, 102); stroke-width: 5px;" /> 
                </svg>
                <svg width="1039" height="5" class="absolute" :style="`left: ${400 - side}px; top: 330px`">
                    <line x1="0" y1="0" x2="1039" y2="0" style="stroke:rgb(99, 95, 102); stroke-width: 5px;" /> 
                </svg>
                <svg width="3" height="44" class="absolute" :style="`left: ${399-side}px; top: 332px` ">
                    <line x1="0" y1="0" x2="0" y2="44" style="stroke:rgb(99, 95, 102); stroke-width: 3px;" /> 
                </svg>
                <svg width="3" height="174" class="absolute" :style="`left: ${490-side}px; top: 332px` ">
                    <line x1="0" y1="0" x2="0" y2="174" style="stroke:rgb(99, 95, 102); stroke-width: 3px;" /> 
                </svg>
                <svg width="3" height="44" class="absolute" :style="`left: ${(399+211)-side}px; top: 332px` ">
                    <line x1="0" y1="0" x2="0" y2="44" style="stroke:rgb(99, 95, 102); stroke-width: 3px;" /> 
                </svg>
                <svg width="3" height="174" class="absolute" :style="`left: ${(490+230)-side}px; top: 332px` ">
                    <line x1="0" y1="0" x2="0" y2="174" style="stroke:rgb(99, 95, 102); stroke-width: 3px;" /> 
                </svg>
                <svg width="3" height="44" class="absolute" :style="`left: ${(399+(211*2))-side}px; top: 332px` ">
                    <line x1="0" y1="0" x2="0" y2="44" style="stroke:rgb(99, 95, 102); stroke-width: 3px;" /> 
                </svg>
                <svg width="3" height="174" class="absolute" :style="`left: ${(490+(260*2))-side}px; top: 332px` ">
                    <line x1="0" y1="0" x2="0" y2="174" style="stroke:rgb(99, 95, 102); stroke-width: 3px;" /> 
                </svg>
                <svg width="3" height="44" class="absolute" :style="`left: ${(399+(220*3))-side}px; top: 332px` ">
                    <line x1="0" y1="0" x2="0" y2="44" style="stroke:rgb(99, 95, 102); stroke-width: 3px;" /> 
                </svg>
                <svg width="3" height="44" class="absolute" :style="`left: ${(380+(220*4))-side}px; top: 332px` ">
                    <line x1="0" y1="0" x2="0" y2="44" style="stroke:rgb(99, 95, 102); stroke-width: 3px;" /> 
                </svg>
                <svg width="3" height="174" class="absolute" :style="`left: ${(490+(290*3))-side}px; top: 332px` ">
                    <line x1="0" y1="0" x2="0" y2="174" style="stroke:rgb(99, 95, 102); stroke-width: 3px;" /> 
                </svg>
                <svg width="3" height="44" class="absolute" :style="`left: ${(380+(211*5))-side}px; top: 332px` ">
                    <line x1="0" y1="0" x2="0" y2="44" style="stroke:rgb(99, 95, 102); stroke-width: 3px;" /> 
                </svg>
            </div>
            <div class="row flex justify-center pt-4">
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Ketua Pelaksana</div>
                    <div class="pejabat px-2 text-center" @contextmenu="showGuru($event, 'ketua')">{{ panitia['ketua'] ? panitia['ketua'].nama : 'Nama' }}</div>
                </div>
            </div>
            
            <div class="row flex justify-center pt-2 pb-4">
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Wakil Ketua</div>
                    <div class="pejabat px-2 text-center bg-white" @contextmenu="showGuru($event, 'wakil')">{{ panitia['wakil'] ? panitia.wakil.nama : 'Nama' }}</div>
                </div>
            </div>
            <div class="row flex justify-center p-4 gap-6">
                <div class="flex-grow"></div>
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Sekretaris 1</div>
                    <div class="pejabat px-2 text-center" @contextmenu="showGuru($event, 'sekretaris1')">{{ panitia['sekretaris1'] ? panitia.sekretaris1.nama : 'Nama'}}</div>
                </div>
                <div class="flex-grow"></div>
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Bendahara 1</div>
                    <div class="pejabat px-2 text-center" @contextmenu="showGuru($event, 'bendahara1')">{{ panitia['bendahara1'] ? panitia.bendahara1.nama : 'Nama'}}</div>
                </div>
                <div class="flex-grow"></div>
            </div>
            <div class="row flex justify-center p-4 gap-6">
                <div class="flex-grow"></div>
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Sekretaris 2</div>
                    <div class="pejabat px-2 text-center"  @contextmenu="showGuru($event, 'sekretaris2')">{{ panitia['sekretaris2'] ? panitia.sekretaris2.nama : 'Nama' }}</div>
                </div>
                <div class="flex-grow"></div>
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Bendahara 2</div>
                    <div class="pejabat px-2 text-center"  @contextmenu="showGuru($event, 'bendahara2')">{{ panitia['bendahara2'] ? panitia.bendahara2.nama : 'Nama' }}</div>
                </div>
                <div class="flex-grow"></div>
            </div>
            <div class="row flex justify-center p-4">
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Seksi-seksi</div>
                </div>
            </div>
            <div class="row flex justify-around p-4 gap-6">
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded" v-for="(bidang,b) in lomba.bidangs" :key="b">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Sie {{ bidang.label }}</div>
                    <div class="pejabat px-2 text-center"  @contextmenu="showGuru($event, (bidang.kode+1))">{{ panitia[(bidang.kode+1)] ? panitia[(bidang.kode+1)].nama : 'Nama'}}</div>
                    <div class="pejabat px-2 text-center"  @contextmenu="showGuru($event, (bidang.kode+2))">{{ panitia[(bidang.kode+2)] ? panitia[(bidang.kode+2)].nama : 'Nama'}}</div>
                    <div class="pejabat px-2 text-center"  @contextmenu="showGuru($event, (bidang.kode+3))">{{ panitia[(bidang.kode+3)] ? panitia[(bidang.kode+3)].nama : 'Nama'}}</div>
                </div>
            </div>
            <div class="row flex justify-around p-4 gap-6">
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Sie Dokumentasi</div>
                    <div class="pejabat px-2 text-center" @contextmenu="showGuru($event, 'dokumentasi1')">{{ panitia['dokumentasi1'] ? panitia['dokumentasi1'].nama : 'Nama' }}</div>
                    <div class="pejabat px-2 text-center" @contextmenu="showGuru($event, 'dokumentasi2')">{{ panitia['dokumentasi2'] ? panitia['dokumentasi2'].nama : 'Nama' }}</div>
                    <div class="pejabat px-2 text-center" @contextmenu="showGuru($event, 'dokumentasi3')">{{ panitia['dokumentasi3'] ? panitia['dokumentasi3'].nama : 'Nama' }}</div>
                </div>
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Sie Konsumsi</div>
                    <div class="pejabat px-2 text-center" @contextmenu="showGuru($event, 'konsumsi1')">{{ panitia['konsumsi1'] ? panitia['konsumsi1'].nama : 'Nama' }}</div>
                    <div class="pejabat px-2 text-center" @contextmenu="showGuru($event, 'konsumsi2')">{{ panitia['konsumsi2'] ? panitia['konsumsi2'].nama : 'Nama' }}</div>
                    <div class="pejabat px-2 text-center" @contextmenu="showGuru($event, 'konsumsi3')">{{ panitia['konsumsi3'] ? panitia['konsumsi3'].nama : 'Nama' }}</div>
                </div>
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Sie Perlengkapan</div>
                    <div class="pejabat px-2 text-center" @contextmenu="showGuru($event, 'perlengkapan1')">{{ panitia['perlengkapan1'] ? panitia['perlengkapan1'].nama : 'Nama' }}</div>
                    <div class="pejabat px-2 text-center" @contextmenu="showGuru($event, 'perlengkapan2')">{{ panitia['perlengkapan2'] ? panitia['perlengkapan2'].nama : 'Nama' }}</div>
                    <div class="pejabat px-2 text-center" @contextmenu="showGuru($event, 'perlengkapan3')">{{ panitia['perlengkapan3'] ? panitia['perlengkapan3'].nama : 'Nama' }}</div>
                </div>
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Sie Pembantu Umum</div>
                    <div class="pejabat px-2 text-center" @contextmenu="showGuru($event, 'pu1')">{{ panitia['pu1'] ? panitia['pu1'].nama : 'Nama' }}</div>
                    <div class="pejabat px-2 text-center" @contextmenu="showGuru($event, 'pu2')">{{ panitia['pu2'] ? panitia['pu2'].nama : 'Nama' }}</div>
                    <div class="pejabat px-2 text-center" @contextmenu="showGuru($event, 'pu3')">{{ panitia['pu3'] ? panitia['pu3'].nama : 'Nama' }}</div>
                </div>
            </div>
            <!-- <p>
                {{ lomba }}
            </p> -->
        </div>
    </div>
</template>

<style>
::-webkit-scrollbar {
    display: none;
}
</style>