<script setup>
import {useNewsStore} from '@/stores/news'
import ArticleBase from '@/Components/Article/ArticleBase.vue'
const newsStore = useNewsStore()
</script>

<template>
  <article
    v-for="(articles, source) in newsStore.newest"
    :key="source"
    class="grid md:grid-cols-4 sm:grid-cols-1 my-4 gap-4"
  >
    <ArticleBase
      v-for="(article, j) in articles"
      :key="j"
      :article="article"
      :source="source"
    />
  </article>
</template>
