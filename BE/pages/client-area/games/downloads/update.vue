<template>
  <div class="text-center pa-2">
    <v-menu
      v-model="menu"
      :close-on-content-click="false"
      :nudge-width="200"
      offset-x
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="primary" x-small v-bind="attrs" v-on="on">
          <i class="fa fa-pencil-alt"></i>
        </v-btn>
      </template>

      <v-card>
        <v-list>
          <v-list-item>
            <v-list-item-action>
              <v-text-field v-model="form.name" label="Name" />
            </v-list-item-action>
          </v-list-item>
          <v-list-item>
            <v-list-item-action>
              <v-checkbox
                v-model="form.is_certificate"
                :false-value="0"
                :true-value="1"
                :value="1"
                label="Certificate"
              />
            </v-list-item-action>
          </v-list-item>
          <v-list-item v-if="form.is_certificate">
            <v-list-item-action>
              <selector-jurisdiction v-model="form.jurisdiction_id" />
            </v-list-item-action>
          </v-list-item>
        </v-list>

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
  name: "EditUpload",
  props: {
    item: {
      type: Object,
      required: true,
    },
  },
  data: () => ({
    menu: false,
    form: {
      id: 0,
      name: "",
      is_certificate: 0,
      jurisdiction_id: 0,
      is_media_pack: 0,
    },
  }),
  watch: {
    item() {
      this.form = {
        ...this.form,
        id: this.item.id,
        name: this.item.name,
        is_certificate: this.item.is_certificate,
        jurisdiction_id: this.item.jurisdiction_id,
      };
    },
  },
  created() {
    this.form = {
      ...this.form,
      id: this.item.id,
      name: this.item.name,
      is_certificate: this.item.is_certificate,
      jurisdiction_id: this.item.jurisdiction_id,
    };
  },
  methods: {
    async save() {
      if (!this.form.id) return false;
      try {
        const { data } = await this.$axios.post("/games/upload-download", {
          ...this.form,
        });

        if (data.success) {
          this.toastSuccess(data.message);
          this.$root.$emit("downloads:update-item");
          this.menu = false;
        }
      } catch (err) {
        console.warn("[GameCreate::Err]", err);
      }
    },
  },
};
</script>
