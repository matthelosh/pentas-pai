<script setup>
import { ref, onBeforeMount } from 'vue';
import 'jodit/build/jodit.min.css'
import { JoditEditor } from 'jodit-vue'

const props = defineProps({text: String})
const emit = defineEmits(['simpan'])
onBeforeMount(() => {
    content.value = props.text ? props.text : 'Write Some text'
})

const content = ref('')
const el = ref(null)

const simpan = () => {
    emit('simpan', content.value)
}
</script>

<template>
    <div class="w-full bg-white rounded p-3">
        <button class="bg-sky-600 hover:bg-sky-400 active:bg-orange-400 text-white py-2 px-3 rounded-full my-4" @click="simpan">Simpan</button>
        <JoditEditor v-model="content" />
    </div>
</template>