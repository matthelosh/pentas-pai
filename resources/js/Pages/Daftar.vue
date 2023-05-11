<script setup>
import { ref, onMounted } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import Front from '@/Layout/Front.vue';
import axios from 'axios';
import AlertBox from '@/Components/General/AlertBox.vue';

import { ArrowPathIcon } from '@heroicons/vue/20/solid';

const page = usePage()

const fileFoto = ref(null)
const urlFoto = ref('img/peserta.png')
const loading = ref(false)
const onFotoPicked = (e) => {
    let file = e.target.files[0]
    urlFoto.value = URL.createObjectURL(file)
    fileFoto.value = file
    // console.log(file)
}

const peserta = ref({lomba_id:[]})
const bidangs = ref([])

const formRegistrasi = ref()

const kirim = async () => {
    loading.value = true
    let fd = new FormData()
    fd.append('data', JSON.stringify(peserta.value))
    if(fileFoto.value != null) {
        fd.append('foto', fileFoto.value)
    }
    await axios.post('/registrasi', fd)
                .then(res => {
                    // console.log(res)
                    loading.value = false
                    alertBox.value.open('Ok', res.data.msg)
                    peserta.value = {lomba_id:[]}
                }).catch(err => {
                    let msg = 'Error'
                    if(err.response.data.errCode == 23000) {
                       msg = `${peserta.value.nama}, NISN: ${peserta.value.nisn} sudah terdaftar`
                    } else {
                        msg = 'Maaf ada kesalahan di pihak kami.'
                    }
                    loading.value = false
                    alertBox.value.open('Error', msg)
                    return false
                })
}

const alertBox = ref(null)
// const tes = () => {
//     alertBox.value.open('Ok', 'Berhasil')
// }

</script>

<template>
<AlertBox ref="alertBox" />
<Head title="Mendaftar Lomba" />
<Front>
    <div class="w-full rounded bg-white shadow p-3">
        <h1 class="text-lg font-bold">Formulir Pendaftaran
            <!-- <button class="outline rounded px-2 hover:bg-gray-200 active:bg-gray-400" @click="tes">Tes</button> -->
        </h1>
        <div class="columns-1 md:columns-2 md:p-10 gap-5 relative">
            <div class="w-full bg-gray-100 p-3 mb-3 rounded">
                <img :src="urlFoto" alt="Peserta" class="w-1/2 rounded-full mx-auto shadow transition-all duration-500 hover:shadow-lg hover:shadow-lime-600 cursor-pointer bg-[#fefefe]" @click="$refs.foto.click()">
                <h1 class="text-center text-gray-500 text-lg">Foto Peserta <br /><small class="text-black">[Klik gambar untuk mengganti]</small></h1>
                <input type="file" ref="foto" class="hidden" @change="onFotoPicked" />
            </div>
            <form ref="formRegistrasi" @submit.prevent="kirim" class="p-2 md:h-96">
                <h3 class=" text-lg text-gray-700 mt-0 mb-4 font-extrabold">Data Peserta</h3>
                <div class="flex justify-between mb-3">
                    <label for="sekolah">Sekolah</label>
                    <select name="sekolah" class="rounded-lg w-3/4 p-1 placeholder:text-blue-500 focus:border-blue-500 bg-gray-100" placeholder="Pilih" v-model="peserta.sekolah_id">
                        <option v-for="(sekolah,s) in page.props.sekolahs" :key="s" :value="sekolah.npsn" :selected="sekolah.npsn == peserta.sekolah_id">{{ sekolah.nama }}</option>
                    </select>
                </div>
                <div class="flex justify-between mb-3">
                    <label for="nisn" class="w-1/4">NISN</label>
                    <input type="text" name="nisn" class="rounded-lg w-3/4 p-1 placeholder:text-blue-500 focus:border-blue-500 bg-gray-100" placeholder="Nomor Induk Siswa Nasional" v-model="peserta.nisn" />
                </div>
                <div class="flex justify-between mb-3">
                    <label for="nama" class="w-1/4">Nama</label>
                    <input type="text" name="nama" class="rounded-lg w-3/4 p-1 placeholder:text-blue-500 focus:border-blue-500 bg-gray-100" placeholder="Nama Lengkap" v-model="peserta.nama" />
                </div>
                <div class="flex justify-between mb-3">
                    <label for="jk" class="w-1/4">JK</label>
                    <div class="grid grid-cols-2 w-3/4">
                        <span>
                            <input type="radio" name="jk" value="Laki-laki" id="lk" v-model="peserta.jk" />
                            <label for="lk" class="ml-2">Laki-laki</label>
                        </span>
                        <span>
                            <input type="radio" name="jk" value="Perempuan" id="pr" v-model="peserta.jk" />
                            <label for="pr" class="ml-2">Perempuan</label>
                        </span>
                    </div>
                </div>
                <div class="flex justify-between mb-3">
                    <label for="lomba">Lomba</label>
                    <select name="lomba" class="rounded-lg w-3/4 p-1 placeholder:text-blue-500 focus:border-blue-500 bg-gray-100" placeholder="Pilih" v-model="peserta.lomba_id" multiple>
                        <!-- <option value="0" selected>Pilih</option> -->
                        <option v-for="(lomba,l) in page.props.bidangs" :key="l" :value="lomba.kode" :selected="lomba.kode == peserta.lomba_id">{{ lomba.label }}</option>
                        
                    </select>
                </div>
                <div class="flex justify-between mb-3">
                    <label for="hp" class="w-1/4">No. WA</label>
                    <input type="text" name="hp" class="rounded-lg w-3/4 p-1 placeholder:text-blue-500 focus:border-blue-500 bg-gray-100" placeholder="Nomor WA/HP" v-model="peserta.hp" />
                </div>
                <div class="flex justify-center mb-3">
                    <button type="submit" class=" bg-blue-600 text-white rounded px-3 py-1 hover:bg-blue-800 flex items-center disabled:bg-blue-300 disabled:text-gray-300" :disabled="loading">
                        <ArrowPathIcon class=" animate-spin w-5 mr-1" v-if="loading" />
                        Daftar
                        
                    </button>
                </div>
            </form>
        </div>
    </div>
</Front>
</template>