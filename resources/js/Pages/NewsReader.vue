<script setup>
import AppLayout from "../Layouts/AppLayout.vue";
import TopHeadlines from "@/Components/TopHeadlines.vue";

const props = defineProps({
    news: Object,
    query: String,
});

</script>

<template>
    <AppLayout title="News Reader">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                News Reader
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <TopHeadlines :news="news" :query="query"/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
