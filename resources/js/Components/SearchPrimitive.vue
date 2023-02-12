<script setup>
import {ref} from "vue";
import PrimaryButton from "./Inertia/PrimaryButton.vue";
import TextInput from "./Inertia/TextInput.vue";

const emit = defineEmits([
    'search'
])

const query = ref('')

</script>

<template>
    <div class="flex justify-end font-semibold text-xl text-gray-600 leading-tight mb-8">
        <TextInput
            type="text"
            v-model="query"
            @keydown.enter="$emit('search', query)"
        />
        <PrimaryButton
            class="ml-2"
            :disabled="!query.length"
            @click="$emit('search', query)"
        >
            Search
        </PrimaryButton>
    </div>
</template>
