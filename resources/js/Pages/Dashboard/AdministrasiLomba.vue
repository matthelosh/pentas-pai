<script setup>
import { ref, defineAsyncComponent } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiHumanMale, mdiHumanFemale, mdiHumanMaleFemale, mdiChevronDoubleDown, mdiChevronDoubleUp } from '@mdi/js';

import Dash from '@/Layout/Dash.vue';

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
</script>

<template>
<Head title="Administrasi Lomba" />
<Dash title="Administrasi Lomba">
    <div class="w-full grid  grid-cols-1 md:grid-cols-3 gap-4 py-4 md:pt-0">
        
        <div class="card w-full bg-white rounded-xl overflow-hidden shadow" v-for="(bidang,b) in $page.props.lomba.bidangs" :key="b">
            <div class="toolbar w-full h-12 bg-teal-600 text-white flex items-center justify-between p-3 shadow">
                <h1>
                    <SvgIcon type="mdi" :path="bidang.kelompok == 'putra' ? mdiHumanMale : (bidang.kelompok == 'putri' ? mdiHumanFemale : mdiHumanMaleFemale)" class="inline" />
                    {{ bidang.label }} {{ bidang.kategori }} {{ bidang.kelompok }}
                </h1>
                <div class="toolbar-items flex items-center">
                    <button @click="toggleContent($event)" class="btnChevron">
                        <SvgIcon type="mdi" :path="mdiChevronDoubleDown" class=" duration-500" />
                    </button>
                </div>
            </div>
            <div class="content bg-white flex-col gap-2 hidden p-3 duration-500 transition-all">
                <button class="bg-gray-300 border border-teal-400 shadow py-1 px-3 rounded-full hover:bg-sky-400 hover:shadow-md active:bg-sky-300 hover:text-white duration-150 text-gray-950">
                    Presensi Peserta
                </button>
                <button class="bg-gray-300 border border-teal-400 shadow py-1 px-3 rounded-full hover:bg-sky-400 hover:shadow-md active:bg-sky-300 hover:text-white duration-150 text-gray-950">
                    Form Nilai
                </button>
                <button class="bg-gray-300 border border-teal-400 shadow py-1 px-3 rounded-full hover:bg-sky-400 hover:shadow-md active:bg-sky-300 hover:text-white duration-150 text-gray-950">
                    Berita Acara
                </button>
            </div>
        </div>
        
    </div>
</Dash>
</template>