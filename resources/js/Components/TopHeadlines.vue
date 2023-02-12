<script setup>
import { Head } from '@inertiajs/vue3';
import ArticleContent from './ArticleContent.vue';
import WeatherWidget from '@/Components/WeatherWidget.vue';
import PrimaryButton from "./Inertia/PrimaryButton.vue";
import TextInput from "./Inertia/TextInput.vue";
import {ref, onMounted} from "vue";
import dummyResults from './dummyResults.js'
import SearchPrimitive from "./SearchPrimitive.vue";

const props = defineProps({
    news: Object
})

const searchQuery = ref('')
const searchResult = ref([])

onMounted(() => {
    searchResult.value = [...props.news]
})

const searchNews = (query) => {
    axios.post('/api/news/search', { searchQuery: query }).then(res => {
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
    <Head title="Top Headlines" />

    <section class="m-8">
        <WeatherWidget />


        <header v-if="news?.length" class="text-xl text-gray-600 mt-4 mb-8">
            <p class="text-3xl">Breaking News</p>
        </header>
        <header v-else class="text-xl text-gray-500 mt-4">Loading news...</header>

        <div class="flex justify-end font-semibold text-xl text-gray-600 leading-tight mb-8">
            <SearchPrimitive @search="(searchEvent) => searchNews(searchEvent)" />
            <!--        <PrimaryButton class="ml-2" @click="clear()" :disabled="!searchQuery.length">Clear</PrimaryButton>-->
        </div>

        <ArticleContent :news="searchResult" />

    </section>
</template>
