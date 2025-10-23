<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'

const services = ref([])
const selectedService = ref(null)
const selectedDate = ref(new Date().toISOString().substring(0, 10))
const availableSlots = ref([])
const clientEmail = ref('')
const loading = ref(false)
const successMessage = ref(null)
const errorMessage = ref(null)

async function loadServices() {
    const { data } = await axios.get('/api/services')
    services.value = data?.data ?? data
}

watch([selectedService, selectedDate], async ([svc, date]) => {
    if (!svc || !date) return
    await loadSlots()
})

async function loadSlots() {
    try {
        loading.value = true
        const { data } = await axios.get('/api/availability', {
            params: { date: selectedDate.value, service_id: selectedService.value }
        })
        availableSlots.value = data?.data ?? data
    } catch (e) {
        console.error('Failed to load slots:', e)
    } finally {
        loading.value = false
    }
}

async function book(slot) {
    if (!clientEmail.value) {
        errorMessage.value = 'Please enter your email before booking.'
        return
    }

    try {
        loading.value = true
        errorMessage.value = null
        successMessage.value = null

        await axios.post('/api/appointments', {
            service_id: selectedService.value,
            starts_at: slot.startUtc,
            client_email: clientEmail.value,
        })

        successMessage.value = 'Appointment booked successfully!'
        await loadSlots()
    } catch (e) {
        console.error(e)
        errorMessage.value = e?.response?.data?.message || 'Booking failed.'
    } finally {
        loading.value = false
    }
}

onMounted(loadServices)
</script>

<template>
    <section style="padding:20px; font-family:sans-serif;">
        <h2>Client Booking</h2>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px; max-width:480px;">
            <div>
                <label style="display:block; font-weight:600; margin-bottom:6px;">Service</label>
                <select v-model="selectedService" style="width:100%; padding:8px;">
                    <option disabled value="">Select a service</option>
                    <option v-for="s in services" :key="s.id" :value="s.id">{{ s.name }}</option>
                </select>
            </div>

            <div>
                <label style="display:block; font-weight:600; margin-bottom:6px;">Date</label>
                <input type="date" v-model="selectedDate" style="width:100%; padding:8px;" />
            </div>
        </div>

        <div style="margin-top:16px;">
            <label style="display:block; font-weight:600; margin-bottom:6px;">Your email</label>
            <input v-model="clientEmail" type="email" placeholder="you@example.com" style="padding:8px; width:100%; max-width:320px;" />
        </div>

        <div style="margin-top:24px;">
            <h3 style="margin:0 0 8px;">Available Slots</h3>
            <p v-if="loading">Loading...</p>
            <p v-else-if="!availableSlots.length">No slots available for this day.</p>

            <div style="display:flex; flex-wrap:wrap; gap:8px;">
                <button
                    v-for="slot in availableSlots"
                    :key="slot.startUtc"
                    @click="book(slot)"
                    style="padding:8px 12px; background:#22c55e; border:0; border-radius:6px; color:white; cursor:pointer;"
                >
                    {{ slot.startLocal }} - {{ slot.endLocal }}
                </button>
            </div>
        </div>

        <p v-if="successMessage" style="color:#166534; margin-top:16px;">{{ successMessage }}</p>
        <p v-if="errorMessage" style="color:#991b1b; margin-top:16px;">{{ errorMessage }}</p>
    </section>
</template>
