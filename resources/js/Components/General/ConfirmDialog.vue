<template>
    <div class="dialog-backdrop" @click.self="close">
        <div class="dialog-box">
            <header>
                <h3 class="font-bold text-lg text-teal-800">{{ title }}</h3>
            </header>
            <main class="text-slate-700">
                <slot>{{ message }}</slot>
            </main>
            <footer>
                <button @click="confirm" class="text-teal-700">Ok</button>
                <button @click="close" class="text-red-600">Batal</button>
            </footer>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

defineProps({
    title: { type: String, default: "Konfirmasi" },
    message: { type: String, default: "" },
});

const emit = defineEmits(["close", "confirm"]);

// const open = () => (visible.value = true);
const close = () => {
    emit("close");
};
const confirm = () => {
    emit("confirm");
};

defineExpose({ open, close });
</script>

<style scoped>
.dialog-backdrop {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 999;
}

.dialog-box {
    background: white;
    padding: 20px;
    border-radius: 8px;
    min-width: 300px;
}

footer {
    display: flex;
    justify-content: flex-end;
    gap: 20px;
}
</style>
