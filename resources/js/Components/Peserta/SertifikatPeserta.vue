<script setup>
import { ref, onMounted, computed } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import { XCircleIcon, PrinterIcon, Bars3Icon } from "@heroicons/vue/20/solid";
import { Icon } from "@iconify/vue";
import VueQrcode from "@chenfengyuan/vue-qrcode";
import { imgUrl } from "@/Plugins/misc";
import axios from "axios";
import { paginate } from "@/Plugins/misc";
import jsPDF from "jspdf";
import html2canvas from "html2canvas";
import { namaSekolah } from "@/Plugins/misc";

onMounted(() => {
    list();
});

const page = usePage();
const props = defineProps({
    bidang: Object,
});

const mode = ref("list");

const pesertas = ref([]);

const sekolahs = computed(() => {
    return pesertas.value.map((peserta) => peserta.sekolah);
});

const sekolah = ref("0");
const list = async () => {
    await axios
        .post(
            route("dashboard.peserta.index", {
                _query: { bidang: props.bidang.id },
            })
        )
        .then((res) => {
            pesertas.value = res.data.pesertas;
        });
};

const currentPage = ref(1);

const items = computed(() => {
    let datas =
        sekolah.value == "0"
            ? pesertas.value
            : pesertas.value.filter(
                  (peserta) => peserta.sekolah_id == sekolah.value
              );
    return paginate(datas, currentPage.value);
});

const selectedPeserta = ref({});

const viewSertificate = (peserta) => {
    mode.value = "cetak";
    selectedPeserta.value = peserta;
    headTitle.value =
        "Sertifikat Peserta " + props.bidang.label + " - " + peserta.nama;
};

const cetak = () => {
    // let paper = document.querySelector(".paper")

    // let win = window.open("","_blank", "width=1024,height=800")
    // let html = `<!doctype html>
    //             <html>
    //                 <head>
    //                     <title>Sertifikat ${page.props.lomba.label} ${props.bidang.label} - ${selectedPeserta.value.nama} - ${selectedPeserta.value.sekolah.nama} </title>
    //                     <link href="http://pentaspai.test:5173/resources/css/app.css" rel="stylesheet" />
    //                     <style>

    //                     </style>
    //                 </head>
    //                 <body>
    //                     ${paper.outerHTML}
    //                 </body>
    //             </html>

    // `
    // win.document.write(html)

    headTitle.value = `Sertifikat ${page.props.lomba.label} ${props.bidang.label} - ${selectedPeserta.value.nama} - ${selectedPeserta.value.sekolah.nama} `;
    setTimeout(() => {
        window.print();
    }, 500);
};

const nama = (nama) => {
    return nama.toLowerCase();
};

const unduh = async () => {
    const pdfContent = document.querySelector(".paper");

    const canvas = await html2canvas(pdfContent, { scale: 2 });
    const imgData = canvas.toDataURL("image/png");

    const pdf = new jsPDF("landscape", "mm", "a4");
    const imgWidth = 294;
    const imgHeight = 207;
    let position = 0;
    pdf.addImage(imgData, "PNG", 5, position + 5, imgWidth, imgHeight);
    pdf.save("example.pdf");
};

const headTitle = ref("Sertifikat Peserta");
</script>

<template>
    <div>
        <Head :title="headTitle" />
        <div class="w-full bg-white rounded-xl">
            <div
                class="toolbar w-full h-12 bg-white flex items-center justify-between p-3 shadow sticky top-0 z-10 print:hidden mt-4 md:mt-0 rounded-t-xl"
            >
                <span class="toolbar-title hidden md:block">
                    Sertifikat Peserta Lomba {{ props.bidang.label }}
                </span>
                <div
                    class="toolbar-items flex items-center gap-2 justify-end w-full md:w-auto"
                >
                    <select
                        name="sekolah"
                        v-model="sekolah"
                        class="hidden md:block"
                    >
                        <option value="0">Semua Sekolah</option>
                        <option
                            v-for="(school, s) in sekolahs"
                            :value="school.npsn"
                        >
                            {{ school.nama }}
                        </option>
                    </select>
                    <button
                        class="bg-sky-400 hover:bg-sky-600 active:bg-orange-400 text-white flex gap-1 items-center py-1 px-2 rounded"
                        @click="mode = 'list'"
                    >
                        Lihat
                        <Bars3Icon class="h-8" />
                    </button>
                    <button
                        class="bg-sky-400 hover:bg-sky-600 active:bg-orange-400 text-white flex gap-1 items-center py-1 px-2 rounded"
                        @click="cetak"
                    >
                        Cetak
                        <PrinterIcon class="h-8" />
                    </button>
                    <button
                        class="bg-sky-400 hover:bg-sky-600 active:bg-orange-400 text-white flex gap-1 items-center py-2 px-2 rounded"
                        @click="unduh"
                    >
                        Unduh
                        <Icon icon="mdi:file-pdf" class="text-xl" />
                    </button>
                    <button
                        class="bg-red-400 hover:bg-red-600 active:bg-orange-400 text-white aspect-square rounded-full"
                        @click="$emit('close')"
                    >
                        <XCircleIcon class="h-8" />
                    </button>
                </div>
            </div>
            <div class="content print:p-0 overflow-auto">
                <div class="table w-full" v-if="mode == 'list'">
                    <table class="table w-full bg-white border border-collapse">
                        <caption class="text-xl my-4">
                            Data Peserta Bidang Lomba
                            {{
                                props.bidang.label
                            }}
                        </caption>
                        <thead>
                            <tr class="bg-gray-200">
                                <th
                                    class="py-2 px-3 text-gray-800 border-e border-gray-400"
                                >
                                    No
                                </th>
                                <th
                                    class="py-2 px-3 text-gray-800 border-e border-gray-400"
                                >
                                    NISN
                                </th>
                                <th
                                    class="py-2 px-3 text-gray-800 border-e border-gray-400"
                                >
                                    Nama
                                </th>
                                <th
                                    class="py-2 px-3 text-gray-800 border-e border-gray-400"
                                >
                                    JK
                                </th>
                                <th
                                    class="py-2 px-3 text-gray-800 border-e border-gray-400"
                                >
                                    Sekolah
                                </th>
                                <th
                                    class="py-2 px-3 text-gray-800 border-e border-gray-400"
                                >
                                    Bidang Lomba
                                </th>
                                <th
                                    class="py-2 px-3 text-gray-800 print:hidden"
                                >
                                    Opsi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="odd:bg-gray-100 hover:bg-lime-100"
                                v-for="(peserta, p) in items.current"
                                :key="p"
                            >
                                <td
                                    class="text-center py-1 px-2 border-e border-gray-400"
                                >
                                    {{ p + 1 }}
                                </td>
                                <td class="py-1 px-2 border-e border-gray-400">
                                    {{ peserta.nisn }}
                                </td>
                                <td class="py-1 px-2 border-e border-gray-400">
                                    {{ peserta.nama }}
                                </td>
                                <td class="py-1 px-2 border-e border-gray-400">
                                    {{ peserta.jk }}
                                </td>
                                <td class="py-1 px-2 border-e border-gray-400">
                                    {{ namaSekolah(peserta.sekolah.nama) }}
                                </td>
                                <td
                                    class="py-1 px-2 border-e border-gray-400 text-center"
                                >
                                    {{ props.bidang.label }}
                                </td>
                                <td class="py-1 px-2 print:hidden text-center">
                                    <button
                                        class="py-1 px-2 rounded hover:bg-green-600 active:bg-orange-400 bg-green-400 text-white"
                                        @click="viewSertificate(peserta)"
                                    >
                                        Cetak
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="pagination p-1">
                        <div
                            class="w-full bg-gray-200 flex items-center justify-between px-3 flex-wrap print:hidden"
                        >
                            <div class="flex items-center gap-1">
                                Total: {{ items.dataLength }}
                            </div>
                            Jml Halaman: {{ items.pageCount }}
                        </div>
                        <div
                            class="w-full flex flex-wrap md:justify-end print:hidden"
                        >
                            <button
                                @click="currentPage -= 1"
                                class="flex justify-center w-8 border border-gray-500 flex-grow md:flex-grow-0"
                                :disabled="currentPage == 1"
                            >
                                &lt;
                            </button>
                            <button
                                v-for="b in items.pageCount"
                                :key="b"
                                class="flex justify-center w-8 border border-gray-500 flex-grow md:flex-grow-0"
                                :class="
                                    b == currentPage
                                        ? 'bg-sky-600 text-white'
                                        : ''
                                "
                                @click="currentPage = b"
                            >
                                {{ b }}
                            </button>
                            <button
                                @click="currentPage += 1"
                                class="flex justify-center w-8 border border-gray-500 flex-grow md:flex-grow-0"
                                :disabled="currentPage >= items.pageCount"
                            >
                                &gt;
                            </button>
                        </div>
                    </div>
                </div>

                <div
                    class="w-full flex justify-center py-8 print:p-0 relative"
                    v-if="mode == 'cetak'"
                >
                    <button
                        class="absolute bg-teal-200 hover:bg-teal-500 text-white z-40 top-[50%] -translate-y-[50%] left-4 p-3 rounded-full hover:translate-x-2 transition-all duration-300"
                    >
                        <Icon icon="mdi:arrow-left" class="text-xl" />
                    </button>
                    <button
                        class="absolute bg-teal-200 hover:bg-teal-500 text-white z-40 top-[50%] -translate-y-[50%] right-4 p-3 rounded-full hover:-translate-x-2 transition-all duration-300"
                    >
                        <Icon icon="mdi:arrow-right" class="text-xl" />
                    </button>
                    <div class="wrapper relative shadow-lg print:shadow-none">
                        <div
                            class="paper h-[207mm] w-[294mm] bg-slate-50 print:my-0 rounded print:rounded-0 relative bg-[url('/img/sertifikat/bg.png')]"
                        >
                            <div
                                class="bg absolute top-0 right-0 bottom-0 left-0"
                            >
                                <div
                                    class="content bg absolute top-0 right-0 bottom-0 left-0 flex overflow-x-hidden"
                                >
                                    <div
                                        class="side w-[305px] h-full bg-[#eeeeeeff] relative pt-28"
                                    >
                                        <img
                                            src="/img/sertifikat/corner-tl.png"
                                            alt=""
                                            class="absolute top-0"
                                        />
                                        <div
                                            class="foto bg-slate-300 w-[200px] h-[200px] rounded-full mx-auto overflow-hidden"
                                        >
                                            <img
                                                :src="selectedPeserta.foto"
                                                alt="Foto Peserta"
                                                onerror="this.error=null;this.src='/img/peserta.png';"
                                            />
                                        </div>
                                        <h3
                                            class="text-center w-[80%] mx-auto my-1 font-bold mt-4"
                                        >
                                            No. {{ selectedPeserta.nisn }}
                                        </h3>
                                        <h3
                                            class="text-center w-[80%] mx-auto my-1 font-bold"
                                        >
                                            {{
                                                namaSekolah(
                                                    selectedPeserta.sekolah.nama
                                                )
                                            }}
                                        </h3>
                                        <img
                                            src="/img/sertifikat/dots.png"
                                            alt=""
                                            class="left-[50%] absolute -translate-x-[50%] bottom-8"
                                        />
                                        <img
                                            src="/img/sertifikat/piala.png"
                                            alt=""
                                            class="left-0 bottom-0 absolute"
                                        />
                                    </div>
                                    <div
                                        class="main-content w-[817px] h-full overflow-hidden relative border-box"
                                    >
                                        <img
                                            src="/img/sertifikat/ornamen-1.png"
                                            alt="Ornamen"
                                            class="absolute top-[50%] -translate-y-[50%] -translate-x-[80%]"
                                        />
                                        <img
                                            src="/img/sertifikat/bendera.png"
                                            alt="Bendera"
                                            class="absolute right-0 top-0"
                                        />
                                        <img
                                            src="/img/sertifikat/ornamen-br.png"
                                            alt="Pojok Kanan Bawah"
                                            class="absolute right-0 bottom-0"
                                        />

                                        <div
                                            class="absolute w-full pl-16 pr-8 py-4"
                                        >
                                            <div
                                                class="kop w-full flex justify-between items-start"
                                            >
                                                <div class="logo flex">
                                                    <img
                                                        src="/img/logo_pentas.png"
                                                        alt="Logo Pentas"
                                                        class="h-[90px]"
                                                    />
                                                    <img
                                                        src="/img/kurmer.png"
                                                        alt="Logo Kurmer"
                                                        class="h-20"
                                                    />
                                                </div>
                                                <div
                                                    class="icons flex gap-4 items-end pr-16"
                                                >
                                                    <img
                                                        src="/img/tutwuri.png"
                                                        alt="Logo Tutwuri"
                                                        class="h-[40px]"
                                                    />
                                                    <img
                                                        src="/img/kemenag.png"
                                                        alt="Logo Kemenag"
                                                        class="h-[40px]"
                                                    />
                                                    <img
                                                        src="/img/malangkab.png"
                                                        alt="Logo Malangkab"
                                                        class="h-[40px]"
                                                    />
                                                    <img
                                                        src="/img/logo_kkg.png"
                                                        alt="Logo KKG PAI Wagir"
                                                        class="h-[40px]"
                                                    />
                                                </div>
                                            </div>
                                            <div
                                                class="title uppercase w-[60%]"
                                            >
                                                <h3
                                                    style="
                                                        font-weight: 1000;
                                                        font-family: Arial,
                                                            Helvetica,
                                                            sans-serif;
                                                        font-size: 4rem;
                                                        line-height: 4rem;
                                                        color: #235678;
                                                    "
                                                >
                                                    Sertifikat Apresiasi
                                                </h3>
                                            </div>
                                            <div
                                                class="present text-2xl font-[arial] font-black text-[#235678] mt-6"
                                            >
                                                Diberikan kepada:
                                            </div>
                                            <div
                                                class="nama text-[3rem] font-black text-[#b74919ff] font-[arial] tracking-wide"
                                            >
                                                {{ selectedPeserta.nama }}
                                            </div>
                                            <!-- <div
                                            class="horizontal-line h-1 bg-[#235678]"
                                        ></div> -->
                                            <div
                                                class="text text-justify text-sky-900 text-lg mt-4"
                                            >
                                                Atas partisipasi dalam kegiatan
                                                "<span class="font-bold">{{
                                                    page.props.lomba.label
                                                }}</span
                                                >" yang diselenggarakan pada
                                                tanggal
                                                {{
                                                    new Date(
                                                        page.props.lomba.tanggal
                                                    ).toLocaleDateString(
                                                        "id-ID",
                                                        {
                                                            day: "2-digit",
                                                            month: "long",
                                                            year: "numeric",
                                                        }
                                                    )
                                                }}
                                                di
                                                {{
                                                    namaSekolah(
                                                        page.props.lomba.sekolah
                                                            .nama
                                                    )
                                                }}. Semoga dapat menjadi
                                                motivasi dalam mengingkatkan
                                                prestasi di masa mendatang.
                                            </div>
                                            <div
                                                class="ttd w-[80%] flex justify-between mt-10"
                                            >
                                                <div class="kkg">
                                                    <p>Ketua KKG PAI</p>
                                                    <img
                                                        src="/img/stempel.png"
                                                        alt="Stemple KKG"
                                                        class="absolute h-[150px] -translate-x-[60px]"
                                                    />
                                                    <img
                                                        src="/img/ttd-kkg.png"
                                                        alt="TTD KKG"
                                                        class="absolute h-[100px]"
                                                    />

                                                    <p
                                                        class="mt-20 font-bold underline leading-4"
                                                    >
                                                        Saiful Arif, S. Ag., M.
                                                        Pd
                                                    </p>
                                                    <p class="leading-4">
                                                        NIP. 19760316 201001 1
                                                        007
                                                    </p>
                                                </div>
                                                <div class="panitia">
                                                    <p>Ketua Panitia</p>
                                                    <img
                                                        src="/img/ttd-ketua.jpg"
                                                        alt="TTD KKG"
                                                        class="absolute h-[100px] mix-blend-multiply"
                                                    />
                                                    <p
                                                        class="mt-20 font-bold underline leading-4"
                                                    >
                                                        Maa Rizal Ula, S. Pd.I
                                                    </p>
                                                    <p class="leading-4">
                                                        NIP. 19930308 202421 1
                                                        025
                                                    </p>
                                                </div>
                                            </div>

                                            <VueQrcode
                                                value="https://pentaspai.kkgpaiwagir.or.id"
                                                class="absolute left-38 ml-40"
                                                :scale="2"
                                                width="50"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
