<script setup>
import PrimaryButton from './Inertia/PrimaryButton.vue'

defineProps({
  article_id: Number,
  source: String
})
defineEmits([
  'liked'
])
</script>

<template>
  <PrimaryButton
    class="mr-2"
    @click.stop="$emit('liked', {article_id, source})"
  >
    Like
  </PrimaryButton>
</template>

