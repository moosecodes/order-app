<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div>
                <ApplicationLogo class="block h-12 w-auto" />
            </div>

            <div class="mt-8 text-2xl">
                Welcome!
            </div>

            <div class="mt-6 text-gray-500">
                This full stack web application is built using Laravel 9, Jetstream, Inertia.js, Vue 3, and TailwindCSS.  Each page on this app explains how it works under the hood.  Feel free to look around and don't hesitate to reach out with questions!
            </div>
        </div>
    </div>
</template>
