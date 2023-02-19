<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  props: Object
})
</script>

<template>
  <div
    v-if="props.canLogin"
    class="flex justify-between sm:block text-right my-4"
  >
    <Link
      v-if="props.user"
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
        v-if="props.canRegister"
        :href="route('register')"
        class="ml-4 text-right text-sm text-gray-700 dark:text-gray-500 underline"
      >
        Register
      </Link>
    </template>
  </div>
</template>
