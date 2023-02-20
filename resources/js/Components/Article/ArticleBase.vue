<script setup>
import ArticleLink from '@/Components/Article/ArticleLink.vue'
import ArticleImage from '@/Components/Article/ArticleImage.vue'
import ArticlePubDate from '@/Components/Article/ArticlePubDate.vue'
import LikesAndViews from '@/Components/Article/LikesAndViews.vue'
import ArticleTitleAndDescription from '@/Components/Article/ArticleTitleAndDescription.vue'
import {likeArticle} from '@/Components/utils'

defineProps({
  article: Object
})
</script>

<template>
  <div>
    <ArticleLink :article="article">
      <ArticleImage :article="article" />
      <ArticlePubDate :article="article" />
      <ArticleTitleAndDescription :article="article" />
    </ArticleLink>
    <LikesAndViews
      :article="article"
      :api_source="article"
      @liked="likeArticle"
    />
  </div>
</template>
