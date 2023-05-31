<script setup>
import { ref, defineAsyncComponent } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import { read, utils } from 'xlsx'
import SvgIcon from '@jamescoyle/vue-icon'
import { mdiFileExcelBox } from '@mdi/js'
import Dash from '@/Layout/Dash.vue'
const ImportSekolah = defineAsyncComponent(() => import('@/Components/Sekolah/ImportSekolah.vue'))
// Impor
const imporBtnTitle = ref('Impor')
const importDialog = ref(false)
const importedDatas = ref([])
const onFilePicked = (e) => {
    const file = e.target.files[0]
    imporBtnTitle.value = file.name

    const reader = new FileReader()

    reader.onload = async (event) => {
        let wb = await read(event.target.result)
        let datas = await utils.sheet_to_json(wb.Sheets[wb.SheetNames[0]])
        importedDatas.value = datas
        importDialog.value = true

    }

    reader.readAsArrayBuffer(file)
}

const closeImpor = () => {
    importDialog.value = false
    importedDatas.value = []
    router.reload({only: ['sekolahs']})
}

</script>

<template>
<Head title="Data Sekolah" />
<ImportSekolah :show="importDialog" :datas="importedDatas" @close="closeImpor" />
<Dash title="Data Sekolah">
    <div class="container w-full bg-white my-4 md:mt-0 rounded-xl overflow-hidden">
        <div class="toolbar w-full h-12 flex items-center justify-between p-3 sticky top-0 bg-white shadow">
            <span >
                <h1 class="hidden md:block tetx-lg font-bold">
                    Data Sekolah
                </h1>
            </span>
            <div class="toolbar-items flex items-center gap-2">
                <input type="file" name="fileSekolah" ref="fileSekolah" @change="onFilePicked" class="hidden" accept=".xls, .xlsx, .ods, .csv">
                <button class="py-1 px-2 bg-teal-600 flex items-center text-white rounded hover:bg-teal-800 active:bg-orange-600" @click="$refs.fileSekolah.click()">
                    <SvgIcon type="mdi" :path="mdiFileExcelBox" class="h-6 text-white" />
                    {{ imporBtnTitle }}
                </button>
            </div>
        </div>
        <div class="content w-full bg-white p-3 mt-2 ">
            <div class="overflow-x-auto w-full border">
                <table class="w-[100%] table table-responsive border-collapse ">
                <thead>
                    <tr class="bg-teal-200">
                        <th class="p-3 border-e border-gray-600">No</th>
                        <th class="p-3 border-e border-gray-600">NPSN</th>
                        <th class="p-3 border-e border-gray-600">Nama</th>
                        <th class="p-3">Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(sekolah,s) in $page.props.sekolahs" :key="s" class="even:bg-teal-100">
                        <td class="text-center py-1 px-2 border-e border-gray-600">{{ s+1 }}</td>
                        <td class="text-center py-1 px-2 border-e border-gray-600">{{ sekolah.npsn }}</td>
                        <td class="py-1 px-2 border-e border-gray-600">{{ sekolah.nama }}</td>
                        <td class="py-1 px-2 ">{{ sekolah.alamat }}</td>
                        
                    </tr>
                    <tr v-if="$page.props.sekolahs.length < 1">
                        <td colspan="3" class="p-2 flex itens-center justify-center">
                            Belum ada sekolah
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</Dash>
</template>