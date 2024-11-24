<script setup>
import { ref, onMounted, computed } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import Dash from "@/Layout/Dash.vue";

const page = usePage();
const datas = ["Lomba", "Bidang", "Sekolah", "Guru", "Peserta", "Juara"];
</script>

<template>
    <Head title="Dashboard" />
    <Dash title="Dashboard">
        <div class="content">
            <h1
                class="text-2xl sm:text-4xl font-extrabold uppercase text-gray-50 text-center mt-4 mb-2 drop-shadow-lg"
            >
                {{
                    $page.props.lomba
                        ? $page.props.lomba.label
                        : "Belum Ada Lomba"
                }}
            </h1>
            <div class="grid sm:grid-cols-4 gap-3 p-3">
                <div
                    v-for="(data, d) in page.props.datas"
                    :key="d"
                    class="p-3 bg-white rounded shadow"
                >
                    <h1>{{ d }}: {{ data.length }}</h1>
                </div>
            </div>
        </div>
    </Dash>
</template>
