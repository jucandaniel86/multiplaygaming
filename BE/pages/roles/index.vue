<template>
  <v-row>
    <v-col cols="12">
      <div class="bg-light rounded h-100 p-4">
        <SharedPageHeader :title="title">
          <template v-slot:content>
            <button
              v-can="'roles_add'"
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
            <tr>
              <td class="custom-class">{{ item.name }}</td>
              <td>{{ item.permissions.length }}</td>
              <td class="custom-class">
                <button
                  type="button"
                  class="btn btn-square btn-primary m-2"
                  v-can="'roles_edit'"
                  @click.prevent="edit(item)"
                >
                  <i class="fa fa-pencil-alt"></i>
                </button>
                <button
                  type="button"
                  class="btn btn-square btn-primary text-center"
                  v-can="'roles_delete'"
                  @click.prevent="deleteItem(item.id)"
                >
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
          </template>
        </v-data-table>
      </div>

      <v-dialog v-model="dialog" scrollable max-width="600px" fullscreen>
        <item-form :id="currentID" :key="frmKey" />
      </v-dialog>
    </v-col>
  </v-row>
</template>
<script>
import ItemForm from "./form";
export default {
  layout: "backend",
  middleware: ["auth"],
  components: { ItemForm },
  data: () => ({
    title: "Roles",
    totalItems: 0,
    items: [],
    currentID: null,
    loading: true,
    searchText: "",
    options: {},
    dialog: false,
    frmKey: `FrmKey_${new Date().getTime()}`,
    headers: [
      {
        text: "Name",
        align: "start",
        sortable: false,
        value: "name",
        width: "60%",
      },
      {
        text: "Permissions",
        align: "start",
        sortable: false,
        value: "name",
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
    this.$root.$on("roles:close-modal", () => this.onModalClose());
    this.$root.$on("roles:reload-table", () => this.getDataFromApi());
  },
  methods: {
    add() {
      this.frmKey = `FrmKey_${new Date().getTime()}`;
      this.currentItem = null;
      this.dialog = true;
      this.currentID = null;
    },

    edit(item) {
      this.currentID = item.id;
      this.dialog = true;
      this.frmKey = `FrmKey_${new Date().getTime()}`;
    },

    onModalClose() {
      this.dialog = false;
    },

    async getDataFromApi() {
      this.loading = true;
      try {
        const { page, itemsPerPage } = this.options;

        const { data } = await this.$axios.get("/roles/list", {
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

    async deleteItem(ID) {
      this.confirmDelete().then(async (result) => {
        if (result.value) {
          try {
            const { data } = await this.$axios.delete("/roles/delete", {
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
