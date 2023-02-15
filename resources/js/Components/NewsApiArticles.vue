<script setup>
import PrimaryButton from "./Inertia/PrimaryButton.vue";
import LikeButton from "./LikeButton.vue";

const props = defineProps({
    newsapi_api: Object,
    newscatcher_api: Object,
    newsdata_api: Object
})

const likeArticle = ({article_id, api_source}) => {
    axios.put('/api/news/like', { article_id, api_source })
        .then(function (response) {
            console.log(response)
            const article = props[api_source].filter(a =>  a.id === response.data.id)
            article[0].favs = response.data.favs
        })
        .catch(function (error) {
            console.log(error);
        })
}

const track = ({article_id, api_source}) => {
    console.log(props[api_source])
    axios.post('/api/news/articleViewed', { article_id, api_source })
        .then(function (response) {
            console.log(response)
            const article = props[api_source].filter(a =>  a.id === response.data.id)
            article[0].views = response.data.views
        })
        .catch(function (error) {
            console.log(error);
        })
}
</script>

<template>
    <div class="my-4 text-gray-500">{{props['newsapi_api'].length + props['newscatcher_api'].length + props['newsdata_api'].length}} articles</div>

    <section
        v-for="(source, api) in props"
        :key="api"
        class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-xl text-gray-700"
    >
        <article v-for="(article, i) in source" :key="i">
            <a
                :href="article.link || article.url"
                target="_blank"
                @click="track({article_id: article.id, api_source: api})"
            >
                <img
                    v-if="article.urlToImage || article.media"
                    :src="article.urlToImage || article.media"
                    :alt="article.title"
                    class="rounded mb-4 aspect-video m-auto"
                />
                <small class="font-bold text-gray-400">
                    {{
                        new Date(article.publishedAt).toLocaleDateString() ||
                        new Date(article.published_date).toLocaleDateString() ||
                        new Date(article.pubDate).toLocaleDateString()
                    }}
                </small>
                <p class="font-bold text-gray-600 mb-2 hover:text-red-700 line-clamp-2">{{article.title}}</p>
                <p class="text-sm text-gray-500 mt-2 hover:text-red-700 line-clamp-3">{{article.description || article.excerpt}}</p>
            </a>
            <div v-if="!article.notfound" class="my-8">
                <LikeButton
                    :article_id="article.id"
                    :api_source="api"
                    @liked="likeArticle"
                />
                <small v-if="article.favs > 0" class="text-gray-600 mt-2 ml-4">{{article.favs}} likes</small>
                <small v-if="article.views > 0" class="text-gray-600 mt-2 ml-4">{{article.views}} views</small>
            </div>
        </article>
        <small v-if="source.length">source: {{api}}</small>
    </section>
</template>
