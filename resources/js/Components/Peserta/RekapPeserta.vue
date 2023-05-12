<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import * as _ from 'lodash-es';
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiClose } from '@mdi/js';

const items = ref([])
const list = async () => {
    await axios.post(route('rekap'))
            .then(res => {
                items.value = res.data.sekolahs
            })
}

const perBidangs = (pesertas) => {
    return _.groupBy(pesertas, 'lomba_id')
}

onMounted(() => {
    list()
})
</script>

<template>

<div class="w-full bg-white">
    <Head title="Rekapitulasi Peserta" />
    <div class="toolbar p-3 flex items-center justify-between">
        Rekapitulasi Peserta
        <div class="toolbar-items flex items-center">
            <button class="rounded-full" @click="$emit('close')">
                <SvgIcon type="mdi" :path="mdiClose" :size="28" class="text-red-400" />
            </button>
        </div>
    </div>
    <div class="content">
        <table class="border border-separate border-spacing-1 w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-black px-2 py-1">No</th>
                    <th class="border border-black px-2 py-1">Sekolah</th>
                    <th class="border border-black px-2 py-1">Peserta</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(data, d) in items" class=" break-inside-avoid-page">
                    <td class="border border-black w-[5%] text-center">{{ d+1 }}</td>
                    <td class="border border-black w-[25%]">{{ data.nama }}</td>
                    <td class="border border-black p-1 text-cent">
                        <span class="w-full flex my-2 gap-2 border" v-for="(peserta, pe) in perBidangs(data.pesertas)" :key="pe" >
                            <div class="bg-gray-50 p-2 w-[30%] flex items-center">{{ peserta ? peserta[0].bidangs[0].label: '' }}</div>
                            <div class="bg-teal-50 w-[70%] flex items-center px-2 flex-grow-1">
                                <ul class="w-full" v-if="peserta">
                                    <li v-for="(item, it) in peserta" :key="it">
                                        {{ it+1 }}. {{ item.nama }} [ NISN: {{ item.nisn }} ]
                                    </li>
                                </ul>
                            </div>
                        </span>
                        <!-- {{ perBidangs(data.pesertas) }} -->
                        <!-- <tr v-for="(peserta, pe) in perBidangs(data.pesertas)" :key="pe" class="w-[100%] block">
                            <td class="border border-black w-[40%]">{{ peserta ? peserta[0].bidangs[0].label: '' }}</td>
                            <td class="border border-black w-[60%]">
                                <ul>
                                    <li v-for="(item, it) in peserta">
                                    {{ item.nama }}</li>
                                </ul>
                            </td>
                        </tr> -->
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</template>