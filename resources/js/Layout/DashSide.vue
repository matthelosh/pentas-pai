<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { ArrowRightCircleIcon } from '@heroicons/vue/20/solid';
import { Icon } from '@iconify/vue';

const page = usePage()

const menus = ref([
    {
        label: 'Dashboard',
        url: 'dashboard',
        icon: 'view-dashboard-outline',
        roles:['admin','panitia']
    },
    {
        label: 'Utama',
        url:'#',
        roles: ['admin', 'panitia'],
        icon: 'database',
        children: [
            {
                label: 'Data Peserta',
                url: 'dashboard.peserta',
                roles: ['admin','panitia'],
                icon: 'account-multiple',
            },
            {
                label: 'Data Guru',
                url: 'dashboard.guru',
                roles: ['admin','panitia'],
                icon: 'account-tie',
            },
            {
                label: 'Data Lomba',
                url: 'dashboard.lomba',
                roles: ['admin'],
                icon: 'chart-line',
            },
            {
                label: 'Data Sekolah',
                url: 'sekolah.home',
                roles: ['admin', 'panitia'],
                icon: 'domain',
            },
        ]
    },
    {
        label: 'Administrasi',
        url: '#',
        roles: ['admin','panitia'],
        icon: 'typewriter',
        children: [
            {
                label: 'Administrasi Peserta',
                url: 'administrasi.peserta',
                roles: ['admin','panitia'],
                icon: 'card-account-details-outline',
            },
            {
                label: 'Administrasi Lomba',
                url: 'administrasi.lomba',
                roles: ['admin'],
                icon: 'flag',
            },
            {
                label: 'Administrasi Panitia',
                url: 'administrasi.panitia',
                roles: ['admin','panitia'],
                icon: 'account-tie',
            },
            {
                label: 'Administrasi Persuratan',
                url: 'administrasi.surat',
                roles: ['admin','panitia'],
                icon: 'envelope',
            },
        ]
    },
    {
        label: 'Perlombaan',
        url: '#',
        roles: ['admin', 'panitia'],
        icon: 'flag',
        children: [
            {
                label: 'Soal',
                url: '#',
                roles: ['admin','panitia'],
                icon: 'document',
            },
            {
                label: 'Hasil Lomba',
                url: '#',
                roles: ['admin','panitia'],
                icon: 'clipboard',
            },
            {
                label: 'Juara',
                url: '#',
                roles: ['admin', 'panitia'],
                icon: 'trophy',
            }
        ]
    },
    {
        label: 'Pengaturan',
        url: 'setting',
        roles: ['admin'],
        icon: 'wrench',
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

</script>

<template>
    <ul class="mt-2 bg-white bg-opacity-20 overflow-y-auto h-[60%]">
        <li v-for="(menu, i) in menus" :key="i" v-show="menu.roles.includes(role)">
            <Link :href="menu.url !== '#' ? route(menu.url) : '#'" class="flex items-center py-2 px-3 md:hover:bg-opacity-70 md:hover:bg-white md:hover:shadow md:hover:pl-5 transition-all duration-500 font-extralight"  :class="route().current() == menu.url ? 'active' : ''" v-if="!menu.children">
                <Icon :icon="`mdi:${menu.icon}`" />
                {{ menu.label }}
            </Link>
            <a v-else href="#" class="parent flex items-center py-2 px-3 md:hover:bg-opacity-70 md:hover:bg-white md:hover:shadow md:hover:pl-5 transition-all duration-500 font-extralight"  @click.prevent="expandChild" :class="doesMyChildActive(['dashboard.peserta','dashboard.guru', 'dashboard.lomba','sekolah.home']) ? 'active' :''">
                <Icon :icon="`mdi:${menu.icon}`" />
                {{ menu.label }} 
            </a>
            <ul class="child-menu duration-500 transition-all ease-in-out shadow-inner bg-white bg-opacity-50" :class="doesMyChildActive(menu.children) ? 'inline' :'hidden'" v-if="menu.children" >
                <li v-for="(child, c) in menu.children" :key="c" v-show="child.roles.includes(role)">
                    <Link :href="child.url !== '#' ? route(child.url) : '#'" class="flex items-center gap-1 hover:bg-white md:hover:bg-opacity-70 px-8 py-2 font-extralight" :class="amIActive(child.url) ? 'bg-white bg-opacity-90' : 'bg-white bg-opacity-50'">
                        <Icon :icon="`mdi:${child.icon}`" />
                        {{child.label}}
                    </Link>
                </li>
            </ul>
        </li>
    </ul>
        
</template>

<style scoped>
li > a.active {
    background: white;
}

/* .fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
} */

.child-menu {
    transition: all .35s cubic-bezier(0.075, 0.82, 0.165, 1);
}
.child-menu.hidden {
    transition: all .35s cubic-bezier(0.075, 0.82, 0.165, 1);
}

.page-enter-active,
    .page-leave-active {
        transition: all .1s;
    }

.page-enter,
.page-leave-active {
    opacity: 0;
}
</style>