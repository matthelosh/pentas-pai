<script setup>
import { ref, onMounted } from 'vue';
import { CheckCircleIcon, XCircleIcon } from '@heroicons/vue/20/solid';


const show = ref(false)

const info = ref({
    text: '',
    status: ''
})

const open = (status, msg) => {
    show.value = true
    info.value = { text: msg, status: status}
    setTimeout(() => {
        show.value = false
    }, 2000)
}

defineExpose({
    open
})

</script>

<template>
    <Transition type="fade">
        <div class="overlay fixed top-0 right-0 bottom-0 left-0 z-50 bg-black bg-opacity-50 flex items-center justify-center transition ease-in-out delay-150 duration-300" v-if="show" @click.self="show = false"> 
            <div class="dialog w-10/12 md:w-1/4 h-1/3  bg-white rounded-lg shadow flex flex-col items-center justify-center">
                <CheckCircleIcon class="w-1/3 text-lime-400 animate-bounce" v-if="info.status == 'Ok'" />
                <XCircleIcon class="w-1/3 text-red-400 animate-bounce" v-if="info.status == 'Error' " />
                <h1 class="text-lg text-center mx-2">{{ info.text }}</h1>
            </div>
        </div>
    </Transition>
</template>