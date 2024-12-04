<script setup>
import { ref, computed } from "vue";

const title = ref("");
const items = ref(null);
const show = ref(false);
const randomNumber = ref(0);
const min = ref(1);
const max = computed(() => items.value.length);
const uruts = ref([]);
const results = ref([]);
const acak = () => {
    items.value.forEach((item, i) => {
        setNumber(item);
    });
};

const setNumber = (item) => {
    let no =
        Math.floor(Math.random() * (max.value - min.value + 1)) + min.value;
    if (!uruts.value.includes(no)) {
        uruts.value.push(no);
        results.value.push({
            siswa_id: item.nisn,
            urut: no,
            nama: item.nama,
            foto: item.foto,
            sekolah: item.sekolah.nama,
        });
        // return no;
    } else {
        setNumber(item);
    }
};

const open = async (message, data) => {
    title.value = message;
    items.value = data;
    show.value = true;
    acak();
};

const tutup = () => {
    results.value = [];
    items.value = [];
    uruts.value = [];
    title.value = "";
    show.value = false;
};
defineExpose({ open });
</script>

<template>
    <div
        class="backdrop fixed top-0 left-0 bottom-0 right-0 bg-teal-800 bg-opacity-70 flex items-center justify-center z-40"
        @click.self="tutup"
        v-if="show"
    >
        <div class="dialog min-w-[300px] max-w-[65vw] rounded-lg bg-white p-4">
            <h3
                class="text-center mb-3 text-xl uppercase font-black text-teal-800"
            >
                {{ title }}
            </h3>
            <div class="grid grid-cols-4 gap-4">
                <template class="item" v-for="item in results">
                    <div
                        class="col-span-1 p-2 bg-teal-600 text-white rounded relative"
                        v-if="item"
                    >
                        <div
                            class="absolute text-8xl bg-red-400 rounded w-[100px] h-[100px] flex items-center justify-center top-0 left-0"
                        >
                            {{ item.urut }}
                        </div>
                        <img
                            :src="item.foto"
                            alt="Foto Peserta"
                            onerror="this.error=null;this.src='/img/peserta.png';"
                        />
                        <h3
                            class="bg-white p-2 text-slate-700 uppercase text-center"
                        >
                            {{ item.nama }}
                        </h3>
                        <h3
                            class="bg-white p-2 text-slate-700 uppercase text-center"
                        >
                            {{ item.sekolah }}
                        </h3>
                    </div>
                </template>
            </div>
            <div class="w-full flex justify-center pt-8">
                <button
                    class="bg-sky-500 py-2 px-4 rounded text-white uppercase"
                >
                    Tetapkan
                </button>
            </div>
        </div>
    </div>
</template>
