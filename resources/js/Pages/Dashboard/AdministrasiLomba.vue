<script setup>
import { ref, defineAsyncComponent } from 'vue';
import { Head } from '@inertiajs/vue3';

const Dash = defineAsyncComponent(() => import('@/Layout/Dash.vue'))
</script>

<template>
<Head title="Administrasi Lomba" />
<Dash title="Administrasi Lomba">
    <div class="w-full grid  grid-cols-1 md:grid-cols-3 gap-4 py-4 md:pt-0">
        <div class="w-full bg-white rounded-xl overflow-hidden shadow" v-for="i in 9" :key="i">
            <div class="toolbar w-full h-12 bg-teal-600 text-white flex items-center justify-between p-3 shadow">
                <h1>Administrasi Lomba</h1>
                <div class="toolbar-items flex items-center">

                </div>
            </div>
            <div class="content bg-white w-full p-3">
                <article>Tes Saja</article>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur dolores error cupiditate esse delectus excepturi accusantium eos laboriosam beatae quidem veniam nam doloremque facere, ex, aliquam, vitae quam sequi nisi!</p>
            </div>
        </div>
    </div>
</Dash>
</template>