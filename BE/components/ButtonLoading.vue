<template>
  <v-btn :disabled="isLoading" @click.prevent="actionClick" color="color">
    <i class="fa" :class="iconClass" />
    {{ text }}
  </v-btn>
</template>
<script>
export default {
  props: {
    isLoading: {
      type: Boolean,
      required: false,
      default: false,
    },
    icon: {
      type: String,
      required: false,
      default: "",
    },
    text: {
      type: String,
      required: true,
    },
    color: {
      type: String,
      required: false,
      default: "primary",
    },
  },
  data() {
    return {
      iconClass: [],
    };
  },
  created() {
    this.getIconClass();
  },
  watch: {
    isLoading() {
      this.getIconClass();
    },
  },
  methods: {
    actionClick() {
      this.$emit("on-click");
    },
    getIconClass() {
      let _classes = ["fa"];
      if (this.isLoading) {
        _classes.push("fa-spinner fa-spin");
      } else {
        _classes.push(this.icon);
      }
      this.iconClass = _classes;
    },
  },
};
</script>
