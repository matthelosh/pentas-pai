<script setup>
import { ref, computed, defineAsyncComponent } from "vue";
import { Icon } from "@iconify/vue";
import { inject } from "vue";

const $dialog = inject("$dialog");
const title = ref("");
const items = ref(null);
const show = ref(false);
const bidangId = ref(null);
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

const open = async (message, data, bidang_id) => {
    bidangId.value = bidang_id;
    title.value = message;
    items.value = data;
    show.value = true;
    // console.log(data);
    acak();
};

const tutup = () => {
    results.value = [];
    items.value = [];
    uruts.value = [];
    title.value = "";
    show.value = false;
};

const DialogBox = defineAsyncComponent(() =>
    import("@/Components/General/DialogBox.vue")
);
const dialogBox = ref(null);
const storeSort = async () => {
    // axios
    //     .post(route("dashboard.peserta.nourut.simpan"), {
    //         bidang_id: bidangId.value,
    //         datas: results.value,
    //     })
    //     .then((res) => {
    //         console.log(res);
    //     });
    const ok = await dialogBox.value.open(
        "Menerima hasil acak no urut tersebut?"
    );
    console.log(ok);
};

defineExpose({ open });
</script>

<template>
    <div
        class="backdrop fixed top-0 left-0 h-[95vh] right-0 bg-teal-800 bg-opacity-70 flex items-center justify-center z-40"
        @click.self="tutup"
        v-if="show"
    >
        <DialogBox ref="dialogBox" />
        <div
            class="dialog min-w-[300px] max-w-[65vw] rounded-lg bg-white p-4 relative"
        >
            <button
                class="bg-red-400 w-[50px] h-[50px] flex items-center justify-center text-white text-2xl absolute right-0 top-0 rounded-tr-lg"
                @click="tutup"
            >
                <Icon icon="mdi-close" />
            </button>
            <h3
                class="text-center mb-3 text-xl uppercase font-black text-teal-800"
            >
                {{ title }}
            </h3>
            <div class="dialog-body max-h-[80vh] overflow-y-auto py-4">
                <div class="grid grid-cols-4 gap-4">
                    <template
                        class="item"
                        v-for="item in results.sort((a, b) =>
                            a.urut > b.urut ? 1 : -1
                        )"
                    >
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
                                class="h-[150px] w-[150px] mx-auto rounded-full"
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
            </div>

            <div class="w-full flex justify-center pt-8">
                <button
                    class="bg-sky-500 py-2 px-4 rounded text-white uppercase"
                    @click="storeSort"
                >
                    Tetapkan
                </button>
            </div>
        </div>
    </div>
</template>
