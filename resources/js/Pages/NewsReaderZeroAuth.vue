<script setup>
import { Head } from '@inertiajs/vue3';
import TopHeadlines from "@/Components/TopHeadlines.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    newsapi_api: Object,
    newscatcher_api: Object,
    newsdata_api: Object
})

</script>

<template>
    <Head title="Breaking News" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <TopHeadlines
                    :newsapi_api="newsapi_api"
                    :newscatcher_api="newscatcher_api"
                    :newsdata_api="newsdata_api"
                />
            </div>
        </div>
    </div>
</template>
