<script setup>
import PrimaryButton from "./Inertia/PrimaryButton.vue";

const props = defineProps({
    newscatcher_api: Object
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
        })
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
        <article v-for="(article, i) in newscatcher_api" :key="i">
            <a
                :href="article.link"
                target="_blank"
            >
                <p class="text-gray-500 my-2">{{article.twitter_account || article.authors}}</p>
                <p class="text-sm text-gray-500 my-2">{{ article.author }}</p>
                <img
                    class="rounded mb-4 aspect-video"
                    :src="article.media"
                    :alt="article.title"
                />
                <p class="font-bold text-gray-600 mb-2 line-clamp-2">{{article.title}}</p>
                <p class="text-sm text-gray-500 mb-2 line-clamp-3">{{article.excerpt}}</p>
            </a>
            <section v-if="!article.notfound" class="my-8">
                <PrimaryButton @click.stop="likeArticle(article.id)" class="mr-2">Like</PrimaryButton>
                <small v-if="article.favs > 0" class="text-gray-600 mt-2 ml-4">{{article.favs}} likes</small>
                <small v-if="article.views > 0" class="text-gray-600 mt-2 ml-4">{{article.views }} views</small>
            </section>
        </article>
    </div>
    <footer class="text-gray-500 my-12">
        <small>
            source: <a href="https://www.newsapi.org" target="_blank">newscatcher</a>
        </small>
    </footer>
</template>
