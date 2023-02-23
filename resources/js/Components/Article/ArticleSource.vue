<script setup>
import ArticleLink from "@/Components/Article/ArticleLink.vue";
import ArticleImage from "@/Components/Article/ArticleImage.vue";
import LikesAndViews from "@/Components/Article/LikesAndViews.vue";
import ArticleMetaData from "@/Components/Article/ArticleMetaData.vue";
import { likeArticle, saveArticle, track } from "@/Components/utils";
import { onMounted, ref } from "vue";

const currentSource = ref([]);

const props = defineProps({
  source: Object,
  storeKey: String,
});

onMounted(() => {
  currentSource.value = props.source;
});

async function handleLike(likeDetails) {
  const likedResponse = await likeArticle(likeDetails);
  currentSource.value.favs = likedResponse.favs;
}

async function handleSave(saveDetails) {
  const savedResponse = await saveArticle(saveDetails);
  currentSource.value.saves = savedResponse.saves;
}

async function handleView(viewDetails) {
  const viewedResponse = await track(viewDetails);
  currentSource.value.views = viewedResponse.views;
}
</script>

<template>
  <article v-for="(article, i) in props.source" :key="i">
    <div>
      <ArticleLink :article="article" :source="storeKey" @viewed="handleView">
        <ArticleImage :article="article" />
        <ArticleMetaData :article="article" />
      </ArticleLink>

      <LikesAndViews
        :article="article"
        :source="storeKey"
        @liked="handleLike"
        @saved="handleSave"
      />
    </div>
  </article>
</template>
