<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
});
</script>

<template>
  <Head title="Welcome" />

  <div
    class="
      relative
      flex
      items-top
      justify-center
      min-h-screen
      sm:items-center sm:pt-0
    "
  >
    <div v-if="canLogin" class="hidden fixed top-0 right-500 px-6 py-4 sm:block">
      <Link
        v-if="$page.props.user"
        :href="route('dashboard')"
        class="text-sm underline"
        >Dashboard</Link
      >

      <template v-else>
        <Link :href="route('login')" class="text-sm text-black underline"
          >Log in</Link
        >

        <Link
          v-if="canRegister"
          :href="route('register')"
          class="ml-4 text-sm text-black underline"
          >Register</Link
        >
      </template>
    </div>

    <div class="flex flex-col text-center">
      <h1 class="text-9xl">GIFT BOX</h1>
      <div class="flex justify-center mb-3">
        <svg
          class="w-16 h-16"
          viewBox="0 0 16 16"
          fill="#000"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M8 7.982C9.664 6.309 13.825 9.236 8 13 2.175 9.236 6.336 6.31 8 7.982Z"
          />
          <path
            d="M3.75 0a1 1 0 0 0-.8.4L.1 4.2a.5.5 0 0 0-.1.3V15a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V4.5a.5.5 0 0 0-.1-.3L13.05.4a1 1 0 0 0-.8-.4h-8.5Zm0 1H7.5v3h-6l2.25-3ZM8.5 4V1h3.75l2.25 3h-6ZM15 5v10H1V5h14Z"
          />
        </svg>
      </div>
      <h2 class="text-3xl text-gray-500">YOU ARE WELCOME</h2>
    </div>
  </div>
</template>
