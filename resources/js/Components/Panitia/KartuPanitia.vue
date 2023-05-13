<script setup>
import { ref, computed, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import { XCircleIcon } from '@heroicons/vue/20/solid';
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiTypewriter } from '@mdi/js';
import VueQrcode from '@chenfengyuan/vue-qrcode';
import axios from 'axios';

const panitias = ref([])

const list = async () => {
    await axios.post(route('panitia.index'))
                .then(res => {
                    panitias.value = res.data.panitias
                    console.log(res)
                    // alert('yes')
                }).catch(err => console.log(err))
}

onMounted(() => {
    list()
    // alert('hi')
})
</script>

<template>

    <div class="w-full bg-white">
        <Head title="Kartu Panitia" />
        <div class="toolbar w-full p-3 flex items-center justify-between shadow-lg print:hidden bg-white">
            Kartu Panitia
            <div class="toolbar-items flex items-center gap-2 ">
                <button class="rounded-full p-0" @click="$emit('close')">
                    <XCircleIcon class="h-8 text-red-400 hover:text-red-600 active:text-orange-400" />
                </button>
            </div>
        </div>
        <div class="content w-full bg-gray-100 print:bg-transparent grid grid-cols-3 gap-3 py-3 px-10 print:p-0">
            <div v-for="(panitia, p) in panitias" :key="p" class="shadow-lg border p-4 print:p-2 relative w-full bg-white h-[124mm] print:h-[94mm] print:shadow-none print:border-1 print:border-gray-200 overflow-y-hidden box-border">
                <!-- <div class="w-8 rounded-e-full h-2/3 top-20 print:top-20 bg-teal-600 absolute left-0">
                    &nbsp;
                </div> -->
                <div class="content pt-2">
                    <div class="header mt-4 print:mt-2" >
                        <h2 class="leading-4 text-center">PANITIA PELAKSANA</h2>
                        <h2 class="leading-4 text-center font-extrabold">
                            PENTAS PAIS 2023 <br />
                            <small class="leading-4 text-center">KEC. WAGIR</small>
                        </h2>
                    </div>
                    <div class="identitas p-4 pb-0 text-center mt-4 print:mt-2 inline-block">
                        <img src="/img/peserta.png" alt="Foto" class="w-1/3 mx-auto rounded-full border-4 bg-teal-600 p-1">
                        <h1 class="text-[1vw] print:text-[.8rem] font-bold tracking-wide mt-2">
                            <small>{{panitia.guru.nama}}</small>
                            
                        </h1>
                        <h2 class="leading-4 print:text-sm print:leading-3"><code>{{ panitia.jabatan }}</code></h2>
                        <p class="leading-4 text-sm"><code>{{ panitia.guru.hp }}</code></p>
                    </div>
                    <vue-qrcode :value="`https://pentaspais.kkgpaiwagir.or.id/panpel/${i}`" :options="{width:60}" class="mx-auto mt-6 print:mt-3" />
                    <SvgIcon :path="mdiTypewriter" type="mdi" class="absolute right-0 bottom-2 text-gray-100" size="90" />
                    <div class="footer absolute left-0 right-0 bottom-0 flex justify-between p-3 print:p-1">
                        <p class="text-sm text-teal-800 print:text-xs">https://pentaspais.kkgpaiwagir.or.id</p>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>