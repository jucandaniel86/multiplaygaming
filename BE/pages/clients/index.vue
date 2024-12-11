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
              <td>{{ item.client_rgs_id }}</td>
              <td>{{ item.brands_count }}</td>
              <td>
                <v-btn
                  color="primary"
                  x-small
                  :disabled="item.brands_count === 0"
                  @click.prevent="taxes(item)"
                >
                  <v-icon color="white" x-small>mdi-plus</v-icon>
                </v-btn>
              </td>
              <td>
                <v-btn
                  color="primary"
                  x-small
                  @click.prevent="goToBrands(item.id)"
                >
                  <v-icon color="white" x-small>mdi-plus</v-icon>
                </v-btn>
              </td>
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

      <v-dialog v-model="dialogTaxes" scrollable max-width="800px">
        <taxes-form :current-item="currentItem" />
      </v-dialog>
    </v-col>
  </v-row>
</template>
<script>
import ItemForm from "./form";
import TaxesForm from "./taxes";
export default {
  layout: "backend",
  middleware: ["auth"],
  components: { ItemForm, TaxesForm },
  data: () => ({
    title: "Clients",
    totalItems: 0,
    items: [],
    currentItem: null,
    loading: true,
    searchText: "",
    options: {},
    dialog: false,
    dialogTaxes: false,
    frmKey: `FrmKey_${new Date().getTime()}`,
    headers: [
      {
        text: "Name",
        align: "start",
        sortable: false,
        value: "name",
        width: "40%",
      },
      {
        text: "Client RGS ID",
        align: "start",
        sortable: false,
        value: "client_rgs_id",
        width: "20%",
      },
      {
        text: "Total Brands",
        align: "start",
        sortable: false,
        value: "name",
        width: "10%",
      },
      {
        text: "Taxes",
        align: "start",
        sortable: false,
        value: "tasex",
        width: "10%",
      },
      {
        text: "Brands",
        align: "start",
        sortable: false,
        value: "brands",
        width: "10%",
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
    this.$root.$on("clients:close-modal", () => this.onModalClose());
    this.$root.$on("clients:refresh-list", () => this.getDataFromApi());
    this.$root.$on("clients:close-taxes-modal", () => this.onTaxesModalClose());
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

    taxes(item) {
      this.currentItem = item;
      this.dialogTaxes = true;
    },

    goToBrands(item_id) {
      this.$router.push({
        name: "clients-brands-id",
        params: {
          id: item_id,
        },
      });
    },

    onModalClose() {
      this.dialog = false;
    },

    onTaxesModalClose() {
      this.dialogTaxes = false;
    },

    async getDataFromApi() {
      this.loading = true;
      try {
        const { page, itemsPerPage } = this.options;

        const { data } = await this.$axios.get("/clients/list", {
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
            const { data } = await this.$axios.delete("/clients/delete", {
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
