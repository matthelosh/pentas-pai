<script setup>
import Front from "@/Layout/Front.vue";
import { Icon } from "@iconify/vue";
import { usePage, Head } from "@inertiajs/vue3";

const page = usePage();

const toggleContent = (e) => {
    const target = e.target;
    const parent = target.closest(".item-collapse");
    const content = parent.querySelector(".content");
    const icon = parent.querySelector(".icon");
    content.classList.toggle("hidden");
    icon.classList.toggle("rotate-90");
};
</script>

<template>
    <Front>
        <Head title="Hasil Lomba" />
        <div class="container pt-16 pb-4">
            <h3
                class="text-center text-lg uppercase text-white font-bold flex items-center justify-center gap-1"
            >
                <Icon icon="mdi:trophy" class="text-yellow-200 text-2xl" />
                Hasil Perlombaan
            </h3>

            <div
                class="item-collapse bg-slate-50 rounded-lg my-2"
                v-for="bidang in page.props.bidangs"
            >
                <div
                    class="title flex items-center justify-between px-2 py-4"
                    @click="toggleContent($event)"
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
                    <button class="p-1 border rounded-full bg-slate-200">
                        <Icon icon="mdi-chevron-right" class="icon" />
                    </button>
                </div>
                <div class="content hidden bg-lime-50 p-4 rounded-b-lg"></div>
            </div>
        </div>
    </Front>
</template>
