<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import StockScreener from '@/Components/StockScreener.vue';

defineProps({
    title: String,
    stocks: Object,
    query: String,
})
</script>

<template>
    <AppLayout title="Stock Market">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Stock Market
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <StockScreener :stocks="stocks" :query="query"/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
