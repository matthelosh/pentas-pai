<script setup>
import {ref} from 'vue';
import Kop from '@/Components/General/Kop.vue';
import moment from 'moment-with-locales-es6'
moment.locale('id')

const props = defineProps({
    surat: Object
})
</script>

<template>
<div class="w-full bg-white px-14 shadow print:shadow-none">
    <Kop />
    <div class="meta mt-2 mb-4">
        <tr>
            <td>No.</td>
            <td>:</td>
            <td>{{ props.surat.kode }}</td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>:</td>
            <td>{{ surat.lampirans  ? surat.lampirans.length : '-'  }} Berkas</td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>:</td>
            <td>{{ props.surat.perihal }}</td>
        </tr>
    </div>

    <div class="penerima mt-2 mb-6">
        <p>Kepada:</p>
        <p>Yth. {{ props.surat.penerima }}</p>
        <p>Di Tempat</p>
    </div>

    <article v-html="surat.content"></article>

    <div class="ttd grid grid-cols-9 mx-8 mt-6 pb-24">
        <div class="ttd-ketua relative col-span-3 print:col-span-4">
            <p>&nbsp;</p>
            <p>Ketua KKG PAI Kec. Wagir</p>

            <img src="/img/ttd-kkg.png" alt="TTD" class="h-16 mx-auto -translate-x-14">
            <p class="underline">Hasan Lutfi, S.Pd., M. PdI.</p>
            <p>NIP. 19760904 200801 1 013</p>
            <img src="/img/stempel.png" alt="Stempel" class=" h-32 absolute top-4 -left-8">
        </div>
        <div class="col-span-3 print:col-span-1">
            &nbsp;
        </div>
        <div class="ttd-sekretaris text-center col-span-3 print:col-span-4">
            <p>Wagir {{ moment(surat.tanggal).format('DD MMM YYYY') }}</p>
            <p>Sekretaris</p>

            <img src="/img/ttd-ketua.png" alt="TTD" class="h-16 mx-auto -translate-x-2">
            <p class="underline">Choiri Mahmudi, S. Ag., M. Pd.</p>
            <p>NIP. 19760115 200501 1 002</p>

        </div>
    </div>
</div>

<div class="lampirans my-8" v-if="surat.lampirans">
    <div class="w-full bg-white px-14 shadow print:break-before-page print:shadow-none" v-for="(lampiran,l) in surat.lampirans" :key="l">
        <h1 class="text-center text-4xl my-4">{{ lampiran.judul }}</h1>
        <article v-html="lampiran.content" id="lampiran-content"></article>
    </div>
</div>
</template>

<style>
#lampiran-content > p {
    /* background: pink; */
    text-align: center;
}


#lampiran-content table {
    width: 100%;
    margin: 20px auto;
    font-size: 1.2rem;
}

#lampiran-content table,
#lampiran-content table th,
#lampiran-content table td
{
    border: 1px solid black;
    border-collapse: collapse;
}
#lampiran-content table th,
#lampiran-content table td {
    padding: 5px 10px;
}
</style>