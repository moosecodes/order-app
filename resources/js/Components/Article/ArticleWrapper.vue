<script setup>
import {useNewsStore} from '@/stores/news'
import ArticleBase from '@/Components/Article/ArticleBase.vue'
const newsStore = useNewsStore()
</script>

<template>
  <article
    v-for="(articles, source) in newsStore.newest"
    :key="source"
    class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-lg my-4"
  >
    <ArticleBase
      v-for="(article, j) in articles"
      :key="j"
      :article="article"
      :source="source"
    />
  </article>
</template>
