<script setup>
import { ref, onMounted } from 'vue';
import { XMarkIcon } from '@heroicons/vue/20/solid';
import axios from 'axios';
import ContextMenu from '@imengyu/vue3-context-menu';

onMounted(() => {
    listGuru()
})

const listGuru = async() => {
    await axios.post(route('guru.index'))
        .then(res => {
            let datas = []
            res.data.gurus.forEach(guru => {
                datas.push({nip: guru.nip, label: guru.nama, onClick: () => alert('Hi')})
            })
            gurus.value = datas
        })
}

const props = defineProps({
    lomba: Object
})

const gurus = ref([])

const panitia = ref({
    ketua: '',
    wakil: '',
})

const setPanitia = (e, jabatan) => {
    e.preventDefault()
    // alert('tes')
    ContextMenu.showContextMenu({
        x: e.x,
        y: e.y,
        maxHeight: 230,
        items: gurus.value
    })
}

</script>

<template>
    <div class="w-full bg-white rounded-shadow">
        <div class="toolbar h-12 flex items-center justify-between p-3 sticky top-0 bg-teal-800 text-lime-50">
            <span>
                Susunan Panitia {{ lomba.label }}
            </span>
            <div class="toolbar-items flex items-center">
                <button @click="$emit('close')">
                    <XMarkIcon class="h-8 bg-red-400 bg-opacity-30 rounded-full text-red-200 hover:bg-red-400 active:bg-orange-400" />
                </button>
            </div>
        </div>
        <div class="content w-full bg-white">
            <div class="row flex justify-center pt-4">
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Ketua Pelaksana</div>
                    <div class="pejabat px-2 text-center" @contextmenu="setPanitia($event, 'ketua')">Nama</div>
                </div>
            </div>
            <div class="row flex justify-center pt-2 pb-4">
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Wakil Ketua</div>
                    <div class="pejabat px-2 text-center" @contextmenu="setPanitia($event, 'wakil')">Nama</div>
                </div>
            </div>
            <div class="row flex justify-center p-4 gap-6">
                <div class="flex-grow"></div>
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Sekretaris 1</div>
                    <div class="pejabat px-2 text-center">Nama</div>
                </div>
                <div class="flex-grow"></div>
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Bendahara 1</div>
                    <div class="pejabat px-2 text-center">Nama</div>
                </div>
                <div class="flex-grow"></div>
            </div>
            <div class="row flex justify-center p-4 gap-6">
                <div class="flex-grow"></div>
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Sekretaris 2</div>
                    <div class="pejabat px-2 text-center">Nama</div>
                </div>
                <div class="flex-grow"></div>
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Bendahara 2</div>
                    <div class="pejabat px-2 text-center">Nama</div>
                </div>
                <div class="flex-grow"></div>
            </div>
            <div class="row flex justify-center p-4">
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Seksi-seksi</div>
                </div>
            </div>
            <div class="row flex justify-around p-4 gap-6">
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded" v-for="(bidang,b) in lomba.bidangs" :key="b">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Sie {{ bidang.label }}</div>
                    <div class="pejabat px-2 text-center">Nama</div>
                    <div class="pejabat px-2 text-center">Nama</div>
                    <div class="pejabat px-2 text-center">Nama</div>
                </div>
            </div>
            <div class="row flex justify-around p-4 gap-6">
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Sie Dokumentasi</div>
                    <div class="pejabat px-2 text-center">Nama</div>
                    <div class="pejabat px-2 text-center">Nama</div>
                    <div class="pejabat px-2 text-center">Nama</div>
                </div>
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Sie Konsumsi</div>
                    <div class="pejabat px-2 text-center">Nama</div>
                    <div class="pejabat px-2 text-center">Nama</div>
                    <div class="pejabat px-2 text-center">Nama</div>
                </div>
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Sie Perlengkapan</div>
                    <div class="pejabat px-2 text-center">Nama</div>
                    <div class="pejabat px-2 text-center">Nama</div>
                    <div class="pejabat px-2 text-center">Nama</div>
                </div>
                <div class="box flex flex-col max-w-64 border border-gray-800 rounded">
                    <div class="jabatan px-2 text-center bg-gray-600 text-white">Sie Pembantu Umum</div>
                    <div class="pejabat px-2 text-center">Nama</div>
                    <div class="pejabat px-2 text-center">Nama</div>
                    <div class="pejabat px-2 text-center">Nama</div>
                </div>
            </div>
            <!-- <p>
                {{ lomba }}
            </p> -->
        </div>
    </div>
</template>