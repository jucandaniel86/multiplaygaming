<template>
  <SharedCardHeader :title="title">
    <template v-slot:content>
      <div class="pa-2">
        <v-text-field
          v-model="form.name"
          label="Client Commercial name"
          required
        ></v-text-field>
        <v-text-field
          v-model="form.legal_name"
          label="Legal name"
          required
        ></v-text-field>
        <v-text-field
          v-model="form.bet_limits"
          label="Bet limits"
          required
        ></v-text-field>
        <v-text-field
          v-model="form.client_rgs_id"
          label="Client RGS ID"
          required
        ></v-text-field>
        <v-select
          v-model="form.rev_share"
          :items="['GGR', 'NGR']"
          label="Rev Share model"
        ></v-select>

        <selector-currency
          v-model="form.currencies"
          :default-value="form.currencies"
          :displayExchangeButton="false"
          :multiple="true"
        />
      </div>
    </template>
    <template v-slot:footer>
      <div class="d-flex justify-center align-center">
        <button-loading
          :is-loading="isLoading"
          :icon="'fa-save'"
          style="max-width: 200px"
          :text="'Save'"
          @on-click="save"
        />
      </div>
    </template>
  </SharedCardHeader>
</template>
<script>
import ButtonLoading from "../../components/ButtonLoading.vue";
export default {
  components: { ButtonLoading },
  props: {
    currentItem: {
      type: Object | null,
      required: false,
    },
  },
  data: () => ({
    valid: true,
    isLoading: false,
    title: "Save Client",
    form: {
      name: "",
      legal_name: "",
      regulated: 0,
      rev_share: "GGR",
      tax: "",
      bet_limits: "",
      client_rgs_id: "",
      currencies: [],
    },
  }),
  watch: {
    currentItem() {
      this.assignItem();
    },
  },
  created() {
    this.assignItem();
  },
  methods: {
    assignItem() {
      if (
        this.currentItem &&
        typeof this.currentItem === "object" &&
        Object.entries(this.currentItem).length
      ) {
        this.form = {
          ...this.form,
          ...this.currentItem,
        };
        this.form.currencies = this.currentItem.clientCurrencies;
      }
    },
    async save() {
      this.isLoading = true;
      try {
        const { data } = await this.$axios.post("/clients/save", this.form);

        if (data.success) {
          this.toastSuccess(data.message);
          this.$root.$emit("clients:close-modal", {});
          this.$root.$emit("clients:refresh-list", {});
        } else {
          this.toastError(data.msg);
        }
      } catch (err) {
        this.toastError("Something went wrong!");
      }
      this.isLoading = false;
    },
  },
};
</script>
