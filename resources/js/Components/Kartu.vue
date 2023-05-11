<script setup>
import {ref, onMounted} from 'vue';
import axios from 'axios';
import PBtn from '@/Components/General/PBtn.vue';
import {printContsCard} from '@/Plugins/printKartu';

const props = defineProps({
    dokumen: String
})

// const emit = defineEmits(['close', 'cetak'])
const dialog = ref(false)
// const close = () => {
//     emit('close')
// }

const loading = ref(false)

const lomba = ref([])

const listBidang = async () => {
    loading.value = true
    await axios.post('/lomba')
    .then(res => {
            lomba.value = res.data.lombas[0]
            loading.value = false
        }).catch(err => console.log(err))
}


onMounted(() => {
    dialog.value = true
    listBidang()
})
</script>
<template>
<div class="fixed top-0 right-0 bottom-0 bg-[#333333de] z-50 h-screen w-full flex justify-center items-center" @click.self="$emit('close')">
    <div class=" w-6/12 grid grid-cols-3 gap-3" v-if="loading">
        <div class="w-full h-36 bg-white rounded shadow grid grid-cols-4 overflow-hidden" v-for="i in 6" :key="i">
            <div class="h-full w-3/4 bg-gray-200"></div>
            <div class="w-full h-full py-4 pr-3 col-span-3">
                <div class="h-2 w-full bg-gray-200 my-3 animate-pulse" v-for="c in 5" :key="c"></div>
            </div>
        </div>
    </div>
    <div class=" w-8/12 grid grid-cols-3 gap-3" v-if="!loading">
        <div class="w-full h-48 bg-white rounded shadow grid grid-cols-4 overflow-hidden" v-for="(lomba,l) in lomba.bidangs" :key="l">
            <div class="h-full w-3/4 bg-gray-200"></div>
            <div class="w-full h-full py-4 pr-3 col-span-3">
                <p>{{ lomba.label }}</p>
                <h1 class="text-4xl">{{ lomba.pesertas.length }} <small class="text-sm">Orang</small></h1>
                <p-btn color="sky" class="mt-16" @click="$emit('cetakKartu', {lomba:lomba, dokumen:props.dokumen})">Cetak</p-btn>
            </div>
            
        </div>
    </div>
</div>
</template>