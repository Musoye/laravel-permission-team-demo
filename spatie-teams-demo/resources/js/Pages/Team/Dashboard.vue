<template>

    <h1 class="text-2xl font-bold mb-4">Team: {{ team.name }}</h1>

    <div class="mb-4">
      <template v-if="permissions.includes('create-form')">
        <form @submit.prevent="submit">
          <div>
            <input v-model="form.title" placeholder="Form title" class="border p-2 rounded w-full" />
          </div>
          <div class="mt-2">
            <textarea v-model="form.payload" placeholder="Form payload (JSON or text)" class="border p-2 rounded w-full"></textarea>
          </div>
          <div class="mt-2">
            <button class="px-4 py-2 rounded bg-blue-600 text-white">Create Form</button>
          </div>
        </form>
      </template>

      <template v-else>
        <div class="text-sm text-gray-600">You don't have permission to create forms on this team.</div>
      </template>
    </div>

    <div>
      <h2 class="text-xl font-semibold mb-2">Team Forms</h2>
      <div v-if="forms.length">
        <ul>
          <li v-for="f in forms" :key="f.id" class="mb-2 border p-3 rounded">
            <div class="font-medium">{{ f.title }}</div>
            <div class="text-sm text-gray-600">By: {{ f.creator?.name ?? 'Unknown' }}</div>
            <pre class="mt-2">{{ f.payload }}</pre>
          </li>
        </ul>
      </div>
      <div v-else class="text-gray-600">No forms yet.</div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm, Head } from '@inertiajs/inertia-vue3'

const props = defineProps({
  team: Object,
  permissions: Array,
  forms: Array,
})

const form = useForm({
  title: '',
  payload: '',
})

function submit() {
  form.post(route('forms.store', props.team.id), {
    onSuccess: () => {
      form.reset('title', 'payload')
    }
  })
}
</script>

<style scoped>
/* small styles if you want */
</style>
