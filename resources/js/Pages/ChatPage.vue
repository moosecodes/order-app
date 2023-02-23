<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ChatMessaging from "@/Components/ChatMessaging.vue";

Echo.channel("chat-channel")
    .subscribed(() => console.log(`subscribed! ${"chat-channel"}`))
    .listen("HomepageEvent", function (event) {
        console.log(event);
    });
</script>

<template>
    <AppLayout title="Chat">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Chat
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <ChatMessaging />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
