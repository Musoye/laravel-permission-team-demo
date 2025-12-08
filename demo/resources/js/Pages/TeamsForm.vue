<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold">Forms for {{ team.name }}</h1>

    <button
      v-if="permissions.includes('create-form')"
      @click="showForm = !showForm"
      class="bg-blue-500 text-white px-3 py-2 rounded mt-4"
    >
      Create New Form
    </button>

    <div v-if="showForm" class="mt-4">
      <form @submit.prevent="submit">
        <input v-model="form.title" placeholder="Title" class="border p-2 w-full" />
        <textarea v-model="form.content" class="border p-2 w-full mt-2" placeholder="Content"></textarea>
        <button class="bg-green-500 text-white px-3 py-2 rounded mt-2">Save</button>
      </form>
    </div>

    <div class="mt-6">
      <div
        v-for="f in forms"
        :key="f.id"
        class="border p-4 mb-3 rounded"
      >
        <h2 class="font-semibold">{{ f.title }}</h2>
        <p class="text-sm">By: {{ f.author?.name }}</p>
        <p class="mt-2">{{ f.content }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  team: Object,
  forms: Array,
  permissions: Array
});

const showForm = ref(false);
const form = ref({ title: "", content: "" })

function submit() {
  Inertia.post(`/teams/${props.team.id}/forms`, form.value)
}
</script>
