<script setup>
defineProps({
  article: Object,
});
</script>

<template>
  <img
    v-if="
      article.urlToImage || article.media || 'https://picsum.photos/700/500'
    "
    :src="
      article.urlToImage || article.media || 'https://picsum.photos/700/500'
    "
    :alt="article.title"
    class="m-auto mb-4 aspect-video rounded bg-black"
  />
</template>
