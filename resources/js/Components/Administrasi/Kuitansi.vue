<script setup>
import { Icon } from "@iconify/vue";
import { computed, onBeforeMount, onMounted, ref } from "vue";
import { terbilang } from "@/Plugins/misc";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const props = defineProps({ items: Array, open: Boolean });
const emit = defineEmits(["close"]);
const uang = ref(300000);
const satuan = ref("sekolah");
const data = computed(() => {
    return Object.groupBy(props.items, ({ sekolah }) => sekolah.nama);
});

const generateSerial = () => {
    const chars = "0123456789ABCDEF";
    let result = "";
    for (var i = 0; i < 8; ++i) {
        var char = chars[Math.floor(Math.random() * chars.length)];
        result += char;
    }

    return result;
};

const items = ref([]);

const getItem = async () => {
    if (satuan.value == "peserta") {
        await axios.post(route("dashboard.peserta.index")).then((res) => {
            items.value = res.data.pesertas;
        });
    } else {
        await axios.post(route("sekolah.index")).then((res) => {
            items.value = res.data.sekolahs;
        });
    }
};

const cetak = () => {
    const el = document.querySelector(".content");
    const cssUrl =
        page.props.appEnv == "local"
            ? "http://pentaspai.test:5173/resources/css/app.css"
            : "/build/assets/app.css";

    let win = window.open("", "_blank", "width=1366,height=1080");

    let html = `
        <!doctype html>
        <html>
            <head>
                <title>Kuitansi Pentas PAI</title>    
                <link href="${cssUrl}" rel="stylesheet" />
            </head>
            <body>
                ${el.outerHTML}
            </body>
        </html>
    `;
    win.document.write(html);

    setTimeout(() => {
        win.print();
        win.close();
    }, 1000);
};

const bendahara = computed(() => {
    return page.props.panitias.filter(
        (panitia) => panitia.jabatan == "bendahara1"
    )[0];
});

onMounted(() => console.log(page.props));
onBeforeMount(async () => {
    await getItem();
});
</script>

<template>
    <div class="fixed top-0 right-0 left-0 bg-white z-40">
        <div
            class="toolbar flex items-center justify-between h-12 px-2 shadow print:hidden"
        >
            <h3>Kuitansi Pembayaran Registrasi</h3>
            <div class="flex items-center gap-2">
                Pilih Satuan:
                <select placeholder="Satuan" v-model="satuan">
                    <option value="sekolah">Sekolah</option>
                    <option value="peserta">Peserta</option>
                </select>

                Masukkan Nilai Uang:
                <input
                    type="number"
                    placeholder="Tentukan Harga"
                    v-model="uang"
                />
                <button
                    @click="cetak"
                    class="mr-4 flex items-center gap-1 rounded border border-slate-500 hover:bg-slate-600 transition-all duration-300 linear hover:text-white py-1 px-3 bg-slate-100"
                >
                    <Icon icon="mdi:printer" />
                    Cetak
                </button>
                <button
                    class="bg-red-600 text-white p-2"
                    @click="emit('close')"
                >
                    <Icon icon="mdi:close" />
                </button>
            </div>
        </div>
        <div
            class="content bg-slate-400 print:bg-white py-16 px-48 print:px-0 print:py-1 overflow-y-auto screen:max-h-[96vh]"
        >
            <div
                class="sheet bg-white m-4 break-inside-avoid break-after-always"
                v-for="(item, i) in items"
            >
                <div
                    class="grid grid-cols-12 h-[600px] print:h-[300px] border border-dashed print:border-slate-700"
                >
                    <div
                        class="col-span-2 flex items-center justify-center border-e border-dashed border-slate-500 print:text-sm"
                    >
                        <table class="mx-auto">
                            <tbody>
                                <tr>
                                    <td
                                        style="
                                            writing-mode: tb-rl;
                                            transform: rotate(-180deg);
                                        "
                                    >
                                        <h3>KKG PAI Kecamatan Wagir</h3>
                                        <h1>Panitia Pentas PAI</h1>
                                        <p class="print:text-xs">
                                            Sekretariat: SD Negeri Jedong
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img
                                            src="/img/logo_pentas.png"
                                            alt="Logo"
                                            class="h-32 print:h-16 -rotate-90"
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-span-10 p-6 relative">
                        <img
                            src="/img/logo_pentas.png"
                            alt="Logo-Background"
                            class="absolute left-[50%] -translate-x-[50%] top-[50%] -translate-y-[50%] opacity-30 print:h-48"
                        />
                        <div
                            class="content absolute top-0 right-0 bottom-0 left-0 bg-white bg-opacity-50 backdrop-blur p-4 text-xl"
                        >
                            <h1
                                class="text-6xl print:text-2xl text-right uppercase font-black"
                            >
                                Bukti Pembayaran
                            </h1>

                            <table class="print:text-xs">
                                <tbody>
                                    <tr class="border-b">
                                        <td class="py-4">No</td>
                                        <td class="py-4">:</td>
                                        <td class="py-4 font-black">
                                            {{
                                                (i < 10 ? "000" : "00") +
                                                (i + 1)
                                            }}
                                            / PENTAS-PAI / 2024
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <td>Telah terima dari</td>
                                        <td>:</td>
                                        <td>Bendahara {{ item.nama }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td>Terbilang</td>
                                        <td>:</td>
                                        <td
                                            class="font-black bg-slate-300 py-2 px-8 rounded-tl-full rounded-br-full bg-opacity-50"
                                        >
                                            {{ terbilang(uang) }} Rupiah
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <td>Untuk Pembayaran</td>
                                        <td>:</td>
                                        <td>
                                            Biaya Pendaftaran / Registrasi Lomba
                                            Pentas PAI Tahun 2024
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div
                                class="grid grid-cols-3 print:text-xs mt-16 print:mt-8"
                            >
                                <div class="col-span-1">
                                    <div>
                                        <p>
                                            Jumlah:
                                            <span
                                                class="font-black bg-slate-300 py-2 px-8 rounded-tl-full rounded-br-full"
                                            >
                                                Rp.
                                                {{
                                                    uang.toLocaleString()
                                                }}</span
                                            >
                                        </p>
                                    </div>
                                </div>
                                <div class="col-span-1"></div>
                                <div class="col-span-1">
                                    <p>Tanggal, 18 Desember 2024</p>
                                    <p>Bendahara Pentas PAI</p>
                                    <img
                                        :src="`/img/ttd/${bendahara?.guru?.nip}.png`"
                                        alt="TTD Bendahara"
                                        class="h-32 print:h-16 absolute -mt-4 translate-x-8"
                                    />
                                    <p
                                        class="font-bold underline mt-20 print:mt-10"
                                    >
                                        {{ bendahara?.guru?.nama }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
