<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import TextInput from "@/Components/TextInput.vue";

defineProps({
    weather: Object
});

Echo.channel('weather-channel')
    .listen('WeatherReadingEvent', function(event) {
        messageListRef = [...messageListRef, event.msg]
    })

let inputRef = ref('')
let messageListRef = ref([])
const send = () => {
    if(inputRef.value) {
        messageListRef.value = [...messageListRef.value, inputRef.value]

        Echo.join(`weather-channel.1`)
            .whisper('typing', {
                msg: inputRef.value
            });

        inputRef.value = ''
    }
}
</script>

<template>
    <Head title="Weather and Messaging" />

    <div class="m-8">
        <p class="text-xl text-gray-500 mb-2">Type message here</p>
        <TextInput
            type="text"
            class="text-xl"
            v-model="inputRef"
            @keydown.enter="send"
            autofocus
        />

        <p class="text-xl text-gray-500 mt-4">Messages</p>
        <ul>
            <li v-for="msg in messageListRef" class="text-sm">{{msg}}</li>
        </ul>
        <div>
            <p class="text-xl text-gray-500 mt-8 mb-4">  Weather for {{ $page.props.weather.city }}, {{ $page.props.weather.region }}</p>
            <ul>
                <li v-for="(item, i) in $page.props.weather" :key="item"><b>({{i}})</b> {{ item }}</li>
            </ul>
        </div>
    </div>
</template>
