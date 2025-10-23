import axios from 'axios'

const http = axios.create({
    baseURL: '/api',
    headers: { Accept: 'application/json' },
})

export default {
    getServices() {
        return http.get('/services')
    },
    getAvailability(params) {
        return http.get('/availability', { params })
    },
    book(payload) {
        return http.post('/appointments', payload)
    },

    getWorkingHours() {
        return http.get('/working-hours')
    },
    addWorkingHour(payload) {
        return http.post('/working-hours', payload)
    },
}
