<script setup>
import { ref, onMounted } from 'vue';
import { Head, usePage } from '@inertiajs/vue3'
import Front from '@/Layout/Front.vue';
import { EyeIcon, EyeSlashIcon, UserCircleIcon, LockClosedIcon, ArrowPathIcon } from '@heroicons/vue/20/solid';
import axios from 'axios';
import AlertBox from '@/Components/General/AlertBox.vue';

const page = usePage()

const showPassword = ref(false)
const loading = ref(false)
const alertBox = ref(null)
const user = ref({})
const login = async () => {
    loading.value = true
    await axios.post('/login', user.value)
            .then(res => {
                window.location.href = route('dashboard')
            }).catch(err => {
                // console.log(err)
                let msg = err.response.status == 422 ? 'Username atau password tidak tepat' : err.response.data.message
                alertBox.value.open("Error", msg)
                loading.value = false
            })
}

onMounted(() => {
    if (page.props.auth.user) {
        window.location.href = route('dashboard')
    }
})

</script>
<template>
<AlertBox ref="alertBox" />    
<Head title="Login" />
<Front class="h-screen">
<div class="container md:flex md:items-center md:h-[580px]">
    <div class="container bg-white w-full rounded shadow-lg columns-1 md:columns-2 gap-4 md:w-9/12 mx-auto">
        <div class="w-full h-96 flex items-center justify-center bg-teal-700">
            <div>
                <img src="img/peserta.png" alt="Avatar" class="mx-auto rounded-full aspect-square shadow-md border p-1 bg-gray-200" width="100">
                <h3 class="text-center text-white">Selamat Datang!</h3>
            </div>
        </div>
        <div class="w-full h-96 flex items-center justify-center">
            <form ref="form-login" @submit.prevent="login" class="w-full px-10">
                <div class="mb-5">
                    <h3 class="text-2xl flex items-center">
                        <LockClosedIcon class="h-6 mb-1" />
                        Login
                    </h3>
                </div>
                <div>
                    <label for="name">Username</label>
                    <div class="flex relative items-center">
                        <input type="text" name="name" id="name" placeholder="Username" class="w-full placeholder:text-gray-600 rounded-lg focus:outline-teal-800" v-model="user.name" :disabled="loading">
                        <UserCircleIcon class=" absolute text-gray-600 h-6 right-0 mr-3" />
                    </div>
                </div>
                <div class="my-3">
                    <label for="password">Password</label>
                    <div class="relative flex items-center">
                        <input name="password" id="password" placeholder="Password" :type="showPassword ? 'text' : 'password'" class="w-full placeholder:text-gray-600 rounded-lg focus:outline-teal-800" v-model="user.password" :disabled="loading">
                        <EyeIcon class="text-gray-600  absolute h-6 right-0 duration-100 mr-3 cursor-pointer" v-if="!showPassword" @click="showPassword = true" />
                        <EyeSlashIcon class="text-gray-600  absolute h-6 right-0 mr-3 duration-100 cursor-pointer" v-if="showPassword" @click="showPassword = false" />
                    </div>
                </div>
                <div class="flex justify-center">
                    <button type="submit" class="bg-sky-600 text-white py-2 px-3 rounded-lg mx-auto w-full flex items-center justify-center disabled:bg-sky-200 disabled:text-gray-400" :disabled="loading">
                        <ArrowPathIcon v-if="loading" class=" animate-spin w-6" />
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</Front>
</template>