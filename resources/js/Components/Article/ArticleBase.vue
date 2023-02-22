<script setup>
import ArticleLink from '@/Components/Article/ArticleLink.vue'
import ArticleImage from '@/Components/Article/ArticleImage.vue'
import LikesAndViews from '@/Components/Article/LikesAndViews.vue'
import ArticleTitleAndDescription from '@/Components/Article/ArticleMetaData.vue'
import {likeArticle, saveArticle, track} from '@/Components/utils'
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

async function handleSave(saveDetails) {
  const savedResponse = await saveArticle(saveDetails)
  currentArticle.value.saves = savedResponse.saves
}

async function handleView(viewDetails) {
  const viewedResponse = await track(viewDetails)
  currentArticle.value.views = viewedResponse.views
}
</script>

<template>
  <section>
    <ArticleLink
      :article="currentArticle"
      :source="source"
      @viewed="handleView"
    >
      <ArticleImage :article="currentArticle" />
      <ArticleTitleAndDescription :article="currentArticle" />
    </ArticleLink>
    <LikesAndViews
      :article="currentArticle"
      :source="source"
      @liked="handleLike"
      @saved="handleSave"
    />
  </section>
</template>
