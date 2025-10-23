<script setup>
import {ref, onMounted} from 'vue'
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
    <section style="padding:32px; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
        <h2 style="margin:0 0 20px; font-size:22px; font-weight:600;">Admin: Working Hours</h2>

        <form
            @submit.prevent="addRule"
            style="
            display: flex;
            gap: 16px;
            align-items: flex-end;
            flex-wrap: wrap;
            background: #fafafa;
            border: 1px solid #e5e7eb;
            padding: 16px;
            border-radius: 10px;
            max-width: 740px;
  "
        >
            <div style="flex: 1 1 150px; min-width: 120px;">
                <label style="display:block; font-weight:600; margin-bottom:6px;">Day of week</label>
                <select
                    v-model.number='form.day_of_week'
                    style="width:100%; padding:8px 10px; border:1px solid #d1d5db; border-radius:6px; font-size:14px;"
                >
                    <option v-for="(d,idx) in ['Sun','Mon','Tue','Wed','Thu','Fri','Sat']" :key="idx" :value="idx">{{
                            d
                        }}
                    </option>
                </select>
            </div>

            <div style="flex: 3 1 120px; min-width: 100px;">
                <label style="display:block; font-weight:600; margin-bottom:6px;">Start</label>
                <input
                    v-model="form.start_time"
                    type="time"
                    style="width:80%; padding:8px 10px; border:1px solid #d1d5db; border-radius:6px; font-size:14px;"
                />
            </div>

            <div style="flex: 1 1 120px; min-width: 100px;">
                <label style="display:block; font-weight:600; margin-bottom:6px;">End</label>
                <input
                    v-model="form.end_time"
                    type="time"
                    style="width:90%; margin-right: 10px; padding:8px 10px; border:1px solid #d1d5db; border-radius:6px; font-size:14px;"
                />
            </div>

            <div style="flex: 0 0 60px;">
                <button
                    :disabled="saving"
                    type="submit"
                    style="
                    margin-left: 10px;
                    width:100%;
                    padding:10px 6px;
                    border:0;
                    border-radius:6px;
                    background:#2563eb;
                    color:white;
                    font-weight:600;
                    cursor:pointer;
                    transition:background .2s;
      "
                    @mouseover="!saving && ($event.target.style.background='#1e40af')"
                    @mouseleave="!saving && ($event.target.style.background='#2563eb')"
                >
                    {{ saving ? 'Saving…' : 'Add' }}
                </button>
            </div>
        </form>


        <p v-if="errorMessage" style="color:#b91c1c; margin-top:10px;">{{ errorMessage }}</p>

        <div style="margin-top:32px;">
            <h3 style="margin:0 0 10px; font-size:18px; font-weight:600;">Existing Rules</h3>
            <table style="width:100%; border-collapse:collapse; font-size:14px;">
                <thead>
                <tr style="background:#f9fafb;">
                    <th style="text-align:left; border-bottom:1px solid #e5e7eb; padding:8px;">Day</th>
                    <th style="text-align:left; border-bottom:1px solid #e5e7eb; padding:8px;">Start</th>
                    <th style="text-align:left; border-bottom:1px solid #e5e7eb; padding:8px;">End</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="row in workingHours" :key="row.id" style="border-bottom:1px solid #f1f1f1;">
                    <td style="padding:8px;">{{
                            ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'][row.day_of_week]
                        }}
                    </td>
                    <td style="padding:8px;">{{ row.start_time }}</td>
                    <td style="padding:8px;">{{ row.end_time }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>
