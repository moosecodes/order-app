<script setup>
import PrimaryButton from "./Inertia/PrimaryButton.vue";

const props = defineProps({
    news: Object
})

const likeArticle = (id) => {
    axios.put('/api/news/like', {
        id
    })
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
    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-xl text-gray-700 mb-8">
        <div v-for="(article, i) in news" :key="i" class="hover:scale-105">
            <a
                :href="article.url"
                target="_blank"
            >
                <p class="text-gray-500">{{article.source}}</p>
                <p class="text-sm text-gray-500 mb-4">{{article.author}}</p>
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
