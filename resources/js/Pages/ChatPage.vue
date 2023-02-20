<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import ChatMessaging from '@/Components/ChatMessaging.vue'

Echo.channel('chat-channel')
  .subscribed(() => console.log(`subscribed! ${'chat-channel'}`))
  .listen('HomepageEvent', function (event) {
    console.log(event)
  })
</script>

<template>
  <AppLayout title="Chat">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Chat
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <ChatMessaging />
        </div>
      </div>
    </div>
  </AppLayout>
</template>
