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

const newsStore = useNewsStore()
// let { searchResults, newest, trending } = storeToRefs(newsStore)

let userInput = ref('')

const searchNews = (searchQuery) => {
    userInput.value = searchQuery
    axios.post('/api/search', { searchQuery })
        .then(res => {
            if(res.data.length) {
                newsStore.searchResults = [...res.data]
            } else {
                newsStore.searchResults = [...dummyResults]
            }
        })
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
        />

        <TrendingHeadlines :trending="$page.props.trending" />

        <NewsArticles :articles="$page.props.articles" />
    </section>
</template>
