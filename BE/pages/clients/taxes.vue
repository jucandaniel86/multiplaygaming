<template>
  <v-card>
    <v-card-title class="pa-1">{{ modalName }}</v-card-title>
    <v-card-text class="pa-2">
      <v-row class="d-flex align-start">
        <v-col cols="3">
          <selector-brands
            v-model="brand"
            :client="currentItem.id"
            :default-value="brand"
          />
          <v-alert
            type="error"
            v-if="errors.brand_id"
            class="pa-0 mb-0"
            style="font-size: 0.8rem"
          >
            {{ errors.country_id[0] }}
          </v-alert>
        </v-col>
        <v-col cols="3">
          <selector-country
            v-model="form.country_id"
            :default-value="form.country_id"
          />
          <v-alert
            type="error"
            v-if="errors.country_id"
            class="pa-0 mb-0"
            style="font-size: 0.8rem"
          >
            {{ errors.country_id[0] }}
          </v-alert>
        </v-col>
        <v-col cols="3">
          <v-text-field v-model="form.tax" label="Tax" />
          <v-alert
            type="error"
            v-if="errors.tax"
            class="pa-0 mb-0"
            style="font-size: 0.8rem"
          >
            {{ errors.tax[0] }}
          </v-alert>
        </v-col>
        <v-col cols="2" class="d-flex align-center">
          <v-btn
            @click.prevent="save"
            :disabled="isSave"
            color="primary"
            small
            class="mt-4"
          >
            Save
          </v-btn>
        </v-col>
      </v-row>

      <v-simple-table fixed-header height="350" :loading="isLoading">
        <thead>
          <td>Brand</td>
          <td>Country</td>
          <td>Tax</td>
          <td>Actions</td>
        </thead>
        <tbody>
          <tr v-for="(item, i) in items" :key="`Taxes${i}`">
            <td>{{ item.brand ? item.brand.name : "N/A" }}</td>
            <td>{{ item.country ? item.country.NAME : "N/A" }}</td>
            <td>
              <v-text-field v-model="item.tax" />
            </td>
            <td>
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
        </tbody>
      </v-simple-table>
    </v-card-text>
    <v-card-actions class="justify-end">
      <v-btn small color="primary" @click.prevent="closeModal">
        <v-icon color="white" x-small>mdi-close</v-icon>
        Close
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
export default {
  props: {
    currentItem: {
      required: true,
      type: Object,
    },
  },
  data: () => ({
    title: "Taxes",
    form: {
      brand_id: "",
      country_id: "",
      tax: "",
      brand_rgs_id: "",
    },
    isSave: false,
    isLoading: false,
    items: [],
    errors: [],
    brand: null,
  }),
  computed: {
    modalName() {
      return `${this.title} for ${this.currentItem.name}`;
    },
  },
  watch: {
    brand() {
      if (!this.brand) return;
      this.form.brand_id = this.brand.id;
      this.form.brand_rgs_id = this.brand.brand_rgs_id;
    },
  },
  created() {
    this.loadItems();
  },
  methods: {
    closeModal() {
      this.$root.$emit("clients:close-taxes-modal");
    },
    resetForm() {
      this.form = {
        brand_id: "",
        country_id: "",
        tax: "",
        brand_rgs_id: "",
      };
      this.brand = null;
    },
    async save() {
      this.isSave = true;
      try {
        const { data } = await this.$axios.post("/clients/save-tax", this.form);

        if (data.success) {
          this.toastSuccess(data.message);
          this.resetForm();
          this.loadItems();
        } else {
          this.toastError(data.msg);
        }
      } catch (err) {
        if (err.response.data) {
          this.toastError(err.response.data.message);
          if (err.response.data.errors) {
            this.errors = err.response.data.errors;
          }
        }
      }
      this.isSave = false;
    },
    async loadItems() {
      this.isLoading = true;
      try {
        const { data } = await this.$axios.get("/clients/taxes-list", {
          params: {
            client_id: this.currentItem.id,
          },
        });
        if (data) {
          this.items = data.data;
        }
      } catch (err) {
        console.warn("taxesForm::", err);
      }
      this.isLoading = false;
    },
    async edit(item) {
      try {
        const { data } = await this.$axios.post("/clients/save-tax", item);

        if (data.success) {
          this.toastSuccess(data.message);
        } else {
          this.toastError(data.msg);
        }
      } catch (err) {
        console.warn("saveError", err);
      }
    },
    async deleteItem(ID) {
      this.confirmDelete().then(async (result) => {
        if (result.value) {
          try {
            const { data } = await this.$axios.delete("/clients/delete-tax", {
              params: {
                id: ID,
              },
            });
            if (data.success) {
              this.toastSuccess(data.data.msg);
              this.loadItems();
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