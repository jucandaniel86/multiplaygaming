<template>
  <v-menu
    ref="menu"
    v-model="menu"
    :close-on-content-click="false"
    transition="scale-transition"
    offset-y
    min-width="auto"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-text-field
        v-model="date"
        :label="label"
        prepend-icon="mdi-calendar"
        readonly
        v-bind="attrs"
        v-on="on"
      ></v-text-field>
    </template>
    <v-date-picker
      v-model="date"
      no-title
      scrollable
      @change="save"
    ></v-date-picker>
  </v-menu>
</template>
<script>
export default {
  props: {
    defaultValue: {
      required: false,
    },
    label: {
      type: String,
      required: false,
      default: "Date",
    },
  },
  data: () => ({
    activePicker: null,
    date: null,
    menu: false,
  }),
  watch: {
    menu(val) {
      val && setTimeout(() => (this.activePicker = "YEAR"));
    },
    defaultValue() {
      this.date = this.defaultValue;
    },
    date() {
      this.$emit("input", this.date);
    },
  },
  methods: {
    save(date) {
      this.$refs.menu.save(date);
    },
  },
};
</script>
