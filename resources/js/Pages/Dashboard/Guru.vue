<script setup>
import Dash from '@/Layout/Dash.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, defineAsyncComponent } from 'vue';
import { mdiAccountPlusOutline, mdiAccountMinus, mdiAccountTie } from '@mdi/js';
import SvgIcon from '@jamescoyle/vue-icon';
import {jabatans} from '@/Plugins/Datas'


const AlertBox = defineAsyncComponent(() => import('@/Components/General/AlertBox.vue'))
const ImportGuru = defineAsyncComponent(() => import('@/Components/Guru/ImporGuru.vue'))


const loading = ref(false)

const alertBox = ref(null)

const $page = usePage();

// Impor 
const buttonImporTitle = ref('Impor')
const fileGuru = ref(null)
const dialogImport = ref(false)
const onFileGuruPicked = (e) => {
    let file = e.target.files[0]
    buttonImporTitle.value = file.name
    fileGuru.value = file
    dialogImport.value = true
}

const closeImpor = () => {
    fileGuru.value = null
    dialogImport.value = false
    buttonImporTitle.value = 'Impor'
    router.reload({only: ['gurus']})
}

// Akun
const buatAkun = async (id) => {
    axios.post(route('guru.account.make'), {id: id})
            .then(res => {
                alertBox.value.open('Ok', res.data.msg)
                router.reload({only: ['gurus']})
            }).catch(err => {
                    alertBox.value.open('Error', err.response.data.msg)
                })
}

const bulkAccount = () => {
    const gurus = $page.props.gurus.filter(guru => !guru.user)
    gurus.forEach(guru => {
        buatAkun(guru.id)
    })
}

// Mode
const mode = ref('list')




</script>

<template>
<ImportGuru :file="fileGuru" :show="dialogImport" @close="closeImpor" v-if="dialogImport" />
<AlertBox ref="alertBox" />
<Head title="Data Panitia" />
<Dash>
    <div class="w-full bg-white rouded shadow" v-if="mode == 'list'">
        <div class="toolbar bg-white flex items-center justify-between p-3 h-12 shadow print:hidden sticky top-0">
            <div class="toolbar-title text-lg font-bold flex items-end">
                <SvgIcon type="mdi" :path="mdiAccountTie" class="h-8" />
                Data Guru
            </div>
            <div class="toolbar-items flex items-center gap-1">
                <input type="file" name="fileGuru" id="file-guru" ref="inputFileGuru" class="hidden" @change="onFileGuruPicked">
                <button class="bg-sky-600 hover:bg-sky-800 active:bg-sky-200 active:text-gray-800 py-1 px-2 text-white rounded" @click="$refs.inputFileGuru.click()">
                    {{ buttonImporTitle }}
                </button>
                <button class="bg-sky-600 hover:bg-sky-800 active:bg-sky-200 active:text-gray-800 py-1 px-2 text-white rounded" @click="newGuru">
                    Tambah
                </button>
                <button class="bg-sky-600 hover:bg-sky-800 active:bg-sky-200 active:text-gray-800 py-1 px-2 text-white rounded" @click="bulkAccount">
                    Buat Akun
                </button>
            </div>
        </div>
        <div class="table table-responsive w-full">
            <table class="border border-collapse w-full">
                <thead class="sticky top-12">
                    <tr class="bg-gray-100">
                        <th class="py-2 px-3">No</th>
                        <th class="py-2 px-3">NIP</th>
                        <th class="py-2 px-3">Nama</th>
                        <th class="py-2 px-3">JK</th>
                        <th class="py-2 px-3">Sekolah</th>
                        <th class="py-2 px-3">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd:bg-gray-50" v-for="(guru,g) in $page.props.gurus" :key="guru">
                        <td class="text-center py-1 px-3">{{ g+1 }}</td>
                        <td class="py-1 px-3">{{ guru.nip }}</td>
                        <td class="py-1 px-3">{{ guru.nama }} <span class="text-teal-800 font-bold">[{{ guru.user ? guru.user.name : ''}}]</span> </td>
                        <td class="py-1 px-3">{{ guru.jk }}</td>
                        <td class="py-1 px-3">{{ guru.sekolah ? guru.sekolah.nama : '-' }}</td>
                        <td class="py-1 px-3">
                            <button class="aspect-square rounded-full" :class="!guru.user ? 'bg-teal-800' : 'bg-red-800'" @click="buatAkun(guru.id)">
                                <SvgIcon type="mdi" :path="guru.user ? mdiAccountMinus : mdiAccountPlusOutline" class="h-4 text-white" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</Dash>
</template>