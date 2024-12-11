<template>
  <div class="form-group" style="margin-bottom: 8px">
    <label v-if="label">{{ label }}</label>
    <wysiwyg v-model="content" style="color: #fff" :height="600" />
  </div>
</template>
<script>
export default {
  props: {
    label: {
      type: String,
      required: false,
      default: null,
    },
    defaultValue: {
      type: String,
      required: false,
    },
    minHeight: {
      type: Number,
      required: false,
      default: 500,
    },
  },
  data: () => ({
    content: "",
    // editor: ClassicEditor,
    editorModel: null,
    editorConfig: {
      image: {
        uploadURL: "http://api-affiliates.parfum.casa/api/v1/images/upload",
        dropzoneOptions: {},
      },
    },
  }),
  watch: {
    content() {
      this.$emit("input", this.content);
    },
    defaultValue() {
      this.content = this.defaultValue;
    },
  },
  created() {
    this.content = this.defaultValue;
  },
};
</script>
<style>
@import "./editor/editorStyles.css";
.v-messages__message {
  border: 1px solid #ff9800 !important;
  color: #ff9800 !important;
  padding: 0.3rem;
  margin-bottom: 0.5rem;
}
</style>
