<script setup>
import {onMounted} from 'vue';
import {getWeather, currentTemp} from '../utils/weather'

onMounted(() => {
    getWeather()
})
</script>

<template>
    <div class="my-4">
        <p v-if="currentTemp" class="text-gray-500 text-left">
            {{currentTemp}}
        </p>
        <p v-else class="text-gray-500 text-left">
            Loading Weather...
        </p>
    </div>
</template>
