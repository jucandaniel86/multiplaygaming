<template>
  <v-row>
    <v-col cols="12">
      <div class="bg-light rounded h-100 p-4">
        <SharedPageHeader :title="'Game Categories'">
          <template v-slot:content>
            <button class="btn btn-primary" @click.prevent="add">
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
            <tr>
              <td class="custom-class">{{ item.name }}</td>
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
                  type="button"
                  class="btn btn-square btn-primary m-2"
                  @click.prevent="edit(item)"
                >
                  <i class="fa fa-pencil-alt"></i>
                </button>
                <button
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

      <modal
        name="form"
        :height="'auto'"
        :maxWidth="600"
        width="100%"
        :scrollable="false"
        :adaptive="true"
        :styles="{ overflow: 'visible' }"
      >
        <category-form :current-item="currentCategory" />
      </modal>
    </v-col>
  </v-row>
</template>
<script>
import CategoryForm from "./form";
export default {
  layout: "backend",
  middleware: ["auth"],
  components: { CategoryForm },
  data: () => ({
    totalItems: 0,
    items: [],
    currentCategory: null,
    loading: true,
    searchText: "",
    options: {},
    headers: [
      {
        text: "Name",
        align: "start",
        sortable: false,
        value: "name",
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
      this.$modal.show("form");
    },

    edit(item) {
      this.currentCategory = item;
      this.$modal.show("form");
    },

    onModalClose() {
      this.$modal.hide("form");
    },

    async getDataFromApi() {
      this.loading = true;
      try {
        const { sortBy, sortDesc, page, itemsPerPage } = this.options;

        const { data } = await this.$axios.get("/categories/list", {
          params: {
            start: page,
            length: itemsPerPage,
            search: this.searchText,
          },
        });

        this.items = data.data.items;
        this.totalItems = data.total;
      } catch (err) {
        this.toastError("Something went wrong!");
      }
      this.loading = false;
    },

    async deleteItem(ID) {
      this.confirmDelete().then(async (result) => {
        if (result.value) {
          try {
            const { data } = await this.$axios.delete("/categories/delete", {
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
