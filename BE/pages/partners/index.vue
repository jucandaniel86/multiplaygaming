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
              <template v-if="$vuetify.breakpoint.mdAndUp">
                <selector-partner-categories v-model="partner_category" />

                <selector-partner-types v-model="partner_type" class="ml-2" />

                <v-spacer></v-spacer>

                <v-btn color="red" @click.prevent="add" class="ml-2">
                  <v-icon color="white" x-small>mdi-plus</v-icon>
                  Add new
                </v-btn>
              </template>
            </v-toolbar>
          </template>
          <template v-slot:default="props">
            <v-row style="overflow: scroll; max-height: 600px">
              <v-col
                v-for="item in props.items"
                :key="item.id"
                cols="12"
                sm="6"
                md="4"
                lg="3"
              >
                <v-card>
                  <v-card-title
                    class="subheading font-weight-bold pa-1 d-flex flex-column"
                  >
                    {{ item.name }}
                    <a :href="item.external_url" v-if="item.external_url">{{
                      item.external_url
                    }}</a>
                    <v-chip
                      v-if="item.priority"
                      style="position: absolute; top: 5px; right: 5px"
                      color="blue"
                      >{{ item.priority }}</v-chip
                    >

                    <v-chip-group>
                      <v-chip x-small>{{ item.partner_category }}</v-chip>
                      <v-chip x-small>{{ item.partner_type }}</v-chip>
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
                    <v-img :src="item.logo_url" :max-height="120"></v-img>
                  </v-card-text>

                  <v-card-actions>
                    <v-spacer></v-spacer>

                    <PartnerOrder :partner="item" />
                    <PartnerEdit :partner="item" />

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
        <partner-form :key="addFormKey" />
      </v-dialog>
    </v-col>
  </v-row>
</template>
<script>
import PartnerForm from "./form.vue";
import PartnerEdit from "./edit.vue";
import PartnerOrder from "./order.vue";

export default {
  name: "PartnersList",
  layout: "backend",
  middleware: ["auth"],
  components: { PartnerForm, PartnerEdit, PartnerOrder },
  data: () => ({
    dialog: false,
    dialog2: false,
    addFormKey: "AddForm",
    pageTitle: "Partners",
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
    partner_type() {
      this.getDataFromApi();
    },
    partner_category() {
      this.getDataFromApi();
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
    this.$root.$on("partners:refresh-list", () => this.getDataFromApi());
    this.$root.$on("partners:close-modal", () => this.closeModal());
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
            const { data } = await this.$axios.delete("/partners/delete", {
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

        const { data } = await this.$axios.get("/partners/list", {
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
