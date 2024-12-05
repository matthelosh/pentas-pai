<script setup>
import { ref, watch } from "vue";
import { QuestionMarkCircleIcon } from "@heroicons/vue/20/solid";

const show = ref(false);
const items = ref([]);
const message = ref("");
const resolved = ref(null);
const rejected = ref(null);
const open = async (text, datas) => {
    show.value = true;
    message.value = text;
    return new Promise((resolve, reject) => {
        resolved.value = resolve;
        rejected.value = reject;
    });
};

const okey = () => {
    show.value = false;
    resolved.value(true);
};
const nope = () => {
    show.value = false;
    resolved.value(false);
};

defineExpose({
    open,
});
</script>

<template>
    <div
        class="overlay fixed top-0 right-0 bottom-0 left-0 z-50 bg-black bg-opacity-50 flex items-center justify-center"
        @click.self="show = false"
        v-if="show"
    >
        <div
            class="dialog w-[95vw] sm:max-w-[400px] sm:min-h-[250px] rounded-lg shadow bg-white flex items-center justify-center p-3"
        >
            <div class="w-full">
                <QuestionMarkCircleIcon
                    class="text-red-400 h-32 animate-bounce mx-auto"
                />
                <h1 class="text-xl text-gray-800 mb-4 text-center">
                    {{ message }}
                </h1>
                <div class="flex justify-end gap-2 w-full">
                    <button
                        @click="nope"
                        class="px-3 py-2 text-lg text-red-500"
                    >
                        Belum
                    </button>
                    <button
                        @click="okey"
                        class="px-3 py-2 text-lg text-teal-600 font-bold"
                    >
                        Yakin
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
