<script setup>
import LaravelLogo from "./svg/LaravelLogo.vue";
import JetstreamLogo from "./svg/JetstreamLogo.vue";
import InertiaLogo from "./svg/InertiaLogo.vue";
import VueLogo from "./svg/VueLogo.vue";
import ViteLogo from "./svg/ViteLogo.vue";

defineProps({
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <div>

        <div class="mt-8 text-2xl">
            This Application
        </div>

        <p>was made with the following technologies!</p>

        <div class="my-12 flex justify-evenly items-center">
            <LaravelLogo />
            <JetstreamLogo />
            <InertiaLogo />
        </div>
        <div class="my-12 flex justify-evenly items-center">
            <VueLogo />
            <ViteLogo />
        </div>
        <div class="my-12 flex justify-evenly items-center">
            <div>MySQL</div>
            <div>Docker</div>
        </div>
    </div>
</template>
