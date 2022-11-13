<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Components/Welcome.vue";
import { Link } from "@inertiajs/inertia-vue3";
import DialogModal from "@/Components/DialogModal.vue";
</script>

<template>
  <AppLayout :title="pageModeLabel">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ pageModeLabel }}
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a type="button" class="
            focus:outline-none
            text-white
            bg-green-700
            hover:bg-green-800
            focus:ring-4 focus:ring-green-300
            font-medium
            rounded-md
            text-sm
            pr-4
            pl-2.5
            py-2.5
            mr-2
            mb-2
            dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800
            inline-flex
            items-center
            cursor-pointer
          " :href="route('wishes.create', { from_page: this.$page.props.pageMode })">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-0.5"
            viewBox="0 0 16 16">
            <path
              d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
          </svg>
          <span> Add a wish </span>
        </a>
        <div v-if="checkWishesExists()" class="overflow-x-auto relative rounded-md shadow-md">
          <table class="w-full text-sm text-left text-white">
            <thead class="text-xs text-white uppercase bg-black">
              <tr>
                <th v-if="checkPageModeIsAll()" scope="col" class="py-3 px-6">Person</th>
                <th scope="col" class="py-3 px-6">Title</th>
                <th scope="col" class="py-3 px-6">Description</th>
                <th scope="col" class="py-3 px-6">URL</th>
                <th v-if="!checkPageModeIsAll()" scope="col" colspan="2" class="py-3 pl-6">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="$wish in $page.props.wishes" :key="$wish.id" class="
                  bg-white
                  text-black
                  border-t
                  hover:bg-gray-100 hover:cursor-pointer
                " @click="showWishModal($wish)">
                <th v-if="checkPageModeIsAll()" scope="row" class="py-4 px-6 font-medium whitespace-nowrap">
                  {{ $wish.user.name }}
                </th>
                <td class="py-4 px-6">{{ $wish.title }}</td>
                <td class="py-4 px-6">{{ $wish.description }}</td>
                <td class="py-4 px-6">
                  <a :href="$wish.url" target="_blank" class="underline">Link</a>
                </td>
                <td v-if="!checkPageModeIsAll()" class="py-4 pl-6">
                  <button type="button" class="
                      text-white
                      bg-blue-700
                      hover:bg-blue-800
                      focus:ring-4 focus:ring-blue-300
                      font-medium
                      rounded-lg
                      text-sm
                      px-5
                      py-2.5
                      mr-2
                      mb-2
                      dark:bg-blue-600 dark:hover:bg-blue-700
                      focus:outline-none
                      dark:focus:ring-blue-800
                    " @click.stop="editWish($wish.id)">
                    Edit
                  </button>
                  <button type="button" class="
                      focus:outline-none
                      text-white
                      bg-red-700
                      hover:bg-red-800
                      focus:ring-4 focus:ring-red-300
                      font-medium
                      rounded-lg
                      text-sm
                      px-5
                      py-2.5
                      mr-2
                      mb-2
                      dark:bg-red-600
                      dark:hover:bg-red-700
                      dark:focus:ring-red-900
                    " @click.stop="deleteWish($wish.id)">
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div v-else class="
            flex
            p-4
            mb-4
            text-sm text-yellow-700
            bg-yellow-100
            rounded-lg
            dark:bg-yellow-200 dark:text-yellow-800
          " role="alert">
          <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
              clip-rule="evenodd"></path>
          </svg>
          <div><span class="font-medium">Warning:</span> wishes not found</div>
        </div>
      </div>
    </div>
  </AppLayout>
  <div v-if="showModal" class="
      bg-slate-800 bg-opacity-50
      flex
      justify-center
      items-center
      fixed
      top-0
      right-0
      bottom-0
      left-0
    ">
    <div class="bg-white px-5 py-5 rounded-md text-left">
      <span class="mb-1 font-normal">Person</span>
      <p class="mb-3 font-normal">{{ wishModal.person }}</p>
      <span class="mb-1 font-normal">Title</span>
      <p class="mb-3 font-normal">{{ wishModal.title }}</p>
      <span class="mb-1 font-normal">Description</span>
      <p class="mb-3 font-normal">{{ wishModal.description }}</p>
      <span class="mb-1 font-normal">Progress ({{ wishModal.progress }}%)</span>
      <div class="mb-3 w-full bg-gray-400 rounded-full">
        <div class="bg-blue-500 h-1" :style="{ 'width': `${wishModal.progress}%` }"></div>
      </div>
      <span class="mb-1 font-normal">URL</span>
      <p class="mb-3 font-normal">{{ wishModal.url }}</p>
      <button type="button" class="
          focus:outline-none
          text-white
          bg-red-700
          hover:bg-red-800
          focus:ring-4 focus:ring-red-300
          font-medium
          rounded-lg
          text-sm
          px-5
          py-2.5
          mr-2
          mb-2
        " @click.stop="closeWishModal()">
        Close
      </button>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      showModal: false,
      wishModal: {
        person: null,
        title: null,
        description: null,
        progress: null,
        url: null
      },
    };
  },
  props: {
    wishes: Array,
    pageMode: String,
    pageModeLabel: String,
  },
  methods: {
    checkPageModeIsAll() {
      return this.$page.props.pageMode === 'all';
    },
    checkWishesExists() {
      let wishes = this.$page.props.wishes;

      if (wishes == null) {
        return false;
      }

      if (wishes.length == 0) {
        return false;
      }

      return true;
    },
    showWishModal(wish) {
      this.wishModal.person = wish.user.name;
      this.wishModal.title = wish.title;
      this.wishModal.description = wish.description;
      this.wishModal.progress = wish.progress;
      this.wishModal.url = wish.url;
      this.showModal = true;
    },
    closeWishModal() {
      this.wishModal.person = null;
      this.wishModal.title = null;
      this.wishModal.description = null;
      this.wishModal.progress = null;
      this.wishModal.url = null;
      this.showModal = false;
    },
    editWish(wishId) {
      const route = this.route('wishes.edit', wishId)
      this.$inertia.get(route, { from_page: 'personal' });
    },
    deleteWish(wishId) {
      const route = this.route('wishes.destroy', wishId);
      this.$inertia.delete(route);
    }
  },
};
</script>
