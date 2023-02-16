<script setup>
import {onMounted, ref} from "vue"
import LikeButton from "./LikeButton.vue";
import { likeArticle, saveArticle, track } from "./utils";
import SaveButton from "./SaveButton.vue";

const trending = ref([])

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean
})

onMounted(() => {
    getTrendingHeadlines()
})
const getTrendingHeadlines = () => {
    axios.get('/api/newsapi/trending')
        .then(res => {
            trending.value = res.data
        })
        .catch(error => {
            console.log(error)
        })
}
</script>

<template>
    <div class="max-sm:hidden">
        <div v-if="trending.length" class="font-bold text-indigo-900 items-center my-4">
            <span>Trending Headlines</span>
            <small> ({{ trending.length }} trending)</small>
        </div>

        <section class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 text-xl text-gray-700">
            <article
                v-for="(article, i) in trending"
                :key="i"
            >
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
                    <p class="text-lg font-bold text-indigo-900 mb-2 hover:text-red-700 line-clamp-2">
                        {{article.title}}
                    </p>
                </a>
                <div
                    v-if="!article.notfound"
                    class="my-4"
                >
                    <LikeButton
                        :article_id="article.id"
                        :api_source="i.toString()"
                        :props="props"
                        @liked="likeArticle"
                    />
                    <SaveButton
                        :article_id="article.id"
                        :api_source="i.toString()"
                        :props="props"
                        @saved="saveArticle"
                    />
                    <small v-if="article.favs > 0" class="mt-2 ml-4">
                        {{article.favs}} likes
                    </small>
                    <small v-if="article.views > 0" class="ml-4">
                        {{article.views}} views
                    </small>
                </div>
            </article>
        </section>
    </div>
</template>
