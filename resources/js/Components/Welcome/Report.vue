<script setup>
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiClose } from '@mdi/js';
import axios from 'axios';
import { ref, onMounted, computed } from 'vue';
import * as _ from 'lodash-es';
import { watch } from 'vue';
import { ArrowPathIcon } from '@heroicons/vue/20/solid';

const show = ref(false)
const title = ref('')
const data = ref(null)
const kode = ref(null)
const bidangs = ref([])
const jumlah = ref(0)
const perBidangs = ref([])
const loading = ref(true)

const open = (message, data) => {
    show.value = true
    title.value = message
    kode.value = data.id
    
    listSekolah(data.id)
}

// const items = computed(() => {
//     return _.groupBy(data.value.pesertas, 'bidangs.kode')
// })

const listSekolah = async (id) => {
    loading.value = true
    await axios.post(route('sekolah.show', [id]))
                .then(res => {
                    data.value = res.data.sekolah
                    loading.value = false
                    // bidangs.value = _.groupBy(res.data.sekolah.pesertas, 'lomba_id')
                })
    // alert(kode.value)
}

watch(data,(item, oldValue) => {
    jumlah.value = item.bidangs.reduce((ac, cr) => {
        return ac + cr.pesertas.length
    }, 0)
    loading.value = false
})




defineExpose({ open })

onMounted( () => {
    
})
</script>

<template>
<Transition type="fade">
    <div class="report fixed top-0 right-0 bottom-0 left-0 z-50 bg-white overflow-y-auto" v-if="show">
        <div class="report-body w-full min-w-full">
            <div class="report-toolbar p-3 flex justify-between items-center shadow sticky top-0 bg-white z-20">
                {{ title }}
                <div class="toolbar-items flex items-center">
                        <button class="rounded-full bg-red-400 shadow" @click="show = false">
                            <SvgIcon type="mdi" :path="mdiClose" :size="28" class="text-white" />
                        </button>
                </div>
            </div>
            <div class="h-screen w-full flex items-center justify-center" v-if="loading">
                <ArrowPathIcon class="w-28 animate-spin text-teal-600" />
            </div>
            <div class="report-content py-4 md:mx-72 h-[92vh] flex items-center justify-center my-20" v-if="!loading">
                <div>
                    <h3 class="text-center text-gray-600 text-xl">Peserta Yang Terdaftar Bidang Lomba</h3>
                    <h1 class="text-center text-gray-800 text-8xl font-extrabold relative">{{ jumlah }} <small class="text-xl absolute bottom-2 -translate-x-4 text-sky-400 drop-shadow-sm">Pendaftaran</small></h1>
                    <h1 v-if="jumlah == 0" class="text-gray-800">Login dan Daftarkan Peserta Pada Bidang Lomba yang tersedia.</h1>

                    <div class="grid grid-cols-2 border font-extrabold  p-3 rounded" v-for="(bidang, b) in data.bidangs" :key="b" v-show="bidang.pesertas.length > 0">
                        <div class="bg-gray-50 text-teal-800 p-2 flex items-center">
                            <!-- {{ bidang ? bidang[0].bidangs[0].label : ""}} -->
                            {{ bidang.label }}
                        </div>
                        <div class="bg-gray-200 text-gray-800 p-2">
                            <p v-for="(peserta, pt) in bidang.pesertas" :key="pt" class="font-extrabold">
                                {{ peserta.nama }} <span class="text-sky-600 font-bold tracking-wide">[{{ peserta.nisn }}]</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</Transition>
</template>