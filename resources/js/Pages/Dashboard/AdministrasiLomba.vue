<script setup>
import { ref, defineAsyncComponent } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiHumanMale, mdiHumanFemale, mdiHumanMaleFemale, mdiChevronDoubleDown, mdiChevronDoubleUp } from '@mdi/js';
import * as _ from 'lodash-es';

import Dash from '@/Layout/Dash.vue';
import { computed } from 'vue';

const page = usePage()

const KartuPeserta = defineAsyncComponent(() => import('@/Components/Peserta/KartuPeserta.vue'))
const RekapPeserta = defineAsyncComponent(() => import('@/Components/Peserta/RekapPeserta.vue'))
const SertifikatPeserta = defineAsyncComponent(() => import('@/Components/Peserta/SertifikatPeserta.vue'))

const FormNilai = defineAsyncComponent(() => import('@/Components/Lomba/FormNilai.vue'))

const mode = ref('list')
const contentShow = ref(false)
const toggleContent = (e) => {
    // contentShow.value = !contentShow.value
    const button = e.target.closest("button")
    const card = e.target.closest(".card")
    button.classList.toggle('rotate-180')
    card.querySelector(".content").classList.toggle("flex")
    card.querySelector(".content").classList.toggle("hidden")
    card.classList.toggle("h-12")
    // card.classList.toggle("z-10")
    // card.classList.toggle("left-0")
    // card.classList.toggle("top-0")
    // card.classList.toggle("bottom-0")
    // console.log(e.target.closest('button'))
}

const bidangs = computed(() => {
const datas = page.props.lomba.bidangs;
return _.chunk(datas, 2)
})

const selectedBidang = ref(null)
const kartuPeserta = async(bidang) => {
    mode.value = 'kartu-peserta'
    selectedBidang.value = bidang
}

const formNilai = async(bidang) => {
    mode.value= 'form-nilai'
    selectedBidang.value = bidang
}

</script>

<template>
<Head title="Administrasi Lomba" />
<Dash title="Administrasi Lomba">
    <Transition name="slide-fade">
        <div class="content relative w-full" v-if="mode == 'list'">
            <h1 class=" text-center md:my-4 font-bold tracking-wider text-white drop-shadow text-3xl ">
                <span>
                    Adminstrasi Lomba <br>
                </span>
            </h1>
            
            <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-3 items-start mt-8">
                <div class="grid gap-3" v-for="(cols, c) in bidangs" :key="c">
                    <div 
                        class="card w-full bg-white h-12 rounded-xl overflow-hidden"
                        v-for="(bidang,b) in cols"
                        :key="b" 
                    >
                        <div class="card-toolbar w-full flex items-center justify-between p-3 bg-teal-600 text-white">
                            <span>
                                {{ bidang.label }}
                            </span>
                            <div class="toolbar-items flex items-center">
                                <button @click="toggleContent($event)" class="btnChevron hover:border border-gray-50 rounded-full">
                                    <SvgIcon type="mdi" :path="mdiChevronDoubleDown" class=" duration-500" />
                                </button>
                            </div>
                        </div>
                        <div class="content card-content bg-white flex-col gap-2 hidden p-3 duration-500 transition-all">
                            <button class="bg-teal-600 border border-teal-400 shadow py-1 px-3 rounded-full hover:bg-sky-400 hover:shadow-md active:bg-sky-300 hover:text-white duration-150 text-teal-50" @click="formNilai(bidang)">
                                Form Nilai
                            </button>
                            
                            <button class="bg-teal-600 border border-teal-400 shadow py-1 px-3 rounded-full hover:bg-sky-400 hover:shadow-md active:bg-sky-300 hover:text-white duration-150 text-teal-50" @click="sertifikatPeserta(bidang)">
                                Sertifikat Peserta
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <FormNilai v-else-if="mode == 'form-nilai'" :bidang="selectedBidang" @close="mode='list'" />
        <KartuPeserta v-else-if="mode == 'kartu-peserta'" :bidang="selectedBidang" @close="mode='list'" />
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