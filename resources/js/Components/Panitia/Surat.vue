<script setup>
import {ref, onMounted, computed} from 'vue';
import axios from 'axios';
import Editor from '@/Components/General/Editor.vue';
import CetakSurat from '@/Components/Panitia/CetakSurat.vue'

onMounted(() => {
    listSurat()
})

const mode = ref('list')
const datas = ref([])
const loading = ref(false)

const surat = ref({
    kode: '',
    perihal: '',
    penerima: '',
    content: 'Isi Surat Disini',
    tanggal: '',
    tujuan: ''
})

const listSurat = async() => {
    loading.value = true
    await axios.post(route('surat.index'))
            .then(res => {
                datas.value = res.data.surats
                loading.value = false
            }).catch(err => {
                console.log(err)
                loading.value = false
            })
}
const simpan = async () => {
    await axios.post(route('surat.store'), {surat: JSON.stringify(surat.value)})
        .then(res => {
            mode.value = 'list'
            listSurat()
        }).catch(err => console.log(err))
}
const cetak = () => {
    window.print()
}

const cetakSurat = (selectedSurat) => {
    surat.value = selectedSurat
    mode.value = 'cetak-surat'
}

const lampiran = ref({
    judul: '',
    content: '',
    deskripsi: ''
})
const attachment = (selectedSurat) => {
    surat.value = selectedSurat
    mode.value = 'lampiran'
}

const simpanLampiran = async () => {
    await axios.post('/panitia/surat/'+surat.value.id+'/lampiran/store', lampiran.value)
                .then(res => {
                    console.log(res)
                    mode.value = 'list'
                    listSurat()
                })
}
</script>

<template>
<div class="w-full bg-white rounded shadow print:rounded-none print:shadow-none">
    <div class="toolbar h-10 bg-white shadow p-3 flex items-center justify-between print:hidden">
        <h1>Data Surat</h1>
        <div class="toolbar-items flex items-center gap-2">
            <button class="bg-sky-400 hover:bg-sky-600 active:bg-sky-800 text-white rounded shadow py-1 px-2" @click="mode='list'">Lihat</button>
            <button class="bg-sky-400 hover:bg-sky-600 active:bg-sky-800 text-white rounded shadow py-1 px-2" @click="cetak">Cetak</button>
            <button class="bg-sky-400 hover:bg-sky-600 active:bg-sky-800 text-white rounded shadow py-1 px-2" @click="mode='tulis'">Tulis</button>
            <button class="bg-red-400 hover:bg-red-600 active:bg-red-800 text-white rounded shadow py-1 px-2" @click="$emit('close')">Tutup</button>
        </div>
    </div>
    <div class="table p-3 print:p-0 w-full">
        <Transition type="expand">
            <table class="table border border-collapse w-full" v-if="mode == 'list'">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border py-2 border-gray-400">No</th>
                    <th class="border py-2 border-gray-400">Tanggal</th>
                    <th class="border py-2 border-gray-400">Perihal</th>
                    <th class="border py-2 border-gray-400">Penerima</th>
                    <th class="border py-2 border-gray-400">Tujuan</th>
                    <th class="border py-2 border-gray-400">Lampiran</th>
                    <th class="border py-2 border-gray-400">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <tr class="odd:bg-gray-50" v-for="(surat,s) in datas" :key="s">
                    <td class="py-1 border border-gray-400">{{ s+1 }}</td>
                    <td class="py-1 border border-gray-400">{{ surat.tanggal }}</td>
                    <td class="py-1 border border-gray-400">{{ surat.perihal }}</td>
                    <td class="py-1 border border-gray-400">{{ surat.penerima }}</td>
                    <td class="py-1 border border-gray-400">{{ surat.tujuan }}</td>
                    <td class="py-1 border border-gray-400">{{ surat.lampirans ? surat.lampirans.length : '0' }}</td>
                    <td class="py-1 border border-gray-400 flex justify-center items-center gap-1">
                        <button class="py-1 px-2 rounded bg-cyan-400 text-white hover:bg-cyan-600 active:bg-cyan-800" @click="attachment(surat)">Lampiran</button>
                        <button class="py-1 px-2 rounded bg-cyan-400 text-white hover:bg-cyan-600 active:bg-cyan-800" @click="cetakSurat(surat)">Cetak</button>
                    </td>
                </tr>
            </tbody>
            </table>

            <div class="paper w-full bg-white p-3" v-else-if="mode=='tulis'">
                <div class="meta w-full mb-4 flex gap-2 justify-around">
                    <input type="text" name="kode" placeholder="Kode Surat" v-model="surat.kode">
                    <input type="text" name="perihal" placeholder="Perihal" v-model="surat.perihal">
                    <input type="text" name="Penerima" placeholder="Penerima" v-model="surat.penerima">
                    <select name="Tujuan" placeholder="Penerima" v-model="surat.tujuan">
                        <option value="0">Pilih Tujuan</option>    
                        <option value="Keluar">Keluar</option>    
                        <option value="Masuk">Masuk</option>    
                    </select>
                    <input type="date" name="tanggal" placeholder="Tanggal" v-model="surat.tanggal">
                </div>
                <Editor v-model="surat.content" />
                <div class="w-full flex justify-end mt-3">
                    <button class="py-2 px-3 bg-sky-400 text-white rounded hover:bg-sky-600 active:bg-sky-800" @click="simpan">Simpan</button>
                </div>
            </div>

            <div class="lampiran w-full bg-white p-3" v-else-if="mode == 'lampiran'">
                <h1 class="text-lg font-bold mb-4">Lampiran Surat {{surat.kode}}</h1>
                <div class="meta flex items-start gap-2">
                    <input type="text" name="judul" v-model="lampiran.judul" class="rounded" placeholder="Judul Lampiran">
                    <textarea  name="deskripsi" v-model="lampiran.deskripsi" class="rounded" placeholder="Judul Lampiran" rows="2"></textarea>
                </div>
                <Editor v-model="lampiran.content" />
                <div class="w-full flex flex-end">
                    <button class="py-2 px-3 bg-sky-400 tetx-white hover:bg-sky-600 active:bg-sky-800" @click="simpanLampiran">Simpan</button>
                </div>
            </div>

            <CetakSurat v-else-if="mode=='cetak-surat'" :surat="surat" />
        </Transition>
    </div>
</div>
</template>