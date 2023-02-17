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
    <div v-if="!article.notfound && $page.props.user">
        <LikeButton
            :article_id="article.id"
            :api_source="api"
            :props="props"
            @liked="details => $emit('liked', details)"
        />
        <small v-if="article.favs > 0" class="text-gray-600 mt-2 ml-4">{{article.favs}} likes</small>
        <small v-if="article.views > 0" class="text-gray-600 mt-2 ml-4">{{article.views}} views</small>
    </div>
</template>
