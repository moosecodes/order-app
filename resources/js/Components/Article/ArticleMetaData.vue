<script setup>
const props = defineProps({
  article: Object,
})
</script>

<template>
  <div>
    <p class="text-sm font-semibold text-gray-400 hover:text-red-700">
      {{
        new Date(props.article.publishedAt).toLocaleDateString() ||
          new Date(props.article.published_date).toLocaleDateString() ||
          new Date(props.article.pubDate).toLocaleDateString()
      }}
    </p>
    <p class="my-2 font-bold text-gray-400 line-clamp-2 hover:text-red-700">
      {{ props.article.source }}
    </p>
    <p
      class="my-2 text-xl font-bold text-indigo-900 line-clamp-2 hover:text-red-700"
    >
      {{ props.article.title }}
    </p>
    <p class="mt-2 text-sm text-indigo-900 line-clamp-3 hover:text-red-700">
      {{ props.article.description || props.article.excerpt }}
    </p>
  </div>
</template>
