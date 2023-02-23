<script setup>
import { onMounted } from "vue";
import { useInfoStore } from "../stores/info";

import AppLayout from "@/Layouts/AppLayout.vue";
import DashboardContent from "@/Components/DashboardContent.vue";

const infoStore = useInfoStore();

const props = defineProps({
  laravelVersion: String,
  phpVersion: String,
});

onMounted(() => {
  infoStore.laravelVersion = props.laravelVersion;
  infoStore.phpVersion = props.phpVersion;
});
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <DashboardContent
          :laravelVersion="infoStore.laravelVersion"
          :phpVersion="infoStore.phpVersion"
        />
      </div>
    </div>
  </AppLayout>
</template>
