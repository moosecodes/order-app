<script setup>
import ApplicationLogo from '@/Components/Inertia/ApplicationLogo.vue';

defineProps({
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
        <div class="mt-8 text-2xl">
            Dashboard
        </div>

        <div class="mt-8 text-2xl">
            Top stories here based on likes.
        </div>

        <ApplicationLogo
            :laravelVersion="laravelVersion"
            :phpVersion="phpVersion"
        />
    </div>
</template>
