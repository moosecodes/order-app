<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps({
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div class="mt-8 text-2xl">
                Welcome.
            </div>

            <ApplicationLogo
                :laravelVersion="laravelVersion"
                :phpVersion="phpVersion"
                class="block h-12 w-auto"
            />
        </div>
</template>
