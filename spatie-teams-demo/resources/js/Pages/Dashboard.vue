<template>
  <Layout>
    <h2>Welcome</h2>
    <div class="mt-4">
        <p><a :href="`/teams/${teamId}/dashboard`">Go to Demo Team</a></p>
      <inertia-link :href="route('team.dashboard', teamId)">Go to Demo Team</inertia-link>
    </div>
  </Layout>
</template>

<script setup>
const teamId = 1; // demo seeded team id (Alpha Team) — adjust if different
</script>
