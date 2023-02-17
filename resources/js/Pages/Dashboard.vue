<script setup>
import {onMounted} from "vue";
import { useInfoStore } from "../stores/info";

import AppLayout from '@/Layouts/AppLayout.vue';
import DashboardContent from '@/Components/DashboardContent.vue';

const infoStore = useInfoStore()

const props = defineProps({
    laravelVersion: String,
    phpVersion: String
})

onMounted(() => {
    infoStore.laravelVersion = props.laravelVersion
    infoStore.phpVersion = props.phpVersion
})
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <DashboardContent
                    :laravelVersion="infoStore.laravelVersion"
                    :phpVersion="infoStore.phpVersion"
                />
            </div>
        </div>
    </AppLayout>
</template>
