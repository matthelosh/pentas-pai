<script setup>
import { ref, onMounted, defineAsyncComponent } from "vue";
import { XCircleIcon } from "@heroicons/vue/20/solid";
import { imgUrl } from "@/Plugins/misc";
import { usePage } from "@inertiajs/vue3";
const Kop = defineAsyncComponent(() => import("@/Components/General/Kop.vue"));
const page = usePage();
const props = defineProps({
    bidang: Object,
});

const selectedBidang = ref({});

onMounted(() => {
    list();
});

const cetak = () => {
    window.print();
};
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
</script>

<template>
    <div class="w-full bg-white">
        <div
            class="w-full bg-white h-12 shadow-lg flex items-center justify-between p-2 border-b-2 border-teal-400 print:hidden"
        >
            Presensi Peserta Lomba {{ props.bidang.label }}
            <div class="toolbar-items flex items-center gap-2">
                <button
                    class="mr-4 hover:border-sky-400 hover:text-sky-500 border py-1 px-2 rounded"
                    @click="cetak"
                >
                    Cetak
                </button>
                <XCircleIcon
                    class="text-red-600 h-6 cursor-pointer"
                    @click="$emit('close')"
                />
            </div>
        </div>

        <div
            class="table bg-white w-full p-5 shadow-lg print:shadow-none print: print:mt-4 break-inside-avoid"
        >
            <Kop />
            <table
                class="table border border-collapse w-10/12 mx-auto print:w-full"
            >
                <caption class="text-center text-xl my-6 uppercase font-bold">
                    Daftar Hadir Peserta Lomba
                    {{
                        props.bidang.label
                    }}
                </caption>
                <thead class="bg-gray-50">
                    <tr>
                        <th class="border px-2 py-3">No</th>
                        <th class="border px-2 py-3">No. Urut</th>
                        <th class="border px-2 py-3">NISN</th>
                        <th class="border px-2 py-3">Nama</th>
                        <th class="border px-2 py-3">JK</th>
                        <th class="border px-2 py-3">Sekolah</th>
                        <th class="border px-2 py-3" style="width: 20%">
                            TTD / Paraf
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(peserta, p) in selectedBidang.pesertas"
                        :key="p"
                    >
                        <td class="border px-2 py-2 text-center">
                            {{ p + 1 }}
                        </td>
                        <td class="border px-2 py-2 text-center font-bold">
                            {{ peserta.urutans[0].ke }}
                        </td>
                        <td class="border px-2 py-2">
                            {{ peserta.nisn }}
                        </td>
                        <td class="border px-2 py-2">
                            <span class="flex items-center h-full">
                                <span>
                                    <img
                                        :src="imgUrl(peserta.foto)"
                                        alt="Foto"
                                        onerror="this.error = null;this.src='/img/peserta.png'"
                                        class="h-10 rounded-full aspect-square print:aspect-square object-cover object-top mr-2"
                                    />
                                </span>
                                {{ peserta.nama }}
                            </span>
                        </td>
                        <td class="border px-2 py-2">{{ peserta.jk }}</td>
                        <td class="border px-2 py-2">
                            {{ peserta.sekolah.nama }}
                        </td>
                        <td class="border px-2 py-2 w-[150px] align-text-top">
                            <span class="text-xs text-gray-400">{{
                                p + 1
                            }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="grid grid-cols-3 mt-6">
                <div></div>
                <div></div>
                <div class="relative">
                    <p>
                        Wagir,
                        {{
                            new Date(
                                page.props.lomba.tanggal
                            ).toLocaleDateString("id-ID", {
                                day: "numeric",
                                month: "long",
                                year: "numeric",
                            })
                        }}
                    </p>
                    <p>Ketua Panitia</p>
                    <img
                        src="/img/ttd-ketua.jpg"
                        alt="TTD Ketua"
                        class="absolute h-24 -mt-2 mix-blend-multiply"
                    />
                    <p class="font-bold underline mt-16">
                        {{
                            page.props.panitias.filter(
                                (pan) => pan.jabatan == "ket"
                            )[0].guru.nama
                        }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
