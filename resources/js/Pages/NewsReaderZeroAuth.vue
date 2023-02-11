<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PrimaryButton from "@/Components/Inertia/PrimaryButton.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    news: Object,
    query: String,
});

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

        <div v-if="canLogin" class="hidden sm:block">
            <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</Link>

            <template v-else>
                <Link :href="route('login')" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</Link>

                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</Link>
            </template>
        </div>

        <header v-if="news?.length" class="text-xl text-gray-600 mt-4 mb-8">
            <p v-if="query" class="text-3xl">Search results for "{{query}}"</p>
            <p v-else class="text-3xl">Breaking News</p>
        </header>

        <header v-else class="text-xl text-gray-500 mt-4">Loading news...</header>

        <section class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-xl text-gray-700 mb-8">
            <div v-for="(article, i) in news" class="hover:scale-105">
                <a
                    :href="article.url"
                    target="_blank"
                    @click="read(article.id)"
                >
                    <p class="text-gray-500">{{article.source}}</p>
                    <p class="text-sm text-gray-500 mb-4">{{article.author}}</p>
                    <img
                        class="rounded mb-4 aspect-video"
                        :src="article.urlToImage"
                        :alt="article.title"
                    />
                    <p class="font-bold text-gray-600 mb-2 line-clamp-2">{{article.title}}</p>
                    <PrimaryButton @click.prevent="like(article.id)" class="mr-2">Like</PrimaryButton>
                    <span class="text-gray-600 mt-2 ml-4">Likes: {{article.favs}}</span>
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
