<script setup>
const props = defineProps({
  article: Object
})
</script>

<template>
  <p class="font-semibold text-sm text-gray-300">
    {{
      new Date(props.article.publishedAt).toLocaleDateString() ||
        new Date(props.article.published_date).toLocaleDateString() ||
        new Date(props.article.pubDate).toLocaleDateString()
    }}
  </p>
</template>
