<script setup>
import { Head } from '@inertiajs/vue3'
import TheNewsPage from '@/Components/NewsPage.vue'
</script>

<template>
  <Head title="Breaking News" />

  <div class="py-12">
    <div class="mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <TheNewsPage
          :sources="$page.props.sources"
          :trending="$page.props.trending"
        />
      </div>
    </div>
  </div>
</template>
