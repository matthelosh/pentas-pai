<script setup>
import { Head, usePage } from "@inertiajs/vue3";
import Front from "@/Layout/Front.vue";
import { ref, computed, onMounted, watch } from "vue";
const page = usePage();
import { namaSekolah } from "@/Plugins/misc";
defineProps({ peserta: Object });
</script>

<template>
    <Head title="Data Peserta" />
    <Front>
        <div class="mt-16 rounded-lg w-full min-h-[80vh] bg-white px-4 py-14">
            <div
                class="avatar bg-sky-300 w-[200px] h-[200px] border-8 border-white shadow-lg mx-auto rounded-full overflow-hidden"
            >
                <img
                    :src="peserta.foto"
                    alt="Foto Peserta"
                    onerror="this.error = null;this.src='/img/peserta.png'"
                />
            </div>
            <h3 class="text-center mt-6 font-bold text-teal-700 text-xl">
                {{ peserta.nama }}
            </h3>
            <h3 class="text-center text-slate-700 font-bold">
                NISN {{ peserta.nisn }}
            </h3>
            <h3 class="text-center text-slate-700 font-bold mt-6">
                Lembaga: {{ namaSekolah(peserta.sekolah.nama) }}
            </h3>
            <h3 class="text-center text-slate-700 font-bold">
                Bidang Lomba: {{ peserta.bidangs[0].label }}
            </h3>
        </div>
    </Front>
</template>
