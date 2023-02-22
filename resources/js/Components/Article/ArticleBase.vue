<script setup>
import ArticleLink from '@/Components/Article/ArticleLink.vue'
import ArticleImage from '@/Components/Article/ArticleImage.vue'
import ArticlePubDate from '@/Components/Article/ArticlePubDate.vue'
import LikesAndViews from '@/Components/Article/LikesAndViews.vue'
import ArticleTitleAndDescription from '@/Components/Article/ArticleTitleAndDescription.vue'
import {likeArticle} from '@/Components/utils'
import {onMounted, ref} from 'vue'

const props = defineProps({
  article: Object,
  source: String
})

const currentArticle = ref([])

onMounted(()=>{
  currentArticle.value = props.article
})

async function handleLike(likeDetails) {
  const likedResponse = await likeArticle(likeDetails)
  currentArticle.value.favs = likedResponse.favs
}
</script>

<template>
  <div>
    <ArticleLink :article="currentArticle">
      <ArticleImage :article="currentArticle" />
      <ArticlePubDate :article="currentArticle" />
      <ArticleTitleAndDescription :article="currentArticle" />
    </ArticleLink>
    <LikesAndViews
      :article="currentArticle"
      :source="source"
      @liked="handleLike"
    />
  </div>
</template>
