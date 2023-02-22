<script setup>
import ArticleWrapper from '@/Components/Article/ArticleWrapper.vue'
import { useNewsStore } from '@/stores/news'
const newsStore = useNewsStore()

</script>

<template>
  <div class="font-bold text-indigo-900 items-center my-4">
    <span>Newest Articles</span>
    <small> ({{ Object.keys(newsStore.newest).length }} sources)</small>
    <ArticleWrapper />
  </div>
</template>
