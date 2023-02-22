<script setup>
import PrimaryButton from '../Inertia/PrimaryButton.vue'
defineProps({
  article_id: Number,
  api_source: String
})
defineEmits([
  'saved'
])
</script>

<template>
  <PrimaryButton
    class="mr-2"
    @click.stop="$emit('saved', {article_id, api_source})"
  >
    Save
  </PrimaryButton>
</template>

