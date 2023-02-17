<script setup>
import {onMounted, ref} from 'vue';
const currentTemp = ref([])
const locations = [
    '90004', '60601', '10001'
]
onMounted(() => {
    locations.forEach(l => getWeather(l))
})

function getWeather(zip = '90004') {
    axios.get(`/api/weather/${zip}`)
        .then(function (res) {
            currentTemp.value = [
                ...currentTemp.value,
                `${res.data.temp_f} F in ${res.data.city}, ${res.data.region}`
            ]})
        .catch(function (error) {
            console.log(error);
        })
}
</script>

<template>
    <div class="my-4 font-bold text-black-600 text-left">
        <div v-if="currentTemp.length" class="grid sm:grid-cols-1 lg:grid-cols-3">
            <div v-for="temp in currentTemp">{{temp}}</div>
        </div>
        <p v-else>
            Loading Weather...
        </p>
    </div>
</template>
