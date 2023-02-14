<script setup>
import NewsApiArticles from './NewsApiArticles.vue';
import WeatherWidget from '@/Components/WeatherWidget.vue';
import {ref, onMounted, computed} from "vue";
import dummyResults from './dummyResults.js'
import SearchPrimitive from "./SearchPrimitive.vue";

const props = defineProps({
    newsapi_api: Object,
    newscatcher_api: Object,
    newsdata_api: Object
})

const searchQuery = ref('')
const searchResult = ref([])

onMounted(() => {
    searchResult.value = [...props.newsapi_api]
})

const newsStatus = computed(() => {
    return !searchQuery.value.length ? 'Breaking News' : `Search results for "${searchQuery.value}"`
})

const searchNews = (query) => {
    searchQuery.value = query;

    axios.post('/api/news/search', { searchQuery: searchQuery.value })
        .then(res => {
            if(!res.data.length) {
                console.log(res.data)
                searchResult.value = dummyResults
            } else {
                searchResult.value = res.data
            }
        })
}

</script>

<template>
    <section class="m-8">
        <div
            v-if="props.newsapi_api?.length || props.newscatcher_api?.length || props.newsdata_api?.length"
            class="flex justify-between text-xl text-gray-600 mb-12"
        >
            <p class="max-sm:text-sm text-3xl text-red-700 self-center">{{ newsStatus }}</p>
            <SearchPrimitive class="font-semibold text-xl text-gray-600 items-center"
                @search="(searchEvent) => searchNews(searchEvent)"
            />
        </div>
        <div v-else class="text-xl text-gray-500 mt-4">Loading news...</div>

        <WeatherWidget />

        <NewsApiArticles
            :newsapi_api="searchResult"
            :newscatcher_api="newscatcher_api"
            :newsdata_api="newsdata_api"
        />
    </section>
</template>
