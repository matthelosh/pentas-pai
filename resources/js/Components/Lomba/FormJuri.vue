<script setup>
import { Icon } from "@iconify/vue";
import { onBeforeMount, ref } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({ open: Boolean, selectedBidang: Object });
const emit = defineEmits(["close"]);
const bidang = ref(null);

const loading = ref(false);
const show = ref(false);
const aspeks = ref([]);
const form = ref(false);

const gurus = ref([]);

const juri = ref({
    id: null,
    bidang_id: "",
    guru_id: 0,
    label: "",
});

const getGuru = async () => {
    await axios.post(route("guru.index")).then((res) => {
        console.log(res);
        gurus.value = res.data.gurus;
    });
};

const simpan = async () => {
    // loading.value = true;
    juri.value.label = "Juri " + props.selectedBidang.label;
    // console.log(juri.value);
    await router.post(route("dashboard.lomba.bidang.juri.store"), juri.value, {
        onStart: () => (loading.value = true),
        onSuccess: () => {
            router.get(route("dashboard.lomba"));
        },
        onError: (err) => {},
        onFinish: () => (loading.value = false),
    });
};

const hapus = async (id) => {
    await router.delete(
        route("dashboard.lomba.bidang.juri.destroy", {
            id: id,
        }),
        {
            onStart: () => (loading.value = true),
            onSuccess: () => {
                router.get(route("dashboard.lomba"));
            },
            onError: (err) => {},
            onFinish: () => (loading.value = false),
        }
    );
};

onBeforeMount(() => {
    console.log(props.open);
    bidang.value = props.selectedBidang ?? null;
    juri.value.bidang_id = props.selectedBidang.id ?? "";
    show.value = props.open;
    getGuru();
});
</script>

<template>
    <div
        class="overlay fixed z-40 top-0 right-0 bottom-0 left-0 bg-slate-500 bg-opacity-50 backdrop-blur"
        v-if="show"
    >
        <div
            class="dialog w-screen sm:w-[50%] h-screen overflow-y-auto bg-white sm:rounded-xl shadow"
        >
            <div
                class="header flex items-center justify-between bg-slate-600 text-white"
            >
                <h3 class="title p-1">Aspek Penilaian {{ bidang?.label }}</h3>
                <div class="flex items-center">
                    <button
                        class="sm:rounded-full p-2 bg-red-600 text-white"
                        @click="emit('close')"
                    >
                        <Icon icon="mdi-close" />
                    </button>
                </div>
            </div>
            <div class="content p-4">
                <table class="border w-full" v-if="!form">
                    <thead class="bg-slate-500 text-white">
                        <tr>
                            <th class="py-2 border w-[50px]">No</th>
                            <th class="py-2 border">Nama</th>
                            <th class="py-2 border">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(juri, j) in bidang?.juris">
                            <td class="border py-2 text-center">{{ j + 1 }}</td>
                            <td class="border p-2">{{ juri.guru?.nama }}</td>
                            <td class="border p-2 text-center w-[50px]">
                                <button @click="hapus(juri.id)">
                                    <Icon
                                        icon="mdi-trash"
                                        class="text-red-500"
                                    />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form" v-else>
                    <div class="card bg-slate-100 rounded-lg shadow py-4 px-2">
                        <h3 class="text-center font-bold mb-2">Tambah Juri</h3>
                        <div class="text-field p-2 border">
                            <p class="label mb-2">Juri Lomba</p>
                            <select
                                v-model="juri.guru_id"
                                class="w-full rounded border-slate-300"
                            >
                                <option value="0">Pilih Juri</option>
                                <option
                                    v-for="(guru, g) in gurus"
                                    :value="guru.id"
                                >
                                    {{ guru.nama }}
                                </option>
                            </select>
                            <div class="flex items-center justify-center mt-4">
                                <button
                                    class="p-2 bg-sky-500 rounded text-white hover:bg-sky-400 active:bg-sky-600 my-2 flex items-center gap-2 disabled:bg-sky-200"
                                    @click="simpan"
                                    :loading="loading"
                                    :disabled="loading"
                                >
                                    <Icon
                                        icon="mdi-loading"
                                        class="animate-spin"
                                        v-if="loading"
                                    />
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button
            class="fixed z-30 shadow-lg p-4 rounded-full right-2 bottom-8"
            :class="`${form ? 'bg-red-200' : 'bg-sky-200'}`"
            @click="form = !form"
        >
            <Icon
                :icon="`mdi:${form ? 'close' : 'plus'}`"
                class="text-3xl"
                :class="`${form ? 'text-red-500' : 'text-sky-600'}`"
            />
        </button>
    </div>
</template>
