<template>
  <v-row>
    <v-col cols="12">
      <div class="bg-light rounded h-100 p-4">
        <SharedPageHeader :title="pageTitle"></SharedPageHeader>

        <v-data-iterator
          :items="items"
          :items-per-page.sync="itemsPerPage"
          :page.sync="page"
          :search="search"
          :sort-by="sortBy.toLowerCase()"
          :sort-desc="sortDesc"
          :options.sync="options"
          :loading="loading"
        >
          <template v-slot:header>
            <v-toolbar class="mb-1" style="z-index: 99">
              <v-text-field
                v-model="search"
                clearable
                flat
                hide-details
                prepend-inner-icon="mdi-magnify"
                label="Search"
                class="mr-2"
              ></v-text-field>

              <v-spacer></v-spacer>

              <v-btn color="red" @click.prevent="add" class="ml-2">
                <v-icon color="white" x-small>mdi-plus</v-icon>
                Add new
              </v-btn>
            </v-toolbar>
          </template>
          <template v-slot:default="props">
            <v-row style="overflow: scroll; max-height: 600px">
              <v-col
                v-for="item in props.items"
                :key="item.id"
                cols="12"
                sm="6"
                md="6"
                lg="6"
              >
                <v-card>
                  <v-card-title
                    class="subheading font-weight-bold pa-1 d-flex flex-column"
                  >
                    {{ item.name }}
                    <a :href="item.external_url" v-if="item.external_url">{{
                      item.external_url
                    }}</a>

                    <v-chip-group>
                      <v-chip
                        x-small
                        :color="`${item.is_active ? 'green' : 'red'}`"
                      >
                        {{ item.is_active ? "active" : "disabled" }}
                      </v-chip>
                    </v-chip-group>
                  </v-card-title>

                  <v-divider class="ma-1"></v-divider>

                  <v-card-text>
                    <v-img
                      :src="item.slide_url"
                      :max-height="150"
                      contain
                    ></v-img>
                  </v-card-text>

                  <v-card-actions>
                    <v-spacer></v-spacer>

                    <banner-edit :banner="item" />

                    <v-btn icon @click.prevent="deleteItem(item.id)">
                      <v-icon>mdi-trash-can-outline</v-icon>
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-col>
            </v-row>
          </template>
        </v-data-iterator>
      </div>

      <v-dialog v-model="dialog" scrollable max-width="600px">
        <banner-form :key="addFormKey" />
      </v-dialog>
    </v-col>
  </v-row>
</template>
<script>
import BannerForm from "./form.vue";
import BannerEdit from "./edit.vue";

export default {
  name: "BannersList",
  layout: "backend",
  middleware: ["auth"],
  components: { BannerForm, BannerEdit },
  data: () => ({
    dialog: false,
    dialog2: false,
    addFormKey: "AddForm",
    pageTitle: "Banners",
    itemsPerPageArray: [4, 8, 12],
    search: "",
    filter: {},
    sortDesc: false,
    page: 1,
    itemsPerPage: -1,
    category: "",
    partner_type: "",
    partner_category: "",
    sortBy: "game_name",
    keys: [
      "Name",
      "Calories",
      "Fat",
      "Carbs",
      "Protein",
      "Sodium",
      "Calcium",
      "Iron",
    ],
    loading: false,
    options: {},
    items: [],
  }),
  watch: {
    options: {
      handler() {
        this.getDataFromApi();
      },
      deep: true,
    },
  },
  computed: {
    numberOfPages() {
      return Math.ceil(this.items.length / this.itemsPerPage);
    },
    filteredKeys() {
      return this.keys.filter((key) => key !== "Name");
    },
  },
  mounted() {
    this.$root.$on("banners:refresh-list", () => this.getDataFromApi());
    this.$root.$on("banners:close-modal", () => this.closeModal());
  },
  methods: {
    add() {
      this.addFormKey = new Date().getTime();
      this.dialog = true;
    },

    closeModal() {
      this.dialog = false;
    },

    closeOrder() {
      this.dialog2 = false;
    },

    async deleteItem(ID) {
      this.confirmDelete().then(async (result) => {
        if (result.value) {
          try {
            const { data } = await this.$axios.delete("/banners/delete", {
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

    async getDataFromApi() {
      this.loading = true;
      try {
        const { page, itemsPerPage } = this.options;

        const { data } = await this.$axios.get("/banners/list", {
          params: {
            start: page,
            length: itemsPerPage,
            search: this.search,
            partner_type: this.partner_type,
            partner_category: this.partner_category,
          },
        });

        this.items = data.data.items;
        this.totalItems = data.data.total;
      } catch (err) {
        this.toastError("Something went wrong!");
        console.log(err);
      }
      this.loading = false;
    },
  },
};
</script>
