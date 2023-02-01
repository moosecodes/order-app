<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    news: Object
});
</script>

<template>
    <Head title="Top Headlines" />
    <div class="m-8">
        <p>Welcome, {{$page.props.user.name}}</p>
        <p v-if="news.length" class="text-xl text-gray-500 mt-4 mb-8">Top News</p>
        <p v-else class="text-xl text-gray-500 mt-4">Loading articles...</p>

        <ul class="grid grid-cols-4 gap-4 text-xl text-gray-700">
            <li v-for="(article, i) in news" class="mb-8">
                <a :href="article.url" target="_blank">
                    <span class="mb-4">
                        <p class="text-gray-500">{{article.source}}</p>
                        <p class="text-gray-700 mb-4">{{article.title}}</p>
                        <img :src="article.urlToImage" :alt="article.title"/>
                    </span>
                </a>
            </li>
        </ul>

    </div>
</template>
