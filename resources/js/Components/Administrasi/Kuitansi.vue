<script setup>
import { Icon } from "@iconify/vue";
import { computed, ref } from "vue";
import { terbilang } from "@/Plugins/misc";
const props = defineProps({ items: Array, open: Boolean });
const emit = defineEmits(["close"]);
const uang = ref(300000);
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

const cetak = () => window.print();
</script>

<template>
    <div class="fixed top-0 right-0 bottom-0 left-0 bg-white z-40">
        <div
            class="toolbar flex items-center justify-between h-12 px-2 shadow print:hidden"
        >
            <h3>Kuitansi Pembayaran Registrasi</h3>
            <div class="flex items-center gap-2">
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
            class="content bg-slate-400 print:bg-white py-16 px-48 print:p-0 overflow-y-auto max-h-[96vh]"
        >
            <div
                class="sheet bg-white m-4 break-inside-avoid break-after-always"
                v-for="item in Object.entries(data)"
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
                                            Sekretariat: SD Negeri 2
                                            Mendalanwangi
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
                                            {{ generateSerial() }} / PENTAS-PAI
                                            / 2024
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <td>Telah terima dari</td>
                                        <td>:</td>
                                        <td>Bendahara {{ item[0] }}</td>
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
                            <div class="grid grid-cols-3 print:text-xs mt-16">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
