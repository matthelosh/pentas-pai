<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { ArrowRightCircleIcon } from '@heroicons/vue/20/solid';

const page = usePage()

const menus = ref([
    {
        label: 'Dashboard',
        url: 'dashboard',
        roles:['admin','panitia']
    },
    {
        label: 'Utama',
        url:'#',
        roles: ['admin', 'panitia'],
        children: [
            {
                label: 'Data Peserta',
                url: 'dashboard.peserta',
                roles: ['admin','panitia']
            },
            {
                label: 'Data Guru',
                url: 'dashboard.guru',
                roles: ['admin','panitia']
            },
            {
                label: 'Data Lomba',
                url: 'dashboard.lomba',
                roles: ['admin']
            },
            {
                label: 'Data Sekolah',
                url: 'sekolah.home',
                roles: ['admin', 'panitia']
            },
        ]
    },
    {
        label: 'Administrasi',
        url: '#',
        roles: ['admin','panitia'],
        children: [
            {
                label: 'Administrasi Peserta',
                url: 'administrasi.peserta',
                roles: ['admin','panitia']
            },
            {
                label: 'Administrasi Lomba',
                url: 'administrasi.lomba',
                roles: ['admin']
            },
            {
                label: 'Administrasi Panitia',
                url: 'administrasi.panitia',
                roles: ['admin','panitia']
            },
        ]
    },
    {
        label: 'Perlombaan',
        url: '#',
        roles: ['admin', 'panitia'],
        children: [
            {
                label: 'Soal',
                url: '#',
                roles: ['admin','panitia']
            },
            {
                label: 'Hasil Lomba',
                url: '#',
                roles: ['admin','panitia']
            },
            {
                label: 'Juara',
                url: '#',
                roles: ['admin', 'panitia']
            }
        ]
    }
])

const expandChild = (e) => {
    const li = e.target.closest('li')
    li.querySelector('ul').classList.toggle('hidden')
    
}

const amIActive = (url) => {
    return route().current() == url ? true : false
}

const doesMyChildActive = (children) => {
    let routes = children.map(ch => ch.url)
    return routes.includes(route().current()) ? true : false

}

const role = computed(() => {
    return page.props.auth.user.level
})

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
</script>

<template>
    <ul class="mt-2 bg-white bg-opacity-20 overflow-y-auto h-[60%]">
        <li v-for="(menu, i) in menus" :key="i" v-show="menu.roles.includes(role)">
            <Link :href="menu.url !== '#' ? route(menu.url) : '#'" class="flex items-center py-2 px-3 md:hover:bg-opacity-70 md:hover:bg-white md:hover:shadow md:hover:pl-5 transition-all duration-500 " @mouseover="imTouched" @mouseleave="leftBehind" :class="route().current() == menu.url ? 'active' : ''" v-if="!menu.children">
                <ArrowRightCircleIcon class="ikon h-5 transition-all duration-500" :class="route().current() == menu.url ? '' : 'hidden'" />
                {{ menu.label }}
            </Link>
            <a v-else href="#" class="parent flex items-center py-2 px-3 md:hover:bg-opacity-70 md:hover:bg-white md:hover:shadow md:hover:pl-5 transition-all duration-500" @mouseover="imTouched" @mouseleave="leftBehind" @click.prevent="expandChild" :class="doesMyChildActive(['dashboard.peserta','dashboard.guru', 'dashboard.lomba','sekolah.home']) ? 'active' :''">
                <ArrowRightCircleIcon class="ikon h-5 transition-all duration-500" :class="!doesMyChildActive(['dashboard.peserta','dashboard.guru', 'dashboard.lomba', 'sekolah.home']) ? 'hidden' :''" />
                {{ menu.label }} 
            </a>
            <ul class="child-menu duration-500 transition-all ease-in-out shadow-inner bg-white bg-opacity-50" :class="doesMyChildActive(menu.children) ? 'inline' :'hidden'" v-if="menu.children" >
                <li v-for="(child, c) in menu.children" :key="c" v-show="child.roles.includes(role)">
                    <Link :href="child.url !== '#' ? route(child.url) : '#'" class="block hover:bg-white md:hover:bg-opacity-70 px-8 py-2" :class="amIActive(child.url) ? 'bg-white bg-opacity-90' : 'bg-white bg-opacity-50'">{{child.label}}</Link>
                </li>
            </ul>
        </li>
    </ul>
        
</template>