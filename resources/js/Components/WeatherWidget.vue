<script setup>
import {onMounted, ref} from 'vue';

const currentTemp = ref([])

onMounted(() => {
    getWeather('90004')
})

function getWeather(zip = '90004') {
    axios.get(`/api/weather/${zip}`)
        .then(function (res) {
            currentTemp.value = [
                `${res.data.temp_f} F in ${res.data.city}, ${res.data.region}`,
                `${res.data.temp_f} F in ${res.data.city}, ${res.data.region}`,
                `${res.data.temp_f} F in ${res.data.city}, ${res.data.region}`
            ]
        })
        .catch(function (error) {
            console.log(error);
        })
}
</script>

<template>
    <div class="my-4">
        <p v-if="currentTemp" class=" flex justify-evenly text-gray-500 text-center">
            <span v-for="temp in currentTemp">{{temp}}</span>
        </p>
        <p v-else class="text-gray-500 text-left">
            Loading Weather...
        </p>
    </div>
</template>
