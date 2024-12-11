<template>
  <v-row>
    <v-col cols="12">
      <div class="bg-light rounded h-100 p-4">
        <SharedPageHeader :title="title">
          <template v-slot:content>
            <div class="d-flex gap-2">
              <v-btn color="primary" small @click.prevent="add">
                Add new
              </v-btn>
              <v-btn color="primary" small @click="backToClients" icon>
                <v-icon>mdi-arrow-left-circle</v-icon>
              </v-btn>
            </div>
          </template>
        </SharedPageHeader>

        <v-data-table
          :headers="headers"
          :items="items"
          :options.sync="options"
          :server-items-length="totalItems"
          :loading="loading"
          :items-per-page="1000"
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
              <td>{{ item.brand_rgs_id }}</td>
              <td class="custom-class">
                <v-btn color="primary" x-small @click.prevent="edit(item)">
                  <v-icon color="white" x-small>mdi-pencil</v-icon>
                </v-btn>
                <v-btn
                  color="primary"
                  x-small
                  @click.prevent="deleteItem(item.id)"
                >
                  <v-icon color="white" x-small>mdi-delete-alert</v-icon>
                </v-btn>
              </td>
            </tr>
          </template>
        </v-data-table>
      </div>

      <v-dialog v-model="dialog" scrollable max-width="600px">
        <item-form :current-item="currentItem" :key="frmKey" />
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
    title: "Brands",
    totalItems: 0,
    items: [],
    currentItem: null,
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
        width: "70%",
      },
      {
        text: "Client RGS ID",
        align: "start",
        sortable: false,
        value: "client_rgs_id",
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
    this.$root.$on("brands:close-modal", () => this.onModalClose());
    this.$root.$on("brands:refresh-list", () => this.getDataFromApi());
  },
  methods: {
    add() {
      this.frmKey = `FrmKey_${new Date().getTime()}`;
      this.currentItem = null;
      this.dialog = true;
    },

    edit(item) {
      this.currentItem = item;
      this.dialog = true;
      this.frmKey = `FrmKey_${new Date().getTime()}`;
    },

    onModalClose() {
      this.dialog = false;
    },

    backToClients() {
      this.$router.push({
        name: "clients",
      });
    },

    async getDataFromApi() {
      this.loading = true;
      try {
        const { page, itemsPerPage } = this.options;

        const { data } = await this.$axios.get("/clients/brands-list", {
          params: {
            start: page,
            length: itemsPerPage,
            search: this.searchText,
            client_id: this.$route.params.id,
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
            const { data } = await this.$axios.delete("/clients/delete-brand", {
              params: {
                id: ID,
              },
            });

            if (data.success) {
              this.toastSuccess(data.data.msg);
              this.getDataFromApi();
            } else {
              this.toastError(data.data.msg);
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
