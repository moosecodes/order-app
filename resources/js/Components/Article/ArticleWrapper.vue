<script setup>
import {useNewsStore} from '@/stores/news'
import ArticleBase from '@/Components/Article/ArticleBase.vue'
const newsStore = useNewsStore()
</script>

<template>
  <article
    v-for="(source, i) in newsStore.newest"
    :key="i"
    class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-lg my-4"
  >
    <ArticleBase
      v-for="(article, j) in source"
      :key="j"
      :article="article"
    />
  </article>
</template>
