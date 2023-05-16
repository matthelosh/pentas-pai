<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import { XCircleIcon } from '@heroicons/vue/20/solid';
import * as _ from 'lodash-es';

const props = defineProps({
    lomba:Object
})

const kriterias = ref([
    {
        lomba: 'mtq',
        aspeks: ['Tajwid', 'Fashahah', 'Suara', 'Lagu']
    },
    {
        lomba: 'mhq',
        aspeks: ['Tajwid','Fashahah','Hafalan']
    },
    {
        lomba: 'pdc',
        aspeks: ['Retorika', 'Penguasaan Materi', 'Gaya Bahasa', 'Ekspresi']
    },
    {
        lomba: 'adz',
        aspeks: ['Adab', 'Lagu', 'Penghayatan', 'Makhraj dan Tajwid']
    },
    {
        lomba: 'bjr',
        aspeks: ['Adab', 'Vokal', 'Syair', 'Musik']
    }
])

const bidang = computed(() => {
    return kriterias.value.filter(item => item.lomba == props.lomba.kode)
})

const pesertas = computed(() => {
    if(props.lomba.kode == 'bjr' || props.lomba.kode == 'lcc') {
        return _.groupBy(props.lomba.pesertas, 'sekolah.nama')
    } else {
        return props.lomba.pesertas
    }
})

const banjari = (kode) => {
    return ['bjr'].includes(kode)   
}

</script>

<template>
<div class="w-full bg-white">
    <Head title="Form Nilai" />
    <div class="toolbar bg-gray-50 h-12 flex items-center justify-between p-3 shadow print:hidden">
        <div class="toolbar-title">
            Formulir Nilai {{ props.lomba.label }}
        </div>
        <div class="toolbar-items flex items-center gap-1">
            <XCircleIcon class="text-red-600 h-8 cursor-pointer" @click="$emit('close')" />
        </div>
    </div>
    <div class="content w-full px-3">
        <div class="form-nilai break-after-page">
            <table class="table w-full border border-black border-collapse table-auto">
                <caption class="my-4 print:mt-0">
                    <h1 class="text-center text-xl">Form Nilai Lomba {{ props.lomba.label }}</h1>
                    <h2 class="text-center text-2xl">{{ lomba.label }}</h2>
                </caption>
                <thead>
                    <tr>
                        <th class="border border-black py-1 print:py-0 px-3" rowspan="2">{{ banjari(lomba.kode) ? 'Grup/Sekolah' : 'No' }}</th>
                        <th class="border border-black py-1 print:py-0 px-3" rowspan="2" v-if="!banjari(lomba.kode)">NISN</th>
                        <th class="border border-black py-1 print:py-0 px-3" rowspan="2">{{ banjari(lomba.kode) ? 'Peserta' : 'Nama' }}</th>
                        <th class="border border-black py-1 print:py-0 px-3" :colspan="banjari(lomba.kode) ? '0' : bidang[0].aspeks.length">Skor</th>
                        <th class="border border-black py-1 print:py-0 px-3" rowspan="2">Nilai</th>
                    </tr>
                    <tr>
                        <th v-for="(aspek, a) in bidang[0].aspeks" :key="a" class="border border-black py-1 px-2 w-10 break-words">{{ aspek }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(peserta,p) in pesertas" class=" odd:bg-gray-50">
                        <td class="text-center py-1 px-3 border border-black">{{ banjari(lomba.kode) ? p : p+1 }}</td>
                        <td class="text-center py-1 px-3 border border-black" v-if="!banjari(lomba.kode)">{{ peserta.nisn }}</td>
                        <td class="py-1 px-3 border border-black">
                            <ul v-if="banjari(lomba.kode)">
                                <li v-for="(pes, i) in peserta" :key="i">{{ i+1 }}. {{ pes.nama }}</li>
                            </ul>
                            <span v-else>{{ peserta.nama }} <small class=" font-bold">[{{ peserta.sekolah.nama }}]</small></span>
                        </td>
                        <td class="py-1 px-3 border border-black" v-for="i in bidang[0].aspeks" :key="i"></td>
                        <td class="py-1 px-3 border border-black"></td>
                    </tr>
                </tbody>
            </table>

            <div class="ttd w-full grid grid-cols-3 mt-2">
                <div >
                    <p>&nbsp;</p>
                    <p class="text-center">Koordinator {{ lomba.label }}</p>

                    <p class="underline mt-16 text-center">.......................................................................</p>
                    <p>NIP.</p>
                </div>
                <div></div>
                <div>
                    <p class="text-center">Wagir, 16 Mei 2023</p>
                    <p class="text-center">Juri {{ lomba.label }}</p>

                    <p class="underline mt-16 text-center">.......................................................................</p>
                    <p>NIP.</p>
                </div>
            </div>
        </div>
        <div class="berita-acara">
            <h1 class="text-center text-lg">BERITA ACARA PELAKSANAAN</h1>
            <h2 class="text-center text-xl">BIDANG LOMBA {{ props.lomba.label }}</h2>

            <p class="mt-10">Pada hari ini _____________, tanggal ___, bulan ________________, tahun _________ kami Koordinator bidang lomba {{ props.lomba.label }} {{$page.props.lomba.label}} beserta juri yang bertugas telah melaksanakan dengan keterangan sebagai berikut:</p>
            <table>
                <tr>
                    <td>Bidang Lomba</td><td>:</td><td>______________________</td>
                </tr>
                <tr>
                    <td>Dimulai Pukul</td><td>:</td><td>______________________</td>
                </tr>
                <tr>
                    <td>Selesai Pukul</td><td>:</td><td>______________________</td>
                </tr>
                <tr>
                    <td>Jumlah Peserta</td><td>:</td><td>______________________</td>
                </tr>
                <tr>
                    <td>Jumlah Hadir</td><td>:</td><td>______________________</td>
                </tr>
                <tr>
                    <td>Jumlah Tidak Hadir</td><td>:</td><td>______________________</td>
                </tr>
                <tr>
                    <td>Catatan Selama Lomba</td><td>:</td><td>___________________________________________________</td>
                </tr>
            </table>
            <p>dengan hasil berikut</p>
            <table class="border border-black mx-auto my-4">
                <thead>
                    <tr>
                        <th class="border border-black">No</th><th class="border border-black">Juara</th><th class="border border-black px-3">Nama / Regu</th><th class="border border-black px-3">Nilai/ Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-black py-2 px-3">1</td><td class="border border-black py-2 px-3">Juara 1</td><td class="border border-black"></td><td class="border border-black"></td>
                    </tr>
                    <tr>
                        <td class="border border-black py-2 px-3">2</td><td class="border border-black py-2 px-3">Juara 2</td><td class="border border-black"></td><td class="border border-black"></td>
                    </tr>
                    <tr>
                        <td class="border border-black py-2 px-3">3</td><td class="border border-black py-2 px-3">Juara 3</td><td class="border border-black"></td><td class="border border-black"></td>
                    </tr>
                    <tr>
                        <td class="border border-black py-2 px-3">4</td><td class="border border-black py-2 px-3">Juara Harapan 1</td><td class="border border-black"></td><td class="border border-black"></td>
                    </tr>
                    <tr>
                        <td class="border border-black py-2 px-3">5</td><td class="border border-black py-2 px-3">Juara Harapan 2</td><td class="border border-black"></td><td class="border border-black"></td>
                    </tr>
                </tbody>
            </table>
            <p>Demikian berita acara ini dibuat untuk dijadikan maklum.</p>
            <div class="ttd w-full grid grid-cols-3 mt-2">
                <div >
                    <p>&nbsp;</p>
                    <p class="text-center">Koordinator {{ lomba.label }}</p>

                    <p class="underline mt-16 text-center">.......................................................................</p>
                    <p>NIP.</p>
                </div>
                <div></div>
                <div>
                    <p class="text-center">Wagir, 16 Mei 2023</p>
                    <p class="text-center">Juri {{ lomba.label }}</p>

                    <p class="underline mt-16 text-center">.......................................................................</p>
                    <p>NIP.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</template>