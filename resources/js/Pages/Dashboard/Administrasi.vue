<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, Transition, TransitionGroup } from 'vue';
import Dash from '@/Layout/Dash.vue';
import Kartu from '@/Components/Peserta/Kartu.vue'
import CetakKartu from '@/Components/Peserta/CetakKartu.vue';

const mode = ref('list')
const dialog = ref(false)
const selectedLomba = ref(null)

const showContestantCard = () => {
  dialog.value = true
}

const cetakKartu = (lomba) => {
  // console.log(lomba)
  dialog.value = false
  mode.value = 'cetak-kartu'
  selectedLomba.value = lomba
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
              <button class="bg-sky-800 text-white py-1 px-3  hover:bg-teal-500 duration-200 transition-all rounded mx-1 hover:shadow-lg">Presensi</button>
            </div>
            <div class="bg-white">rer</div>
            <div class="bg-white">dfg</div>
            <div class="bg-white">dfdf</div>
        </div>
        <Kartu v-if="dialog" @close="dialog=false" @cetakKartu="cetakKartu($event, lomba)"/>
        <CetakKartu :lomba="selectedLomba" v-if="mode == 'cetak-kartu'" @close="mode = 'list'" />
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