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
          <v-icon>mdi-link-edit</v-icon>
        </v-btn>
      </template>

      <v-card class="pa-2">
        <v-text-field
          v-model="form.name"
          label="Title"
          hide-details
        ></v-text-field>

        <v-textarea
          v-model="form.description"
          label="Text"
          rows="3"
        ></v-textarea>

        <v-textarea
          v-model="form.external_url"
          label="Link"
          rows="3"
        ></v-textarea>

        <v-file-input v-model="form.slide_file" label="Slider File" />

        <v-checkbox
          v-model="form.is_active"
          label="Active"
          :true-value="1"
          :false-value="0"
        />

        <v-card-actions>
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
    banner: {
      type: Object,
      required: true,
    },
  },
  data: () => ({
    menu: false,
    form: {
      name: "",
      external_url: "",
      description: "",
      is_active: 1,
      slide_file: [],
    },
  }),
  created() {
    this.form = {
      ...this.form,
      ...this.banner,
    };
    this.form.slide_file = [];
  },
  methods: {
    async save() {
      if (!this.form.id) return false;
      try {
        const frmData = new FormData();

        Object.entries(this.form).forEach((e) => {
          frmData.append(e[0], e[1]);
        });

        const { data } = await this.$axios.post("/banners/save", frmData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });

        if (data.success) {
          this.toastSuccess(data.message);
          this.menu = false;
          this.$root.$emit("banners:refresh-list", {});
        }
      } catch (err) {
        console.warn("[PartnersUpdate::Err]", err);
      }
    },
  },
};
</script>
