<template>
  <div class="text-center pa-2">
    <v-menu
      v-model="menu"
      :close-on-content-click="false"
      :nudge-width="200"
      offset-x
      style="z-index: 100"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn icon v-bind="attrs" v-on="on">
          <v-icon>mdi-order-bool-ascending-variant</v-icon>
        </v-btn>
      </template>

      <v-card class="pa-2">
        <v-card-actions>
          <v-select
            v-model="form.priority"
            label="Priority"
            :items="[
              { id: 1, label: 1 },
              { id: 2, label: 2 },
              { id: 3, label: 3 },
            ]"
            item-text="label"
            item-value="id"
          ></v-select>

          <v-spacer></v-spacer>

          <v-btn text @click="menu = false"> Cancel </v-btn>
          <v-btn color="primary" text @click="save"> Save </v-btn>
        </v-card-actions>
      </v-card>
    </v-menu>
  </div>
</template>
<script>
export default {
  name: "EditPartner",
  props: {
    partner: {
      type: Object,
      required: true,
    },
  },
  data: () => ({
    menu: false,
    form: {
      id: 0,
      priority: null,
    },
  }),
  created() {
    this.form = {
      ...this.form,
      id: this.partner.id,
      priority: this.partner.priority,
    };
  },
  methods: {
    async save() {
      if (!this.form.id) return false;
      try {
        const { data } = await this.$axios.post(
          "/partners/priority",
          this.form
        );

        if (data.success) {
          this.toastSuccess(data.message);
          this.menu = false;
          this.$root.$emit("partners:refresh-list");
        }
      } catch (err) {
        console.warn("[GameCreate::Err]", err);
      }
    },
  },
};
</script>
