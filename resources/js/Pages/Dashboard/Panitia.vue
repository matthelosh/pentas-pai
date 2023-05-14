<script setup>
import Dash from '@/Layout/Dash.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import AlertBox from '@/Components/General/AlertBox.vue';
import { mdiAccountMultipleCheck, mdiClose } from '@mdi/js';
import SvgIcon from '@jamescoyle/vue-icon';

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

const alertBox = ref(null)

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
    let panitia = {guru_id: guru.id, lomba_id: lomba_id, jabatan: jabatan, id: guru.panitias.length > 0 ? guru.panitias[0].id : null, user_id: guru.panitias.length > 0 ? guru.panitias[0].user_id:null,}
    await axios.post(route('panitia.store'), {data: JSON.stringify(panitia)})
                .then(res => {
                    if (res.data.status == 'ok') {
                        alertBox.value.open('Ok', res.data.msg)
                        router.reload({only: ['gurus']})
                    }
                }).catch(err => {
                    alertBox.value.open('Error', err.response.data.msg)
                })
}

const buatAkun = async () => {
    axios.post(route('panitia.account.make'))
            .then(res => {
                alertBox.value.open('Ok', res.data.msg)
                router.reload({only: ['gurus']})
            }).catch(err => {
                    alertBox.value.open('Error', err.response.data.msg)
                })
}
</script>

<template>
<AlertBox ref="alertBox" />
<Head title="Data Panitia" />
<Dash>
    <div class="w-full bg-white rouded shadow">
        <div class="toolbar bg-white sticky top-14 flex items-center justify-between p-3 h-12 shadow print:hidden">
            <div class="toolbar-title text-lg font-bold flex items-center gap-1">
                <SvgIcon type="mdi" :path="mdiAccountMultipleCheck" />
                Data Panitia
            </div>
            <div class="toolbar-items flex items-center gap-1">
                <button class="bg-sky-600 hover:bg-sky-800 active:bg-sky-200 active:text-gray-800 py-2 px-3 text-white rounded-md" @click="buatAkun">
                    Buat Akun
                </button>
                <!-- <button class="rounded-full bg-red-600 hover:bg-red-800 active:bg-orange-400 text-white p-1">
                    <SvgIcon type="mdi" :path="mdiClose"  />
                </button> -->
            </div>
        </div>
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
                        <td class="py-1 px-3">{{ guru.nama }} <span class="text-teal-800">{{ guru.panitias[0].user ?  `[${guru.panitias[0].user.name }]`: ''}}</span></td>
                        <td class="py-1 px-3">{{ guru.jk }}</td>
                        <td class="py-1 px-3">{{ guru.sekolah ? guru.sekolah.nama : '-' }}</td>
                        <td class="py-1 px-3">{{ guru.panitia ? guru.panitias.jabatan : '-' }}
                            <select name="jabatan" id="jabatanSelect"  @change="setJabatan($event, guru)">
                                <option value="0">Pilih Jabatan</option>
                                <option v-for="(jabatan,j) in jabatans" :key="j" :value="jabatan" :selected="(guru.panitias.length > 0 && jabatan == guru.panitias[0].jabatan)">{{ jabatan }}</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</Dash>
</template>