<script setup>
import { track } from '@/Components/utils'

defineProps({
  article: Object,
  api_source: String
})
</script>
<template>
  <a
    :href="article.link || article.url"
    target="_blank"
    @click="track({article_id: article.id, api_source: api_source})"
  >
    <slot />
  </a>
</template>
