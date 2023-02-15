<script setup>
import MadeWithPanel from '@/Components/MadeWithPanel.vue';

defineProps({
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
        <MadeWithPanel
            :laravelVersion="laravelVersion"
            :phpVersion="phpVersion"
        />
    </div>
</template>
