<script setup>
import LikeButton from "./LikeButton.vue"
import SaveButton from "./SaveButton.vue";
import { likeArticle, saveArticle, track } from './utils.js'
import LikesAndViews from "./LikesAndViews.vue";

const props = defineProps({
    articles: Object
})

</script>

<template>
    <div class="font-bold text-indigo-900 items-center my-4">
        <span>Newest Articles</span>
        <small> ({{ articles?.length }} articles)</small>
    </div>

    <section
        v-for="(source, api_source) in articles"
        :key="api_source"
        class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-lg"
    >
        <article v-for="(article, i) in source" :key="i" class="my-4">
            <a
                :href="article.link || article.url"
                target="_blank"
                @click="track({article_id: article.id, api_source: api_source, props})"
            >
                <img
                    v-if="article.urlToImage || article.media || 'https://picsum.photos/375/210'"
                    :src="article.urlToImage || article.media || 'https://picsum.photos/375/210'"
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
            <div v-if="!article.notfound && $page.props.user" class="my-8">
                <LikesAndViews
                    :article="article"
                    :api="api_source"
                    :props="props"
                />
            </div>
        </article>
    </section>
</template>
