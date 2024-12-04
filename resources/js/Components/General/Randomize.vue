<script setup>
import { ref, computed } from "vue";

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

const open = async (message, data, bidang_id) => {
    bidangId.value = bidang_id;
    title.value = message;
    items.value = data;
    show.value = true;
    // console.log(data);
    acak();
};

const tutup = () => {
    results.value = [];
    items.value = [];
    uruts.value = [];
    title.value = "";
    show.value = false;
};

const storeSort = async () => {
    axios
        .post(route("dashboard.peserta.nourut.simpan"), {
            bidang_id: bidangId.value,
            datas: results.value,
        })
        .then((res) => {
            console.log(res);
        });
};

defineExpose({ open });
</script>

<template>
    <div
        class="backdrop fixed top-0 left-0 bottom-0 right-0 bg-teal-800 bg-opacity-70 flex items-center justify-center z-40"
        @click.self="tutup"
        v-if="show"
    >
        <div
            class="dialog min-w-[300px] max-w-[65vw] rounded-lg bg-white p-4 max-h-[85vh] overflow-y-auto"
        >
            <h3
                class="text-center mb-3 text-xl uppercase font-black text-teal-800"
            >
                {{ title }}
            </h3>
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
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore
                doloribus delectus, quisquam minus, quos corrupti voluptate
                assumenda mollitia eaque ea ex exercitationem distinctio quia
                fuga eius voluptatem, consectetur harum laudantium.
            </p>
            <p>
                Delectus rerum tempore, deserunt aliquam, nobis numquam
                veritatis illo ipsum minima nihil odit. Est tempore facilis
                magni debitis! Eum dicta suscipit cupiditate fugit magnam
                reprehenderit corporis quos nihil! At, rem.
            </p>
            <p>
                Sed non porro esse, reprehenderit facere numquam laudantium
                tempora, placeat quisquam optio, fugiat maiores? Esse, corporis.
                Eveniet illum, porro sequi ex voluptas illo. Rem similique
                molestiae autem nostrum culpa repudiandae!
            </p>
            <p>
                Blanditiis error sapiente optio soluta non voluptates cum
                itaque, hic, fugiat, totam nemo? Quisquam quaerat possimus
                deleniti ullam quam. Vitae soluta suscipit quas odio aperiam
                quasi mollitia accusantium fugit commodi!
            </p>
            <p>
                Sed repellat impedit expedita alias dolores sequi? Ea deleniti
                impedit, cupiditate culpa perferendis minima excepturi non amet
                maiores, rem eius odio eveniet obcaecati vel fugiat nostrum
                mollitia. Eius, magni facere?
            </p>
            <p>
                Dicta hic animi quam aliquid quisquam voluptate libero dolorum.
                Sequi id, quae doloribus autem eius modi dolorem officia quod
                vero minima neque ex perspiciatis, nulla ipsam placeat saepe,
                dicta tempore.
            </p>
            <p>
                Sequi soluta odio est et excepturi, libero asperiores officiis
                aperiam similique! Expedita ipsa rerum laborum amet
                necessitatibus, possimus vitae id! Amet dolor accusantium
                aspernatur praesentium eligendi dolorum? Vel, incidunt
                voluptate?
            </p>
            <p>
                Cupiditate quas officiis optio ipsum illum nulla, quisquam
                aliquam quaerat fugiat eos dolor dignissimos. Eos, sunt ullam
                alias molestiae quod iusto hic, adipisci nesciunt numquam nobis
                praesentium, mollitia odio explicabo.
            </p>
            <p>
                Aperiam ullam vero dicta quod quasi sapiente exercitationem
                distinctio impedit. Odit sed ex consequatur modi soluta
                similique consectetur, distinctio praesentium quaerat excepturi
                beatae atque ut aliquid, asperiores expedita. Cumque, enim.
            </p>
            <p>
                Autem laudantium id itaque, quibusdam fugit, consequuntur
                voluptatibus assumenda doloremque natus praesentium architecto
                cumque nemo cupiditate facilis obcaecati, dolores provident
                maiores officia eveniet numquam eaque atque vitae doloribus!
                Soluta, laborum?
            </p>
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
</template>
