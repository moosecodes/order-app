<script setup>
import ArticleContent from './ArticleContent.vue';
import WeatherWidget from '@/Components/WeatherWidget.vue';
import {ref, onMounted} from "vue";
import dummyResults from './dummyResults.js'
import SearchPrimitive from "./SearchPrimitive.vue";
import NewsCatcherArticles from "../Components/NewsCatcherArticles.vue";
import NewsDataArticles from "../Components/NewsDataArticles.vue";

const props = defineProps({
    news: Object,
    newscatcher_api: Object,
    newsdata_api: Object
})

const searchQuery = ref('')
const searchResult = ref([])

onMounted(() => {
    searchResult.value = [...props.news]
})

const searchNews = (query) => {
    axios.post('/api/news/search', { searchQuery: query })
        .then(res => {
            console.log(res)

            if(!res.data.length) {
                console.log(res.data)
                searchResult.value = dummyResults
            } else {
                console.log('got results')
                searchResult.value = [...res.data, ...searchResult.value]
            }

            searchQuery.value = ''
        })
}

</script>

<template>
    <section class="m-8">
        <WeatherWidget />

        <div v-if="news?.length" class="text-xl text-gray-600 mt-4 mb-8">
            <p class="text-3xl">Breaking News</p>
        </div>
        <div v-else class="text-xl text-gray-500 mt-4">Loading news...</div>

        <div class="flex flex-col justify-end font-semibold text-xl text-gray-600">
            <SearchPrimitive
                @search="(searchEvent) => searchNews(searchEvent)"
            />
        </div>

        <div class="my-4">{{searchResult.length}} articles</div>

        <ArticleContent :news="searchResult" />
        <NewsCatcherArticles :newscatcher_api="newscatcher_api" />
        <NewsDataArticles :newsdata_api="newsdata_api" />
    </section>
</template>
