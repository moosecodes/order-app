<script setup>
import PrimaryButton from "./Inertia/PrimaryButton.vue";
defineProps({
    article_id: Number,
    api_source: String
})
const emit = defineEmits([
    'liked'
])
</script>

<template>
    <PrimaryButton
        @click.stop="$emit('liked', {article_id, api_source})"
        class="mr-2">Like
    </PrimaryButton>
</template>

