<script setup>
import NewsArticles from './NewsArticles.vue';
import WeatherWidget from '@/Components/WeatherWidget.vue';
import {ref, onMounted, computed} from "vue";
import SearchPrimitive from "./SearchPrimitive.vue";
import dummyResults from "./dummyResults";
import { Link } from '@inertiajs/vue3';
import TrendingHeadlines from "@/Components/TrendingHeadlines.vue";
import SearchResults from "./SearchResults.vue";

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    newsapi_api: Object,
    newscatcher_api: Object,
    newsdata_api: Object
})

let userSearchQuery = ref('')
let result = ref([])

onMounted(() => {
    // result.value = [...props.newsapi_api, ...props.newscatcher_api, ...props.newsdata_api]
})



const searchNews = async (searchQuery) => {
    userSearchQuery.value = searchQuery

    axios.post('/api/newsapi/search', { searchQuery: searchQuery })
        .then(res => {
            if(!res.data.length) {
                result.value = [...dummyResults]
            } else {
                result.value = [...res.data]
            }
        })
}

const newsIsAvailable = () => {
    return  props.newsapi_api?.length ||
            props.newscatcher_api?.length ||
            props.newsdata_api?.length
}

const breakingNewsTitle = computed(() => {
    return !userSearchQuery.value.length ? 'Breaking News' : `Search results for "${userSearchQuery.value}"`
})
</script>

<template>
    <section class="m-8">
        <WeatherWidget class="text-sm self-center"/>

        <div v-if="$page.props.canLogin" class="flex justify-between sm:block text-right">
            <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</Link>
            <template v-else>
                <Link :href="route('login')" class=" text-right text-sm text-gray-700 dark:text-gray-500 underline">Log in</Link>
                <Link v-if="true" :href="route('register')" class="ml-4  text-right text-sm text-gray-700 dark:text-gray-500 underline">Register</Link>
            </template>
            <div v-if="newsIsAvailable" class="flex justify-between text-gray-600">
                <p class="text-3xl text-red-700 self-center">{{ breakingNewsTitle }}</p>
                <SearchPrimitive class="my-4" @search="q => searchNews(q)" />
            </div>
        </div>
        <div v-else class="text-xl text-gray-500 mt-4">Loading news...</div>

        <SearchResults v-if="result?.length" :result="result"></SearchResults>

        <TrendingHeadlines
            :newsapi_api="newsapi_api"
            :newscatcher_api="newscatcher_api"
            :newsdata_api="newsdata_api"
        />

        <NewsArticles
            :newsapi_api="newsapi_api"
            :newscatcher_api="newscatcher_api"
            :newsdata_api="newsdata_api"
        />
    </section>
</template>
