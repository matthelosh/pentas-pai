<script setup>
import { Icon } from "@iconify/vue";
import { router, usePage } from "@inertiajs/vue3";
import { keyBy } from "lodash";
import { defineAsyncComponent, ref } from "vue";

const Dash = defineAsyncComponent(() => import("@/Layout/Dash.vue"));
const page = usePage();
const showDialog = ref(false);
const bg = (kode) => {
    const code = kode.split("-");
    return "/img/" + code[3] + ".png";
};
const pesertas = ref([]);
const nilais = ref([]);
const loading = ref(false);
const selectedBidang = ref(null);

const DialogBox = defineAsyncComponent(() =>
    import("@/Components/General/DialogBox.vue")
);
const dialogBox = ref(null);
const fillNilai = (item) => {
    // console.log(item);
    selectedBidang.value = item;
    const thisNilais = [];
    let aspekIds = item.aspeks.map((aspek) => aspek.id);
    if (item.kategori == "tunggal") {
        pesertas.value = item.pesertas;
        item.pesertas.forEach((siswa) => {
            let nilais = siswa.nilais.filter(
                (nilai) => nilai.bidang_id == selectedBidang.value.id
            );
            const skors = [];
            if (nilais.length < 1) {
                item.aspeks.forEach((aspek) => {
                    skors.push({ aspek_id: aspek.id, skor: 0 });
                });
            } else {
                nilais.forEach((skor) => {
                    skors.push({
                        id: skor.id,
                        aspek_id: skor.aspek_id,
                        skor: skor.nilai,
                    });
                });
            }
            thisNilais.push({
                siswa_id: siswa.nisn,
                skors: skors,
            });
        });
    } else {
        // console.log("Halo");
        pesertas.value = Object.groupBy(
            item.pesertas,
            ({ sekolah }) => sekolah.nama
        );
        Object.entries(pesertas.value).forEach(([key, siswas]) => {
            // console.log(siswas[0]);
            const skors = [];
            let nilais = siswas[0].nilais.filter(
                (nilai) => nilai.bidang_id == selectedBidang.value.id
            );
            if (nilais.length < 1) {
                item.aspeks.forEach((aspek) => {
                    skors.push({ aspek_id: aspek.id, skor: 0 });
                });
            } else {
                // console.log(siswas[0].nilai);
                nilais.forEach((skor) => {
                    skors.push({
                        id: skor.id,
                        aspek_id: skor.aspek_id,
                        skor: skor.nilai,
                    });
                });
            }
            thisNilais.push({
                sekolah_id: siswas[0].sekolah.npsn,
                siswa_id: siswas[0].nisn,
                skors: skors,
            });
        });
    }

    nilais.value = thisNilais;
    // console.log(nilais.value);

    showDialog.value = true;
};

const close = () => {
    selectedBidang.value = null;
    showDialog.value = false;
};

const toggleCollapse = (e) => {
    const target = e.target;
    const item = target.closest(".item-collapse");
    const icon = item.querySelector(".icon");
    const content = item.querySelector(".content");
    content.classList.toggle("hidden");
    icon.classList.toggle("rotate-90");
};

const simpanNilai = async (siswa) => {
    const nilai = nilais.value.find((nil) => {
        if (selectedBidang.value.kategori === "regu") {
            return nil.siswa_id == siswa[1][0].nisn;
        } else {
            return nil.siswa_id == siswa.nisn;
        }
    });
    // console.log(nilai);
    await router.post(
        route("dashboard.lomba.nilai.store", {
            _query: {
                bidang_id: selectedBidang.value.id,
                sekolah_id: nilai.sekolah_id ?? null,
            },
        }),
        nilai,
        {
            onStart: () => (loading.value = true),
            onFinish: () => (loading.value = false),
            onSuccess: () => {
                console.log(page.props.flash.message);
            },
        }
    );
};

const regus = (item) => {
    // pesertas;
    const result = Object.groupBy(item.pesertas, ({ sekolah }) => sekolah.nama);
    // console.log(result);
    return Object.keys(result).length;
};

const showConfirm = ref(false);
const confirmRekap = () => {
    showConfirm.value = !showConfirm.value;
};

const rekap = async () => {
    await dialogBox.value
        .open("Pastikan nilai peserta sudah tersimpan!")
        .then((ok) => {
            if (ok) {
                router.post(
                    route("dashboard.lomba.result.store"),
                    { bidangId: selectedBidang.value.id, nilais: nilais.value },
                    {
                        onSuccess: () => console.log(page.props.flash.message),
                    }
                );
            }
        });
};
</script>

<template>
    <Dash title="Form Penilaian">
        <DialogBox ref="dialogBox" />
        <!-- <h1 class="text-center my-4 text-lg fontpbold">Pilih Bidang Lomba</h1> -->
        <div
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 py-4"
            v-if="page.props.bidangs.length > 0"
        >
            <template v-for="c in page.props.bidangs">
                <div
                    @click="fillNilai(c)"
                    class="card rounded-lg shadow hover:shadow-lg transition-all duration-300 hover:cursor-pointer overflow-hidden"
                    :style="`background: url('${bg(
                        c.kode
                    )}'); background-size:cover; background-repeat: no-repeat; min-height: 400px; background-position: center;`"
                >
                    <div
                        class="card-title text-xl font-bold bg-white py-4 px-4 bg-opacity-10 backdrop-blur text-white shadow uppercase text-center"
                    >
                        Bidang
                        {{
                            c.label.split(" ").length == 3
                                ? c.label.split(" ")[0] +
                                  " " +
                                  c.label.split(" ")[1]
                                : c.label.split(" ")[0]
                        }}
                    </div>
                    <div
                        class="card-body flex items-center justify-center p-4 h-full"
                    >
                        <div
                            class="content bg-white p-4 rounded shadow-lg text-center"
                        >
                            <h3 class="text-xl">Jumlah Peserta</h3>
                            <h1
                                class="text-4xl font-bold flex items-end justify-center"
                            >
                                {{
                                    c.kategori == "tunggal"
                                        ? c.pesertas.length
                                        : regus(c)
                                }}
                            </h1>
                            <span class="text-teal-600">
                                {{ c.kategori == "tunggal" ? "Orang" : "Regu" }}
                            </span>
                        </div>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </template>
        </div>
        <div v-else class="h-[93vh] flex items-start py-8 justify-center">
            <h3
                class="text-center text-slate-800 p-8 bg-white rounded-lg shadow-lg"
            >
                <Icon
                    icon="mdi-alert"
                    class="mx-auto text-4xl text-orange-400"
                />
                Laman ini hanya untuk juri.
            </h3>
        </div>

        <div
            class="dialog w-screen sm:rounded-xl sm:w-full h-screen bg-white fixed z-40 top-0 right-0 bottom-0 left-0 sm:left-3 overflow-y-auto"
            v-if="showDialog"
        >
            <div
                class="toolbar flex justify-between items-center pl-2 bg-slate-600 text-white sticky top-0"
            >
                <h2>
                    Form Nilai Bidang
                    {{
                        selectedBidang.label.split(" ").length == 3
                            ? selectedBidang.label.split(" ")[0] +
                              " " +
                              selectedBidang.label.split(" ")[1]
                            : selectedBidang.label.split(" ")[0]
                    }}
                </h2>

                <button class="bg-red-400 p-2" @click="close">
                    <Icon icon="mdi:close" class="text-white" />
                </button>
            </div>

            <div class="content p-4 h-min-[90vh] overflow-y-auto">
                <table class="w-full hidden sm:block">
                    <thead>
                        <tr class="bg-slate-100">
                            <th class="border p-2">No</th>
                            <th class="border p-2 hidden sm:table-cell">
                                NISN
                            </th>
                            <th class="border p-2">Nama</th>
                            <th class="border p-2 hidden sm:table-cell">
                                Lembaga
                            </th>
                            <template v-for="aspek in selectedBidang.aspeks">
                                <th class="border p-2">
                                    {{ aspek.label }}
                                </th>
                            </template>
                            <th class="border p-2">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(siswa, s) in selectedBidang.pesertas">
                            <td class="border text-center">{{ s + 1 }}</td>
                            <td class="border text-center hidden sm:table-cell">
                                {{ siswa.nisn }}
                            </td>
                            <td class="border px-2">{{ siswa.nama }}</td>
                            <td class="border px-2 hidden sm:table-cell">
                                {{ siswa.sekolah.nama }}
                            </td>
                            <template
                                v-for="(aspek, a) in selectedBidang.aspeks"
                            >
                                <td class="text-center border w-[200px]">
                                    <input
                                        type="number"
                                        max="100"
                                        min="0"
                                        placeholder="Nilai"
                                        class="border-slate-200 w-[90px]"
                                        v-model="nilais[s].skors[a].skor"
                                    />
                                </td>
                            </template>
                            <td class="border text-center p-2">
                                <button
                                    class="bg-teal-600 py-2 px-3 rounded text-white hover:bg-teal-500 active:bg-teal-400 flex items-center gap-1 mx-auto"
                                    @click="simpanNilai(s)"
                                >
                                    <Icon icon="mdi-check" />
                                    Simpan
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="card block sm:hidden">
                    <template
                        v-for="(siswa, s) in selectedBidang.kategori == 'regu'
                            ? Object.entries(pesertas)
                            : pesertas"
                    >
                        <div
                            class="item-collapse my-4 bg-slate-100 px-2 py-4 transition-all duration-300 ease-in-out"
                        >
                            <div
                                class="title flex items-center justify-between"
                                @click.stop="toggleCollapse($event)"
                            >
                                <h3>
                                    {{ s + 1 }}.
                                    {{
                                        selectedBidang.kategori == "regu"
                                            ? siswa[0]
                                            : siswa.nama
                                    }}
                                </h3>
                                <button
                                    class="p-1 border rounded-full bg-slate-200"
                                >
                                    <Icon
                                        icon="mdi-chevron-right"
                                        class="icon"
                                    />
                                </button>
                            </div>
                            <div
                                class="content hidden bg-white p-3 mt-4 rounded-lg shadow transition-all duration-300 ease-in-out"
                            >
                                <template
                                    v-for="(aspek, a) in selectedBidang.aspeks"
                                >
                                    <div
                                        class="aspek mb-4 rounded-full bg-teal-50 border-teal-600 border py-4 px-6 flex items-center justify-between"
                                    >
                                        <span class="font-bold">{{
                                            aspek.label
                                        }}</span>
                                        <input
                                            type="number"
                                            max="100"
                                            placeholder="Skor"
                                            class="w-[100px] border-teal-700 rounded-full h-16 text-center text-lg"
                                            v-model="nilais[s].skors[a].skor"
                                        />
                                        <!-- {{ nilais[s].skors[a].skor }} -->
                                    </div>
                                </template>
                                <div class="flex justify-center">
                                    <button
                                        class="bg-sky-600 p-4 rounded-full text-white uppercase hover:bg-sky-500 active:bg-sky-400"
                                        @click="simpanNilai(siswa)"
                                    >
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            <button
                class="right-4 fixed bottom-8 rounded-full shadow-lg bg-teal-500 text-white text-lg font-bold tracking-wide flex items-center gap-2 transition-all ease-in-out duration-300"
            >
                <span
                    v-if="showConfirm"
                    @click.self="rekap"
                    class="p-4 bg-pink-400 rounded-full transition-all ease-in-out duration-300"
                    >Buat Rekap?</span
                >
                <Icon
                    icon="mdi-hdd"
                    @click="confirmRekap"
                    class="m-4 text-2xl"
                />
            </button>
        </div>
    </Dash>
</template>
