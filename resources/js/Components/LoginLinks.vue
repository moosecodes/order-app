<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  user: Object,
  canLogin: Boolean,
  canRegister: Boolean,
})
</script>

<template>
  <div
    v-if="canLogin"
    class="flex justify-between sm:block text-right my-4"
  >
    <Link
      v-if="user"
      :href="route('dashboard')"
      class="text-sm text-gray-700 dark:text-gray-500 underline"
    >
      Dashboard
    </Link>
    <template v-else>
      <Link
        :href="route('login')"
        class=" text-right text-sm text-gray-700 dark:text-gray-500 underline"
      >
        Log in
      </Link>
      <Link
        v-if="canRegister"
        :href="route('register')"
        class="ml-4 text-right text-sm text-gray-700 dark:text-gray-500 underline"
      >
        Register
      </Link>
    </template>
  </div>
</template>
