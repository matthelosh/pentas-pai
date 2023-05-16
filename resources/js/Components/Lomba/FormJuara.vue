<script setup>
import { ref, onMounted } from 'vue';
const props = defineProps({juara: Object})
import axios from 'axios';
import { ArrowPathIcon } from '@heroicons/vue/20/solid';

const juara = ref({
    bidang_id: '0',
    peringkat: '0',
})
const bidangs = [
    { kode: 'adz', label: 'Adzan' },
    { kode: 'pdc', label: 'Pildacil' },
    { kode: 'bjr', label: 'Banjaro' },
    { kode: 'lcc', label: 'Cerdas Cermat' },
    { kode: 'mtq', label: 'MTQ' },
    { kode: 'mhq', label: 'MHQ' },
]

const pesertas = ref([])

const loading = ref(false)

const onBidangChanged = async (e) => {
    await axios.post(route('dashboard.peserta.index'))
            .then(res => {
                let datas = []
                res.data.pesertas.forEach((item, index) => {
                    datas.push({nisn: item.nisn, nama: item.nama})
                })
                pesertas.value = datas
            })
}

const simpan = async () => {
    loading.value = true
    await axios.post(route('juara.store'), {data: JSON.stringify(juara.value)})
                .then(res => {
                    // juara.value = {
                    //     buidang_id: '0',
                    //     peringkat: '0'
                    // }
                    loading.value = false
                })
}

onMounted(() => {
    if (props.juara) {
        juara.value = props.juara
    }
})
</script>

<template>
<div class="fixed top-0 right-0 bottom-0 left-0 bg-gray-800 bg-opacity-60 flex  justify-center" @click.self="$emit('close')">
    <div class="dialog bg-white md:w-4/12 rounded shadow-xl h-[400px] mt-24">
        <div class="dialog-content py-3 px-4">
            <h1>Formulir Juara</h1>
            <form @submit.prevent="simpan" class="form">
                <label for="bidang_id" class="flex items-center justify-between">
                    Bidang lomba:
                    <select name="bidang_id" v-model="juara.bidang_id" class="py-1 pr-10 caret-slate-800 rounded focus:shadow-lime-400 my-2" @change="onBidangChanged">
                        <option value="0">Pilih Bidang Lomba</option>
                        <option v-for="(bidang,b) in bidangs" :key="b" :value="bidang.kode">{{ bidang.label }}</option>
                    </select> 
                </label>
                <label for="peserta_id" class="my-1 flex items-center justify-between">No. Peserta:
                    <input type="text" name="peserta_id" placeholder="No. Peserta/NISN " class="py-1 rounded focus:shadow my-2" v-model="juara.peserta_id">
                </label>
                <label for="peserta_id" class="my-1 flex items-center justify-between">Nilai:
                    <input type="number" name="nilai" placeholder="Nilai " class="py-1 rounded focus:shadow my-2" v-model="juara.nilai">
                </label>
                <label for="bidang_id" class="flex items-center justify-between">
                    Peringkat:
                    <select name="peringkat" v-model="juara.peringkat" class="py-1 pr-10 caret-slate-800 rounded focus:shadow-lime-400 my-2">
                        <option value="0">Peringkat</option>
                        <option value="1">1 (SATU)</option>
                        <option value="2">2 (DUA)</option>
                        <option value="3">3 (TIGA)</option>
                        <option value="4">HARAPAN 1</option>
                        <option value="5">HARAPAN 2</option>
                    </select> 
                </label>
                <label for="bidang_id" class="flex items-center justify-between">
                    Keterangan:
                    <textarea name="keterangan" v-model="juara.keterangan" class="py-1 pr-10 caret-slate-800 rounded focus:shadow-lime-400 my-2"></textarea>
                </label>
                <button class="bg-sky-400 text-white py-1 px-2 rounded mx-auto flex gap-2" type="sumbit" :disabled="loading"> Simpan 
                    <ArrowPathIcon class="h-8 animate-spin text-white" v-if="loading" />
                </button>
            </form>
        </div>
    </div>
</div>
</template>
