<script setup>
import PrimaryButton from "./Inertia/PrimaryButton.vue";

const props = defineProps({
    newsapi_api: Object,
    newscatcher_api: Object,
    newsdata_api: Object
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
        .catch(function (error) {
            console.log(error);
        })
}
</script>

<template>
    <div class="my-4 text-gray-500">{{props['newsapi_api'].length + props['newscatcher_api'].length + props['newsdata_api'].length}} articles</div>

    <div
        v-for="(source, k) in props"
        :key="k"
        class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-xl text-gray-700"
    >
        <article v-for="(article, i) in source" :key="i">
            <a
                :href="article.link || article.url"
                target="_blank"
                @click="track(article.id)"
            >
                <img
                    v-if="article.urlToImage || article.media"
                    class="rounded mb-4 aspect-video m-auto"
                    :src="article.urlToImage || article.media"
                    :alt="article.title"
                />
                <p class="font-bold text-gray-600 mb-2 line-clamp-3 hover:text-red-700">{{article.title}}</p>
                <p class="text-sm text-gray-500 mt-2 line-clamp-3">{{article.description}}</p>
            </a>
            <section v-if="!article.notfound" class="my-8">
                <PrimaryButton v-if="k === 0" @click.stop="likeArticle(article.id)" class="mr-2">Like</PrimaryButton>
                <small v-if="article.favs > 0" class="text-gray-600 mt-2 ml-4">{{article.favs}} likes</small>
                <small v-if="article.views > 0" class="text-gray-600 mt-2 ml-4">{{article.views}} views</small>
            </section>
        </article>
    </div>
</template>
