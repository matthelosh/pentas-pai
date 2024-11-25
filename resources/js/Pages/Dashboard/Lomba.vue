<script setup>
import Dash from "@/Layout/Dash.vue";
import { ref, defineAsyncComponent } from "vue";
import { CheckCircleIcon } from "@heroicons/vue/20/solid";
import { Head, router, usePage } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
import axios from "axios";
import * as _ from "lodash-es";
import SvgIcon from "@jamescoyle/vue-icon";
import { mdiMinusCircle } from "@mdi/js";
const PBtn = defineAsyncComponent(() =>
    import("@/Components/General/PBtn.vue")
);
const page = usePage();

const mode = ref("list");

// Form Lomba
const formLomba = ref(false);
const FormLomba = defineAsyncComponent(() =>
    import("@/Components/Lomba/FormLomba.vue")
);
const closeLomba = () => {
    formLomba.value = false;
    selectedLomba.value = null;
    router.reload({ only: ["lombas"] });
};

// Ruwet
const selectedLokasi = ref(null);

const AlertBox = defineAsyncComponent(() =>
    import("@/Components/General/AlertBox.vue")
);
const alertBox = ref(null);

const DialogBox = defineAsyncComponent(() =>
    import("@/Components/General/DialogBox.vue")
);
const dialogBox = ref(null);

const bidangs = (pesertas) => {
    return _.groupBy(pesertas, "lomba_id");
};

const onSelectedLokasi = (e) => {
    selectedLokasi.value = e.target.value;
};

const toggleStatus = async (lomba) => {
    if (lomba.status == "1") {
        alertBox.value.open("Error", "Lomba " + lomba.label + " sudah aktif.");
        return false;
    }
    if (await dialogBox.value.open("Aktifkan Lomba " + lomba.label + "?")) {
        if (!lomba.sekolah) {
            alertBox.value.open("Error", "Tentukan lokasi lomba");
            // console.log(lomba)
            return false;
        } else {
            selectedLokasi.value = lomba.lokasi_id;
        }
        axios
            .put(route("lomba.activate", { id: lomba.id }), {
                lokasi_id: selectedLokasi.value,
            })
            .then((res) => {
                router.reload({ only: ["lombas"] });
                alertBox.value.open("Ok", `${lomba.label} diaktifkan.`);
            })
            .catch((err) => console.log(err));
    }
};

const removeBidang = async (bidang, lomba) => {
    if (
        await dialogBox.value.open(
            "Hapus Bidang " + bidang.label + " pada " + lomba.label + "?"
        )
    ) {
        axios.delete(route("bidang.destroy", { id: bidang.id })).then((res) => {
            router.reload({ only: ["lombas"] });
            alertBox.value.open("Ok", res.data.msg);
        });
        console.log(bidang, lomba);
    }
};

// Panitia
const Panitia = defineAsyncComponent(() =>
    import("@/Pages/Dashboard/Panitia.vue")
);
const selectedLomba = ref(null);
const panitiaMode = ref("");

const viewPanitia = (lomba) => {
    selectedLomba.value = lomba;
    mode.value = "panitia";
    panitiaMode.value = "view";
};
const createPanitia = (lomba) => {
    selectedLomba.value = lomba;
    mode.value = "panitia";
    panitiaMode.value = "create";
};

const editLomba = (lomba) => {
    formLomba.value = true;
    selectedLomba.value = lomba;
};

const FormAspek = defineAsyncComponent(() =>
    import("@/Components/Lomba/FormAspek.vue")
);

const selectedBidang = ref(null);
const formAspek = ref(false);
const showFormAspek = (item) => {
    // console.log(item);
    selectedBidang.value = item;
    formAspek.value = true;
};

const closeFormAspek = () => {
    selectedBidang.value = null;
    formAspek.value = false;
};

// Form Juri
const FormJuri = defineAsyncComponent(() =>
    import("@/Components/Lomba/FormJuri.vue")
);
const formJuri = ref(false);
const showFormJuri = (item) => {
    // console.log(item);
    selectedBidang.value = item;
    formJuri.value = true;
};

const closeFormJuri = () => {
    formJuri.value = false;
    selectedBidang.value = null;
};
</script>

<template>
    <Head title="Data Perlombaan" />
    <DialogBox ref="dialogBox" />
    <AlertBox ref="alertBox" />
    <FormJuri
        v-if="formJuri"
        :selectedBidang="selectedBidang"
        :open="formJuri"
        @close="closeFormJuri"
    />
    <FormLomba
        :show="formLomba"
        @close="closeLomba"
        :lomba="selectedLomba"
        v-if="formLomba"
    />
    <Dash title="Data Lomba">
        <Panitia
            v-if="mode == 'panitia'"
            :lomba="selectedLomba"
            @close="mode = 'list'"
        />
        <FormAspek
            v-if="formAspek"
            :open="formAspek"
            :selectedBidang="selectedBidang"
            @close="closeFormAspek"
        />
        <div class="w-full min-h-[100vh] relative" v-if="mode == 'list'">
            <div
                class="hidden sm:block bg-white my-4 md:mt-0 rounded-xl overflow-hidden"
            >
                <div
                    class="toolbar bg-gray-100 h-12 flex items-center justify-between p-3 sticky top-0 print:hidden"
                >
                    <span class="flex items-center gap-1">
                        <Icon icon="mdi-trophy" />
                        Lomba
                    </span>
                    <div class="toolbar-items flex items-center">
                        <p-btn color="sky" @click="formLomba = true">
                            Baru
                        </p-btn>
                    </div>
                </div>
                <div class="content w-full bg-white p-3 mt-2">
                    <div class="overflow-x-auto w-full border">
                        <table
                            class="w-[100%] table table-responsive border-collapse"
                        >
                            <caption class="text-center text-xl font-bold my-2">
                                Data Lomba
                            </caption>
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="py-2 px-3">No</th>
                                    <th class="py-2 px-3">Label</th>
                                    <th class="py-2 px-3 hidden md:block">
                                        Tahun
                                    </th>
                                    <th class="py-2 px-3">
                                        Bidang Lomba dan Peserta
                                    </th>
                                    <th class="py-2 px-3">Lokasi</th>
                                    <th class="py-2 px-3">Panitia</th>
                                    <th class="py-2 px-3 print:hidden">Opsi</th>
                                </tr>
                            </thead>
                            <tbody v-if="page.props.lombas">
                                <tr
                                    class="odd:bg-gray-100 hover:bg-lime-50"
                                    v-for="(lomba, l) in page.props.lombas"
                                    :key="l"
                                >
                                    <td class="text-center">{{ l + 1 }}</td>
                                    <td
                                        class="px-3 text-sky-800 hover:underline hover:cursor-pointer"
                                        @click="editLomba(lomba)"
                                    >
                                        {{ lomba.label }}
                                    </td>
                                    <td class="text-center hidden md:block">
                                        {{ lomba.tahun }}
                                    </td>
                                    <td class="px-3">
                                        <ul v-if="lomba.bidangs">
                                            <li
                                                v-for="(
                                                    bidang, b
                                                ) in lomba.bidangs"
                                                :key="b"
                                                class="my-1 group flex items-center"
                                            >
                                                {{ bidang?.label }} &nbsp;
                                                <span
                                                    class="text-orange-400 font-bold"
                                                >
                                                    [{{
                                                        bidang?.pesertas?.length
                                                    }}
                                                    orang]</span
                                                >
                                                <button
                                                    class="group-hover:inline-block hidden"
                                                    @click="
                                                        removeBidang(
                                                            bidang,
                                                            lomba
                                                        )
                                                    "
                                                >
                                                    <SvgIcon
                                                        type="mdi"
                                                        :path="mdiMinusCircle"
                                                        class="text-red-600"
                                                    />
                                                </button>
                                            </li>
                                        </ul>
                                    </td>
                                    <td class="px-3">
                                        {{ lomba.sekolah.nama }}
                                    </td>
                                    <td class="px-3">
                                        <button
                                            class="py-1 px-2 bg-sky-400 hover:bg-sky-600 active:bg-orange-400 text-white rounded"
                                            @click="viewPanitia(lomba)"
                                            v-if="lomba.panitias.length > 0"
                                        >
                                            Lihat
                                        </button>
                                        <button
                                            class="py-1 px-2 bg-sky-400 hover:bg-sky-600 active:bg-orange-400 text-white rounded"
                                            @click="createPanitia(lomba)"
                                            v-else
                                        >
                                            Buat
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <button>
                                            <CheckCircleIcon
                                                class="h-8"
                                                :class="
                                                    lomba.status == '1'
                                                        ? 'text-lime-400'
                                                        : 'text-gray-200'
                                                "
                                                @click="toggleStatus(lomba)"
                                            />
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="block sm:hidden my-4">
                <div
                    class="card rounded-xl bg-white w-full mb-4 overflow-hidden shadow"
                    v-for="(lomba, l) in page.props.lombas"
                >
                    <div
                        class="w-full bg-slate-200 p-3 flex items-center justify-between"
                    >
                        <span class="font-bold text-teal-800 uppercase">
                            Tahun {{ lomba.tahun }}
                        </span>

                        <div class="flex items-center">
                            <button
                                class="p-1 bg-orange-400 hover:bg-sky-600 active:bg-orange-400 text-white rounded-full"
                                @click="viewPanitia(lomba)"
                                v-if="lomba.panitias.length > 0"
                            >
                                <Icon icon="mdi-account-tie" />
                            </button>
                            <button
                                class="p-1 bg-sky-400 hover:bg-sky-600 active:bg-orange-400 text-white rounded-full"
                                @click="createPanitia(lomba)"
                                v-else
                            >
                                <Icon icon="mdi-account-tie" />
                            </button>
                            <button class="ml-2">
                                <CheckCircleIcon
                                    class="h-8"
                                    :class="
                                        lomba.status == '1'
                                            ? 'text-lime-400'
                                            : 'text-white'
                                    "
                                    @click="toggleStatus(lomba)"
                                />
                            </button>
                        </div>
                    </div>
                    <ol class="list-inside p-3">
                        <li
                            class="py-3 items-center flex justify-between border-y border-slate-300 border-dashed"
                            v-for="bidang in lomba.bidangs"
                        >
                            <div class="flex items-center gap-2">
                                {{
                                    bidang.label.split(" ").length === 3
                                        ? bidang.label.split(" ")[0] +
                                          " " +
                                          bidang.label.split(" ")[1]
                                        : bidang.label.split(" ")[0]
                                }}
                            </div>
                            <div class="flex items-center gap-2">
                                <span
                                    class="flex items-center gap-1 text-sky-700 bg-sky-50 p-2 rounded border-sky-200"
                                >
                                    <Icon
                                        icon="mdi-human"
                                        class="text-sky-500"
                                    />
                                    <span class="font-bold">
                                        {{ bidang.pesertas.length }}
                                    </span>
                                </span>
                                <button
                                    class="text-teal-700 rounded p-2 flex items-center gap-1 bg-teal-100"
                                    @click="showFormAspek(bidang)"
                                >
                                    <Icon icon="mdi:list-status" />
                                    <span class="font-bold">
                                        {{ bidang.aspeks.length }}
                                    </span>
                                </button>
                                <button
                                    class="text-sky-700 rounded p-2 flex items-center gap-1 bg-sky-100 relative"
                                    @click="showFormJuri(bidang)"
                                >
                                    <Icon
                                        icon="mdi:account-tie"
                                        class="text-2xl"
                                    />
                                    <span
                                        class="badge absolute bg-red-500 text-white rounded-full text-sm h-6 w-6 flex items-center justify-center -top-2 -right-2"
                                        >{{ bidang.juris.length }}</span
                                    >
                                </button>
                                <button
                                    class="text-red-700 rounded p-2 flex items-center gap-1 bg-red-100"
                                    @click="removeBidang(bidang, lomba)"
                                >
                                    <Icon icon="mdi-trash" class="text-2xl" />
                                </button>
                            </div>
                        </li>
                    </ol>
                </div>

                <button
                    class="fixed z-30 bg-sky-200 shadow-lg p-2 rounded-full right-2 bottom-8"
                    @click="formLomba = true"
                >
                    <Icon icon="mdi:plus" class="text-4xl text-sky-600" />
                </button>
            </div>
        </div>
    </Dash>
</template>
