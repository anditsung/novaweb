import NovaSidebarMenu from 'nova-sidebar-menu'

Nova.booting((Vue, router, store) => {
    Vue.component('nova-sidebar', NovaSidebarMenu)
})