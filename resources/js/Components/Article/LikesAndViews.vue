<script setup>
import LikeButton from "./LikeButton.vue";
import SaveButton from "@/Components/Article/SaveButton.vue";

defineProps({
    article: Object,
    source: String,
});
defineEmits(["liked", "saved"]);
</script>

<template>
    <div v-if="!article.notfound" class="my-8">
        <LikeButton
            :article_id="article.id"
            :source="source"
            @liked="(details) => $emit('liked', details)"
        />
        <SaveButton
            :article_id="article.id"
            :source="source"
            @saved="(details) => $emit('saved', details)"
        />
        <small v-if="article.favs > 0" class="mt-2 ml-4 text-gray-600"
            >{{ article.favs }} likes</small
        >
        <small v-if="article.views > 0" class="mt-2 ml-4 text-gray-600"
            >{{ article.views }} views</small
        >
        <small v-if="article.saves > 0" class="mt-2 ml-4 text-gray-600"
            >{{ article.saves }} saves</small
        >
    </div>
</template>
