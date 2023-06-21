<script setup>
import { Head, usePage } from '@inertiajs/vue3';

import Dash from '@/Layout/Dash.vue'
import { defineAsyncComponent, ref } from 'vue';

const Editor = defineAsyncComponent(() => import('@/Components/General/Editor.vue'))
const content= ref('Tulis Isi Surat')
</script>

<template>
<Head title="Administrasi Surat" />
<Dash title="Administrasi Surat">
    <h1>Adminstrasi Surat</h1>
    <Editor :text="content" />
</Dash>
</template>