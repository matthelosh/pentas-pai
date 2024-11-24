<script setup>
import { defineAsyncComponent, ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { Bars3CenterLeftIcon, XMarkIcon } from "@heroicons/vue/20/solid";
import SvgIcon from "@jamescoyle/vue-icon";
import { mdiLogin, mdiViewDashboard } from "@mdi/js";

const Footer = defineAsyncComponent(() =>
    import("@/Components/Welcome/FrontFooter.vue")
);
const nav = ref(false);
const toggleNav = (e) => {
    let navList = document.querySelector("ul#nav-list");
    navList.classList.toggle("hidden");
    nav.value = !nav.value;
};
</script>

<template>
    <div class="relative h-screen bg-white bg-opacity-5 md:p-3 md:pb-0 pb-0">
        <nav
            class="px-3 h-16 fixed md:sticky md:top-0 shadow w-full bg-white md:flex items-center md:justify-between rounded-b-lg z-10 md:rounded-xl"
        >
            <div
                class="logo h-full flex items-center justify-between md:justify-start md:items-center md:w-72"
            >
                <Link
                    as="span"
                    href="/"
                    class="flex items-end gap-1 cursor-pointer"
                >
                    <img src="img/kkg.png" alt="Logo" class="h-9" />
                    <h1 class="leading-3">
                        <span class="font-extrabold text-teal-600"
                            >PENTAS PAI</span
                        >
                        <br />
                        <small class="text-gray-600 font-thin"
                            >KKG Kec. Wagir</small
                        >
                    </h1>
                </Link>
                <button @click="toggleNav">
                    <XMarkIcon
                        class="h-8 md:hidden text-red-600 transition-all"
                        v-if="nav"
                    />
                    <Bars3CenterLeftIcon
                        class="h-8 md:hidden text-gray-600 transition-all duration-150"
                        v-else
                    />
                </button>
            </div>
            <div class="nav-items flex items-center justify-end gap-2">
                <ul
                    id="nav-list"
                    class="hidden md:flex md:justify-end absolute top-14 md:top-0 md:relative bg-white w-full left-0 rounded-b-lg duration-500 z-20 shadow-lg md:shadow-none"
                >
                    <li
                        class="max-0 my-0 md:mx-1 md:my-0 hover:rounded duration-300 border-orange-400 hover:text-orange-400"
                        :class="
                            route().current() == 'home'
                                ? 'text-orange-400 border-b-4 rounded-b font-bold bg-orange-50 bg-opacity-50'
                                : ''
                        "
                    >
                        <Link href="/" class="p-2 block">Beranda</Link>
                    </li>
                    <li
                        class="max-0 my-0 md:mx-1 md:my-0 border-orange-400 hover:rounded duration-100 hover:text-orange-400"
                        :class="
                            route().current() == 'about'
                                ? 'text-orange-400 border-b-4 rounded-b  bg-orange-50 bg-opacity-50 font-bold'
                                : ''
                        "
                    >
                        <Link :href="route('about')" class="p-2 block"
                            >Tentang</Link
                        >
                    </li>
                    <li
                        class="max-0 my-0 md:mx-1 md:my-0 border-orange-400 hover:rounded duration-100 hover:text-orange-400"
                        :class="
                            route().current() == 'peserta'
                                ? 'text-orange-600 border-b-4 rounded-b  bg-orange-50 bg-opacity-50 font-bold'
                                : ''
                        "
                    >
                        <Link :href="route('peserta')" class="p-2 block"
                            >Data Peserta</Link
                        >
                    </li>
                    <li
                        class="max-0 my-0 md:mx-1 md:my-0 border-orange-400 hover:rounded duration-100 hover:text-orange-400"
                        :class="
                            route().current() == 'daftar'
                                ? 'text-orange-400 border-b-4 rounded-b  bg-orange-50 bg-opacity-50 font-bold'
                                : ''
                        "
                    >
                        <Link :href="route('daftar')" class="p-2 block"
                            >Registrasi</Link
                        >
                    </li>
                    <li class="max-0 my-0 md:mx-1">
                        <Link :href="route('dashboard')" class="flex p-2">
                            <svg-icon
                                type="mdi"
                                :path="
                                    $page.props.auth.user
                                        ? mdiViewDashboard
                                        : mdiLogin
                                "
                                class="text-sky-600"
                            />
                            <span class="md:hidden">{{
                                $page.props.auth.user ? " Dashboard" : " Login"
                            }}</span>
                        </Link>
                    </li>
                </ul>
            </div>
        </nav>
        <main class="relative pt-2 pb-8 px-3 md:py-1 md:px-0">
            <slot />
        </main>
    </div>
    <Footer class="bottom-0 fixed left-0 right-0" />
</template>
