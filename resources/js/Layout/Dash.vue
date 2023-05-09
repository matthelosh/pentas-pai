<script setup>
import {onMounted } from 'vue';
import { Bars3CenterLeftIcon, ArrowRightCircleIcon, XCircleIcon } from '@heroicons/vue/20/solid';
import { Link, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import SvgIcon from '@jamescoyle/vue-icon';
import {mdilAccount} from '@mdi/light-js';

const page = usePage()

const toggleSide = () => {
    let sidebar = document.querySelector('#sidebar')
    sidebar.classList.toggle('-translate-x-[100%]')
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
    axios.post('/logout')
        .then(res => {
            window.location.href= route('login')
        })
}

const handleScroll = (e) => {
    let scrollY = window.scrollY
    let sidebar = document.querySelector('#sidebar')
    let sidePos = sidebar.getBoundingClientRect() 

    if(sidePos.top !== scrollY) {
        sidebar.style.position = 'sticky!important'
    }
    console.log(scrollY, sidePos.top)
} 

onMounted(() => {
    window.addEventListener('scroll', handleScroll)
})
</script>

<template>
<div class="h-min-full h-screen relative grid grid-cols-12 gap-3">
    <div id="sidebar" class="sidebar h-screen w-2/4 z-50 md:w-2/12 bg-teal-400 md:rounded-s-lg fixed top-0 md:top-3 md:fixed md:block md:col-span-2 -translate-x-[100%] md:-translate-x-0 transition-all duration-300 shadow-lg md:shadow-none overflow-x-hidden print:hidden">
        <div class="w-full p-3 flex md:hidden items-center bg-teal-100 top-0">Pentas PAIS</div>
        <div class="w-full mt-3 md:mt-0 bg-gray-100 py-5">
            <img src="img/peserta.png" alt="Avatar" class="rounded-full bg-white w-[100px] mx-auto shadow">
            <h3 class="text-center text-teal-800">@{{ page.props.auth.user.name }}</h3>
        </div>
        <ul class="mt-2">
            <li><Link :href="route('dashboard')" class="flex items-center py-2 px-3 md:hover:bg-opacity-70 md:hover:bg-white md:hover:shadow md:hover:pl-5 transition-all duration-500 " @mouseover="imTouched" @mouseleave="leftBehind">
                <ArrowRightCircleIcon class="ikon hidden h-5 transition-all duration-500" />
                Dashboard
                <SvgIcon type="mdil" :path="mdilAccount" />
            </Link></li>
            <li><a href="#" class="flex items-center py-2 px-3 md:hover:bg-opacity-70 md:hover:bg-white md:hover:shadow md:hover:pl-5 transition-all duration-500" @mouseover="imTouched" @mouseleave="leftBehind">
                <ArrowRightCircleIcon class="ikon hidden h-5 transition-all duration-500" />
                Tentang
            </a></li>
            <li>
                <Link :href="route('administrasi')" class="flex items-center py-2 px-3 md:hover:bg-opacity-70 md:hover:bg-white md:hover:shadow md:hover:pl-5 transition-all duration-500 active:bg-white" @mouseover="imTouched" @mouseleave="leftBehind" :class="route().current() == 'administrasi' ? 'active' : ''">
                <ArrowRightCircleIcon class="ikon h-5 transition-all duration-500" :class="route().current() == 'administrasi' ? '' : 'hidden'" />
                Administrasi
                </Link>
            </li>
        </ul>
    </div>
    <div class="main-wrap col-span-12 md:col-span-10 md:px-3">
        <nav class="bg-white p-3 md:rounded-tr-lg shadow sticky md:sticky z-20 top-0 right-0 left-0 flex justify-between items-center print:hidden md:translate-x-[263px]">
            Navbar
            <Bars3CenterLeftIcon class="h-6 cursor-pointer md:hidden" @click="toggleSide" />
            <XCircleIcon class="h-8 hidden md:block cursor-pointer text-red-600 hover:text-red-500 hover:shadow rounded-full" @click="logout" />
        </nav>
        <main class="mt-14 md:mt-3 px-3 md:px-0  md:rounded-br-lg md:translate-x-[263px]">
            <slot />
        </main>
    </div>
</div>
</template>

<style>
li > a.active {
    background: white;
}
</style>