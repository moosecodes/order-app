<script setup>
import PrimaryButton from "./Inertia/PrimaryButton.vue";
defineProps({
    article_id: Number,
    api_source: String|Number,
    props: Object
})
const emit = defineEmits([
    'saved'
])
</script>

<template>
    <PrimaryButton
        @click.stop="$emit('saved', {article_id, api_source, props})"
        class="mr-2">
        Save
    </PrimaryButton>
</template>

