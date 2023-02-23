<script setup>
import {onMounted, ref} from 'vue'
import {track} from '@/Components/utils'

defineEmits(['viewed'])
const props = defineProps({
  article: Object,
  source: String,
})
const currentArticle = ref([])

onMounted(() => {
  currentArticle.value = props.article
})
async function handleView(viewDetails) {
  const viewedResponse = await track(viewDetails)
  // const currentArticle = props.source.filter(a => a.id === viewedResponse.id)
  currentArticle.value.views = viewedResponse.views
  console.log(currentArticle.value.views)
  // currentSource.value[currentArticle.value.id].views = viewedResponse.views
}

onMounted(() => {
  currentArticle.value = props.article
})
</script>
<template>
  <a
    :href="article.link || article.url"
    target="_blank"
    @click="handleView({ article_id: article.id, source })"
  >
    <slot />
  </a>
</template>
