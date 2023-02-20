<script setup>
const props = defineProps({
  article: Object
})
</script>

<template>
  <p class="font-bold text-indigo-900 mb-2 hover:text-red-700 line-clamp-2">
    {{ props.article.title }}
  </p>
  <p class="text-sm text-gray-500 mt-2 hover:text-red-700 line-clamp-3">
    {{ props.article.description || props.article.excerpt }}
  </p>
</template>
