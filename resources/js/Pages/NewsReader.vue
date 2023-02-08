<script setup>
import { computed } from 'vue'
import { ref } from 'vue'

import AppLayout from "../Layouts/AppLayout.vue";
import TopHeadlines from "@/Components/TopHeadlines.vue";
import PrimaryButton from "../Components/PrimaryButton.vue";
import TextInput from "../Components/TextInput.vue";
import axios from "axios";

const props = defineProps({
    news: Object,
    query: String,
});
const searchQuery = ref('')

const handleSearch = () => {
    axios.post('/api/news/search', {
        searchQuery
    })
}
</script>

<template>
    <AppLayout title="News Reader">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                Search News Reader
            </h2>
            <TextInput type="text" v-model="searchQuery" />
            <PrimaryButton class="ml-2" @click="handleSearch">Search</PrimaryButton>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <TopHeadlines :articles="news" :query="query"/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
