<script setup>
import ArticleLink from '@/Components/Article/ArticleLink.vue'
import ArticleImage from '@/Components/Article/ArticleImage.vue'
import LikesAndViews from '@/Components/Article/LikesAndViews.vue'
import ArticleTitleAndDescription from '@/Components/Article/ArticleMetaData.vue'
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
  <section>
    <ArticleLink :article="currentArticle">
      <ArticleImage :article="currentArticle" />
      <ArticleTitleAndDescription :article="currentArticle" />
    </ArticleLink>
    <LikesAndViews
      :article="currentArticle"
      :source="source"
      @liked="handleLike"
    />
  </section>
</template>
