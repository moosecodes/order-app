<script setup>
const props = defineProps({
  article: Object
})
</script>

<template>
  <img
    v-if="props.article.urlToImage || props.article.media || 'https://picsum.photos/375/210'"
    :src="props.article.urlToImage || props.article.media || 'https://picsum.photos/375/210'"
    :alt="props.article.title"
    class="rounded mb-4 aspect-video m-auto bg-black"
  >
</template>
