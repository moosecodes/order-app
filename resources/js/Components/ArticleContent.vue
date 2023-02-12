<script setup>
import PrimaryButton from "./Inertia/PrimaryButton.vue";
import TextInput from "./Inertia/TextInput.vue";
import {ref, onMounted} from "vue";

const props = defineProps({
    news: Object
})

onMounted(() => {
    searchResult.value = [...props.news]
})
const searchQuery = ref('')
const searchResult = ref([])
const searchNews = (searchQuery) => {
    axios.post('/api/news/search', { searchQuery }).then(res => {
        searchResult.value = [...res.data]
    })
}

const likeArticle = (id) => {
    axios.put('/api/news/like', { id })
        .then(function (response) {
            const id = response.data.id
            const article = props.news.filter(a =>  a.id === id)
            article[0].favs = response.data.favs
        })
        .catch(function (error) {
            console.log(error);
        });
}
</script>

<template>
    <div class="flex justify-end font-semibold text-xl text-gray-600 leading-tight mb-8">
        <TextInput type="text" @keydown.enter="searchNews(searchQuery)" v-model="searchQuery" />
        <PrimaryButton class="ml-2" @click="searchNews(searchQuery)">Search</PrimaryButton>
    </div>
    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-xl text-gray-700 mb-8">
        <div v-for="(article, i) in searchResult" :key="i" class="hover:scale-105">
            <a
                :href="article.url"
                target="_blank"
            >
                <p class="text-gray-500">{{article.source}}</p>
                <p class="text-sm text-gray-500 mb-4">{{article.author || article.source }}</p>
                <img
                    class="rounded mb-4 aspect-video"
                    :src="article.urlToImage"
                    :alt="article.title"
                />
                <p class="font-bold text-gray-600 mb-2 line-clamp-2">{{article.title}}</p>

                <PrimaryButton @click.prevent="likeArticle(article.id)" class="mr-2">Like</PrimaryButton>

                <span class="text-gray-600 mt-2 ml-4">Likes: {{article.favs}}</span>
            </a>
        </div>
    </div>
</template>
