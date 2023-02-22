<script setup>
import {useNewsStore} from '@/stores/news'
import ArticleBase from '@/Components/Article/ArticleBase.vue'
const newsStore = useNewsStore()
</script>

<template>
  <article
    v-for="(articles, source) in newsStore.trending"
    :key="source"
    class="max-sm:hidden grid md:grid-cols-6 sm:grid-cols-1 gap-4"
  >
    <ArticleBase
      v-for="(article, j) in articles"
      :key="j"
      :article="article"
      :source="source"
    />
  </article>
</template>
