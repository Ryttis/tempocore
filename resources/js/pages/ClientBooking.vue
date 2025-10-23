<script setup>
import { ref, onMounted, computed } from 'vue'
import dayjs from 'dayjs'
import api from '../api/api'

const services = ref([])
const selectedServiceId = ref(null)
const date = ref(dayjs().format('YYYY-MM-DD'))
const slots = ref([])

const selectedSlot = ref(null)
const clientEmail = ref('')
const clientName = ref('')

const loadingSlots = ref(false)
const bookingMessage = ref(null)
const bookingError = ref(null)

async function loadServices() {
    const { data } = await api.getServices()
    services.value = data?.data ?? data
    if (!selectedServiceId.value && services.value.length) {
        selectedServiceId.value = services.value[0].id
    }
}

async function loadSlots() {
    if (!selectedServiceId.value || !date.value) return
    loadingSlots.value = true
    selectedSlot.value = null
    bookingMessage.value = null
    bookingError.value = null

    try {
        const { data } = await api.getAvailability({
            service_id: selectedServiceId.value,
            date: date.value,
        })
        slots.value = data?.data ?? data
    } catch (e) {
        slots.value = []
        console.error(e)
    } finally {
        loadingSlots.value = false
    }
}

onMounted(async () => {
    await loadServices()
    await loadSlots()
})

function onChange() {
    loadSlots()
}

const canSubmit = computed(() =>
    selectedServiceId.value && selectedSlot.value && clientEmail.value
)

async function submitBooking() {
    bookingMessage.value = null
    bookingError.value = null

    try {
        await api.book({
            service_id: selectedServiceId.value,
            starts_at: selectedSlot.value.startUtc,
            client_email: clientEmail.value,
            client_name: clientName.value || null,
        })
        bookingMessage.value = 'Booked! Check your email.'
        await loadSlots()
    } catch (e) {
        bookingError.value = e?.response?.data?.message || 'Failed to book.'
    }
}
</script>

<template>
    <section>
        <h2 style="margin:0 0 16px;">Book an appointment</h2>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-bottom:16px;">
            <div>
                <label style="display:block; font-weight:600; margin-bottom:6px;">Service</label>
                <select v-model="selectedServiceId" @change="onChange" style="width:100%; padding:8px;">
                    <option v-for="s in services" :key="s.id" :value="s.id">
                        {{ s.name }} ({{ s.duration_minutes }} min)
                    </option>
                </select>
            </div>

            <div>
                <label style="display:block; font-weight:600; margin-bottom:6px;">Date</label>
                <input type="date" v-model="date" @change="onChange" style="width:100%; padding:8px;" />
            </div>
        </div>

        <div style="margin:16px 0;">
            <h3 style="margin:0 0 8px; font-size:16px;">Available slots</h3>
            <div v-if="loadingSlots">Loading slots…</div>
            <div v-else-if="!slots.length" style="color:#666;">No slots for this day.</div>

            <div style="display:flex; flex-wrap:wrap; gap:8px;">
                <button
                    v-for="slot in slots"
                    :key="slot.startUtc"
                    @click="selectedSlot = slot"
                    :style="{
            padding:'8px 10px',
            border:'1px solid #ddd',
            borderRadius:'8px',
            cursor:'pointer',
            background: selectedSlot?.startUtc === slot.startUtc ? '#eef5ff' : 'white'
          }"
                    type="button"
                    title="Pick slot"
                >
                    {{ slot.startLocal }} – {{ slot.endLocal }}
                </button>
            </div>
        </div>

        <form @submit.prevent="submitBooking" style="display:grid; gap:12px; max-width:420px;">
            <div>
                <label style="display:block; font-weight:600; margin-bottom:6px;">Email</label>
                <input v-model="clientEmail" type="email" required placeholder="you@example.com" style="width:100%; padding:8px;"/>
            </div>

            <div>
                <label style="display:block; font-weight:600; margin-bottom:6px;">Name (optional)</label>
                <input v-model="clientName" type="text" placeholder="Jane Doe" style="width:100%; padding:8px;"/>
            </div>

            <button :disabled="!canSubmit" type="submit" style="padding:10px 12px; border:0; border-radius:8px; background:#2563eb; color:white; cursor:pointer;">
                Book selected slot
            </button>

            <p v-if="bookingMessage" style="color: #065f46;">{{ bookingMessage }}</p>
            <p v-if="bookingError" style="color: #991b1b;">{{ bookingError }}</p>
        </form>
    </section>
</template>
