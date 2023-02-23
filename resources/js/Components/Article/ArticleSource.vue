<script setup>
import ArticleLink from '@/Components/Article/ArticleLink.vue'
import ArticleImage from '@/Components/Article/ArticleImage.vue'
import LikesAndViews from '@/Components/Article/LikesAndViews.vue'
import ArticleMetaData from '@/Components/Article/ArticleMetaData.vue'
import {track} from '@/Components/utils'
import {onMounted, ref} from 'vue'

const props = defineProps({
  source: Object,
  storeKey: String,
})
const currentSource = ref([])

onMounted(() => {
  currentSource.value = props.source
})
</script>

<template>
  <article
    v-for="(moose, i) in currentSource"
    :key="i"
  >
    <div>
      <ArticleLink
        :article="moose"
        :source="storeKey"
      >
        <ArticleImage :article="moose" />
        <ArticleMetaData :article="moose" />
      </ArticleLink>

      <LikesAndViews
        :article="moose"
        :source="storeKey"
      />
    </div>
  </article>
</template>
