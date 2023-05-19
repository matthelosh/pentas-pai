<script setup>
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiLoading } from '@mdi/js';

const props = defineProps({
    show: false
})
</script>

<template>
    <div class="top-0 right-0 bottom-0 left-0 fixed bg-gray-800 bg-opacity-70 flex items-center justify-center z-50">
        <div class="text-center">
            <SvgIcon type="mdi" :path="mdiLoading" class="text-white animate-spin mx-auto" size="96" />
            <h1 class="text-center text-white tetx-4xl animate-pulse">Tunggu Sebentar</h1>
        </div>
    </div>
</template>