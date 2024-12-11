<template>
  <div>
    <modal
      :name="key"
      :height="'auto'"
      :maxWidth="600"
      width="100%"
      :scrollable="false"
      :adaptive="true"
      :styles="{ overflow: 'visible' }"
      :key="key"
    >
      <v-card>
        <v-card-text>
          <v-img
            :src="
              imagePreview
                ? imagePreview
                : `https://via.assets.so/img.jpg?w=${imgSizes.w}&h=${imgSizes.h}&tc=blue&bg=#cecece`
            "
            lazy-src="https://picsum.photos/id/11/10/6"
            height="30vh"
          ></v-img>
          <v-file-input
            v-model="image"
            accept="image/*"
            placeholder="Pick an image"
            prepend-icon="mdi-camera"
            @change="selectImage"
            @click:clear="clearImagePreview()"
            label="Image"
          ></v-file-input>
          <v-alert
            v-if="imgSizes.w > 0 && imgSizes.h"
            border="bottom"
            colored-border
            type="warning"
            elevation="2"
          >
            <p>
              Accepted sizes: <b>{{ imgSizes.w }}px</b> X <b>{{ imgSizes.h }}</b
              >, aspect ratio
              <b>{{ roundRatio(imgSizes.w / imgSizes.h) }}</b>
            </p>
          </v-alert>
        </v-card-text>
        <v-card-actions>
          <v-btn @click.prevent="onSave()" :disabled="!imagePreview">
            <v-icon>mdi-content-save</v-icon>
            Save
          </v-btn>
          <v-btn @click.prevent="closeModal">
            <v-icon>mdi-close-thick</v-icon>
            Close
          </v-btn>
        </v-card-actions>
      </v-card>
    </modal>
    <v-btn small @click.prevent="openModal">
      <v-icon>mdi-image-album</v-icon>
      <span>{{ label }}</span>
    </v-btn>
  </div>
</template>
<script>
export default {
  props: {
    imgSizes: {
      type: Object,
      required: false,
      default: () => ({
        w: 100,
        h: 100,
      }),
    },
    label: {
      required: false,
      type: String,
      default: "Add Photo",
    },
    onSaveFunction: {
      required: false,
      type: Function,
      default: () => {},
    },
  },
  data: () => ({
    imagePreview: "",
    image: [],
    key: "",
  }),
  created() {
    this.randomKey();
  },
  methods: {
    randomKey() {
      this.key = `Photo_${new Date().getTime()}`;
    },
    roundRatio(num) {
      return Math.round((num + Number.EPSILON) * 100) / 100;
    },
    openModal() {
      this.$modal.show(this.key);
    },
    closeModal() {
      this.$modal.hide(this.key);
      this.clearImagePreview();
      this.image = [];
    },
    onSave() {
      this.$emit("photo:save", this.image);
      this.closeModal();
    },
    async selectImage(e) {
      const file = e;

      if (!file) return;

      const readData = (f) =>
        new Promise((resolve) => {
          const reader = new FileReader();
          reader.onloadend = () => resolve(reader.result);
          reader.readAsDataURL(f);
        });

      const data = await readData(file);
      this.imagePreview = data;
    },

    async clearImagePreview() {
      this.imagePreview = "";
    },
  },
};
</script>
