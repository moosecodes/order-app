<script setup>
import { storeToRefs } from "pinia";
import { useNewsStore } from "../../stores/news";
import { ref } from "vue";
import TextInput from "../Inertia/TextInput.vue";
import PrimaryButton from "../Inertia/PrimaryButton.vue";

defineEmits(["search", "clear"]);
defineProps({
    results: Object,
    heading: String,
});

let query = ref("");
</script>

<template>
    <div class="flex justify-between text-red-600">
        <p class="self-center text-3xl font-bold">
            {{ heading }}
        </p>

        <div class="flex max-lg:justify-end max-sm:hidden">
            <TextInput
                v-model="query"
                type="text"
                @keydown.enter="$emit('search', query)"
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
                @click="
                    () => {
                        query = '';
                        $emit('clear');
                    }
                "
            >
                Clear
            </PrimaryButton>
        </div>
    </div>
</template>
