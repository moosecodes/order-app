<script setup>
import { Head, Link } from '@inertiajs/vue3';
import TopHeadlines from "@/Components/TopHeadlines.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    news: Object,
    newscatcher_api: Object,
    newsdata_api: Object
});

</script>

<template>
    <Head title="Top Headlines" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
<!--            <div v-if="canLogin" class="hidden sm:block text-right">-->
<!--                <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</Link>-->

<!--                <template v-else>-->
<!--                    <Link :href="route('login')" class=" text-right text-sm text-gray-700 dark:text-gray-500 underline">Log in</Link>-->
<!--                    <Link v-if="canRegister" :href="route('register')" class="ml-4  text-right text-sm text-gray-700 dark:text-gray-500 underline">Register</Link>-->
<!--                </template>-->
<!--            </div>-->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <TopHeadlines
                    :news="news"
                    :newscatcher_api="newscatcher_api"
                    :newsdata_api="newsdata_api" />
            </div>
        </div>
    </div>
</template>
