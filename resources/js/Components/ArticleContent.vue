<script setup>
import PrimaryButton from "./Inertia/PrimaryButton.vue";

const props = defineProps({
    news: Object
})

const likeArticle = (id) => {
    axios.put('/api/news/like', { id })
        .then(function (response) {
            const id = response.data.id
            const article = props.news.filter(a =>  a.id === id)
            article[0].favs = response.data.favs
        })
        .catch(function (error) {
            console.log(error);
        }).finally(() => {
            clear()
    });
}

const track = (id) => {
    axios.post('/api/news/articleViewed', { id })
        .then(function (response) {
            console.log(response)
        })
        .catch()
}
</script>

<template>
    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-xl text-gray-700">
        <article v-for="(article, i) in news" :key="i" class="hover:scale-105">
            <a
                :href="article.url"
                target="_blank"
                @click="track(article.id)"
            >
                <p class="text-gray-500 my-2">{{article.source}}</p>
                <p class="text-sm text-gray-500 my-2">{{article.author || article.source }}</p>
                <img
                    class="rounded mb-4 aspect-video"
                    :src="article.urlToImage"
                    :alt="article.title"
                />
                <p class="font-bold text-gray-600 mb-2 line-clamp-2">{{article.title}}</p>

                <section v-if="!article.notfound">
                    <PrimaryButton @click.prevent="likeArticle(article.id)" class="mr-2">Like</PrimaryButton>
                    <small class="text-gray-600 mt-2 ml-4">Likes: {{article.favs}}</small>
                </section>
            </a>
        </article>
    </div>
    <footer class="text-gray-500 my-12">
        <small>
            source: <a href="https://www.newsapi.org" target="_blank">newsapi.org</a>
        </small>
    </footer>
</template>
