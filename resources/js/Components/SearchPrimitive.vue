<script setup>
import { storeToRefs } from 'pinia'
import { useNewsStore } from '../stores/news'
import {ref} from "vue";
import TextInput from "./Inertia/TextInput.vue";
import PrimaryButton from "./Inertia/PrimaryButton.vue";

defineEmits([
    'search',
    'clear'
])
defineProps({
    results: Object,
    heading: String
})

let query = ref('')
</script>

<template>
    <div class="flex justify-between text-red-600">
        <p class="text-3xl font-bold self-center">{{ heading }}</p>

        <div class="flex max-sm:hidden max-lg:justify-end">
            <TextInput
                type="text"
                v-model="query"
                @keydown.enter="$emit('search', query)"
                @keyup.delete="queryWatcher"
            />
            <PrimaryButton
                class="ml-2"
                :disabled="!query.length"
                @click="$emit('search', query)"
            >
                Search
            </PrimaryButton>
            <PrimaryButton
                class="ml-2"
                :disabled="!query.length"
                @click="() => {
                    query = ''
                    $emit('clear')
                }"
            >
                Clear
            </PrimaryButton>
        </div>
    </div>
</template>
