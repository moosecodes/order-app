<script setup>
import { ref, computed, onMounted } from 'vue'
import { useNewsStore } from '@/stores/news'
import LoginLinks from './LoginLinks.vue'
import SourcedArticles from './Article/SourcedArticles.vue'
import WeatherWidget from '@/Components/Weather/WeatherWidget.vue'
import SearchPrimitive from './Search/SearchPrimitive.vue'
import SearchResults from './Search/SearchResults.vue'

const newsStore = useNewsStore()
// let { searchResults, newest, trending } = storeToRefs(newsStore)

let userInput = ref('')

const props = defineProps({
  sources: Object,
  trending: Object,
})

onMounted(() => {
  newsStore.newest = props.sources
  newsStore.trending = props.trending
})

const searchNews = async (searchQuery) => {
  userInput.value = searchQuery
  let response = await axios.post('/api/search', { searchQuery })
  if (Object.keys(response.data['newsapi']).length) {
    newsStore.searchResults = [...response.data['newsapi']]
  }
  if (Object.keys(response.data['newsdataapi']).length) {
    newsStore.searchResults = [
      ...newsStore.searchResults,
      ...response.data['newsdataapi'],
    ]
  }
}
const clear = () => {
  newsStore.searchResults = []
  userInput.value = ''
}
const heading = computed(() => {
  return !userInput.value.length
    ? 'Breaking News'
    : `Search results for "${userInput.value}"`
})
</script>

<template>
  <section class="m-8">
    <LoginLinks
      v-if="$page.props.canLogin"
      :user="$page.props.user"
      :can-login="$page.props.canLogin"
      :can-register="$page.props.canRegister"
    />

    <div class="text-3xl text-red-800 font-bold">
      {{ heading }}
      <SearchPrimitive
        :results="newsStore.searchResults"
        class="my-8"
        @search="(q) => searchNews(q)"
        @clear="clear()"
      />
    </div>



    <WeatherWidget class="self-center text-sm" />

    <SearchResults
      v-if="newsStore.searchResults?.length"
      :search-results="newsStore.searchResults"
    />

    <SourcedArticles
      source-type="trending"
      store-key="newsapi"
    />

    <SourcedArticles
      source-type="newest"
      store-key="newsapi"
    />
  </section>
</template>
