<script setup>
import ArticleBase from '@/Components/Article/ArticleBase.vue'
import {useNewsStore} from '@/stores/news'
const newsStore = useNewsStore()
</script>

<template>
  <article
    v-for="(articles, source) in newsStore.trending"
    :key="source"
    class="max-sm:hidden grid grid-cols-2"
  >
    <ArticleBase
      v-for="(article, j) in articles"
      :key="j"
      :article="article"
      :source="source"
      class="mx-4"
    />
  </article>
</template>
