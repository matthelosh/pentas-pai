<script setup>
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiHeart, mdiHome, mdiLaravel, mdiLoading, mdiVuejs } from '@mdi/js';


</script>
<template>
    <div class="w-full bg-white gap-2 md:flex flex-col items-center justify-between p-3 bg-opacity-90">
        <span>
            &copy; {{ new Date().getFullYear() }} <a href="https://kkgpaiwagir.or.id" class="text-teal-600 border-b border-dashed border-teal-600 pb-1" target="_blank">KKG PAI Kec. Wagir</a>
        </span>
        <span class="flex gap-1">
            Built with 
            <SvgIcon type="mdi" :path="mdiHeart" class="text-red-600 animate-pulse mx-auto" size="24" />
            <SvgIcon type="mdi" :path="mdiLaravel" class="text-red-600  mx-auto" size="24" />
            <SvgIcon type="mdi" :path="mdiVuejs" class="text-teal-600  mx-auto" size="24" />
            by <a href="mailto:matthelosh@gmail.com" class="text-orange-600 font-bold">Mat Soleh</a>
        </span>
    </div>
</template>