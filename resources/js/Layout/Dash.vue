<script setup>
import {onMounted, defineAsyncComponent, computed, ref } from 'vue';
import { Bars3CenterLeftIcon, ArrowRightCircleIcon, XMarkIcon } from '@heroicons/vue/20/solid';
import { Link, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiExitToApp } from '@mdi/js';

const SideNav = defineAsyncComponent(() => import('@/Layout/DashSide.vue'))
const Loading = defineAsyncComponent(() => import('@/Components/General/Loading.vue'))
const loading = ref(false)

const props = defineProps({title: String})

const page = usePage()

const side = ref(false)

const toggleSide = () => {
    let sidebar = document.querySelector('#sidebar')
    sidebar.classList.toggle('-translate-x-[100%]')
    side.value = !side.value
}

const imTouched = (e) => {
    let el = e.target
    let icon = el.querySelector('.ikon')
    if(!el.classList.contains('active')) {
        icon.classList.remove('hidden')
    }
    
}
const leftBehind = (e) => {
    let el = e.target
    let icon = el.querySelector('.ikon')
    if(!el.classList.contains('active'))
    {icon.classList.add('hidden')}
}

const logout = () => {
    loading.value = true
    axios.post('/logout')
        .then(res => {
            window.location.href= route('login')
            loading.value = false
        })
}


const expandChild = (e) => {
    const li = e.target.closest('li')
    li.querySelector('ul').classList.toggle('hidden')
    
}

const amIActive = (url) => {
    return route().current() == url ? true : false
}

const doesMyChildActive = (children) => {
    return children.includes(route().current()) ? true : false
}

const admin = computed(() => {
    return page.props.auth.user.level == 'admin'
})

const DialogBox = defineAsyncComponent(() => import('@/Components/General/DialogBox.vue'))
const dialogBox = ref(null)
const confirmLogout = async () => {
    if (await dialogBox.value.open("Yakin Mau Keluar?")) {
        logout()
    }
}


</script>

<template>
<Loading v-if="loading" />
<DialogBox ref="dialogBox" />
<div class="h-min-full h-screen relative grid grid-cols-12 gap-3 md:p-3">
    <div id="sidebar" class="sidebar h-[100vh] md:h-[95vh] overflow-y-hidden w-2/4 z-20 md:w-2/12 bg-teal-400 md:rounded-xl fixed top-0 md:top-3 md:fixed md:block md:col-span-2 -translate-x-[100%] md:-translate-x-0 transition-all duration-300 shadow-lg md:shadow-lg overflow-x-hidden print:hidden">
        <div class="w-full p-3 flex md:hidden items-center bg-teal-100 top-0">Pentas PAIS</div>
        
        <div class="w-full mt-3 md:mt-0 bg-gray-100 py-5">
            <img src="/img/peserta.png" alt="Avatar" class="rounded-full bg-white w-[100px] mx-auto shadow">
            <h3 class="text-center text-teal-800">@{{ page.props.auth.user.name }}</h3>
        </div>
        <ul class="top-0 w-full" >
            <li class="flex cursor-pointer p-3 bg-red-400 w-full justify-end gap-1 hover:bg-red-600 text-gray-200 hover:text-white transition-all hover:transition-all hover:justify-end duration-200  ease-in-out" @click="confirmLogout">
                <SvgIcon type="mdi" :path="mdiExitToApp" />
                Keluar
            </li>
        </ul>
        <SideNav /> 
    </div>
    <div class="main-wrap col-span-12 md:col-span-10 md:px-3 print:col-span-12">
        <nav class="bg-white p-3 md:rounded-xl shadow z-20 top-0 right-0 left-0 flex md:hidden justify-between items-center print:hidden md:translate-x-[263px]">
            {{ props.title }}
            <button @click="toggleSide">
                <XMarkIcon class="h-6 cursor-pointer md:hidden text-red-600" v-if="side" />
                <Bars3CenterLeftIcon class="h-6 cursor-pointer md:hidden" v-else />
            </button>
        </nav>
        <main class="px-3 md:px-0 print:p-0 print:m-0 md:rounded-br-lg md:translate-x-[263px] print:translate-x-[0]  print:col-span-12">
            <slot />
        </main>
    </div>
</div>
</template>

<style>
* {
  scrollbar-width: thin;
  scrollbar-color: var(--secondary) var(--primary);
}
*::-webkit-scrollbar {
  width: 5px;
}

*::-webkit-scrollbar-track {
  background: #aaaaaacc;
  border-radius: 2px;
}

*::-webkit-scrollbar-thumb {
  background-color: orange;
  border-radius: 4px;
  border: 1px solid #aaa;
  filter: drop-shadow(0 0 3px rgba(0,0,0,0.5));
}

li > a.active {
    background: white;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.child-menu {
    transition: all .35s cubic-bezier(0.075, 0.82, 0.165, 1);
}
.child-menu.hidden {
    transition: all .35s cubic-bezier(0.075, 0.82, 0.165, 1);
}
</style>