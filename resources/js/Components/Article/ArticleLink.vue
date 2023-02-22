<script setup>
defineEmits([
  'viewed'
])
defineProps({
  article: Object,
  source: String
})
</script>
<template>
  <a
    :href="article.link || article.url"
    target="_blank"
    @click="$emit('viewed', {article_id: article.id, source})"
  >
    <slot />
  </a>
</template>
