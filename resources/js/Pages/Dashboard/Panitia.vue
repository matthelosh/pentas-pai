<script setup>
import Dash from '@/Layout/Dash.vue';
import { Head, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref } from 'vue';

const jabatans = ref([
    'Penasehat',
    'Penanggung Jawab',
    'Ketua',
    'Wakil Ketua',
    'Sekretaris 1',
    'Sekretaris 2',
    'Bendahara 1',
    'Bendahara 2',
    'Sie Lomba MTQ',
    'Sie Lomba MHQ',
    'Sie Lomba Pildacil',
    'Sie Lomba Banjari',
    'Sie Lomba Adzan',
    'Sie Lomba Cerdas-Cermat',
    'Sie Dokumentasi',
    'Sie Perlengkapan',
    'Sie Konsumsi',
    'Sie Pembantu Umum'
])

const loading = ref(false)


const $page = usePage();

const setJabatan = async ($event,guru) => {
    loading.value = true
    let jabatan = $event.target.value
    let lomba_id = ''
    if(jabatan.includes('Sie Lomba')) {
        let teks = jabatan.split(" ")
        switch(teks[-teks.length]) {
            case "MTQ":
                lomba_id = 'mtq'
                break
            case "MHQ":
                lomba_id = 'mhq'
                break
            case "Pildacil":
                lomba_id = 'pdc'
                break
            case "Banjari":
                lomba_id = 'bjr'
                break
            case "Adzan":
                lomba_id = 'adz'
                break
            case "Cerdas-Cermat":
                lomba_id = 'lcc'
                break
        }
    }
    let panitia = {guru_id: guru.id, lomba_id: lomba_id, jabatan: jabatan}
    await axios.post(route('panitia.store'), {data: JSON.stringify(panitia)})
                .then(res => {

                })
}
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
                    <td class="py-1 px-3">{{ guru.panitia ? guru.panitias.jabatan : '-' }}
                        <select name="jabatan" id="jabatanSelect"  @change="setJabatan($event, guru)">
                            <option value="0">Pilih Jabatan</option>
                            <option v-for="(jabatan,j) in jabatans" :key="j" :value="jabatan" :selected="(guru.panitias && jabatan == guru.panitias.jabatan)">{{ jabatan }}</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</Dash>
</template>