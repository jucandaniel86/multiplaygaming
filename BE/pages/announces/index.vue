<template>
  <v-row>
    <v-col cols="12">
      <div class="bg-light rounded h-100 p-4">
        <SharedPageHeader :title="'Announces'">
          <template v-slot:content>
            <button
              v-can="'announces_add'"
              class="btn btn-primary"
              @click.prevent="add"
            >
              Add new
            </button>
          </template>
        </SharedPageHeader>

        <v-data-table
          :headers="headers"
          :items="items"
          :options.sync="options"
          :server-items-length="totalItems"
          :loading="loading"
          :search="searchText"
          class="elevation-1 pa-2"
          :height="550"
        >
          <template v-slot:top>
            <div class="row">
              <div class="col-md-12">
                <v-text-field
                  v-model="searchText"
                  label="Search"
                  chips
                  class="lbl-white"
                ></v-text-field>
              </div>
            </div>
          </template>
          <template v-slot:item="{ item }">
            <tr
              :class="{
                'announce-active': item.active_on_interval,
                'announce-inactive': !item.active_on_interval,
              }"
            >
              <td class="custom-class">
                <h5 class="text-grey mt-2">{{ item.title }}</h5>
                <span>Started at:</span>
                <b>{{ formatDate(item.started_at) }}</b> <span>Ended at:</span>
                <b>{{ formatDate(item.ended_at) }}</b>
              </td>
              <td class="custom-class">
                <span
                  class="badge"
                  :class="{
                    'badge-success': item.is_active,
                    'badge-warning': !item.is_active,
                  }"
                  >{{ item.is_active ? "YES" : "NO" }}</span
                >
              </td>
              <td class="custom-class">
                <button
                  v-can="'announces_edit'"
                  type="button"
                  class="btn btn-square btn-primary m-2"
                  @click.prevent="edit(item)"
                >
                  <i class="fa fa-pencil-alt"></i>
                </button>
                <button
                  v-can="'announces_delete'"
                  type="button"
                  class="btn btn-square btn-primary text-center"
                  @click.prevent="deleteItem(item.id)"
                >
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
          </template>
        </v-data-table>
      </div>

      <v-dialog v-model="dialog" scrollable max-width="600px">
        <announce-form :current-item="currentCategory" />
      </v-dialog>
    </v-col>
  </v-row>
</template>
<script>
import moment from "moment";
import AnnounceForm from "./form";
export default {
  layout: "backend",
  middleware: ["auth"],
  components: { AnnounceForm },
  data: () => ({
    dialog: false,
    totalItems: 0,
    items: [],
    currentCategory: null,
    loading: true,
    searchText: "",
    options: {},
    headers: [
      {
        text: "Title",
        align: "start",
        sortable: false,
        value: "title",
        width: "60%",
      },
      {
        text: "Active",
        align: "start",
        sortable: false,
        value: "is_active",
        width: "20%",
      },
      { text: "Actions", value: "iron", width: "20%" },
    ],
  }),
  watch: {
    options: {
      handler() {
        this.getDataFromApi();
      },
      deep: true,
    },
    searchText() {
      if (this.searchText && this.searchText.length > 2) {
        this.getDataFromApi();
      }
      if (this.searchText.length <= 1) this.getDataFromApi();
    },
  },
  mounted() {
    this.$root.$on("close-modal", () => this.onModalClose());
    this.$root.$on("refresh-list", () => this.getDataFromApi());
  },
  methods: {
    add() {
      this.currentCategory = null;
      // this.$modal.show("form");
      this.dialog = true;
    },

    edit(item) {
      this.currentCategory = item;
      // this.$modal.show("form");
      this.dialog = true;
    },

    onModalClose() {
      // this.$modal.hide("form");
      this.dialog = false;
    },

    async getDataFromApi() {
      this.loading = true;
      try {
        const { sortBy, sortDesc, page, itemsPerPage } = this.options;

        const { data } = await this.$axios.get("/announces/list", {
          params: {
            start: page,
            length: itemsPerPage,
            search: this.searchText,
          },
        });

        this.items = data.data.items;
        this.totalItems = data.data.total;
      } catch (err) {
        this.toastError("Something went wrong!");
      }
      this.loading = false;
    },

    formatDate(_date) {
      return moment(_date).format("YYYY-MM-DD HH:mm:ss");
    },

    async deleteItem(ID) {
      this.confirmDelete().then(async (result) => {
        if (result.value) {
          try {
            const { data } = await this.$axios.delete("/announces/delete", {
              params: {
                id: ID,
              },
            });
            if (data.success) {
              this.toastSuccess(data.message);
              this.getDataFromApi();
            } else {
              this.toastError(data.message);
            }
          } catch (err) {
            this.toastError("Something went wrong!");
          }
        }
      });
    },
  },
};
</script>
<style>
.announce-active {
  background-color: rgba(5, 183, 44, 0.2);
}

.announce-inactive {
  background-color: rgba(247, 0, 0, 0.2);
}
</style>
