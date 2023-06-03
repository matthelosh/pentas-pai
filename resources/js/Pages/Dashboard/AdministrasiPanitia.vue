<script setup>
import { ref, defineAsyncComponent, computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiHumanMale, mdiHumanFemale, mdiHumanMaleFemale, mdiChevronDoubleDown, mdiChevronDoubleUp } from '@mdi/js';

const page = usePage()

const admin = computed(() => page.props.auth.user.level == 'admin')

import Dash from '@/Layout/Dash.vue';

</script>

<template>
<Head title="Administrasi Panitia" />
<Dash title="Administrasi Panitia">
    <div class="container w-full p-3">
        <div class="row w-full flex justify-center items-center mb-3">
            <h1 class="text-white drop-shadow text-2xl">Administrasi Panitia</h1>
        </div>
        <div class="row w-full">
            <div class="w-full  grid grid-cols-1 md:grid-cols-3 gap-3">
                <div class="card shadow rounded-xl bg-white w-full p-3 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    Kartu Panitia
                </div>
                <div class="card shadow rounded-xl bg-white w-full p-3 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    Presensi Panitia
                </div>
                <div class="card shadow rounded-xl bg-white w-full p-3 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    Sertifikat Panitia
                </div>
            </div>
        </div>
    </div>
</Dash>
</template>