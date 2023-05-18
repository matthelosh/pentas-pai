<script setup>
import { defineAsyncComponent, ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import Dash from '@/Layout/Dash.vue';

const componentName = ref('Default')
const compPath = ref('@/Components/Administrasi/Default.vue')

const DefaultComponent = defineAsyncComponent(() => import('@/Components/Administrasi/Default.vue'))
</script>

<template>
<Dash>
    <Head title="Asministrasi" />
    <DefaultComponent />
</Dash>
</template>