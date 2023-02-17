<script setup>
import LikeButton from './LikeButton.vue'
import {likeArticle, track} from './utils'
import {computed} from "vue";
import { useNewsStore } from '../stores/news'
const newsStore = useNewsStore()

const props = defineProps({
    searchResults: Object
})
const news = computed(() => newsStore.searchResults)
</script>

<template>
    <div class="max-sm:hidden">
        <div v-if="newsStore.searchResults.length" class="text-gray-600 self-center my-4">
            <span class="text-2xl self-center my-4">Search Results</span>
            ({{ newsStore.searchResults.length }} sources)
        </div>
        <div v-else>No search results</div>

        <section v-for="source in newsStore.searchResults">
            <hr class="my-4">
            <small>{{source.length}} results from {{source[0].api_source}}</small>
            <hr class="my-4">

            <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-4 text-xl text-gray-700">
                <article v-for="(article, i) in source" :key="i">{{source.id}}
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
            </div>
        </section>
    </div>
</template>
