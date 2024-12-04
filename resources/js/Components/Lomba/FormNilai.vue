<script setup>
import { ref, computed, onMounted, defineAsyncComponent } from "vue";
import { Head } from "@inertiajs/vue3";
import { XCircleIcon } from "@heroicons/vue/20/solid";
import * as _ from "lodash-es";
import axios from "axios";

import { tanggal } from "@/Plugins/misc";

const props = defineProps({
    bidang: Object,
});

const selectedBidang = ref({});

const Kop = defineAsyncComponent(() => import("@/Components/General/Kop.vue"));

onMounted(() => {
    list();
});

const list = async () => {
    await axios
        .post(
            route("bidang.show", {
                id: props.bidang.id,
                _query: {
                    peserta: true,
                },
            })
        )
        .then((res) => {
            selectedBidang.value = res.data.bidang;
        });
};

const kriterias = ref([
    {
        lomba: "mtq",
        aspeks: ["Tajwid", "Fashahah", "Suara", "Lagu"],
    },
    {
        lomba: "mhq",
        aspeks: ["Tajwid", "Fashahah", "Hafalan"],
    },
    {
        lomba: "pdc",
        aspeks: ["Retorika", "Penguasaan Materi", "Gaya Bahasa", "Ekspresi"],
    },
    {
        lomba: "adz",
        aspeks: ["Adab", "Lagu", "Penghayatan", "Makhraj dan Tajwid"],
    },
    {
        lomba: "bjr",
        aspeks: ["Adab", "Vokal", "Syair", "Musik"],
    },
    {
        lomba: "lcc",
        aspeks: ["Penyisihan", "Semifinal", "Final"],
    },
]);

const bidang = computed(() => {
    return kriterias.value.filter((item) =>
        props.bidang.kode.includes(item.lomba)
    );
});

const pesertas = computed(() => {
    if (
        props.bidang.kode.includes("bjr") ||
        props.bidang.kode.includes("lcc")
    ) {
        return _.groupBy(selectedBidang.value.pesertas, "sekolah.nama");
    } else {
        return selectedBidang.value.pesertas;
    }
});

const group = (kode) => {
    return kode.includes("bjr") || kode.includes("lcc");
};
</script>

<template>
    <div class="w-full bg-white rounded-lg">
        <Head title="Form Nilai" />
        <div
            class="toolbar bg-gray-50 h-12 flex items-center justify-between p-3 shadow print:hidden rounded-t-xl"
        >
            <div class="toolbar-title">
                Formulir Nilai {{ props.bidang.label }} {{ props.bidang.kode }}
            </div>
            <div class="toolbar-items flex items-center gap-1">
                <XCircleIcon
                    class="text-red-600 h-8 cursor-pointer"
                    @click="$emit('close')"
                />
            </div>
        </div>
        <div
            class="content w-full px-3 screen:max-h-[91vh] overflow-y-auto bg-slate-500 bg-opacity-70 print:bg-white"
        >
            <div
                class="form-nilai break-after-page my-6 print:m-0 print:bg-white bg-slate-100 px-10 pb-6 print:p-0 shadow-lg print:shadow-none mx-32"
            >
                <Kop />
                <table
                    class="table w-full border border-black border-collapse table-auto"
                >
                    <caption class="my-4 print:mt-0">
                        <h1 class="text-center text-xl">
                            Form Nilai Lomba {{ $page.props.lomba.label }}
                        </h1>
                        <h2 class="text-center text-2xl">
                            {{ props.bidang.label }}
                        </h2>
                    </caption>
                    <thead>
                        <tr>
                            <th
                                class="border border-black py-1 print:py-0 px-3"
                                rowspan="2"
                            >
                                {{
                                    group(props.bidang.kode)
                                        ? "Grup/Sekolah"
                                        : "No"
                                }}
                            </th>
                            <th
                                class="border border-black py-1 print:py-0 px-3"
                                rowspan="2"
                                v-if="!group(props.bidang.kode)"
                            >
                                NISN
                            </th>
                            <th
                                class="border border-black py-1 print:py-0 px-3"
                                rowspan="2"
                            >
                                {{
                                    group(props.bidang.kode)
                                        ? "Peserta"
                                        : "Nama"
                                }}
                            </th>
                            <th
                                class="border border-black py-1 print:py-0 px-3"
                                :colspan="bidang[0].aspeks.length"
                            >
                                Skor
                            </th>
                            <th
                                class="border border-black py-1 print:py-0 px-3"
                                rowspan="2"
                            >
                                Nilai
                            </th>
                        </tr>
                        <tr>
                            <th
                                v-for="(aspek, a) in bidang[0].aspeks"
                                :key="a"
                                class="border border-black py-1 px-2 w-10 break-words"
                            >
                                {{ aspek }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(peserta, p) in pesertas"
                            class="odd:bg-gray-50"
                        >
                            <td
                                class="text-center py-1 px-3 border border-black"
                            >
                                {{ group(props.bidang.kode) ? p : p + 1 }}
                            </td>
                            <td
                                class="text-center py-1 px-3 border border-black"
                                v-if="!group(props.bidang.kode)"
                            >
                                {{ peserta.nisn }}
                            </td>
                            <td class="py-1 px-3 border border-black">
                                <ul v-if="group(props.bidang.kode)">
                                    <li v-for="(pes, i) in peserta" :key="i">
                                        {{ i + 1 }}. {{ pes.nama }}
                                    </li>
                                </ul>
                                <span v-else
                                    >{{ peserta.nama }}
                                    <small class="font-bold"
                                        >[{{ peserta.sekolah.nama }}]</small
                                    ></span
                                >
                            </td>
                            <td
                                class="py-1 px-3 border border-black"
                                v-for="i in bidang[0].aspeks"
                                :key="i"
                            ></td>
                            <td class="py-1 px-3 border border-black"></td>
                        </tr>
                    </tbody>
                </table>

                <div class="ttd w-full grid grid-cols-3 mt-10">
                    <div>
                        <p>&nbsp;</p>
                        <p class="text-center">
                            Koordinator {{ props.bidang.label }}
                        </p>

                        <p class="underline mt-16 text-center">
                            .......................................................................
                        </p>
                        <p>NIP.</p>
                    </div>
                    <div></div>
                    <div>
                        <p class="text-center">
                            Wagir, {{ tanggal($page.props.lomba.tanggal) }}
                        </p>
                        <p class="text-center">Juri {{ props.bidang.label }}</p>

                        <p class="underline mt-16 text-center">
                            .......................................................................
                        </p>
                        <p>NIP.</p>
                    </div>
                </div>
            </div>
            <div
                class="berita-acara my-6 print:m-0 print:bg-white bg-slate-100 px-10 pb-6 print:p-0 shadow-lg print:shadow-none mx-32"
            >
                <Kop />
                <h1 class="text-center text-lg">BERITA ACARA PELAKSANAAN</h1>
                <h2 class="text-center text-xl">
                    BIDANG LOMBA {{ props.bidang.label }}
                </h2>

                <p class="mt-10">
                    Pada hari ini _____________, tanggal ___, bulan
                    ________________, tahun _________ kami Koordinator bidang
                    lomba {{ props.bidang.label }}
                    {{ $page.props.lomba.label }} beserta juri yang bertugas
                    telah melaksanakan dengan keterangan sebagai berikut:
                </p>
                <table>
                    <tr>
                        <td>Bidang Lomba</td>
                        <td>:</td>
                        <td>______________________</td>
                    </tr>
                    <tr>
                        <td>Dimulai Pukul</td>
                        <td>:</td>
                        <td>______________________</td>
                    </tr>
                    <tr>
                        <td>Selesai Pukul</td>
                        <td>:</td>
                        <td>______________________</td>
                    </tr>
                    <tr>
                        <td>Jumlah Peserta</td>
                        <td>:</td>
                        <td>______________________</td>
                    </tr>
                    <tr>
                        <td>Jumlah Hadir</td>
                        <td>:</td>
                        <td>______________________</td>
                    </tr>
                    <tr>
                        <td>Jumlah Tidak Hadir</td>
                        <td>:</td>
                        <td>______________________</td>
                    </tr>
                    <tr>
                        <td>Catatan Selama Lomba</td>
                        <td>:</td>
                        <td>
                            ___________________________________________________
                        </td>
                    </tr>
                </table>
                <p>dengan hasil berikut</p>
                <table class="border border-black mx-auto my-4">
                    <thead>
                        <tr>
                            <th class="border border-black">No</th>
                            <th class="border border-black">Juara</th>
                            <th class="border border-black px-3">
                                Nama / Regu
                            </th>
                            <th class="border border-black px-3">
                                Nilai/ Keterangan
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-black py-2 px-3">1</td>
                            <td class="border border-black py-2 px-3">
                                Juara 1
                            </td>
                            <td class="border border-black"></td>
                            <td class="border border-black"></td>
                        </tr>
                        <tr>
                            <td class="border border-black py-2 px-3">2</td>
                            <td class="border border-black py-2 px-3">
                                Juara 2
                            </td>
                            <td class="border border-black"></td>
                            <td class="border border-black"></td>
                        </tr>
                        <tr>
                            <td class="border border-black py-2 px-3">3</td>
                            <td class="border border-black py-2 px-3">
                                Juara 3
                            </td>
                            <td class="border border-black"></td>
                            <td class="border border-black"></td>
                        </tr>
                        <tr>
                            <td class="border border-black py-2 px-3">4</td>
                            <td class="border border-black py-2 px-3">
                                Juara Harapan 1
                            </td>
                            <td class="border border-black"></td>
                            <td class="border border-black"></td>
                        </tr>
                        <tr>
                            <td class="border border-black py-2 px-3">5</td>
                            <td class="border border-black py-2 px-3">
                                Juara Harapan 2
                            </td>
                            <td class="border border-black"></td>
                            <td class="border border-black"></td>
                        </tr>
                    </tbody>
                </table>
                <p>Demikian berita acara ini dibuat untuk dijadikan maklum.</p>
                <div class="ttd w-full grid grid-cols-3 mt-10">
                    <div>
                        <p>&nbsp;</p>
                        <p class="text-center">
                            Koordinator {{ props.bidang.label }}
                        </p>

                        <p class="underline mt-16 text-center">
                            .......................................................................
                        </p>
                        <p>NIP.</p>
                    </div>
                    <div></div>
                    <div>
                        <p class="text-center">
                            Wagir, {{ tanggal($page.props.lomba.tanggal) }}
                        </p>
                        <p class="text-center">Juri {{ props.bidang.label }}</p>

                        <p class="underline mt-16 text-center">
                            .......................................................................
                        </p>
                        <p>NIP.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
