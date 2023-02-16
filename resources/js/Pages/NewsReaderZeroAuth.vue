<script setup>
import { Head } from '@inertiajs/vue3';
import TopHeadlines from "@/Components/TopHeadlines.vue";

defineProps({
    articles: Object
})

</script>

<template>
    <Head title="Breaking News" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <TopHeadlines :articles="articles" />
            </div>
        </div>
    </div>
</template>
