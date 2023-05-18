<script setup>
import {usePage, Link} from '@inertiajs/vue3'

const page = usePage()
</script>

<template>
    <div class="w-full h-[95vh] flex items-center justify-center ">
        <div class="w-64 ">
            <label for="tipe">
                <select name="tipe" class="pl-2 pr-10 w-full rounded-lg shadow my-1" >
                    <option value="0">Tipe Dokumen</option>
                    <option value="sertifikat">Sertifikat</option>
                    <option value="piagam">Piagam</option>
                </select>
            </label>
            <label for="kode">
                <input type="text" name="kode" placeholder="Kode Dokumen" class="w-full shadow rounded-lg my-1 text-center text-green-800 font-bold">
            </label>
            <Link as="button" :href="`/`" class="w-full bg-gray-600 rounded py-2 px-3 text-gray-50 hover:text-white active:bg-gray-400 active:text-gray-600">Lihat</Link>
        </div>
    </div>
</template>