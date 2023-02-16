<script setup>
import LikeButton from './LikeButton.vue'
import {likeArticle} from './utils'

const props = defineProps({
    result: Object
})
</script>

<template>
    <div class="max-sm:hidden">
        <div v-if="result.length" class="text-gray-600 self-center my-4">
            <span class="text-2xl self-center my-4">Search Results</span>
            ({{ result.length }} articles)
        </div>

        <section class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 text-xl text-gray-700">
            <article v-for="(article, i) in result" :key="i">
                <a
                    :href="article.link || article.url"
                    target="_blank"
                    @click="track({article_id: article.id, api_source: i, props})"
                >
                    <img
                        v-if="article.urlToImage || article.media"
                        :src="article.urlToImage || article.media"
                        :alt="article.title"
                        class="rounded mb-4 aspect-video m-auto"
                    />
                    <p class="text-sm font-bold text-gray-600 mb-2 hover:text-red-700 line-clamp-3">{{article.title}}</p>
                    <!--                <p class="text-sm text-gray-500 mt-2 hover:text-red-700 line-clamp-3">{{article.description || article.excerpt}}</p>-->
                </a>
                <div v-if="!article.notfound" class="my-4">
                    <LikeButton
                        :article_id="article.id"
                        :api_source="i.toString()"
                        :props="props"
                        @liked="likeArticle"
                        class=""
                    />
                    <small v-if="article.favs > 0" class="text-gray-600 mt-2 ml-4">{{article.favs}} likes</small>
                    <small v-if="article.views > 0" class="text-gray-600 mt-2 ml-4">{{article.views}} views</small>
                </div>
            </article>
        </section>
    </div>
</template>
