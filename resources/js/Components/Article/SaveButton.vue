<script setup>
import PrimaryButton from '../Inertia/PrimaryButton.vue'

defineProps({
  article_id: Number,
  source: String
})
defineEmits([
  'saved'
])
</script>

<template>
  <PrimaryButton
    class="mr-2"
    @click.stop="$emit('saved', {article_id, source})"
  >
    Save
  </PrimaryButton>
</template>

