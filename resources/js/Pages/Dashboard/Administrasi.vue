<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, Transition, TransitionGroup } from 'vue';
import Dash from '@/Layout/Dash.vue';
import Kartu from '@/Components/Kartu.vue'
import CetakKartu from '@/Components/Peserta/CetakKartu.vue';
import PresensiPeserta from '@/Components/Peserta/PresensiPeserta.vue'
import Surat from '@/Components/Panitia/Surat.vue'
import RekapPeserta from '@/Components/Peserta/RekapPeserta.vue';
import KartuPanitia from '@/Components/Panitia/KartuPanitia.vue';

const mode = ref('list')
const dialog = ref(false)
const selectedLomba = ref(null)
const dokumen = ref('')

const showContestantCard = () => {
  dialog.value = true
  dokumen.value = 'kartu-peserta'
}

const showPresensiPeserta = () => {
  dialog.value = true
  dokumen.value = 'presensi-peserta'
}

const showSurat = () => {
  // dialog.value = true
  // alert('hi')
  mode.value = 'persuratan'
  // dokumen.value = 'persuratan'
}

const cetak = (args) => {
  dialog.value = false
  mode.value = args.dokumen
  selectedLomba.value = args.lomba
}

// Rekap
const showRekap = () => {
  mode.value = 'rekap'
}
</script>

<template>
<Head title="Administrasi Lomba" />
<Dash>
    <transition-group name="slide-fade">
        <div class="w-full h-full grid md:grid-cols-4 gap-3" v-if="mode == 'list'">
            <div class="bg-white kartu-peserta rounded shadow">
              <h3 class="w-full bg-gray-200 p-2 font-bold">Administrasi Peserta</h3>
              <div class="toolbar grid grid-cols-2 gap-2 p-3">
                <button class="bg-sky-600 text-white py-1 px-3 rounded hover:bg-teal-500 duration-200 transition-all hover:shadow-lg" @click="showContestantCard">Kartu Peserta</button>
                <button class="bg-sky-800 text-white py-1 px-3  hover:bg-teal-500 duration-200 transition-all rounded hover:shadow-lg" @click="showPresensiPeserta">Presensi</button>
                <button class="bg-sky-800 text-white py-1 px-3  hover:bg-teal-500 duration-200 transition-all rounded hover:shadow-lg" @click="showRekap">Rekap</button>
              </div>
            </div>
            <div class="bg-white kartu-peserta rounded shadow">
              <h3  class="w-full bg-gray-200 p-2 font-bold">Administrasi Lomba</h3>
              <div class="toolbar grid grid-cols-2 gap-2 p-3">
                <button class="bg-sky-600 text-white py-1 px-3 rounded hover:bg-teal-500 duration-200 transition-all mx-1 hover:shadow-lg" @click="showContestantCard">Form Nilai</button>
                <button class="bg-sky-800 text-white py-1 px-3  hover:bg-teal-500 duration-200 transition-all rounded mx-1 hover:shadow-lg">Sertifikat</button>
              </div>
            </div>
            <div class="bg-white kartu-peserta rounded shadow">
              <h3  class="w-full bg-gray-200 p-2 font-bold">Administrasi Panitia</h3>
              <div class="toolbar grid grid-cols-2 gap-2 p-3">
                <button class="bg-sky-600 text-white py-1 px-3 rounded hover:bg-teal-500 duration-200 transition-all mx-1 hover:shadow-lg">
                  Sertifikat
                </button>
                <button class="bg-sky-800 text-white py-1 px-3  hover:bg-teal-500 duration-200 transition-all rounded mx-1 hover:shadow-lg" @click="mode = 'kartu-panitia'">Kartu Panitia</button>
                <button class="bg-sky-800 text-white py-1 px-3  hover:bg-teal-500 duration-200 transition-all rounded mx-1 hover:shadow-lg" @click="showSurat">Persuratan</button>
                </div>
            </div>
            <div class="bg-white">dfdf</div>
        </div>
        <Kartu v-if="dialog" :dokumen="dokumen" @close="dialog=false" @cetakKartu="cetak"/>
        <CetakKartu :lomba="selectedLomba" v-if="mode == 'kartu-peserta'" @close="mode = 'list'" />
        <PresensiPeserta :lomba="selectedLomba" v-if="mode == 'presensi-peserta'" @close="mode = 'list'" />
        <Surat v-if="mode == 'persuratan'" @close="mode = 'list'" />
        <RekapPeserta v-if="mode == 'rekap'" @close="mode = 'list'" />
        <KartuPanitia v-if="mode == 'kartu-panitia'" @close="mode = 'list'" />
    </transition-group>
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
  transform: translateY(20px);
  opacity: 0;
}
</style>