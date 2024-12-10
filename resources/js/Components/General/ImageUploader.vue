<script setup>
import { onBeforeMount, ref } from "vue";
import { Cropper } from "vue-advanced-cropper";
import "vue-advanced-cropper/dist/style.css";

const cropper = ref(null);
const img = ref("/img/peserta.png");
const croppedImg = ref({ x: 0, y: 0, width: 100, height: 100 });
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
    const croppedCanvas = croppedImg.value;
    console.log(croppedCanvas);
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

const onCropChange = (coordinates) => {
    croppedImg.value = coordinates;
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
        <div class="dialog bg-white rounded-lg my-4 mx-auto overflow-hidden">
            <input
                type="file"
                ref="imgInput"
                @change="onImgPicked"
                class="hidden"
                accept=".webp, .jpg, .JPG, .jpeg, .JPEG, .png, .PNG, capture=camera"
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
            <div class="dialog-body max-h-[80vh] overflow-y-auto">
                <Cropper
                    ref="cropper"
                    :stencil-props="{ aspectRatio: 10 / 10 }"
                    v-if="img"
                    :src="img"
                    :coordinates.sync="croppedImg"
                    alt="Foto Peserta"
                    @change="onCropChange"
                />
            </div>
        </div>
    </div>
</template>
