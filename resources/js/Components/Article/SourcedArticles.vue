<script setup>
import ArticleSource from '@/Components/Article/ArticleSource.vue'
import { useNewsStore } from '@/stores/news'
const newsStore = useNewsStore()
const props = defineProps({
  sourceType: String,
  storeKey: String,
})
</script>

<template>
  <section>
    <hr class="my-12">
    <div
      class="font-medium my-4"
    >
      {{ `${props.sourceType} articles`.toUpperCase() }}
    </div>

    <div
      v-if="newsStore[props.sourceType]"
      class="my-4 grid grid gap-4 sm:grid-cols-1 md:grid-cols-4"
    >
      <ArticleSource
        v-for="(source, i) in newsStore[props.sourceType]"
        :key="i"
        :source="source"
        :store-key="storeKey"
        class="grid sm:grid-cols-1 md:grid-cols-4"
      />
    </div>
    <div v-else>
      There are no {{ props.sourceType }} articles currently available,
      please check back soon.
    </div>
  </section>
</template>
