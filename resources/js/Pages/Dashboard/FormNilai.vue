<script setup>
import { Icon } from "@iconify/vue";
import { usePage } from "@inertiajs/vue3";
import { defineAsyncComponent, ref } from "vue";

const Dash = defineAsyncComponent(() => import("@/Layout/Dash.vue"));
const page = usePage();
const showDialog = ref(false);
const bg = (kode) => {
    const code = kode.split("-");
    return "/img/" + code[3] + ".png";
};

const selectedBidang = ref(null);
const fillNilai = (item) => {
    console.log(item);
    selectedBidang.value = item;
    showDialog.value = true;
};

const close = () => {
    selectedBidang.value = null;
    showDialog.value = false;
};
</script>

<template>
    <Dash title="Form Penilaian">
        <h1>Pilih Bidang Lomba</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <template v-for="c in page.props.bidangs">
                <div
                    @click="fillNilai(c)"
                    class="card rounded shadow hover:shadow-lg transition-all duration-300 hover:cursor-pointer"
                    :style="`background: url('${bg(
                        c.kode
                    )}'); background-size:cover; background-repeat: no-repeat; min-height: 400px; background-position: center;`"
                >
                    <div
                        class="card-title text-xl font-bold bg-white py-4 px-4 bg-opacity-50 backdrop-filter-blue"
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
                            <h1 class="text-4xl font-bold">
                                {{ c.pesertas.length }}
                            </h1>
                        </div>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </template>
        </div>

        <div
            class="dialog w-screen h-screen bg-white fixed z-40 top-0 right-0 bottom-0 left-0"
            v-if="showDialog"
        >
            <div
                class="toolbar flex justify-between items-center pl-2 bg-slate-600 text-white"
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

            <div class="content p-4">
                <table>
                    <thead>
                        <tr></tr>
                    </thead>
                </table>
            </div>
        </div>
    </Dash>
</template>
