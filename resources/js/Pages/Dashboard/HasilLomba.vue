<script setup>
import Dash from "@/Layout/Dash.vue";
import { usePage } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";

const page = usePage();

const toggleCollapse = (e) => {
    const target = e.target;
    const item = target.closest(".item-collapse");
    const icon = item.querySelector(".icon");
    const content = item.querySelector(".content");
    content.classList.toggle("hidden");
    icon.classList.toggle("rotate-90");
};
</script>

<template>
    <Dash title="Hasil Perlombaan">
        <div class="bg-white p-4 sm:ml-4 rounded-lg">
            <h3 class="text-2xl uppercase">
                Hasil Perlombaan {{ page.props.lomba.label }}
            </h3>
            <div>
                <div
                    class="item-collapse mb-4 shadow"
                    v-for="(bidang, b) in page.props.bidangs"
                    @click.stop="toggleCollapse($event)"
                >
                    <div
                        class="title py-4 hover:rounded-lg px-3 flex items-center justify-between hover:cursor-pointer hover:bg-lime-100"
                    >
                        <h3>
                            {{
                                bidang.label.split(" ").length == 3
                                    ? bidang.label.split(" ")[0] +
                                      " " +
                                      bidang.label.split(" ")[1]
                                    : bidang.label.split(" ")[0]
                            }}
                        </h3>
                        <button
                            class="p-1 border rounded-full bg-lime-300 text-lime-800"
                        >
                            <Icon icon="mdi-chevron-right" class="icon" />
                        </button>
                    </div>
                    <div class="content hidden p-6 bg-slate-50">
                        <table class="w-full shadow-lg">
                            <thead>
                                <tr
                                    class="bg-lime-200 border-b border-lime-500"
                                >
                                    <th
                                        rowspan="2"
                                        class="py-4 border-e border-lime-500"
                                    >
                                        No
                                    </th>
                                    <th
                                        rowspan="2"
                                        class="py-4 border-e border-lime-500"
                                    >
                                        NISN
                                    </th>
                                    <th
                                        rowspan="2"
                                        class="py-4 border-e border-lime-500"
                                    >
                                        Nama
                                    </th>
                                    <th
                                        rowspan="2"
                                        class="py-4 border-e border-lime-500"
                                    >
                                        Lembaga
                                    </th>
                                    <th
                                        :colspan="bidang.aspeks.length"
                                        class="py-4 border-e border-lime-500"
                                    >
                                        Skor
                                    </th>
                                    <th rowspan="2" class="py-4">Nilai</th>
                                </tr>
                                <tr>
                                    <th
                                        class="py-4 border-e border-lime-500 bg-lime-200"
                                        v-for="aspek in bidang.aspeks"
                                    >
                                        {{ aspek.label }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(result, r) in bidang.results"
                                    class="odd:bg-lime-50 even:bg-white"
                                >
                                    <td
                                        class="p-2 border-e border-lime-500 text-center"
                                    >
                                        {{ r + 1 }}
                                    </td>
                                    <td
                                        class="p-2 border-e border-lime-500 text-center"
                                    >
                                        {{ result.siswa.nisn }}
                                    </td>
                                    <td class="p-2 border-e border-lime-500">
                                        {{ result.siswa.nama }}
                                    </td>
                                    <td class="p-2 border-e border-lime-500">
                                        {{ result.siswa.sekolah.nama }}
                                    </td>
                                    <template
                                        v-for="nilai in result.siswa.nilais.filter(
                                            (nilai) =>
                                                nilai.bidang_id == bidang.id
                                        )"
                                    >
                                        <td
                                            class="p-2 border-e border-lime-500"
                                        >
                                            {{ nilai.nilai }}
                                        </td>
                                    </template>
                                    <td class="p-2 text-center">
                                        {{ result.skor }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </Dash>
</template>
