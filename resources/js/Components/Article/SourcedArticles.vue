<script setup>
import ArticleSource from '@/Components/Article/ArticleSource.vue'
import { useNewsStore } from '@/stores/news'
const newsStore = useNewsStore()
const props = defineProps({
  sourceType: String,
  storeKey: String
})
</script>

<template>
  <section>
    <div class="font-medium">
      {{ `${props.sourceType} articles`.toUpperCase() }}
    </div>
    <div
      v-if="newsStore[props.sourceType]"
      class="grid md:grid-cols-4 sm:grid-cols-1 my-4 gap-4"
    >
      <ArticleSource
        v-for="(source, i) in newsStore[props.sourceType]"
        :key="i"
        :source="source"
        :store-key="storeKey"
        class="grid md:grid-cols-4 sm:grid-cols-1"
      />
    </div>
    <div v-else>
      There are no {{ props.sourceType }} articles currently available, please check back soon.
    </div>
  </section>
</template>
