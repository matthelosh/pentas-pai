<script setup>
import { ref, onMounted, } from 'vue';
import PBtn from '../General/PBtn.vue';
import axios from 'axios'

const props = defineProps({
    show: Boolean,
    lomba: Object
})

const lomba = ref({
    lokasi_id: '0'
})

const selectedBidangs = ref([])
const sekolahs = ref([])
const bidangs = ref([])

const listSekolah = async() => {
    await axios.post(route('sekolah.index'))
            .then(res => {
                sekolahs.value = res.data.sekolahs
            }).catch(err => {
                console.log(err)
            })
}

const listBidangs = async() => {
    await axios.post(route('bidang.index'))
                .then(res => {
                    bidangs.value = res.data.bidangs
                })
}

const simpan = async() => {
    lomba.value.bidangs = selectedBidangs.value
    // console.log(lomba.value)
    axios.post(route('lomba.store'), {lomba: JSON.stringify(lomba.value)})
        .then(res => {
            lomba.value = ref({lokasi_id: '0'})
            emit('close')
        })
}

const emit = defineEmits(['close'])
const tutup = () => {
    lomba.value = ref({lokasi_id: '0'})
    emit('close')
}
onMounted(() => {
    listSekolah()
    listBidangs()
    if(props.lomba) {
        lomba.value = props.lomba
        // alert(props.lomba.bidangs.length)
        if(props.lomba.bidangs.length > 0) {
            // alert('tes')
            let datas = []
            props.lomba.bidangs.forEach(bidang => {
                datas.push(bidang.id)
            })
            selectedBidangs.value = datas
        }
    }
    // console.log(props.lomba)
})
</script>

<template>
<div class="fixed top-0 right-0 bottom-0 left-0 bg-gray-800 bg-opacity-60 z-40 flex items-center justify-center" v-if="show">
    <div class="card w-full md:w-2/4 bg-white rounded">
        <div class="card-toolbar h-12 bg-sky-600 text-white p-4 flex justify-between items-center">
            Data Lomba
            <p-btn color="red" @click="tutup">Tutup</p-btn>
        </div>
        <div class="card-content w-full p-4">
            <form @submit.prevent="simpan" ref="formLomba" class="form flex-col gap-2 flex">
                <label for="Kode" class="flex items-center gap-3">
                    <span class="flex-grow">
                        Kode Lomba:
                    </span>
                    <input type="text" name="kode" placeholder="Kode Lomba" v-model="lomba.kode" class="w-3/4">
                </label>
                <label for="Kode" class="flex items-center gap-3">
                    <span class="flex-grow">
                        Label Lomba:
                    </span>
                    <input type="text" name="label" placeholder="Label Lomba" v-model="lomba.label" class="w-3/4">
                </label>
                
                <span class="flex w-full">
                    <label for="Kode" class="flex items-center gap-3 w-3/4">
                        <span class="flex-grow">
                            Tahun Lomba:
                        </span>
                        
                        <input type="date" name="tanggal" placeholder="Tahun Lomba" v-model="lomba.tanggal" class="w-2/4" />
                    </label>
                    <label for="Kode" class="flex items-center gap-3 w-1/4">
                        <input type="text" name="tahun" placeholder="Tahun Lomba" v-model="lomba.tahun" class="w-full" />
                    </label>
                    
                </span>
                <label for="Kode" class="flex items-center gap-3">
                    <span class="flex-grow">
                        Lokasi Lomba:
                    </span>
                    <select name="lokasi_id" v-model="lomba.lokasi_id" class="w-3/4">
                        <option value="0">Pilih Lokasi Lomba</option>
                        <option v-for="(sekolah, s) in sekolahs" :key="s" :value="sekolah.npsn">{{ sekolah.nama }}</option>
                    </select>
                </label>
                <label for="Kode" class="flex items-center gap-3">
                    <span class="flex-grow">
                        Bidang Lomba:
                    </span>
                    <select name="lokasi_id" v-model="selectedBidangs" class="w-3/4" multiple style="resize: vertical;">
                        <option v-for="(bidang, b) in bidangs" :key="b" :value="bidang.id">{{ bidang.label }}</option>
                    </select>
                </label>
                <!-- {{ lomba.bidangs.length }} -->
                <label  class="w-full flex justify-between items-center border-t border-gray-400 border-dashed h-12">
                    <div></div>
                    <p-btn color="sky" type="submit">Simpan</p-btn>
                </label>
            </form>
        </div>
    </div>

</div>
</template>