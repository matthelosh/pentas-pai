<script setup>
import { usePage } from '@inertiajs/vue3';

// const $page = usePage()
</script>

<template>
    <div class="kop grid grid-cols-6 border-double border-b-4 border-gray-800 py-4">
        <div class="logo-kab col-span-1 flex justify-center items-center h-full">
            <img src="/img/malangkab.png" alt="Logo KKG" class="flex-grow-1 h-24 print:h-20">
        </div>
        <div class="identitas col-span-4 text-center">
            <h5 class="text-xl print:text-sm font-bold print:m-0">KORWIL DINAS PENDIDIKAN KECAMATAN WAGIR</h5>
            <h4 class="text-xl font-bold print:m-0 print:leading-5">KELOMPOK KERJA GURU PAI (KKG-PAI)</h4>
            <h3 class="text-xl font-bold print:m-0 print:leading-5">PANITIA {{ $page.props.lomba.label.toUpperCase() }}</h3>
            <p class="print:leading-5 print:text-xs">Sekretariat: {{ $page.props.lomba.sekolah.nama }}, {{ $page.props.lomba.sekolah.alamat }}, Kec. Wagir</p>
            <p class="print:leading-5 print:text-xs">CP.: +62 815-5582-1010 (Ketua Panpel), Info: https://pentaspais.kkgpaiwagir.or.id</p>

        </div>
        <div class="logo-kkg col-span-1 flex justify-center items-center h-full">
            <img src="/img/kkg.png" alt="Logo KKG" class="h-24 print:h-20">
        </div>
    </div>
</template>