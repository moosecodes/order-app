<script setup>
defineProps({
  article: Object
})
</script>

<template>
  <img
    v-if="article.urlToImage || article.media || 'https://picsum.photos/375/210'"
    :src="article.urlToImage || article.media || 'https://picsum.photos/375/210'"
    :alt="article.title"
    class="rounded mb-4 aspect-video m-auto bg-black"
  >
</template>
