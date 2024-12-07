<script setup>
import { onBeforeMount, ref } from "vue";
import { Cropper } from "vue-advanced-cropper";
import "vue-advanced-cropper/dist/style.css";

const cropper = ref(null);
const img = ref("/img/peserta.png");
const croppedImg = ref(null);
const result = ref(null);
const emit = defineEmits(["save", "cancel"]);
const props = defineProps({ fotoUrl: String });
const onImgPicked = (e) => {
    const file = e.target.files[0];
    // const reader = new FileReader()
    // reader.onload = (e) => {

    // }

    img.value = URL.createObjectURL(file);
};

const simpan = () => {
    const croppedCanvas = cropper.value.getResult();
    // console.log(croppedCanvas);
    if (croppedCanvas) {
        croppedCanvas.canvas.toBlob((blob) => {
            if (blob) {
                // console.log("Blob", blob);
                // img.value = URL.createObjectURL(blob);
                emit("save", blob);
            }
        });
    }
};

onBeforeMount(() => {
    img.value = props.fotoUrl ?? "/img/peserta.png";
});
</script>

<template>
    <div
        @click.self="emit('cancel')"
        class="fixed top-0 right-0 bottom-0 left-0 bg-slate-600 bg-opacity-80 backdrop-blur flex items-center justify-center z-[9999]"
    >
        <div class="dialog min-w-[300px] bg-white rounded-lg">
            <div class="dialog-body">
                <input
                    type="file"
                    ref="imgInput"
                    @change="onImgPicked"
                    class="hidden"
                    accept=".webp, .jpg, .JPG, .jpeg, .JPEG, .png, .PNG"
                />
                <div class="flex items-center justify-between rounded-t-lg">
                    <button
                        class="px-2 hover:bg-slate-100"
                        @click="$refs.imgInput.click()"
                    >
                        Ambil Foto
                    </button>
                    <button class="px-2 hover:bg-slate-100" @click="simpan">
                        Simpan
                    </button>
                </div>
                <Cropper
                    ref="cropper"
                    :stencil-props="{ aspectRatio: 1 }"
                    v-if="img"
                    :src="img"
                    alt="Foto Peserta"
                />
            </div>
        </div>
    </div>
</template>
