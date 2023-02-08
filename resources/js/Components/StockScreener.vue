<script setup>
defineProps({
    query: String,
    stocks: Object,
})
</script>

<template>
    <p>{{ query }}</p>
    <ul>
        <li v-for="(item, i) in stocks" :key="i">{{ i }}: {{ item }}</li>
    </ul>
</template>

