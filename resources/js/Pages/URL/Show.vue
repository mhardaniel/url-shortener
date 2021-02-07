<template>
  <div class="md:container md:mx-auto flex flex-col items-center">
    <div
      class="rounded-t-xl p-10 bg-gradient-to-r from-purple-50 to-purple-100 my-10"
    >
      <h1 class="font-bold text-4xl text-center mb-8">URL Shortener</h1>
      <div
        v-if="$page.props.flash.success"
        class="bg-green-100 text-green-500 p-1 my-4"
      >
        {{ $page.props.flash.success }}
      </div>
      <div class="mb-8">
        <p>Short Link</p>
        <p
          class="max-w-lg px-6 py-4 mx-auto shadow bg-white text-purple-900 font-medium rounded-lg border-2"
        >
          <a :href="url.data.short_link" target="_blank">
            {{ url.data.short_link }}
          </a>
        </p>
      </div>
      <div>
        <p>Original Link</p>
        <p
          class="break-all max-w-lg px-6 py-4 mx-auto shadow bg-white text-purple-900 font-medium rounded-lg border-2"
        >
          <a :href="url.data.original_link" target="_blank">
            {{ url.data.original_link }}
          </a>
        </p>
      </div>
      <inertia-link
        href="/"
        as="button"
        type="button"
        class="mt-8 bg-purple-600 text-white text-base font-semibold py-4 px-6 rounded-lg shadow-md hover:bg-purple-700 focus:outline-none"
        >Shorten another</inertia-link
      >
      <!-- <button
      @click="goToHomepage()"
        class="mt-8 bg-purple-600 text-white text-base font-semibold py-4 px-6 rounded-lg shadow-md hover:bg-purple-700 focus:outline-none"
      >
        Shorten another
      </button> -->
    </div>
  </div>
</template>

<style scoped>
</style>

<script>
export default {
  props: {
    url: Object,
  },
  data() {
    return {};
  },
  methods: {
    goToHomepage() {},
  },
  created() {},
};
</script>
