<script setup>
import LikeButton from "./LikeButton.vue"

const props = defineProps({
    article: Object,
    api: String,
    props: Object
})
defineEmits([
    'liked'
])
</script>

<template>
    <div v-if="!article.notfound" class="my-8">
        <LikeButton
            :article_id="article.id"
            :api_source="api"
            :props="props"
            @liked="$emit('liked', {article, api, props})"
        />
        <small v-if="article.favs > 0" class="text-gray-600 mt-2 ml-4">{{article.favs}} likes</small>
        <small v-if="article.views > 0" class="text-gray-600 mt-2 ml-4">{{article.views}} views</small>
    </div>
</template>
