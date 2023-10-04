<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiClose } from '@mdi/js';

onMounted(() => {
    list()
})
const datas = ref([])

const list = async () => {
    await axios.post(route('panitia.index'))
                .then(res => {
                    datas.value = res.data.panitias
                })
}
</script>

<template>
<div class="content w-full bg-white">
    <Head title="Presensi Panitia" />
    <div class="toolbar h-12 px-2 flex items-center justify-between print:hidden shadow-lg">
        <div class="toolbar-title">
            Presensi Panitia
        </div>
        <div class="toolbar-items flex items-center gap-2">
            <SvgIcon type="mdi" :path="mdiClose" class=" w-10 text-red-600 hover:text-red-800 active:text-orange-600 rounded-full cursor-pointer" @click="$emit('close')" />
        </div>
    </div>
    <div class="content-body p-2">
        <table class="w-full border border-collapse border-black">
            <caption>Presensi Panitia {{ $page.props.lomba.label }}</caption>
            <thead>
                <tr>
                    <th class="py-2 px-3 border border-black">No</th>
                    <th class="py-2 px-3 border border-black">Nama</th>
                    <th class="py-2 px-3 border border-black">Jabatan</th>
                    <th class="py-2 px-3 border border-black">Tanda Tangan</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(data,d) in datas" :key="d">
                    <td class="border border-black text-center p-2 w-[5%]">{{ d+1 }}</td>
                    <td class="border border-black p-2">{{ data.guru.nama }}</td>
                    <td class="border border-black p-2">{{ data.jabatan }}</td>
                    <td class="border border-black p-2 w-[30%]">
                        <span class="text-gray-300 text-xs">{{ d+1 }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
</div>    
</template>