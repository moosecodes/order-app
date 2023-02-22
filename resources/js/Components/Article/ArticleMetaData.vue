<script setup>
const props = defineProps({
  article: Object
})
</script>

<template>
  <div>
    <p class="font-semibold text-sm text-gray-300">
      {{
        new Date(props.article.publishedAt).toLocaleDateString() ||
          new Date(props.article.published_date).toLocaleDateString() ||
          new Date(props.article.pubDate).toLocaleDateString()
      }}
    </p>
    <p class="font-bold text-gray-500 my-2 hover:text-red-700 line-clamp-2">
      {{ props.article.source }}
    </p>
    <p class="font-bold text-indigo-900 my-2 hover:text-red-700 line-clamp-2">
      {{ props.article.title }}
    </p>
    <p class="text-sm text-gray-500 mt-2 hover:text-red-700 line-clamp-3">
      {{ props.article.description || props.article.excerpt }}
    </p>
  </div>
</template>
