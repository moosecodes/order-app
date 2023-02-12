<script setup>
import { Head } from '@inertiajs/vue3';
import ArticleContent from './ArticleContent.vue';
import WeatherWidget from '@/Components/WeatherWidget.vue';

defineProps({
    news: Object,
    query: String,
})
</script>

<template>
    <Head title="Top Headlines" />

    <section class="m-8">
        <header v-if="news?.length" class="text-xl text-gray-600 mt-4 mb-8">
            <p v-if="query" class="text-3xl">Search results for "{{query}}"</p>
            <p v-else class="text-3xl">Breaking News</p>
        </header>
        <header v-else class="text-xl text-gray-500 mt-4">Loading news...</header>

        <WeatherWidget />

        <ArticleContent :news="news" />

        <footer class="text-gray-500">
            <small>source:
                <a href="https://www.newsapi.org" target="_blank">newsapi.org</a>
            </small>
        </footer>
    </section>
</template>
