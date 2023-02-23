<script setup>
const props = defineProps({
  article: Object,
})
</script>

<template>
  <div>
    <p class="my-2 font-bold text-red-600 line-clamp-2 hover:text-red-700">
      <span>
        {{ props.article.source }}
      </span>
      <span class="text-xs font-semibold text-gray-300 hover:text-red-700 ml-4">
        {{
          new Date(props.article.publishedAt).toLocaleDateString() ||
            new Date(props.article.published_date).toLocaleDateString() ||
            new Date(props.article.pubDate).toLocaleDateString()
        }}
      </span>
    </p>
    <p
      class="my-2 text-xl font-bold text-indigo-900 line-clamp-2 hover:text-red-700"
    >
      {{ props.article.title }}
    </p>
    <p class="mt-2 text-sm text-gray-700 line-clamp-3 hover:text-red-700">
      {{ props.article.description || props.article.excerpt }}
    </p>
  </div>
</template>
