<script setup>
import { ref, computed, defineAsyncComponent } from "vue";
import { Icon } from "@iconify/vue";
import { inject } from "vue";
import { usePage } from "@inertiajs/vue3";
const page = usePage();
const kategoriLomba = ref("");
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

const parseGroup = async (regus) => {
    let results = [];
    regus.forEach((regu) => {
        results.push({
            sekolah: regu.data[0].sekolah,
            nama: "Regu " + regu.data[0].sekolah.npsn,
            foto: "/img/peserta.png",
        });
    });

    // console.log(results);

    return results;
};

const raws = ref(null);
const open = async (message, data, bidang_id, kategori) => {
    bidangId.value = bidang_id;
    title.value = message;
    kategoriLomba.value = kategori;
    raws.value = data;
    items.value = kategori == "regu" ? await parseGroup(data) : data;
    show.value = true;
    acak();
    // console.log(items.value);
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
    const ok = await dialogBox.value.open(
        "Menerima hasil acak no urut tersebut?"
    );
    if (ok) {
        let payloads = [];
        if (kategoriLomba.value == "regu") {
            raws.value.forEach((raw) => {
                raw.data.forEach((s) => {
                    payloads.push({
                        siswa_id: s.nisn,
                        urut: results.value.filter(
                            (res) => res.sekolah == s.sekolah.nama
                        )[0].urut,
                        nama: s.nama,
                        foto: s.foto,
                        sekolah: s.sekolah.nama,
                    });
                });
            });
        } else {
            payloads = results.value;
        }
        // console.log(payloads);
        axios
            .post(route("dashboard.peserta.nourut.simpan"), {
                bidang_id: bidangId.value,
                datas: payloads,
            })
            .then((res) => {
                console.log(res);
            });
    }
    // console.log(ok);
};

const cetak = async () => {
    let win = window.open("", "_blank", "width=800,height=1200");
    let tr = "";
    results.value.forEach((res) => {
        tr += `
            <tr>
            <td style="text-align:center;">${res.urut}</td>
            <td>${res.nama}</td>
            <td>${res.sekolah}</td>
            </tr>
        `;
    });
    let html = `
            <!doctype html>
            <html>
                <head>
                    <title>Hasil Undian No ${title.value}</title>    
                    <style>
                        h3.title {
                            text-align: center;
                        }
                        table {
                            margin: 20px auto;
                        }
                        th,td {
                            padding: 5px 10px;
                        }
                            body {
                                padding: 20px
                            }
                        table {
                            width: 100%;
                        }
                    </style>
                    </head>

                <body>
                    <h3 class="title">Hasil Undian  ${title.value}</h3>

                    <table border style="border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th style="text-align:center;">Urut</th>
                                <th>Nama</th>
                                <th>Lembaga</th>
                            </tr>
                        </thead>   
                        <tbody>
                            ${tr}
                        </tbody>
                    </table>

                    <div class="ttd" style="display: flex; justify-content: space-between; width: 80%; margin: 50px auto 20px auto">
                        <div style="width: 50%; border: 1px dashed black;padding: 10px; border-radius: 20px;">
                            <p>Catatan:</p>
                            <p>Semua Panitia, Peserta dan Pendamping menyentujui hasil undian di atas.</p>
                        </div>
                        <div>
                            <p style="text-align:center; line-height: .3rem">Wagir, ${new Date().toLocaleDateString(
                                "id-ID",
                                {
                                    day: "numeric",
                                    month: "long",
                                    year: "numeric",
                                }
                            )}</p>
                            <p style="text-align:center;line-height: .3rem">Ketua Panitia</p>



                            <p style="text-align:center;line-height: .3rem; margin-top: 60px;">Maa Rizal Ula, S. Pd.I</p>
                            <p style="text-align:center;line-height: .3rem">NIP. 199303082024211025</p>
                        </div>
                    </div>
                </body>
            </html>
    `;

    win.document.write(html);

    setTimeout(() => {
        win.print();
        win.close();
    }, 1000);
};

defineExpose({ open });
</script>

<template>
    <Teleport to="body">
        <div
            class="backdrop fixed top-0 left-0 bottom-0 right-0 bg-teal-800 bg-opacity-70 flex items-center backdrop-blur justify-center z-40"
            @click.self="tutup"
            v-if="show"
        >
            <div
                class="dialog min-w-[300px] max-w-[65vw] rounded-lg bg-white p-4 relative"
            >
                <button
                    class="bg-sky-400 w-[50px] h-[50px] flex items-center justify-center text-white text-2xl absolute right-14 top-0 translate-x-[6px]"
                    @click="cetak"
                >
                    <Icon icon="mdi-printer" />
                </button>
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
    </Teleport>
    <Teleport to="body">
        <DialogBox ref="dialogBox" />
    </Teleport>
</template>
