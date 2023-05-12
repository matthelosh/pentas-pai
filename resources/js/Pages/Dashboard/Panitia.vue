<script setup>
import Dash from '@/Layout/Dash.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const $page = usePage();
</script>

<template>
<Head title="Data Panitia" />
<Dash>
    <h1>Data Panitia</h1>
    <div class="table table-responsive w-full">
        <table class="border border-collapse w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-3">No</th>
                    <th class="py-2 px-3">NIP</th>
                    <th class="py-2 px-3">Nama</th>
                    <th class="py-2 px-3">JK</th>
                    <th class="py-2 px-3">Sekolah</th>
                    <th class="py-2 px-3">Jabatan</th>
                </tr>
            </thead>
            <tbody>
                <tr class="odd:bg-gray-50" v-for="(guru,g) in $page.props.gurus" :key="guru">
                    <td class="text-center py-1 px-3">{{ g+1 }}</td>
                    <td class="py-1 px-3">{{ guru.nip }}</td>
                    <td class="py-1 px-3">{{ guru.nama }}</td>
                    <td class="py-1 px-3">{{ guru.jk }}</td>
                    <td class="py-1 px-3">{{ guru.sekolah ? guru.sekolah.nama : '-' }}</td>
                    <td class="py-1 px-3">{{ guru.panitia ? guru.panitias.jabatan : '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</Dash>
</template>