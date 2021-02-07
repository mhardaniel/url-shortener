<template>
  <div class="md:container md:mx-auto flex flex-col items-center">
    <div
      class="rounded-t-xl p-10 bg-gradient-to-r from-purple-50 to-purple-100 my-10 md:w-1/3 mx-auto"
    >
      <h1 class="font-bold text-4xl text-center">URL Shortener</h1>
      <div
        v-if="$page.props.flash.success"
        class="bg-green-100 text-green-500 p-1 my-4"
      >
        {{ $page.props.flash.success }}
      </div>

      <form
        @submit.prevent="inputLinkChanged"
        class="flex flex-col justify-center flex-wrap w-full my-8"
      >
        <input
          placeholder="Enter a long URL"
          class="appearance-none border border-transparent w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-md rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
          v-model="form.original_link"
          @paste="inputLinkPaste"
        />
        <span class="text-red-600" v-if="errors.original_link">{{
          errors.original_link
        }}</span>
        <span class="text-red-600" v-if="serverErrors">
          {{ serverErrors.original_link[0] }}
        </span>
        <span class="text-red-600" v-if="clientErrors">
          {{ clientErrors }}
        </span>
        <button
          @click="inputLinkChanged()"
          :disabled="loading"
          type="submit"
          v-bind:class="{ 'disabled:opacity-50': loading }"
          class="mt-8 bg-purple-600 text-white text-base font-semibold py-4 px-6 rounded-lg shadow-md hover:bg-purple-700 focus:outline-none"
        >
          {{ loading ? "Loading" : "Make Short URL" }}
        </button>
      </form>
    </div>

    <div class="urls-table p-10 overflow-x-auto w-full">
      <table
        class="table-fixed border-collapse border-2 w-full md:w-1/2 md:mx-auto"
      >
        <thead>
          <tr>
            <th class="w-60 text-left border-2 px-4 py-2">Original Link</th>
            <th class="w-60 text-left border-2 px-4 py-2">Short Link</th>
            <th class="w-60 text-left border-2 px-4 py-2">Created</th>
            <th class="w-60 text-left border-2 px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody v-if="data.length">
          <tr
            v-for="(url, index) in data"
            :key="url.id"
            v-bind:class="{
              'bg-gradient-to-r from-purple-50 to-purple-100': index === 0,
            }"
          >
            <td class="border-2 px-4 py-2 truncate">
              <a
                target="_blank"
                :href="url.original_link"
                class="no-underline hover:underline"
                >{{ url.original_link }}</a
              >
            </td>
            <td class="border-2 px-4 py-2">
              <a
                target="_blank"
                :href="url.short_link"
                class="no-underline hover:underline"
                >{{ url.short_link }}</a
              >
            </td>
            <td class="border-2 px-4 py-2">{{ url.created_at | moment }}</td>
            <td class="border-2 px-4 py-2">
              <button
                @click="deleteUrl(url.id)"
                type="button"
                class="py-2 px-4 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-white hover:text-red-500 focus:outline-none"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped>
</style>

<script>
import moment from "moment";
import axios from "axios";

export default {
  props: {
    data: Array,
    errors: Object,
  },
  data() {
    return {
      form: {
        original_link: null,
      },
      clientErrors: "",
      loading: false,
      serverErrors: null,
      responseData: Array,
      link: null,
    };
  },
  filters: {
    moment: function (date) {
      return moment(date).fromNow();
    },
  },
  methods: {
    async inputLinkPaste(evt) {
      this.clientErrors = null;
      this.serverErrors = null;

      this.link = evt.clipboardData.getData("text");

      if (this._isValidUrl()) {
        this.loading = true;
        this.$inertia.post(
          "/urls",
          { original_link: this.link },
          {
            onSuccess: () => {
              // Handle success event
              this.loading = false;
            },
            onError: (errors) => {
              // Handle validation errors
            },
          }
        );
      } else {
        this.clientErrors = "The URL format is invalid.";
      }
    },
    async inputLinkChanged(evt) {
      this.clientErrors = null;
      this.serverErrors = null;

      if (this._isValidUrl()) {
        this.loading = true;
        this.$inertia.post("/urls", this.form).then(() => {
          this.loading = false;
        });
        // try {
        //   const response = await axios.post("/urls", this.form);
        //   this.responseData = response.data.url;
        // } catch (error) {
        //   if (error.response) {
        //     console.log(error.response.data.errors);
        //     this.serverErrors = error.response.data.errors;
        //   }
        // } finally {
        //   this.loading = false;
        // }
      } else {
        this.clientErrors = "The URL format is invalid.";
      }
      //   setTimeout(() => {
      //     this.loading = false;
      //   }, 5000);
    },

    _isValidUrl() {
      if (!this.link) return false;

      let res = this.link.match(
        /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g
      );

      return res !== null;
    },
    loadUrls() {
      axios.get("urls").then((data) => (this.data = data.data));
    },
    deleteUrl(id) {
      this.$inertia.delete(`/urls/${id}`, {
        onBefore: () => confirm("Are you sure you want to delete this URL?"),
      });
    },
  },
  created() {
    // this.loadUrls();
  },
};
</script>
