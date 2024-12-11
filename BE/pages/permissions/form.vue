<template>
  <SharedCardHeader :title="title">
    <template v-slot:content>
      <v-text-field v-model="form.name" label="Name" required></v-text-field>
      <selector-permission-categories
        v-model="form.category_id"
        :default-value="form.category_id"
      />
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
    title: "Save Permission",
    form: {
      name: "",
      category_id: 0,
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
      }
    },
    async save() {
      this.isLoading = true;
      try {
        const { data } = await this.$axios.post("/permissions/save", this.form);

        if (data.success) {
          this.toastSuccess(data.message);
          this.$root.$emit("close-modal", {});
          this.$root.$emit("refresh-list", {});
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
