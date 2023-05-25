<script setup>
import { ref, computed, defineAsyncComponent } from 'vue'
import { paginate } from '@/Plugins/misc'
import axios from 'axios'

const Loading = defineAsyncComponent(() => import('@/Components/General/Loading.vue'))
const AlertBox = defineAsyncComponent(() => import('@/Components/General/AlertBox.vue'))

const props = defineProps({
    datas: Array, show: Boolean
})

const currentPage = ref(1)

const pagedatas = computed(() => paginate(props.datas, currentPage.value))

const emit = defineEmits(['close'])
// Kirim
const loading = ref(false)
const alertBox = ref(null)
const impor = async() => {
    loading.value = true
    await axios.post(route('sekolah.impor'), {sekolahs: JSON.stringify(props.datas)})
                .then(res => {
                    loading.value = false
                    alertBox.value.open("Ok", res.data.msg)
                    emit('close')
                }).catch(err => {
                    loading.value = false
                    // alertBox.value.open("Error", err.response.data.msg)
                })
}
</script>

<template>
<Loading v-if="loading" />
<AlertBox ref="alertBox" />
<div class="fixed top-0 right-0 bottom-0 left-0 bg-gray-800 flex items-center justify-center z-40 bg-opacity-70" v-if="show">
    <div class="card w-full md:w-3/4 bg-white rounded overflow-hidden">
        <div class="card-toolbar h-12 w-full shadow flex items-center justify-between p-2 bg-sky-800 text-white">
            Impor Data Sekolah
            <div class="toolbar-items flex items-center">
                <button class="bg-sky-600 hover:bg-sky-400 active:bg-orange-600 text-white px-2 py-1 rounded shadow" @click="impor">Kirim</button>
            </div>
        </div>
        <div class="card-content">
            <table class="table w-full border border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th>No</th>
                        <th>NPSN</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd:bg-gray-100" v-for="(data,d) in pagedatas.current" :key="d">
                        <td class="text-center p-2">{{ d+1 }}</td>
                        <td class="text-center p-2">{{ data.npsn }}</td>
                        <td class="text-left p-2">{{ data.name }}</td>
                        <td class="text-left p-2">{{ data.alamat }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="w-full bg-gray-200 flex items-center justify-between pl-3">
                        Jml Halaman: {{ pagedatas.pageCount }} | Jml Data: {{ pagedatas.dataLength }}
                        <div class="flex items-center h-full flex-wrap">
                            <button @click="currentPage-=1" class="flex justify-center w-8 border border-gray-500">&lt;</button>
                            <button v-for="b in pagedatas.pageCount" :key="b" class="flex justify-center w-8 border border-gray-500" :class="b == currentPage ? 'bg-sky-600 text-white': ''" @click="currentPage=b">{{ b }}</button>
                            <button @click="currentPage+=1" class="flex justify-center w-8 border border-gray-500">&gt;</button>
                        </div>
                    </div>
        </div>
    </div>
</div>
</template>