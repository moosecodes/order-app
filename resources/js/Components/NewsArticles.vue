<script setup>
import LikeButton from "./LikeButton.vue"
import SaveButton from "./SaveButton.vue";
import { likeArticle, saveArticle, track } from './utils.js'

const props = defineProps({
    newsapi_api: Object,
    newscatcher_api: Object,
    newsdata_api: Object
})

</script>

<template>
    <div class="font-bold text-indigo-900 items-center my-4">
        <span>Newest Articles</span>
        <small>
            ({{
                props.newsapi_api.length +
                props.newscatcher_api.length +
                props.newsdata_api.length
            }} articles)
        </small>
    </div>

    <section
        v-for="(source, api) in props"
        :key="api"
        class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-lg"
    >
        <article v-for="(article, i) in source" :key="i">
            <a
                :href="article.link || article.url"
                target="_blank"
                @click="track({article_id: article.id, api_source: api, props})"
            >
                <img
                    v-if="article.urlToImage || article.media"
                    :src="article.urlToImage || article.media"
                    :alt="article.title"
                    class="rounded mb-4 aspect-video m-auto"
                />
                <p class="font-semibold text-sm text-gray-300">
                    {{
                        new Date(article.publishedAt).toLocaleDateString() ||
                        new Date(article.published_date).toLocaleDateString() ||
                        new Date(article.pubDate).toLocaleDateString()
                    }}
                </p>
                <p class="font-bold text-indigo-900 mb-2 hover:text-red-700 line-clamp-2">{{article.title}}</p>
                <p class="text-sm text-gray-500 mt-2 hover:text-red-700 line-clamp-3">{{article.description || article.excerpt}}</p>
            </a>
            <div v-if="!article.notfound" class="my-8">
                <LikeButton
                    :article_id="article.id"
                    :api_source="api"
                    :props="props"
                    @liked="likeArticle"
                />
                <SaveButton
                    :article_id="article.id"
                    :api_source="api"
                    :props="props"
                    @saved="saveArticle"
                />
                <small v-if="article.favs > 0" class="text-indigo-900 mt-2 ml-4">{{article.favs}} likes</small>
                <small v-if="article.views > 0" class="text-gray-600 mt-2 ml-4">{{article.views}} views</small>
            </div>
        </article>
        <small v-if="source.length">source: {{api}}</small>
    </section>
</template>
