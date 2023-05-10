<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, Transition, TransitionGroup } from 'vue';
import Dash from '@/Layout/Dash.vue';
import Kartu from '@/Components/Peserta/Kartu.vue'
import CetakKartu from '@/Components/Peserta/CetakKartu.vue';
import PresensiPeserta from '@/Components/Peserta/PresensiPeserta.vue'

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

const cetak = (args) => {
  console.log(args.lomba)
  // alert(dokumen)
  dialog.value = false
  // dokumen.value = 'kartu-peserta'
  mode.value = args.dokumen
  selectedLomba.value = args.lomba
}
</script>

<template>
<Head title="Administrasi Lomba" />
<Dash>
    <transition-group name="slide-fade">
        <div class="w-full h-full grid md:grid-cols-4 gap-3" v-if="mode == 'list'">
            <div class="bg-white kartu-peserta rounded shadow p-3">
              <h3>Administrasi Peserta</h3>
              <button class="bg-sky-600 text-white py-1 px-3 rounded hover:bg-teal-500 duration-200 transition-all mx-1 hover:shadow-lg" @click="showContestantCard">Kartu Peserta</button>
              <button class="bg-sky-800 text-white py-1 px-3  hover:bg-teal-500 duration-200 transition-all rounded mx-1 hover:shadow-lg" @click="showPresensiPeserta">Presensi</button>
            </div>
            <div class="bg-white kartu-peserta rounded shadow p-3">
              <h3>Administrasi Lomba</h3>
              <button class="bg-sky-600 text-white py-1 px-3 rounded hover:bg-teal-500 duration-200 transition-all mx-1 hover:shadow-lg" @click="showContestantCard">Form Nilai</button>
              <button class="bg-sky-800 text-white py-1 px-3  hover:bg-teal-500 duration-200 transition-all rounded mx-1 hover:shadow-lg">Sertifikat</button>
            </div>
            <div class="bg-white kartu-peserta rounded shadow p-3">
              <h3>Administrasi Panitia</h3>
              <button class="bg-sky-600 text-white py-1 px-3 rounded hover:bg-teal-500 duration-200 transition-all mx-1 hover:shadow-lg" @click="showContestantCard">
                Sertifikat
              </button>
              <button class="bg-sky-800 text-white py-1 px-3  hover:bg-teal-500 duration-200 transition-all rounded mx-1 hover:shadow-lg">Kartu</button>
            </div>
            <div class="bg-white">dfdf</div>
        </div>
        <Kartu v-if="dialog" :dokumen="dokumen" @close="dialog=false" @cetakKartu="cetak"/>
        <CetakKartu :lomba="selectedLomba" v-if="mode == 'kartu-peserta'" @close="mode = 'list'" />
        <PresensiPeserta :lomba="selectedLomba" v-if="mode == 'presensi-peserta'" @close="mode = 'list'" />
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
  transform: translateX(20px);
  opacity: 0;
}
</style>