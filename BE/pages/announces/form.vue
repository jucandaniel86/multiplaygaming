<template>
  <v-card>
    <v-card-title>Save Announce</v-card-title>
    <v-card-text style="height: 300px">
      <v-form ref="form" v-model="valid" class="custom-form" lazy-validation>
        <v-text-field
          v-model="form.title"
          :rules="nameRules"
          label="Title"
          required
        ></v-text-field>

        <v-text-field
          v-model="form.subtitle"
          :rules="nameRules"
          label="Subtitle"
          required
        ></v-text-field>

        <v-textarea v-model="form.link" label="Link" rows="3"></v-textarea>

        <v-textarea
          v-model="form.description"
          label="Description"
          rows="3"
        ></v-textarea>

        <v-row>
          <v-col cols="6">
            <v-datetime-picker label="Started At" v-model="form.started_at">
            </v-datetime-picker>
          </v-col>
          <v-col cols="6">
            <v-datetime-picker label="Ended At" v-model="form.ended_at">
            </v-datetime-picker>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="6">
            <v-checkbox
              v-model="form.is_active"
              :label="`Active`"
              :true-value="1"
              :false-value="0"
              :value="1"
            ></v-checkbox>
          </v-col>
        </v-row>
      </v-form>
    </v-card-text>
    <v-card-actions>
      <button
        :disabled="!valid || isLoading"
        color="success"
        class="btn btn-primary"
        type="button"
        @click="validate"
      >
        Save
      </button>
    </v-card-actions>
  </v-card>
</template>
<script>
import moment from "moment";
export default {
  props: {
    currentItem: {
      type: Object | null,
      required: false,
    },
  },
  data: () => ({
    valid: true,
    isLoading: false,
    form: {
      title: "",
      subtitle: "",
      link: "",
      is_active: 1,
      started_at: "",
      ended_at: "",
    },
    nameRules: [(v) => !!v || "Name field is requred"],
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
    resetForm() {
      this.form = {
        title: "",
        subtitle: "",
        link: "",
        is_active: 1,
        started_at: "",
        ended_at: "",
      };
    },
    assignItem() {
      if (
        this.currentItem &&
        typeof this.currentItem === "object" &&
        Object.entries(this.currentItem).length
      ) {
        if (this.currentItem.started_at) {
          this.currentItem.started_at = new Date(this.currentItem.started_at);
        }

        if (this.currentItem.ended_at) {
          this.currentItem.ended_at = new Date(this.currentItem.ended_at);
        }
        this.form = {
          ...this.form,
          ...this.currentItem,
        };
      }
    },
    async validate() {
      const response = this.$refs.form.validate();
      if (response) {
        this.isLoading = true;
        try {
          const { data } = await this.$axios.post("/announces/save", this.form);

          if (data.success) {
            this.toastSuccess(data.message);
            this.$root.$emit("close-modal", {});
            this.$root.$emit("refresh-list", {});
            this.resetForm();
          } else {
            this.toastError(data.msg);
          }
        } catch (err) {
          this.toastError("Something went wrong!");
        }
        this.isLoading = false;
      }
    },
  },
};
</script>
