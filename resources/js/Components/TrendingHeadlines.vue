<script setup>
import LikeButton from "./LikeButton.vue";
import SaveButton from "./SaveButton.vue";
import { likeArticle, saveArticle, track } from "./utils";
import LikesAndViews from "./LikesAndViews.vue";

const props = defineProps({
    trending: Object
})
</script>

<template>
    <div class="max-sm:hidden">
        <div
            v-if="Object.keys($page.props.trending).length"
             class="font-bold text-indigo-900 items-center my-4"
        >
            <span>Trending Headlines</span>
            <small> ({{ Object.keys($page.props.trending).length }} trending)</small>
        </div>

        <section
            v-for="(source, source_key) in trending" :key="source_key"
            class=" gap-4 text-xl text-gray-700">
            <article
                v-for="(article, i) in source"
                :key="i"
                class="grid grid-cols-2"
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
                </a>

                <div class="text-lg font-bold text-indigo-900 ml-4 mb-2 hover:text-red-700 line-clamp-2">
                    <p class="hover:text-red-700 line-clamp-2">{{article.title}}</p>
                    <p class="text-sm text-gray-500 mt-2 hover:text-red-700">
                        {{article.description || article.excerpt}}
                    </p>
                    <div
                        v-if="!article.notfound && $page.props.user"
                        class="my-4"
                    >
                        <LikesAndViews
                            :article="article"
                            :api="source_key"
                            :props="props"
                            @liked="likeArticle"
                        />
                    </div>
                </div>
            </article>
        </section>
    </div>
</template>
