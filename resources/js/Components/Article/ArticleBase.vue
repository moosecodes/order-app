<script setup>
import ArticleLink from '@/Components/Article/ArticleLink.vue'
import ArticleImage from '@/Components/Article/ArticleImage.vue'
import ArticlePubDate from '@/Components/Article/ArticlePubDate.vue'
import LikesAndViews from '@/Components/Article/LikesAndViews.vue'
import ArticleTitleAndDescription from '@/Components/Article/ArticleTitleAndDescription.vue'
import {likeArticle} from '@/Components/utils'

const props = defineProps({
  article: Object,
  source: String
})

function handleLike(likeDetails) {
  likeArticle(likeDetails)
}
</script>

<template>
  <div>
    <ArticleLink :article="props.article">
      <ArticleImage :article="props.article" />
      <ArticlePubDate :article="props.article" />
      <ArticleTitleAndDescription :article="props.article" />
    </ArticleLink>
    <LikesAndViews
      :article="props.article"
      :source="props.source"
      @liked="handleLike"
    />
  </div>
</template>
