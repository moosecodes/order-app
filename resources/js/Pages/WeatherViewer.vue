<script setup>
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'
import AppLayout from '../Layouts/AppLayout.vue'

let inputRef = ref('')
let messageListRef = ref([])
const send = () => {
  if(inputRef.value) {
    messageListRef.value = [...messageListRef.value, inputRef.value]
    inputRef.value = ''
  }
}
</script>

<template>
  <AppLayout title="Weather">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Weather
      </h2>
      <small>source: <a
        href="https://www.weatherapi.com"
        target="_blank"
      >weatherapi.com</a></small>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <Head title="Weather" />

          <div class="m-8">
            <div>
              <p class="text-xl text-gray-500 mt-8 mb-4">
                Weather for {{ $page.props.weather.city }}, {{ $page.props.weather.region }}
              </p>
              <p
                v-if="!messageListRef.length"
                class="text-xl text-gray-500 mb-4"
              >
                Loading weather...
              </p>
              <ul class="text-xl text-gray-500 mt-4 mb-4">
                <li v-for="msg in messageListRef">
                  {{ msg }} F
                </li>
              </ul>

              <ul>
                <li
                  v-for="(item, i) in $page.props.weather"
                  :key="item"
                >
                  <b>({{ i }})</b> {{ item }}
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
