<script setup>
import { ref, defineAsyncComponent } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import { mdiAlertCircle } from '@mdi/js';
import SvgIcon from '@jamescoyle/vue-icon';
const Front = defineAsyncComponent(() => import('@/Layout/Front.vue'))
</script>

<template>
<Head title="Mendaftar Lomba" />
<Front>
    <div class="w-full h-[90vh] md:h-[80vh] flex items-center justify-center">
        <div class="bg-white w-full md:w-2/4 rounded-xl p-6 shadow">
            <SvgIcon type="mdi" :path="mdiAlertCircle" size="92" class="text-orange-600 mx-auto drop-shadow-md animate-bounce" />
            <h1 class="text-center text-4xl animate-pulse">Formulir pendaftaran hanya bisa diakses oleh GPAI masing-masing sekolah.</h1>
        </div>
    </div>
</Front>
</template>