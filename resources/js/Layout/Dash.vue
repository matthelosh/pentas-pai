<script setup>
import {onMounted, defineAsyncComponent, computed, ref } from 'vue';
import { Bars3CenterLeftIcon, ArrowRightCircleIcon, XCircleIcon } from '@heroicons/vue/20/solid';
import { Link, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiExitToApp } from '@mdi/js';

const Loading = defineAsyncComponent(() => import('@/Components/General/Loading.vue'))
const loading = ref(false)

const props = defineProps({title: String})

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
    loading.value = true
    axios.post('/logout')
        .then(res => {
            window.location.href= route('login')
            loading.value = false
        })
}

// const handleScroll = (e) => {
//     let scrollY = window.scrollY
//     let sidebar = document.querySelector('#sidebar')
//     // let sidePos = sidebar.getBoundingClientRect() 

// } 

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


onMounted(() => {
    // window.addEventListener('scroll', handleScroll)
    // console.log(route().current())
})
</script>

<template>
<Loading v-if="loading" />
<DialogBox ref="dialogBox" />
<div class="h-min-full h-screen relative grid grid-cols-12 gap-3">
    <div id="sidebar" class="sidebar h-[100vh] md:h-[95vh] overflow-y-auto w-2/4 z-20 md:w-2/12 bg-teal-400 md:rounded-xl fixed top-0 md:top-3 md:fixed md:block md:col-span-2 -translate-x-[100%] md:-translate-x-0 transition-all duration-300 shadow-lg md:shadow-lg overflow-x-hidden print:hidden">
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
        <ul class="mt-2">
            <li><Link :href="route('dashboard')" class="flex items-center py-2 px-3 md:hover:bg-opacity-70 md:hover:bg-white md:hover:shadow md:hover:pl-5 transition-all duration-500 " @mouseover="imTouched" @mouseleave="leftBehind" :class="route().current() == 'dashboard' ? 'active' : ''">
                <ArrowRightCircleIcon class="ikon h-5 transition-all duration-500" :class="route().current() == 'dashboard' ? '' : 'hidden'" />
                Dashboard
            </Link></li>
            <li>
                <a href="#" class="parent flex items-center py-2 px-3 md:hover:bg-opacity-70 md:hover:bg-white md:hover:shadow md:hover:pl-5 transition-all duration-500" @mouseover="imTouched" @mouseleave="leftBehind" @click.prevent="expandChild" :class="doesMyChildActive(['dashboard.peserta','dashboard.guru', 'dashboard.lomba','sekolah.home']) ? 'active' :''">
                <ArrowRightCircleIcon class="ikon h-5 transition-all duration-500" :class="!doesMyChildActive(['dashboard.peserta','dashboard.guru', 'dashboard.lomba', 'sekolah.home']) ? 'hidden' :''" />
                Utama
                </a>
                    <ul class="child-menu duration-500 transition-all ease-in-out bg-white bg-opacity-25" :class="doesMyChildActive(['dashboard.peserta','dashboard.guru', 'dashboard.lomba', 'sekolah.home']) ? 'inline' :'hidden'">
                        <li><Link :href="route('dashboard.peserta')" class="block hover:bg-white md:hover:bg-opacity-70 px-8 py-2" :class="amIActive('dashboard.peserta') ? 'bg-white bg-opacity-70' : ''">Data Peserta</Link></li>
                        <li v-if="admin"><Link :href="route('dashboard.guru')" class="block hover:bg-white md:hover:bg-opacity-70 px-8 py-2" :class="amIActive('dashboard.guru') ? 'bg-white bg-opacity-70' : ''">Data Guru</Link></li>
                        <li v-if="admin"><Link :href="route('dashboard.lomba')" class="block hover:bg-white md:hover:bg-opacity-70 px-8 py-2" :class="amIActive('dashboard.lomba') ? 'bg-white bg-opacity-70' : ''">Data Lomba</Link></li>
                        <li v-if="admin"><Link :href="route('sekolah.home')" class="block hover:bg-white md:hover:bg-opacity-70 px-8 py-2" :class="amIActive('sekolah.home') ? 'bg-white bg-opacity-70' : ''">Data Sekolah</Link></li>
                    </ul>
                </li>
            <li>
                <Link :href="route('administrasi')" class="flex items-center py-2 px-3 md:hover:bg-opacity-70 md:hover:bg-white md:hover:shadow md:hover:pl-5 transition-all duration-500 active:bg-white" @mouseover="imTouched" @mouseleave="leftBehind" :class="route().current() == 'administrasi' ? 'active' : ''">
                <ArrowRightCircleIcon class="ikon h-5 transition-all duration-500" :class="route().current() == 'administrasi' ? '' : 'hidden'" />
                Administrasi
                </Link>
            </li>
        </ul>
        
    </div>
    <div class="main-wrap col-span-12 md:col-span-10 md:px-3 print:col-span-12">
        <nav class="bg-white p-3 md:rounded-xl shadow z-20 top-0 right-0 left-0 flex justify-between items-center print:hidden md:translate-x-[263px]">
            {{ props.title }}
            <Bars3CenterLeftIcon class="h-6 cursor-pointer md:hidden" @click="toggleSide" />
            <!-- <XCircleIcon class="h-8 hidden md:block cursor-pointer text-red-600 hover:text-red-500 hover:shadow rounded-full" @click="logout" /> -->
        </nav>
        <main class="md:mt-3 px-3 md:px-0 print:p-0 print:m-0 md:rounded-br-lg md:translate-x-[263px] print:translate-x-[0]  print:col-span-12">
            <slot />
        </main>
    </div>
</div>
</template>

<style>
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