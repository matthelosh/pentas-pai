<script setup>
import { ref } from 'vue';
import { XCircleIcon } from '@heroicons/vue/20/solid';
import { imgUrl } from '@/Plugins/misc';

const props = defineProps({
    lomba: Object
})

</script>

<template>
<div class="w-full bg-white">
    <div class="w-full bg-white h-12 shadow-lg flex items-center justify-between p-2 border-b-2 border-teal-400 print:hidden">
        Presensi Peserta Lomba {{ props.lomba.label }}
        <div class="toolbar-items flex items-center gap-2">
            <XCircleIcon class="text-red-600 h-6 cursor-pointer" @click="$emit('close')" />
        </div>
    </div>
    
    <div class="table bg-white w-full p-5 shadow-lg print:shadow-none print: print:mt-4">
        <table class="table border border-separate w-10/12 mx-auto break-inside-avoid print:w-full">
            <caption class="text-center">Daftar Hadir Peserta Lomba {{ props.lomba.label }}</caption>
            <thead class="bg-gray-50">
                <tr>
                    <th class="border px-2 py-3">No</th>
                    <th class="border px-2 py-3">Nama</th>
                    <th class="border px-2 py-3">NISN</th>
                    <th class="border px-2 py-3">JK</th>
                    <th class="border px-2 py-3">Sekolah</th>
                    <th class="border px-2 py-3">TTD / Paraf</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(peserta,p) in lomba.pesertas" :key="p">
                    <td class="border px-2 py-2 text-center">{{ p+1 }}</td>
                    <td class="border px-2 py-2">
                        {{ peserta.nisn }}
                    </td>
                    <td class="border px-2 py-2 flex items-center h-full">
                        <span>
                            <img :src="imgUrl(peserta.foto)" alt="Foto" class="h-8 rounded-full aspect-square object-cover mr-2" />
                        </span>
                        {{ peserta.nama }}</td>
                    <td class="border px-2 py-2">{{ peserta.jk }}</td>
                    <td class="border px-2 py-2">{{ peserta.sekolah.nama }}</td>
                    <td class="border px-2 py-2 w-[150px] align-text-top">
                        <span class="text-xs text-gray-400">{{ p+1 }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</template>