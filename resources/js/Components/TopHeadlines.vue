<script setup>
import { Head } from '@inertiajs/vue3';
import PrimaryButton from "../Components/PrimaryButton.vue";

defineProps({
    'articles': Object,
    query: String,
})

const read = (id) => {
    axios.put('/api/news/read', {
        id: id
    })
        .then(function (response) {
            console.log(response);
        })
        .catch(function (error) {
            console.log(error);
        });
}
const like = (id) => {
    axios.put('/api/news/like', {
        id: id
    })
        .then(function (response) {
            console.log(response);
        })
        .catch(function (error) {
            console.log(error);
        });
}
</script>

<template>
    <Head title="Top Headlines" />

    <article class="m-8">

        <header v-if="articles.length" class="text-xl text-gray-500 mt-4 mb-8">
            <p v-if="query" class="text-3xl">Search results for "{{query}}"</p>
            <p v-else class="text-3xl">Breaking News</p>
        </header>
        <header v-else class="text-xl text-gray-500 mt-4">Loading articles...</header>

        <section class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-xl text-gray-700 mb-8">
            <div v-for="(article, i) in articles" class="hover:scale-105">
                <a
                    :href="article.url"
                    target="_blank"
                    @click="read(article.id)"
                >
                    <p class="text-gray-500">{{article.source}}</p>
                    <p class="text-sm text-gray-400 mb-4">{{article.author}}</p>
                    <img
                        class="rounded mb-4"
                        :src="article.urlToImage"
                        :alt="article.title"
                    />
                    <p class="font-bold text-gray-500 mb-2 line-clamp-2">{{article.title}}</p>
                    <PrimaryButton @click.prevent="like(article.id)" class="mr-2">Like</PrimaryButton>
                    <PrimaryButton @click.prevent="read(article.id)">Mark Read</PrimaryButton>
                    <p class="text-gray-400 mt-2">likes: {{article.favs}}</p>
                    <p class="text-gray-400 mt-2">read count: {{article.readCount}}</p>
                </a>
            </div>
        </section>
        <footer class="text-gray-500">
            <small>source:
                <a href="https://www.newsapi.org" target="_blank">newsapi.org</a>
            </small>
        </footer>
    </article>
</template>
