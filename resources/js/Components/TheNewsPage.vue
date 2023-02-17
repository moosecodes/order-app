<script setup>
import dummyResults from "./dummyResults";
import {ref, onMounted, computed} from "vue"
import { storeToRefs } from 'pinia'
import { useNewsStore } from '../stores/news'
import LoginLinks from "./LoginLinks.vue"
import NewsArticles from './NewsArticles.vue'
import WeatherWidget from '../Components/WeatherWidget.vue'
import TrendingHeadlines from "../Components/TrendingHeadlines.vue"
import SearchPrimitive from "./SearchPrimitive.vue";
import SearchResults from "./SearchResults.vue";

const newsStore = useNewsStore()
// let { searchResults, newest, trending } = storeToRefs(newsStore)

let userInput = ref('')

const searchNews = (searchQuery) => {
    userInput.value = searchQuery
    axios.post('/api/search', { searchQuery })
        .then(res => {
            if(Object.keys(res.data['newsapi']).length) {
                newsStore.searchResults = [...res.data['newsapi']]
            }
            if(Object.keys(res.data['newsdataapi']).length) {
                newsStore.searchResults = [...newsStore.searchResults, ...res.data['newsdataapi']]
            }
            else {
                // newsStore.searchResults = [...dummyResults]
            }
            console.log(newsStore.searchResults)
        })
}
const clear = () => {
    newsStore.searchResults = []
    userInput.value = ''
}
const heading = computed(() => {
    return !userInput.value.length ? 'Breaking News' : `Search results for "${userInput.value}"`
})
</script>

<template>
    <section class="m-8">
        <WeatherWidget class="text-sm self-center"/>

        <LoginLinks
            v-if="$page.props.canLogin"
            :props="$page.props"
        />

        <SearchPrimitive
            :heading="heading"
            :results="newsStore.searchResults"
            @search="q => searchNews(q)"
            @clear="clear()"
        />

        <SearchResults
            v-if="newsStore.searchResults?.length"
            :searchResults="newsStore.searchResults"
        />

        <TrendingHeadlines :trending="$page.props.trending" />

        <NewsArticles :articles="$page.props.articles" />
    </section>
</template>
