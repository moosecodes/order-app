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

const query = ref('')
const result = ref([])

onMounted(() => {
    result.value = [...props.newsapi_api]
})

const newsStatus = computed(() => {
    return !query.value.length ? 'Breaking News' : `Search results for "${query.value}"`
})

const searchNews = (query) => {
    query.value = query;

    axios.post('/api/news/search', { query: query.value })
        .then(res => {
            if(!res.data.length) {
                console.log(res.data)
                result.value = dummyResults
            } else {
                result.value = res.data
            }
        })
}
</script>

<template>
    <section class="m-8">
        <div
            v-if="props.newsapi_api?.length || props.newscatcher_api?.length || props.newsdata_api?.length"
            class="flex justify-between text-gray-600"
        >
            <p class="text-3xl text-red-700 self-center">{{ newsStatus }}</p>

            <SearchPrimitive class="my-4"
                @search="(query) => searchNews(query)"
            />
        </div>
        <div v-else class="text-xl text-gray-500 mt-4">Loading news...</div>

        <WeatherWidget class="text-sm self-center"/>

        <NewsApiArticles
            :newsapi_api="result"
            :newscatcher_api="newscatcher_api"
            :newsdata_api="newsdata_api"
        />
    </section>
</template>
