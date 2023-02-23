<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  user: Object,
  canLogin: Boolean,
  canRegister: Boolean,
});
</script>

<template>
  <div v-if="canLogin" class="my-4 flex justify-between text-right sm:block">
    <Link
      v-if="user"
      :href="route('dashboard')"
      class="text-sm text-gray-700 underline dark:text-gray-500"
    >
      Dashboard
    </Link>
    <template v-else>
      <Link
        :href="route('login')"
        class="text-right text-sm text-gray-700 underline dark:text-gray-500"
      >
        Log in
      </Link>
      <Link
        v-if="canRegister"
        :href="route('register')"
        class="ml-4 text-right text-sm text-gray-700 underline dark:text-gray-500"
      >
        Register
      </Link>
    </template>
  </div>
</template>
