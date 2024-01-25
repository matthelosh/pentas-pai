<script setup>
import { ref, defineAsyncComponent, computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiHumanMale, mdiHumanFemale, mdiHumanMaleFemale, mdiChevronDoubleDown, mdiChevronDoubleUp } from '@mdi/js';

const page = usePage()

const mode = ref('list')

const admin = computed(() => page.props.auth.user.level == 'admin')
const KartuPanitia = defineAsyncComponent(() => import('@/Components/Panitia/KartuPanitia.vue'))
const SertifikatPanitia = defineAsyncComponent(() => import('@/Components/Panitia/SertifikatPanitia.vue'))
const PresensiPanitia = defineAsyncComponent(() => import('@/Components/Panitia/PresensiPanitia.vue'))

import Dash from '@/Layout/Dash.vue';

</script>

<template>
<Head title="Administrasi Panitia" />
<Dash title="Administrasi Panitia">
    <Transition name="fade">
        <div class="container w-full p-3" v-if="mode == 'list'">
            <div class="row w-full flex justify-center items-center mb-3">
                <h1 class="text-white drop-shadow text-2xl">Administrasi Panitia</h1>
            </div>
            <div class="row w-full">
                <div class="w-full  grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="card shadow rounded-xl bg-white w-full p-3 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer" @click="mode='kartu-panitia'">
                        Kartu Panitia
                    </div>
                    <div class="card shadow rounded-xl bg-white w-full p-3 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer" @click="mode='presensi-panitia'">
                        Presensi Panitia
                    </div>
                    <div class="card shadow rounded-xl bg-white w-full p-3 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer" @click="mode='sertifikat-panitia'">
                        Sertifikat Panitia
                    </div>
                </div>
            </div>
        </div>
        <KartuPanitia v-else-if="mode =='kartu-panitia'" @close="mode='list'" />
        <PresensiPanitia v-else-if="mode =='presensi-panitia'" @close="mode='list'" />
        <SertifikatPanitia v-else-if="mode =='sertifikat-panitia'" @close="mode='list'" />
        
    </Transition>
</Dash>
</template>

<style scoped>
    .fade-enter-active,
    .fade-leave-active {
        opacity: 0;
        transition: all .35s linear;
    }

    .fade-enter-from,
    .fade-leave-to {
        opacity: 1;
    }
</style>