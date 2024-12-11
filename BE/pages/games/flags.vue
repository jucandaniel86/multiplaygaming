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
          Edit Flags
        </v-btn>
      </template>

      <v-card>
        <v-list>
          <v-list-item>
            <v-list-item-action>
              <v-checkbox
                :hide-details="true"
                v-model="form.featured_game"
                :value="1"
                :true-value="1"
                :false-value="0"
                label="Featured Game"
              />
            </v-list-item-action>
          </v-list-item>
          <v-list-item>
            <v-list-item-action>
              <v-checkbox
                :hide-details="true"
                v-model="form.is_branded"
                :value="1"
                :true-value="1"
                :false-value="0"
                label="Branded"
              />
            </v-list-item-action>
          </v-list-item>
          <v-list-item>
            <v-list-item-action>
              <v-checkbox
                :hide-details="true"
                v-model="form.is_coming_soon"
                :value="1"
                :true-value="1"
                :false-value="0"
                label="Coming Soon"
              />
            </v-list-item-action>
          </v-list-item>
          <v-list-item>
            <v-list-item-action>
              <v-checkbox
                :hide-details="true"
                v-model="form.homepage_slider"
                :value="1"
                :true-value="1"
                :false-value="0"
                label="HP Carousel"
              />
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
  name: "GameFlags",
  props: {
    game: {
      type: Object,
      required: true,
    },
  },
  data: () => ({
    menu: false,
    form: {
      id: 0,
      is_branded: 0,
      featured_game: 0,
      is_coming_soon: 0,
      homepage_slider: 0,
    },
  }),
  watch: {
    game() {
      this.form = {
        ...this.form,
        id: this.game.id,
        is_branded: this.game.is_branded,
        featured_game: this.game.featured_game,
        is_coming_soon: this.game.is_coming_soon,
        homepage_slider: this.game.homepage_slider,
      };
    },
  },
  created() {
    this.form = {
      ...this.form,
      id: this.game.id,
      is_branded: this.game.is_branded,
      featured_game: this.game.featured_game,
      is_coming_soon: this.game.is_coming_soon,
      homepage_slider: this.game.homepage_slider,
    };
  },
  methods: {
    async save() {
      if (!this.form.id) return false;
      try {
        const { data } = await this.$axios.post("/games/update", {
          ...this.form,
        });

        if (data.success) {
          this.toastSuccess(data.message);
          this.$root.$emit("games:edit-flags");
          this.menu = false;
        }
      } catch (err) {
        console.warn("[GameCreate::Err]", err);
      }
    },
  },
};
</script>
