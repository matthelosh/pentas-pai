<script setup>
import { ref, defineAsyncComponent } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiHumanMale, mdiHumanFemale, mdiHumanMaleFemale, mdiChevronDoubleDown, mdiChevronDoubleUp } from '@mdi/js';

import Dash from '@/Layout/Dash.vue';

const KartuPeserta = defineAsyncComponent(() => import('@/Components/Peserta/KartuPeserta.vue'))
const RekapPeserta = defineAsyncComponent(() => import('@/Components/Peserta/RekapPeserta.vue'))
const SertifikatPeserta = defineAsyncComponent(() => import('@/Components/Peserta/SertifikatPeserta.vue'))

const mode = ref('list')
const contentShow = ref(false)
const toggleContent = (e) => {
    // contentShow.value = !contentShow.value
    const button = e.target.closest("button")
    const card = e.target.closest(".card")
    button.classList.toggle('rotate-180')
    card.querySelector(".content").classList.toggle("flex")
    card.querySelector(".content").classList.toggle("hidden")
    card.classList.toggle("absolute")
    card.classList.toggle("z-10")
    card.classList.toggle("left-0")
    card.classList.toggle("top-0")
    card.classList.toggle("bottom-0")
    // console.log(e.target.closest('button'))
}

const selectedBidang = ref(null)
const kartuPeserta = async(bidang) => {
    mode.value = 'kartu-peserta'
    selectedBidang.value = bidang
}

const rekapPeserta = async(bidang) => {
    mode.value = 'rekap-peserta'
    selectedBidang.value = bidang
}

const sertifikatPeserta = async(bidang) => {
    mode.value = 'sertifikat-peserta'
    selectedBidang.value = bidang
}
</script>

<template>
<Head title="Administrasi Peserta" />
<Dash title="Administrasi Peserta">
    <Transition name="slide-fade">
        <div class="content relative w-full" v-if="mode == 'list'">
            <h1 class=" text-center md:my-4 font-bold tracking-wider text-white drop-shadow text-3xl ">
                <span class="hidden md:block">
                    Adminstrasi Peserta Lomba <br>
                </span>
                <button class="bg-gray-50 border border-teal-400 shadow py-1 px-3 rounded-full hover:bg-sky-400 hover:shadow-md active:bg-sky-300 hover:text-white duration-150 text-gray-950 mx-auto mt-6 text-lg" @click="rekapPeserta(bidang)">
                Rekap Peserta
            </button>
            </h1>
            
            <div class="w-full grid my-4 md:my-0  grid-cols-1 md:grid-cols-3 gap-4 py-4 md:pt-0 relative">
                <div class="card w-full bg-white rounded-xl overflow-hidden shadow" v-for="(bidang,b) in $page.props.lomba.bidangs" :key="b">
                    <div class="toolbar w-full h-12 bg-teal-600 text-white flex items-center justify-between p-3 shadow">
                        <h1>
                            <SvgIcon type="mdi" :path="bidang.kelompok == 'putra' ? mdiHumanMale : (bidang.kelompok == 'putri' ? mdiHumanFemale : mdiHumanMaleFemale)" class="inline" />
                            {{ bidang.label }} {{ bidang.kategori }}
                        </h1>
                        <div class="toolbar-items flex items-center">
                            <button @click="toggleContent($event)" class="btnChevron hover:border border-gray-50 rounded-full">
                                <SvgIcon type="mdi" :path="mdiChevronDoubleDown" class=" duration-500" />
                            </button>
                        </div>
                    </div>
                    <div class="content bg-white flex-col gap-2 hidden p-3 duration-500 transition-all">
                        <button class="bg-gray-300 border border-teal-400 shadow py-1 px-3 rounded-full hover:bg-sky-400 hover:shadow-md active:bg-sky-300 hover:text-white duration-150 text-gray-950" @click="kartuPeserta(bidang)">
                            Kartu Peserta
                        </button>
                        
                        <button class="bg-gray-300 border border-teal-400 shadow py-1 px-3 rounded-full hover:bg-sky-400 hover:shadow-md active:bg-sky-300 hover:text-white duration-150 text-gray-950" @click="sertifikatPeserta(bidang)">
                            Sertifikat Peserta
                        </button>
                    </div>
                </div>
            </div>
            
        </div>
        <KartuPeserta v-else-if="mode == 'kartu-peserta'" :bidang="selectedBidang" @close="mode='list'" />
        <RekapPeserta v-else-if="mode == 'rekap-peserta'" :bidang="selectedBidang" @close="mode='list'" />
        <SertifikatPeserta v-else-if="mode == 'sertifikat-peserta'" :bidang="selectedBidang" @close="mode='list'" />
    </Transition> 
</Dash>
</template>

<style scoped>
.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}
</style>