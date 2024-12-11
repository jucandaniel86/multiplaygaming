<template>
  <v-row>
    <v-col cols="12">
      <div class="bg-light rounded h-100 p-4">
        <SharedPageHeader :title="title">
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
              <td class="custom-class">{{ item.alias }}</td>
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

      <v-dialog scrollable max-width="600px" v-model="openDialog">
        <jurisdiction-form :current-item="currentJurisdiction" :key="jFrmKey" />
      </v-dialog>
    </v-col>
  </v-row>
</template>
<script>
import JurisdictionForm from "./form";
export default {
  layout: "backend",
  middleware: ["auth"],
  components: { JurisdictionForm },
  data: () => ({
    title: "Jurisdictions",
    totalItems: 0,
    items: [],
    currentJurisdiction: null,
    openDialog: false,
    loading: true,
    searchText: "",
    options: {},
    jFrmKey: `JFrm${new Date().getTime()}`,
    headers: [
      {
        text: "Name",
        align: "start",
        sortable: false,
        value: "name",
        width: "60%",
      },
      {
        text: "Alias",
        align: "start",
        sortable: false,
        value: "alias",
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
      this.currentJurisdiction = null;
      this.jFrmKey = `JFrm${new Date().getTime()}`;
      this.openDialog = true;
    },

    edit(item) {
      this.currentJurisdiction = item;
      this.openDialog = true;
    },

    onModalClose() {
      this.openDialog = false;
    },

    async getDataFromApi() {
      this.loading = true;
      try {
        const { sortBy, sortDesc, page, itemsPerPage } = this.options;

        const { data } = await this.$axios.get("/jurisdictions/list", {
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
            const { data } = await this.$axios.delete("/jurisdictions/delete", {
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
