<template>
  <v-row>
    <v-col cols="12">
      <div class="bg-light rounded h-100 p-4">
        <SharedPageHeader :title="title" />

        <SharedCardHeader :title="'Brand Assets'">
          <template v-slot:header>
            <v-progress-linear indeterminate v-if="isLoading" />
          </template>
          <template v-slot:content>
            <v-text-field
              v-model="form.brand_assets_name"
              label="Title"
              :disabled="isLoading"
            />
            <v-textarea
              v-model="form.brand_assets_link"
              label="Link"
              :disabled="isLoading"
            />
          </template>
        </SharedCardHeader>

        <SharedCardHeader :title="'General Game Assets'">
          <template v-slot:content>
            <v-text-field
              v-model="form.game_assets_name"
              label="Title"
              :disabled="isLoading"
            />
            <v-textarea
              v-model="form.game_assets_link"
              label="Link"
              :disabled="isLoading"
            />
          </template>
        </SharedCardHeader>

        <SharedCardHeader :title="'Promo media pack Assets'">
          <template v-slot:content>
            <v-text-field
              v-model="form.promo_assets_name"
              label="Title"
              :disabled="isLoading"
            />
            <v-textarea
              v-model="form.promo_assets_link"
              label="Link"
              :disabled="isLoading"
            />
          </template>
        </SharedCardHeader>

        <div class="d-flex justify-center">
          <button-loading
            @on-click="save"
            :is-loading="isSave"
            :btn-class="'btn-primary py-3 w-100 mb-4'"
            :icon="'fa-save'"
            style="max-width: 200px"
            :text="'Save'"
          />
        </div>
      </div>
    </v-col>
  </v-row>
</template>
<script>
export default {
  name: "BrandAssets",
  layout: "backend",
  middleware: ["auth"],
  data: () => ({
    title: "Brand Assets",
    isSave: false,
    isLoading: false,
    form: {
      brand_assets_name: "",
      brand_assets_link: "",
      game_assets_name: "",
      game_assets_link: "",
      promo_assets_name: "",
      promo_assets_link: "",
    },
  }),
  async created() {
    await this.getDetails();
  },
  methods: {
    async save() {
      this.isSave = true;
      try {
        let savedOptions = [];
        Object.keys(this.form).forEach((el) => {
          savedOptions.push({
            option_name: el,
            option_value: this.form[el],
          });
        });
        const { data } = await this.$axios.post("/client-area/save", {
          options: savedOptions,
        });

        if (data.success) {
          this.toastSuccess(data.message);
        } else {
          this.toastError(data.msg);
        }
      } catch (err) {
        console.log("Brand Assets err::", err);
        this.toastError("Something went wrong!");
      }
      this.isSave = false;
    },
    async getDetails() {
      this.isLoading = true;
      try {
        const { data } = await this.$axios.get("/client-area/options");
        if (data.data) {
          data.data.forEach((el) => {
            this.form[el.option_name] = el.option_value;
          });
        }
      } catch (err) {
        console.log("Brand Assets err::", err);
      }
      this.isLoading = false;
    },
  },
};
</script>
