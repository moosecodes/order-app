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
    <div class="flex max-sm:hidden max-lg:justify-end text-red-700">
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
