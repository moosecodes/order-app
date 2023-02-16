<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    vars: Object,
})
</script>

<template>
    <div v-if="vars.canLogin" class="flex justify-between sm:block text-right my-4">
        <Link v-if="vars.user" :href="route('dashboard')" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</Link>
        <template v-else>
            <Link :href="route('login')" class=" text-right text-sm text-gray-700 dark:text-gray-500 underline">
                Log in
            </Link>
            <Link v-if="vars.canRegister" :href="route('register')" class="ml-4 text-right text-sm text-gray-700 dark:text-gray-500 underline">
                Register
            </Link>
        </template>
    </div>
</template>
