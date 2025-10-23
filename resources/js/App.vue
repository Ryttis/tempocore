<template>
    <main style="max-width:900px; margin:auto; padding:40px;">
        <header style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
            <h1 style="color:#2563eb;">Smart Booking Scheduler</h1>
            <nav style="display:flex; gap:16px;">
                <router-link to="/" style="text-decoration:none; color:#2563eb;">Client</router-link>
                <router-link to="/admin" style="text-decoration:none; color:#2563eb;">Admin</router-link>
            </nav>
        </header>

        <section style="background:#fff; padding:24px; border-radius:12px; box-shadow:0 2px 6px rgba(0,0,0,0.05);">
            <router-view />
        </section>
    </main>
</template>

<script setup>
</script>

<style>
body {
    font-family: system-ui, -apple-system, sans-serif;
    background: #f9fafb;
    margin: 0;
}
</style>
