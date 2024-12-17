<script setup>
import {
    ref,
    computed,
    onMounted,
    defineAsyncComponent,
    watchEffect,
} from "vue";
import { XCircleIcon } from "@heroicons/vue/20/solid";
import VueQrcode from "@chenfengyuan/vue-qrcode";
import { imgUrl } from "@/Plugins/misc";
import * as _ from "lodash-es";
import axios from "axios";
import { usePage } from "@inertiajs/vue3";

const Loading = defineAsyncComponent(() =>
    import("@/Components/General/Loading.vue")
);

const Randomize = defineAsyncComponent(() =>
    import("@/Components/General/Randomize.vue")
);
const loading = ref(false);
const props = defineProps({
    bidang: Object,
});
const page = usePage();

onMounted(() => {
    getPesertas();
});

const getPesertas = async () => {
    loading.value = true;
    await axios
        .post(
            route("dashboard.peserta.index", {
                _query: {
                    bidang: props.bidang.id,
                },
            })
        )
        .then((res) => {
            pesertas.value = res.data.pesertas;
            loading.value = false;
        });
};

const printMe = () => {
    window.print();
};

const sideBg = (kode) => {
    if (kode.includes("lcc")) {
        return "bg-orange-600";
    } else if (kode.includes("bjr")) {
        return "bg-sky-600";
    } else if (kode.includes("mtq")) {
        return "bg-teal-600";
    } else if (kode.includes("mhq")) {
        return "bg-lime-600";
    } else if (kode.includes("pdc")) {
        return "bg-pink-600";
    } else if (kode.includes("adz")) {
        return "bg-orange-600";
    }
};

const pesertas = ref([]);

const sekolahs = computed(() => {
    if (pesertas.value) {
        return pesertas.value
            .map((item) => item.sekolah)
            .filter(
                (thing, index, self) =>
                    index === self.findIndex((t) => t.npsn === thing.npsn)
            );
    }
});

const label = computed(() => {
    let labels = props.bidang.label.split(" ");
    return props.bidang.kode.includes("bjr")
        ? labels[0]
        : labels[0] + " " + labels[1];
});

const sekolah = ref("0");
// const items = computed(() => {
//     if (sekolah.value == "0") {
//         return grouped.value;
//     } else {
//         return props.bidang.kategori == "regu"
//             ? grouped.value.filter((group) => group.sekolah_id == sekolah.value)
//             : grouped.value;
//     }
// });
const items = ref(null);

const grouped = computed(() => {
    let groups = _.groupBy(pesertas.value, "sekolah_id");
    if (props.bidang.kategori == "regu") {
        let grouped = [];
        Object.values(groups).forEach((v, i) => {
            grouped.push({ no: i + 1, data: v, sekolah_id: v[0].sekolah_id });
        });
        return grouped;
    } else {
        return pesertas.value;
    }
});

const randomize = ref(null);
const randomNumber = () => {
    randomize.value.open(
        "Acak Nomor Peserta " + props.bidang.label,
        items.value,
        props.bidang.id,
        props.bidang.kategori
    );
};

watchEffect(async () => {
    items.value =
        sekolah.value == "0"
            ? grouped.value
            : props.bidang.kategori !== "regu"
            ? grouped.value.filter((group) => group.sekolah_id == sekolah.value)
            : grouped.value;
    // console.log(sekolah.value);
    // console.log(items.value);
});
</script>

<template>
    <div>
        <Randomize ref="randomize" />
        <Loading v-if="loading" :show="loading" />
        <div
            class="w-full bg-white rounded shadow print:shadow-none relative mt-4 print:m-0 print:p-0 md:mt-0 rounded-lg"
        >
            <div
                class="toolbar h-12 bg-[#fefefe] shadow items-center p-2 print:hidden flex justify-between sticky w-full z-10 top-0 rounded-t-lg"
            >
                <span class="hidden md:block"
                    >Kartu Peserta {{ props.bidang.label }}</span
                >
                <div
                    class="toolbar-items flex justify-between gap-2 items-center"
                >
                    <button
                        class="bg-red-600 hover:bg-red-500 active:bg-red-400 py-1 px-4 text-white rounded-full"
                        @click="randomNumber"
                    >
                        Acak Nomor
                    </button>
                    <select
                        name="sekolah_id"
                        v-model="sekolah"
                        class="py-1 rounded-full"
                    >
                        <option value="0">Semua Lembaga</option>
                        <option
                            v-for="(sekolah, s) in sekolahs"
                            :key="s"
                            :value="sekolah.npsn"
                        >
                            {{ sekolah.nama }}
                        </option>
                    </select>

                    <button
                        class="bg-sky-400 text-white px-3 py-1 rounded-full shadow hover:bg-sky-600 hidden md:block"
                        @click="printMe"
                    >
                        Cetak
                    </button>
                    <XCircleIcon
                        class="text-red-600 h-6 cursor-pointer"
                        @click="$emit('close')"
                    />
                </div>
            </div>
            <div class="content screen:max-h-[91vh] overflow-y-auto">
                <div
                    class="w-full sm:w-[70%] print:w-full mx-auto print:m-0 py-8 print:p-0"
                    v-if="pesertas.length > 0"
                >
                    <div
                        class="w-full grid grid-cols-1 md:grid-cols-3 gap-1 print:p-1 p-3 relative print:grid-cols-3"
                        v-if="props.bidang.kategori !== 'regu'"
                    >
                        <div
                            v-for="(peserta, p) in items"
                            :key="p"
                            class="border-gray-800 border shadow print:shadow-none rounded print:break-inside-avoid print:my-1 print:mx-0 mx-auto grid grid-cols-4 relative bg-[url('/img/kartupeserta-bg.png')] bg-cover w-full h-[500px] print:h-[100mm] print:w-[68mm]"
                        >
                            <div
                                class="left h-full relative flex flex-col justify-between p-4 items-center bg-opacity-90"
                                :class="sideBg(props.bidang.kode)"
                            >
                                <h1
                                    class="text-uppercase whitespace-nowrap uppercase font-extrabold w-[100%] text-4xl print:text-2xl text-white mt-0 flex items-center"
                                    style="writing-mode: vertical-lr"
                                >
                                    Lomba
                                    {{
                                        label.split(" ").length === 2
                                            ? label.split(" ")[0]
                                            : label.split(" ")[0] +
                                              " " +
                                              label.split(" ")[1]
                                    }}
                                </h1>
                                <h1
                                    class="text-4xl bg-white aspect-square print:w-12 w-20 text-center rounded-full flex justify-center items-center"
                                >
                                    {{
                                        peserta.urutans.length < 1
                                            ? p + 1
                                            : peserta.urutans[0].ke
                                    }}
                                </h1>
                            </div>
                            <div class="col-span-3">
                                <div
                                    class="logo flex gap-1 items-end justify-center mt-6"
                                >
                                    <img
                                        src="/img/kkg.png"
                                        alt="Logo KKG"
                                        class="h-10"
                                    />
                                    <div class="logo--text">
                                        <h3
                                            class="my-0 leading-4 font-bold text-sm uppercase"
                                        >
                                            {{ page.props.lomba.label }}
                                        </h3>
                                        <h2 class="my-0 leading-4 text-xs">
                                            KKG PAI KECAMATAN WAGIR
                                        </h2>
                                    </div>
                                </div>
                                <div class="foto w-full mt-16 print:mt-2">
                                    <img
                                        :src="imgUrl(peserta.foto)"
                                        alt="Foto"
                                        class="aspect-square object-cover rounded-full w-[100px] print:w-[75px] mx-auto object-top border"
                                        onerror="this.error=null;this.src='/img/peserta.png'"
                                    />
                                </div>
                                <div
                                    class="identitas w-full px-2 mt-10 print:mt-2"
                                >
                                    <h2
                                        class="uppercase text-center leading-4 font-bold text-sm"
                                    >
                                        {{ peserta.nama }}
                                    </h2>
                                    <h3 class="text-center leading-4 text-sm">
                                        No. {{ peserta.nisn }}
                                    </h3>
                                    <h4
                                        class="uppercase text-center leading-4 mt-4 font-bold text-sm"
                                    >
                                        {{ peserta.sekolah.nama }}
                                    </h4>
                                </div>
                                <vue-qrcode
                                    :value="`peserta?nisn=${peserta.nisn}`"
                                    :options="{
                                        width: 75,
                                        color: {
                                            light: '#fefefeee',
                                            dark: '#347f67',
                                        },
                                    }"
                                    class="absolute bottom-2 right-2"
                                ></vue-qrcode>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <div v-for="(group, g) in items" :key="g">
                            <div
                                class="w-full grid grid-cols-3 gap-1 print:gap-2 print:p-0 p-3 relative"
                            >
                                <!-- <div
                                    v-for="(peserta, p) in group.data"
                                    :key="p"
                                    class="border-gray-800 border shadow print:shadow-none print:break-inside-avoid print:my-1 print:mx-0 mx-auto grid grid-cols-4 relative bg-[url('/img/kartupeserta-bg.png')] bg-cover w-full h-[500px] print:h-[350px]"
                                > -->
                                <div
                                    class="border-gray-800 border shadow print:shadow-none print:break-inside-avoid print:my-1 print:mx-0 mx-auto grid grid-cols-4 relative bg-[url('/img/kartupeserta-bg.png')] bg-cover w-full h-[290mm] print:h-[270mm] w-[206mm]"
                                >
                                    <div
                                        class="left h-full relative flex flex-col justify-between p-4 items-center bg-opacity-90"
                                        :class="sideBg(props.bidang.kode)"
                                    >
                                        <h1
                                            class="text-uppercase whitespace-nowrap uppercase font-extrabold w-[100%] text-8xl print:text-8xl text-white ml-14 mt-8"
                                            style="writing-mode: vertical-lr"
                                        >
                                            {{ label }}
                                        </h1>
                                    </div>
                                    <div class="col-span-3">
                                        <div
                                            class="logo text-center gap-1 items-end justify-center mt-14 w-[80%] mx-auto"
                                        >
                                            <img
                                                src="/img/logo_pentas.png"
                                                alt="Logo KKG"
                                                class="h-28 mx-auto"
                                            />
                                            <div class="logo--text">
                                                <h3
                                                    class="my-0 font-black uppercase text-3xl"
                                                >
                                                    {{ page.props.lomba.label }}
                                                </h3>
                                            </div>
                                        </div>

                                        <h1
                                            class="text-[10rem] mx-auto w-[50%] border border-8 my-28 border-black text-center rounded-full"
                                        >
                                            {{
                                                group.data[0].urutans.length < 1
                                                    ? group.no
                                                    : group.data[0].urutans[0]
                                                          .ke
                                            }}
                                        </h1>

                                        <div
                                            class="identitas w-full px-2 mt-20 print:mt-2"
                                        >
                                            <h2
                                                class="uppercase text-center font-bold text-4xl"
                                            >
                                                {{ group.data[0].sekolah.nama }}
                                            </h2>
                                            <h3 class="text-center text-xl">
                                                NPSN.
                                                {{ group.data[0].sekolah.npsn }}
                                            </h3>

                                            <!-- <h4
                                                class="uppercase text-center leading-4 mt-4 font-bold text-sm"
                                            >
                                                {{ peserta.sekolah.nama }}
                                            </h4> -->
                                        </div>
                                        <!-- <vue-qrcode
                                            :value="`peserta?nisn=${peserta.nisn}`"
                                            :options="{
                                                width: 75,
                                                color: {
                                                    light: '#fefefeee',
                                                    dark: '#020202',
                                                },
                                            }"
                                            class="absolute bottom-2 left-28"
                                        ></vue-qrcode> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="w-full h-[80vh] flex items-center justify-center"
                    v-else
                >
                    <div>
                        <h1 class="text-2xl text-gray-800">
                            Tidak ada peserta pada bidang lomba
                            {{ props.bidang.label }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
