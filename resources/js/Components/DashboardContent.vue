<script setup>
import MadeWithPanel from "@/Components/MadeWithPanel.vue";

defineProps({
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <div class="border-b border-gray-200 bg-white p-6 sm:px-20">
        <MadeWithPanel
            :laravel-version="laravelVersion"
            :php-version="phpVersion"
        />
    </div>
</template>
