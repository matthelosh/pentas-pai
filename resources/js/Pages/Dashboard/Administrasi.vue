<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { ref, TransitionGroup, computed, defineAsyncComponent } from 'vue';
import Dash from '@/Layout/Dash.vue';
// import Kartu from '@/Components/Kartu.vue'
const Kartu = defineAsyncComponent(() => import('@/Components/Kartu.vue'))
const CetakKartu = defineAsyncComponent(() => import('@/Components/Peserta/CetakKartu.vue'));
const PresensiPeserta = defineAsyncComponent(() => import('@/Components/Peserta/PresensiPeserta.vue'))
const Surat = defineAsyncComponent(() => import('@/Components/Panitia/Surat.vue'))
const RekapPeserta = defineAsyncComponent(() => import('@/Components/Peserta/RekapPeserta.vue'))
const KartuPanitia = defineAsyncComponent(() => import('@/Components/Panitia/KartuPanitia.vue'))
const PresensiPanitia = defineAsyncComponent(() => import('@/Components/Panitia/PresensiPanitia.vue'))
const FormNilai = defineAsyncComponent(() => import('@/Components/Lomba/FormNilai.vue'))
const PiagamJuara = defineAsyncComponent(() => import('@/Components/Lomba/PiagamJuara.vue'))
const DataJuara = defineAsyncComponent(() => import('@/Components/Lomba/DataJuara.vue'))
const SertifikatPeserta = defineAsyncComponent(() => import('@/Components/Peserta/SertifikatPeserta.vue'))

const mode = ref('list')
const dialog = ref(false)
const selectedLomba = ref(null)
const dokumen = ref(null)

const page = usePage()

const showDialog = (doc) => {
  dialog.value = true
  dokumen.value = doc
  // selectedLomba.value = args.lomba
}


const cetak = (args) => {
  dialog.value = false
  mode.value = args.dokumen
  selectedLomba.value = args.lomba
}
const isAdmin = computed(() => {
  return page.props.auth.user.level == 'admin'
})
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
              <div class="toolbar grid grid-cols-1 gap-2 p-3">
                <button class="bg-sky-600 text-white py-1 px-3 rounded hover:bg-teal-500 duration-200 transition-all hover:shadow-lg" @click="showDialog('kartu-peserta')" v-if="isAdmin">Kartu Peserta</button>
                <button class="bg-sky-800 text-white py-1 px-3  hover:bg-teal-500 duration-200 transition-all rounded hover:shadow-lg" @click="showDialog('presensi-peserta')" v-if="isAdmin">Presensi</button>
                <button class="bg-sky-800 text-white py-1 px-3  hover:bg-teal-500 duration-200 transition-all rounded hover:shadow-lg" @click="showDialog('rekap')" v-if="isAdmin">Rekap</button>
                <button class="bg-sky-800 text-white py-1 px-3  hover:bg-teal-500 duration-200 transition-all rounded hover:shadow-lg sertifikat" @click="showDialog('sertifikat-peserta')" >Sertifikat Peserta</button>
              </div>
            </div>
            <div class="bg-white kartu-peserta rounded shadow">
              <h3  class="w-full bg-gray-200 p-2 font-bold">Administrasi Lomba</h3>
              <div class="toolbar grid grid-cols-1 gap-2 p-3">
                <button class="bg-sky-600 text-white py-1 px-3 rounded hover:bg-teal-500 duration-200 transition-all mx-1 hover:shadow-lg active:bg-orange-400" @click="showDialog('form-nilai')" v-if="isAdmin">Form Nilai</button>
                <button class="bg-sky-800 text-white py-1 px-3  hover:bg-teal-500 duration-200 transition-all rounded mx-1 hover:shadow-lg active:bg-orange-400" @click="showDialog('piagam-juara')">Piagam Juara</button>
                <button class="bg-sky-800 text-white py-1 px-3  hover:bg-teal-500 duration-200 transition-all rounded mx-1 hover:shadow-lg active:bg-orange-400" @click="mode = 'data-juara'">Data Juara</button>
              </div>
            </div>
            <div class="bg-white kartu-peserta rounded shadow">
              <h3  class="w-full bg-gray-200 p-2 font-bold">Administrasi Panitia</h3>
              <div class="toolbar grid grid-cols-1 gap-2 p-3">
                <button class="bg-sky-600 text-white py-1 px-3 rounded hover:bg-teal-500 duration-200 transition-all mx-1 hover:shadow-lg " @click="mode='sertifikat-panitia'">
                  Sertifikat Panitia
                </button>
                <button class="bg-sky-800 text-white py-1 px-3  hover:bg-teal-500 duration-200 transition-all rounded mx-1 hover:shadow-lg" @click="mode = 'kartu-panitia'" v-if="isAdmin">Kartu Panitia</button>
                <button class="bg-sky-800 text-white py-1 px-3  hover:bg-teal-500 duration-200 transition-all rounded mx-1 hover:shadow-lg" @click="mode='persuratan'" v-if="isAdmin">Persuratan</button>
                <button class="bg-sky-800 text-white py-1 px-3  hover:bg-teal-500 duration-200 transition-all rounded mx-1 hover:shadow-lg active:bg-orange-300" @click="mode = 'presensi-panitia'" v-if="isAdmin">Presensi</button>
                </div>
            </div>
            <div class="bg-white">dfdf</div>
        </div>
        
        <CetakKartu :lomba="selectedLomba" v-if="mode == 'kartu-peserta'" @close="mode = 'list'" />
        <PresensiPeserta :lomba="selectedLomba" v-if="mode == 'presensi-peserta'" @close="mode = 'list'" />
        <FormNilai :lomba="selectedLomba" v-if="mode == 'form-nilai'" @close="mode = 'list'" />
        <Surat v-if="mode == 'persuratan'" @close="mode = 'list'" />
        <RekapPeserta v-if="mode == 'rekap'" @close="mode = 'list'" />
        <KartuPanitia v-if="mode == 'kartu-panitia'" @close="mode = 'list'" />
        <PresensiPanitia v-if="mode == 'presensi-panitia'" @close="mode = 'list'" />
        <PiagamJuara v-if="mode == 'piagam-juara'" @close="mode = 'list'" :lomba="selectedLomba" />
        
    </transition-group>
    <DataJuara v-if="mode == 'data-juara'" @close="mode = 'list'" :lomba="selectedLomba" />
    <SertifikatPeserta v-if="mode == 'sertifikat-peserta'" @close="mode = 'list'" :lomba="selectedLomba" />
    
</Dash>

<Kartu v-if="dialog" :dokumen="dokumen" @close="dialog=false" @cetakKartu="cetak"/>
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