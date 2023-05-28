<script setup>
import { Head } from '@inertiajs/vue3';
import Front from '@/Layout/Front.vue';
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiCertificate, mdiMail } from '@mdi/js';
</script>

<template>
    <Head>
        <title>Tentang Kami</title>
    </Head>
    <Front>
        <div class="w-full md:my-8 py-16 md:py-14 relative">
            <div class="w-full md:w-3/4 bg-white rounded-xl overflow-hidden mx-auto  relative">
                <SvgIcon type="mdi" :path="mdiCertificate" class="text-sky-400 absolute -top-16 -right-6 md:-right-8 md:-top-10 drop-shadow-lg"  size="120"  />
                <article class="py-3 px-6">
                    <h1 class="text-2xl font-bold tracking-wide mb-4 mt-2">Tentang Aplikasi Pentas PAI</h1>
                    <p class="my-4 tracking-wide text-justify leading-8">
                        Alhamdulillah, aplikasi ini merupakan bentuk karya inovatif guru Pendidikan Agama Islam Kecamatan Wagir untuk memudahkan pengorganisasian dan pengadministrasian kegiatan lomba Pentas PAI yagn diselenggarakan secara rutin di Wilayah Korwil Dinas Pendidikan Kecamatan Wagir Kabupaten Malang. Dengan aplikasi ini kegiatan operasional lomba yang meliputi registrasi peserta, pencetakan hal-hal adminsitratif seperti kartu peserta, sertifikat, juara, formulir penilaian dan berita acara, sertifikat peserta dan sertifikat panitia dapat dilakukan secara mudah dan sistematis dan terarsip secara digital pada basis data sistem. Sertifikat yang dikeluarkan dilengkapi kode QR yang dapat digunakan untuk memverifikasi keaslian sertifikat, sehingga dapat meminimalisisr pemalsuan. Adminstrasi persuratan panitia juga sudah ada di aplikasi ini, sehingga, kode surat, penomoran dapat tersusun dengan rapi.
                    </p>
                    <p class="my-4 tracking-wide text-justify leading-8">
                        Aplikasi ini juga bisa diadopsi oleh KKG PAI Kecamatan lain. Atau bila dikehendaki dapat dikembangkan lagi untuk Lomba Pentas PAI tingkat Kabupaten. Untuk lebih lanjut dapat menghubungi narahubung <a href="mailto:matthelosh@gmail.com" class="text-orange-400 font-bold underline">DI SINI</a> atau whatsapp <a href="https://wa.me/6285954944407"  class="text-green-400 font-bold underline" target="_blank">DI SINI</a>. 
                    </p>
                </article>
            </div>
        </div>
    </Front>
</template>
