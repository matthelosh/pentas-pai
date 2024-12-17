<script setup>
import { Head, usePage, Link } from "@inertiajs/vue3";
import Front from "@/Layout/Front.vue";
import { ref, computed, onMounted, watch } from "vue";
import * as _ from "lodash-es";
import axios from "axios";
const $page = usePage();
const currentPage = ref(1);
const search = ref(null);
const pesertas = ref($page.props.pesertas);

const datas = computed(() => {
    let length = pesertas.value.length;
    let datas = [];

    if (search.value == null) {
        datas = pesertas.value;
    } else {
        datas = pesertas.value.filter((peserta) => {
            return (
                peserta.nama
                    .toLowerCase()
                    .includes(search.value.toLowerCase()) ||
                peserta.sekolah.nama
                    .toLowerCase()
                    .includes(search.value.toLowerCase()) ||
                peserta.nisn.toLowerCase().includes(search.value.toLowerCase())
            );
        });
    }
    let pages = _.chunk(datas, 10);

    return { current: pages[currentPage.value - 1], pageCount: pages.length };
});
</script>

<template>
    <Head title="Data Peserta" />
    <Front>
        <div class="w-full bg-white rounded-xl overflow-hidden my-20 md:my-4">
            <div
                class="toolbar w-full h-12 bg-gray-50 rounded shadow flex items-center px-3 justify-between"
            >
                <h1>Data Peserta</h1>
                <div class="toolbar-items flex items-center gap-2">
                    <input
                        type="text"
                        placeholder="Cari"
                        class="h-8 rounded"
                        v-model="search"
                    />
                </div>
            </div>
            <div class="content w-full bg-white p-3 mt-2 overflow-x-hidden">
                <div class="table-responsive w-full overflow-x-scroll">
                    <table
                        class="table w-full border-collapse bg-white overflow-x-auto"
                    >
                        <thead>
                            <tr>
                                <th class="border text-center">No</th>
                                <th class="border text-center">NISN</th>
                                <th class="border text-center">Nama</th>
                                <th class="border text-center">JK</th>
                                <th class="border text-center">Sekolah</th>
                                <th class="border text-center">Lomba</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="odd:bg-gray-50"
                                v-for="(data, d) in datas.current"
                                :key="d"
                            >
                                <td class="border p-2">{{ d + 1 }}</td>
                                <td class="border p-2">{{ data.nisn }}</td>
                                <td class="border p-2">
                                    <Link
                                        :href="`/peserta/detail/${data.nisn}`"
                                        class="hover:text-sky-500 hover:underline"
                                    >
                                        {{ data.nama }}
                                    </Link>
                                </td>
                                <td class="border p-2">{{ data.jk }}</td>
                                <td class="border p-2">
                                    {{ data.sekolah.nama }}
                                </td>
                                <td class="border p-2">
                                    <ul>
                                        <li
                                            v-for="(bidang, b) in data.bidangs"
                                            :key="b"
                                        >
                                            {{ bidang.label }}
                                        </li>
                                    </ul>
                                    <!-- | {{ data.lomba_id }} -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div
                    class="bg-gray-200 flex items-center justify-between pl-3 flex-wrap w-full"
                >
                    Jml Halaman: {{ datas.pageCount }}
                    <div class="flex items-center h-full flex-wrap">
                        <button
                            @click="currentPage -= 1"
                            class="flex justify-center w-8 border border-gray-500"
                        >
                            &lt;
                        </button>
                        <button
                            v-for="b in datas.pageCount"
                            :key="b"
                            class="flex justify-center w-8 border border-gray-500"
                            :class="
                                b == currentPage ? 'bg-sky-600 text-white' : ''
                            "
                            @click="currentPage = b"
                        >
                            {{ b }}
                        </button>
                        <button
                            @click="currentPage += 1"
                            class="flex justify-center w-8 border border-gray-500"
                        >
                            &gt;
                        </button>
                    </div>
                </div>
            </div>
            <!-- <div class="w-full bg-gray-200">
        {{ pesertas }}
    </div> -->
        </div>
    </Front>
</template>
