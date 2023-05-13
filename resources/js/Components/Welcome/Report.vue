<script setup>
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiClose } from '@mdi/js';
import axios from 'axios';
import { ref, onMounted, computed, onActivated } from 'vue';
import * as _ from 'lodash-es';
import { watch } from 'vue';

const show = ref(false)
const title = ref('')
const item = ref({})
const kode = ref(null)
const bidangs = ref([])

const open = (message, data) => {
    show.value = true
    title.value = message
    kode.value = data.id
    
}


const listSekolah = async (id) => {
    await axios.post(route('sekolah.show', [id]))
                .then(res => {
                    item.value = res.data.sekolah
                    bidangs.value = _.groupBy(res.data.sekolah.pesertas, 'lomba_id')
                })
    // alert(kode.value)
}

const jumlah = computed(() => {
    return item.value.pesertas ? item.value.pesertas.length : '0'
})


defineExpose({ open })

onMounted(async () => {
    await setTimeout(() => {
        listSekolah(kode.value)
    },1000)
    
})
</script>

<template>
<Transition type="fade">
    <div class="report fixed top-0 right-0 bottom-0 left-0 z-50 bg-white" v-if="show">
        <div class="report-body w-full min-w-full">
            <div class="report-toolbar p-3 flex justify-between items-center shadow sticky top-0">
                {{ title }}
                <div class="toolbar-items flex items-center">
                        <button class="rounded-full bg-red-400 shadow" @click="show = false">
                            <SvgIcon type="mdi" :path="mdiClose" :size="28" class="text-white" />
                        </button>
                </div>
            </div>
            <div class="report-content py-4">
                <h3 class="text-center text-gray-600 text-xl">Jumlah Peserta</h3>
                <h1 class="text-center text-gray-800 text-8xl font-extrabold">{{ jumlah }}</h1>

                <div class="grid grid-cols-2 border font-extrabold" v-for="(bidang, b) in bidangs" :key="b">
                    <div class="bg-gray-50 text-teal-800 p-2 flex items-center">
                        {{ bidang ? bidang[0].bidangs[0].label : ""}}
                    </div>
                    <div class="bg-gray-200 text-gray-800 p-2">
                        <p v-for="(peserta, pt) in bidang" :key="pt" class="font-extrabold">
                            {{ peserta.nama }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</Transition>
</template>