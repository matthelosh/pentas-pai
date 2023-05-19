<script setup>
import { Link } from '@inertiajs/vue3';
import { Bars3CenterLeftIcon} from '@heroicons/vue/20/solid';
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiLogin } from '@mdi/js';

const tes = (e) => {
    let navList = document.querySelector('ul#nav-list')
    navList.classList.toggle('hidden')
}
</script>

<template>
<div class="relative min-h-screen bg-white bg-opacity-5">
    <nav class="p-3 fixed md:sticky md:top-0  shadow w-full bg-white md:flex md:items-center md:justify-between rounded-b-lg z-10 md:rounded">
        <div class="logo flex items-center justify-between md:justify-start md:items-end md:w-72 ">
            <img src="img/kkg.png" alt="Logo" class="h-9 inline">
            <span class="text-lg hidden md:inline">Pentas PAIS</span>
            <Bars3CenterLeftIcon class="h-5 md:hidden" @click="tes" />
        </div>
        <div class="nav-items flex items-center justify-end gap-2">
        
            <ul id="nav-list" class="hidden md:flex md:justify-end absolute top-14 md:top-0 md:relative bg-white w-full left-0 rounded-b-lg duration-500 z-20 shadow-lg md:shadow-none">
                <li class=" max-0 my-0 md:mx-1 md:my-0 hover:bg-green-400 hover:rounded duration-300">
                    <Link href="/" class="p-2 hover:text-white duration-300 block">Beranda</Link>
                </li>
                <li class=" max-0 my-0 md:mx-1 md:my-0 hover:bg-green-400  hover:rounded duration-300">
                    <a href="#" class="p-2 hover:text-white duration-300 block">Tentang</a>
                </li>
                <li class=" max-0 my-0 md:mx-1 md:my-0 hover:bg-green-400  hover:rounded duration-300">
                    <Link :href="route('peserta')" class="p-2 hover:text-white duration-300 block">Data Peserta</Link>
                </li>
                <li class=" max-0 my-0 md:mx-1 md:my-0 hover:bg-green-400  hover:rounded duration-300">
                    <Link :href="route('daftar')" class="p-2 hover:text-white duration-300 block">Registrasi</Link>
                </li>
            </ul>
            <Link :href="route('dashboard')">
                <svg-icon type="mdi" :path="mdiLogin" class="text-sky-600" />
            </Link>
        </div>
    </nav>
    <main class="relative top-16 py-2 md:top-20 px-3 md:py-1 md:px-0">
            <slot />
    </main>
</div>
</template>