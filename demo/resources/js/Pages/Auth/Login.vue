<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white shadow p-6 rounded">
            <h2 class="text-2xl font-bold mb-4 text-center">Login</h2>

            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Email</label>
                    <input
                        v-model="form.email"
                        type="email"
                        class="w-full border p-2 rounded"
                    />
                    <div v-if="errors.email" class="text-red-500 text-sm mt-1">
                        {{ errors.email }}
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Password</label>
                    <input
                        v-model="form.password"
                        type="password"
                        class="w-full border p-2 rounded"
                    />
                    <div v-if="errors.password" class="text-red-500 text-sm mt-1">
                        {{ errors.password }}
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700"
                >
                    Login
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { reactive } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

const form = useForm({
    email: "",
    password: "",
});

const errors = form.errors;

function submit() {
    form.post("/login");
}
</script>
