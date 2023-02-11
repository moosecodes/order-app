import {ref} from "vue";

const currentTemp = ref('')

function getWeather(zip = '90004') {
    axios.get(`/api/weather/${zip}`)
        .then(function (res) {
            currentTemp.value = `${res.data.temp_f} F in ${res.data.city}, ${res.data.region}`
        })
        .catch(function (error) {
            console.log(error);
        })
}

export { getWeather, currentTemp };
