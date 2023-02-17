<script setup>
import { Head } from '@inertiajs/vue3';
import TheNewsPage from "@/Components/TheNewsPage.vue";

</script>

<template>
    <Head title="Breaking News" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <TheNewsPage />
            </div>
        </div>
    </div>
</template>
