<script setup>
import { ref, computed } from 'vue';
import * as _ from 'lodash-es'
import axios from 'axios';
const show = ref(false)
const resolved = ref(null)
const rejected = ref(null)
const message = ref('')
const tes = ref('Halo')
const loading = ref(false)


const impor = async() => {
    await axios.post(route('dashboard.peserta.impor'), {data: items.value})
                .then(res => {
                    show.value = false
                    resolved.value(true)
                })
                .catch(err => console.log(err))
}


let items = ref([])
const open = async (text, datas) => {
    show.value = true
    items.value = datas
    message.value = text
    return new Promise((resolve, reject) => {
        resolved.value = resolve
        rejected.value = reject
    })
}

const oke = async () => {
    // show.value = false
    res.value = true
    // return 'tes'
    // return true
}

const no = () => {
    // resolve.value = false
    // show.value = false
    return false
}

const currentPage = ref(1)

const datas = computed(() => {
    let length = items.value.length
    let pages =  _.chunk(items.value, 10)

    return {current: pages[currentPage.value-1], pageCount: pages.length}
})
defineExpose({
    open
})
</script>

<template>
    <div class="overlay fixed top-0 right-0 bottom-0 left-0 z-50 bg-black bg-opacity-50 flex items-center justify-center" @click.self="show=false" v-if="show">
        <div class="dialog min-w-[400px] min-h-[400px]  rounded shadow bg-white">
            <div class="toolbar bg-gray-100 flex items-center justify-between p-2">
                <h3>Cek Calon Peserta</h3>
                <div class="item-toolbars">
                    <button class="py-1 px-2 rounded bg-sky-400 text-white hover:bg-sky-600 active:bg-orange-400 transition-all duration-150 delay-50" @click="impor">Impor</button>
                </div>
            </div>
            <div class="content p-3">
                <div class="table table-responsive w-full">
                    <table class="table w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border text-center">No</th>
                                <th class="border text-center">NISN</th>
                                <th class="border text-center">Nama</th>
                                <th class="border text-center">JK</th>
                                <th class="border text-center">Sekolah</th>
                                <th class="border text-center">Lomba</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="odd:bg-gray-50" v-for="(data,d) in datas.current" :key="d">
                                <td class="border p-2">{{ d+1 }}</td>
                                <td class="border p-2">{{ data.nisn }}</td>
                                <td class="border p-2">{{ data.nama }}</td>
                                <td class="border p-2">{{ data.jk }}</td>
                                <td class="border p-2">{{ data.sekolah_id }}</td>
                                <td class="border p-2">
                                    | {{ data.lomba_id }}
                                    <ul>
                                        <li v-for="(bidang,b) in data.bidangs" :key="b"> {{ bidang.label }}</li>
                                    </ul>
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="w-full bg-gray-200 flex items-center justify-between pl-3">
                        Jml Halaman: {{ datas.pageCount }}
                        <div class="flex items-center h-full flex-wrap">
                            <button @click="currentPage-=1" class="flex justify-center w-8 border border-gray-500">&lt;</button>
                            <button v-for="b in datas.pageCount" :key="b" class="flex justify-center w-8 border border-gray-500" :class="b == currentPage ? 'bg-sky-600 text-white': ''" @click="currentPage=b">{{ b }}</button>
                            <button @click="currentPage+=1" class="flex justify-center w-8 border border-gray-500">&gt;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>