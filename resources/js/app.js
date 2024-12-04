import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp, Head, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import '@imengyu/vue3-context-menu/lib/vue3-context-menu.css';
import ContextMenu from '@imengyu/vue3-context-menu';
import DialogPlugin from './Plugins/dialog'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app =  createApp({ render: () => h(App, props) });
            app.use(plugin)
            app.use(ZiggyVue, Ziggy)
            app.use(ContextMenu)
            app.use(DialogPlugin)
            app.provide("$dialog", app.config.globalProperties.$dialog)
            app.component('InertiaHead', Head)
            app.component('InertiaLink', Link)
            app.mixin({ methods: { route: window.route } })
            app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
