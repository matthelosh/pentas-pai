<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import SvgIcon from "@jamescoyle/vue-icon";
import { mdiClose, mdiMinusCircle, mdiPlusCircle } from "@mdi/js";

const props = defineProps({
    show: Boolean,
    lomba: Object,
});

const lomba = ref({
    lokasi_id: "0",
    bidangs: [],
});

const selectedBidangs = ref([]);
const sekolahs = ref([]);
const bidangs = ref([
    { kode: "adz", label: "Adzan" },
    { kode: "bjr", label: "Banjari" },
    { kode: "lcc", label: "Cerdas Cermat" },
    { kode: "mtq", label: "MTQ" },
    { kode: "mhq", label: "MHQ" },
    { kode: "pdc", label: "Pildacil" },
]);

const categories = ref(["tunggal", "regu"]);

const groups = ref(["putra", "putri", "campur"]);

const listSekolah = async () => {
    await axios
        .post(route("sekolah.index"))
        .then((res) => {
            sekolahs.value = res.data.sekolahs;
        })
        .catch((err) => {
            console.log(err);
        });
};

const addBidang = () => {
    lomba.value.bidangs.push({
        lomba_id: lomba.value.id,
        kode: "",
        label: "",
        kategori: "",
        kelompok: "",
        deskripsi: "",
    });
};

const removeBidang = (index) => {
    lomba.value.bidangs.splice(index, 1);
};

const simpan = async () => {
    // lomba.value.bidangs = selectedBidangs.value
    console.log(lomba.value);
    axios
        .post(route("lomba.store"), { lomba: JSON.stringify(lomba.value) })
        .then((res) => {
            lomba.value = ref({ lokasi_id: "0" });
            emit("close");
        })
        .catch((err) => {
            console.log(err);
        });
};

const onBidangChanged = (e, b) => {
    lomba.value.bidangs[b].kode = `${lomba.value.kode}-${
        bidangs.value.filter((bid) => bid.label == e.target.value)[0].kode
    }-${lomba.value.bidangs[b].kategori == "tunggal" ? "t" : "r"}-${
        lomba.value.bidangs[b].kelompok[0] +
        lomba.value.bidangs[b].kelompok[
            lomba.value.bidangs[b].kelompok.length - 1
        ]
    }`;
    lomba.value.bidangs[
        b
    ].deskripsi = `${lomba.value.label} Bidang  ${lomba.value.bidangs[b].label} ${lomba.value.bidangs[b].kategori} ${lomba.value.bidangs[b].kelompok} `;
    console.log(e, b);
};

const emit = defineEmits(["close"]);
const tutup = () => {
    lomba.value = ref({ lokasi_id: "0" });
    emit("close");
};
onMounted(() => {
    listSekolah();
    if (props.lomba) {
        lomba.value = props.lomba;
        // if(props.lomba.bidangs.length > 0) {
        //     let datas = []
        //     props.lomba.bidangs.forEach(bidang => {
        //         datas.push(bidang.id)
        //     })
        //     selectedBidangs.value = datas
        // }
    }
});
</script>

<template>
    <div
        class="fixed top-0 right-0 bottom-0 left-0 bg-gray-800 bg-opacity-60 z-40 flex items-center justify-center"
        v-if="show"
    >
        <div
            class="card h-screen w-full md:w-4/4 bg-white rounded-xl overflow-x-hidden overflow-y-auto"
        >
            <div
                class="card-toolbar h-12 bg-sky-600 text-white p-4 flex justify-between items-center rounded-t-xl sticky top-0"
            >
                Data Lomba
                <button @click="tutup">
                    <svg-icon
                        type="mdi"
                        :path="mdiClose"
                        class="text-red-100 hover:text-red-300"
                    />
                </button>
            </div>
            <div class="card-content w-full p-4">
                <form
                    @submit.prevent="simpan"
                    ref="formLomba"
                    class="form flex-col gap-2 flex"
                >
                    <label for="Kode" class="flex items-center gap-3">
                        <span class="flex-grow"> Kode Lomba: </span>
                        <input
                            type="text"
                            name="kode"
                            placeholder="Kode Lomba"
                            v-model="lomba.kode"
                            class="w-3/4 rounded-full"
                        />
                    </label>
                    <label for="Kode" class="flex items-center gap-3">
                        <span class="flex-grow"> Label Lomba: </span>
                        <input
                            type="text"
                            name="label"
                            placeholder="Label Lomba"
                            v-model="lomba.label"
                            class="w-3/4 rounded-full"
                        />
                    </label>

                    <span class="flex w-full gap-2">
                        <label for="Kode" class="flex items-center gap-3 w-3/4">
                            <span class="flex-grow"> Tahun Lomba: </span>
                            <input
                                type="date"
                                name="tanggal"
                                placeholder="Tahun Lomba"
                                v-model="lomba.tanggal"
                                class="w-2/4 rounded-full"
                            />
                        </label>
                        <label for="Kode" class="flex items-center gap-3 w-1/4">
                            <input
                                type="text"
                                name="tahun"
                                placeholder="Tahun Lomba"
                                v-model="lomba.tahun"
                                class="w-full rounded-full"
                            />
                        </label>
                    </span>
                    <label for="Kode" class="flex items-center gap-3">
                        <span class="flex-grow"> Lokasi Lomba: </span>
                        <select
                            name="lokasi_id"
                            v-model="lomba.lokasi_id"
                            class="w-3/4 rounded-full"
                        >
                            <option value="0">Pilih Lokasi Lomba</option>
                            <option
                                v-for="(sekolah, s) in sekolahs"
                                :key="s"
                                :value="sekolah.npsn"
                            >
                                {{ sekolah.nama }}
                            </option>
                        </select>
                    </label>
                    <div class="bidangs">
                        <h1>Bidang Lomba</h1>
                        <table class="w-full rounded-xl shadow">
                            <thead class="bg-sky-100">
                                <tr>
                                    <th class="py-1 w-1/12">Kategori</th>
                                    <th class="py-1 w-1/12">Kelompok</th>
                                    <th class="py-1 w-2/12">Bidang Lomba</th>
                                    <th class="py-1 w-2/12">Kode</th>
                                    <th class="py-1 w-5/12">Deskripsi</th>
                                    <th
                                        class="py-1 flex items-center justify-center"
                                    >
                                        <button @click.prevent="addBidang">
                                            <svg-icon
                                                type="mdi"
                                                :path="mdiPlusCircle"
                                                class="text-sky-500"
                                            />
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(bidang, b) in lomba.bidangs"
                                    :key="b"
                                    class="even:bg-sky-50"
                                >
                                    <td class="border-b border-gray-400">
                                        <select
                                            name="kategori"
                                            v-model="lomba.bidangs[b].kategori"
                                            class="rounded-xl w-full border-none outline-none bg-transparent"
                                        >
                                            <option value="tunggal">
                                                Tunggal
                                            </option>
                                            <option value="regu">Beregu</option>
                                        </select>
                                    </td>
                                    <td class="border-b border-gray-400">
                                        <select
                                            name="kelompok"
                                            v-model="lomba.bidangs[b].kelompok"
                                            class="rounded-xl w-full border-none outline-none bg-transparent"
                                        >
                                            <option value="putra">Putra</option>
                                            <option value="putri">Putri</option>
                                            <option value="campur">
                                                Campur
                                            </option>
                                        </select>
                                    </td>
                                    <td class="border-b border-gray-400">
                                        <select
                                            class="rounded-xl w-full border-none outline-none bg-transparent"
                                            v-model="lomba.bidangs[b].label"
                                            @change="onBidangChanged($event, b)"
                                        >
                                            <option
                                                v-for="(bdg, bd) in bidangs"
                                                :key="bd"
                                                :value="bdg.label"
                                            >
                                                {{ bdg.label }}
                                            </option>
                                        </select>
                                    </td>
                                    <td class="border-b border-gray-400">
                                        <input
                                            class="rounded-xl w-full border-none outline-none bg-transparent"
                                            type="text"
                                            name="kode"
                                            id="kode"
                                            placeholder="Kode"
                                            v-model="lomba.bidangs[b].kode"
                                            readonly
                                        />
                                    </td>
                                    <td class="border-b border-gray-400">
                                        <input
                                            class="rounded-xl w-full border-none outline-none bg-transparent"
                                            type="text"
                                            placeholder="Deskripsi"
                                            v-model="lomba.bidangs[b].deskripsi"
                                        />
                                    </td>
                                    <td
                                        class="flex items-center justify-center border-b border-gray-400 h-12"
                                    >
                                        <button
                                            @click.prevent="removeBidang(b)"
                                        >
                                            <svg-icon
                                                type="mdi"
                                                :path="mdiMinusCircle"
                                                class="text-red-400"
                                            />
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div
                        class="w-full flex justify-between items-center border-t border-gray-400 border-dashed h-12"
                    >
                        <div></div>
                        <button
                            class="bg-sky-600 hover:bg-sky-400 py-1 px-3 text-white rounded-full active:bg-orange-400"
                            type="submit"
                        >
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
