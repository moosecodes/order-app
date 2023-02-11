function getWeather(zip = '90004') {
    axios.get(`/api/weather/${zip}`)
        .then(function (response) {
            console.log(response);
        })
        .catch(function (error) {
            console.log(error);
        });
}

export { getWeather };
