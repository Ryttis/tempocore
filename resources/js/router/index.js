import { createRouter, createWebHistory } from 'vue-router'
import ClientBooking from '../pages/ClientBooking.vue'
import AdminPanel from '../pages/WorkingHoursAdmin.vue'

const routes = [
    { path: '/', name: 'booking', component: ClientBooking },
    { path: '/admin', name: 'admin', component: AdminPanel },
]

export default createRouter({
    history: createWebHistory(),
    routes,
})
