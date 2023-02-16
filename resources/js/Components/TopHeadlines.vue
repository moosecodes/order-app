<script setup>
import {ref} from "vue"
import LoginLinks from "./LoginLinks.vue"
import NewsArticles from './NewsArticles.vue'
import WeatherWidget from '@/Components/WeatherWidget.vue'
import TrendingHeadlines from "@/Components/TrendingHeadlines.vue"
import SearchPrimitive from "./SearchPrimitive.vue";

const props = defineProps({
    newsapi_api: Object,
    newscatcher_api: Object,
    newsdata_api: Object
})

const result = ref([])

const newsIsAvailable = () => {
    return  props.newsapi_api?.length || props.newscatcher_api?.length || props.newsdata_api?.length
}
</script>

<template>
    <section class="m-8">
        <WeatherWidget class="text-sm self-center"/>

        <LoginLinks
            v-if="$page.props.canLogin"
            :vars="$page.props"
        />

        <SearchPrimitive
            :newsIsAvailable="newsIsAvailable"
            @noResults="(e) => console.log('noResult', e)"
            @results="(e) => console.log('results', e)"
        />

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
