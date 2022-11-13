<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Components/Welcome.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

const form = useForm({
  title: null,
  description: null,
  progress: null,
  url: null,
});
</script>

<template>
  <AppLayout title="Update a wish">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Update a wish
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a type="button" :href="setupBackLink()" class="
            text-white 
            bg-gray-700 
            hover:bg-gray-800 
            focus:ring-4 
            focus:ring-gray-300
            font-medium rounded-lg
            text-sm
            px-5
            py-2.5
            mr-2
            mb-3
            inline-flex
            items-center
            cursor-pointer
          ">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left"
            viewBox="0 0 16 16">
            <path fill-rule="evenodd"
              d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
          </svg>
          <span class="ml-1">Back</span>
        </a>
        <div class="px-3 py-3 rounded-md shadow-md bg-white">
          <form @submit.prevent="update">
            <div class="mb-6">
              <label for="title" class="block mb-2 text-sm font-medium text-black">Title</label>
              <span v-if="$page.props.errors">{{ $page.props.errors.title }}</span>
              <input type="text" name="title" id="title" class="
                  shadow-sm
                  bg-gray-50
                  border border-gray-300
                  text-gray-900 text-sm
                  rounded-lg
                  focus:ring-gray-500 focus:border-gray-500
                  block
                  w-full
                  p-2.5
                " placeholder="Some title" v-model="form.title" />
            </div>
            <div class="mb-6">
              <label for="description" class="block mb-2 text-sm font-medium text-black">Description</label>
              <span v-if="$page.props.errors">{{ $page.props.errors.description }}</span>
              <input type="text" name="description" id="description" class="
                  shadow-sm
                  bg-gray-50
                  border border-gray-300
                  text-gray-900 text-sm
                  rounded-lg
                  focus:ring-gray-500 focus:border-gray-500
                  block
                  w-full
                  p-2.5
                " placeholder="Some description" v-model="form.description" />
            </div>
            <div class="mb-6">
              <label for="progress" class="block mb-2 text-sm font-medium text-black">Progress</label>
              <span v-if="$page.props.errors">{{ $page.props.errors.progress }}</span>
              <input type="number" max="100" min="0" step="1" name="progress" id="progress" class="
                  shadow-sm
                  bg-gray-50
                  border border-gray-300
                  text-gray-900 text-sm
                  rounded-lg
                  focus:ring-gray-500 focus:border-gray-500
                  block
                  w-full
                  p-2.5
                " placeholder="0" v-model="form.progress" />
            </div>
            <div class="mb-6">
              <label for="url" class="block mb-2 text-sm font-medium text-black">URL</label>
              <span v-if="$page.props.errors">{{ $page.props.errors.url }}</span>
              <input type="text" name="url" id="url" class="
                  shadow-sm
                  bg-gray-50
                  border border-gray-300
                  text-gray-900 text-sm
                  rounded-lg
                  focus:ring-gray-500 focus:border-gray-500
                  block
                  w-full
                  p-2.5
                " placeholder="https://some.url/" v-model="form.url" />
            </div>
            <button type="submit" class="
                text-white
                bg-blue-700
                hover:bg-blue-800
                focus:ring-4 focus:outline-none focus:ring-blue-300
                font-medium
                rounded-lg
                text-sm
                px-5
                py-2.5
                text-center
              ">
              Update a wish
            </button>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>

export default {
  props: {
    wish: Object
  },
  methods: {
    setupBackLink() {
      let url = this.$inertia.page.url;
      let queryParams = url.split('?')[1];

      if (queryParams !== undefined) {
        queryParams = queryParams.split('&');
        if (queryParams[0].split('=')[1] == 'all') {
          return route('wishes.index', { page_mode: 'all' });
        }

        if (queryParams[0].split('=')[1] == 'personal') {
          return route('wishes.index', { page_mode: 'personal' });
        }

        return route('dashboard');
      }
    },
    update() {
      Inertia.patch(route("wishes.update", this.$page.props.wish.id), this.form);
    }
  },
  mounted() {
    const wish = this.$page.props.wish;
    this.form.title = wish.title;
    this.form.description = wish.description;
    this.form.progress = wish.progress;
    this.form.url = wish.url;
  }
}

</script>