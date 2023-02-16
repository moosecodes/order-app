<script setup>
import TextInput from "./Inertia/TextInput.vue";
import PrimaryButton from "./Inertia/PrimaryButton.vue";
import SearchResults from "./SearchResults.vue";
import dummyResults from "./dummyResults";
import {ref, computed} from "vue";

defineProps({
    newsIsAvailable: Function,
    breakingNewsTitle: String
})

defineEmits([
    'noResults',
    'results'
])

let query = ref('')
let results = ref([])
let userSearchQuery = ref('')

const breakingNewsTitle = computed(() => {
    return !userSearchQuery.value.length ? 'Breaking News' : `Search results for "${query.value}"`
})

const searchNews = (searchQuery) => {
    userSearchQuery.value = searchQuery
    axios.post('/api/newsapi/search', { searchQuery: searchQuery })
        .then(res => {
            if(res.data.length) {
                results.value = [...res.data]
            } else {
                results.value = [...dummyResults]
            }
        })
}
</script>

<template>
    <div class="flex justify-between text-red-600">
        <p v-if="newsIsAvailable" class="text-3xl font-extrabold self-center">{{ breakingNewsTitle }}</p>

        <div class="flex max-sm:hidden max-lg:justify-end">
            <TextInput
                type="text"
                v-model="query"
                @keydown.enter="searchNews(query)"
            />
            <PrimaryButton
                class="ml-2"
                :disabled="!query.length"
                @click="searchNews(query)"
            >
                Search
            </PrimaryButton>
        </div>
    </div>
    <SearchResults v-if="results?.length" :result="results"></SearchResults>
</template>
