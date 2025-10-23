<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const workingHours = ref([])
const form = ref({
    day_of_week: 1,
    start_time: '09:00',
    end_time: '17:00',
})
const saving = ref(false)
const errorMessage = ref(null)

async function loadWorkingHours() {
    try {
        const response = await axios.get('/api/working-hours')
        workingHours.value = response.data.data ?? response.data
    } catch (e) {
        console.error('Failed to load working hours:', e)
    }
}

async function addRule() {
    saving.value = true
    errorMessage.value = null
    try {
        await axios.post('/api/working-hours', form.value)
        await loadWorkingHours()
    } catch (e) {
        console.error('Failed to save working hour:', e)
        errorMessage.value = e?.response?.data?.message || 'Failed to save.'
    } finally {
        saving.value = false
    }
}

onMounted(loadWorkingHours)
</script>

<template>
    <section style="padding:20px; font-family:sans-serif;">
        <h2 style="margin:0 0 16px;">Admin: Working Hours</h2>

        <form @submit.prevent="addRule"
              style="display:grid; grid-template-columns: 1fr 1fr 1fr 120px; gap:8px; align-items:end; max-width:720px;">
            <div>
                <label style="display:block; font-weight:600; margin-bottom:6px;">Day of week</label>
                <select v-model.number="form.day_of_week" style="width:100%; padding:8px;">
                    <option v-for="(d,idx) in ['Sun','Mon','Tue','Wed','Thu','Fri','Sat']"
                            :key="idx" :value="idx">{{ d }}</option>
                </select>
            </div>
            <div>
                <label style="display:block; font-weight:600; margin-bottom:6px;">Start</label>
                <input v-model="form.start_time" type="time" style="width:100%; padding:8px;" />
            </div>
            <div>
                <label style="display:block; font-weight:600; margin-bottom:6px;">End</label>
                <input v-model="form.end_time" type="time" style="width:100%; padding:8px;" />
            </div>
            <button
                :disabled="saving"
                type="submit"
                style="padding:10px 12px; border:0; border-radius:8px; background:#2563eb; color:white; cursor:pointer;">
                Add
            </button>
        </form>

        <p v-if="errorMessage" style="color:#991b1b; margin-top:8px;">{{ errorMessage }}</p>

        <div style="margin-top:24px;">
            <h3 style="margin:0 0 8px; font-size:16px;">Existing rules</h3>
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                <tr>
                    <th style="text-align:left; border-bottom:1px solid #eee; padding:8px;">Day</th>
                    <th style="text-align:left; border-bottom:1px solid #eee; padding:8px;">Start</th>
                    <th style="text-align:left; border-bottom:1px solid #eee; padding:8px;">End</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="row in workingHours" :key="row.id">
                    <td style="padding:8px;">{{ ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'][row.day_of_week] }}</td>
                    <td style="padding:8px;">{{ row.start_time }}</td>
                    <td style="padding:8px;">{{ row.end_time }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>
