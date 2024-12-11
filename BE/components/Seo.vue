<template>
  <v-card tile>
    <v-card-title class="text-h5 grey lighten-2">
      Aspect in search
    </v-card-title>

    <v-card-text>
      <v-card-subtitle
        >Choose how your article will appear in the results of
        search.</v-card-subtitle
      >
      <v-row>
        <v-col cols="6">
          <v-switch
            v-model="mobileView"
            label="Mobile view"
            color="black"
            value="mobile"
            class="lbl-black"
          ></v-switch>
          <div class="seo-article-preview">
            <google-preview
              :preview-type="mobileView"
              :details="form"
              :main-image="mainImage"
              :focus-element="focusElement"
            />
          </div>
        </v-col>
        <v-col cols="6">
          <v-row>
            <v-col cols="12">
              <div class="form-group">
                <v-text-field
                  v-model="form.meta_title"
                  @keyup="onTitleChanged"
                  @focus="onFocus('meta_title')"
                  label="Meta Title"
                />
                <div class="sp-progress">
                  <div
                    class="sp-progress-bar"
                    role="progressbar"
                    aria-valuemx="100"
                    :style="{ width: `${progress.meta_title}%` }"
                    :aria-valuenow="progress.meta_title"
                  >
                    {{ progress.meta_title }}%
                  </div>
                </div>
                <div class="wrap-seopress-counters">
                  <div :style="{ color: metaTitlePixelErr }">
                    {{ metaTitlePixelLength }}
                  </div>
                  <strong>&nbsp; / {{ maxPixelTitle }}px - &nbsp;</strong>
                  <div :style="{ color: metaTitleErr }">
                    {{ metaTitleLength }}
                  </div>
                  <div>
                    / <strong>{{ maxTitleLength }} &nbsp;</strong>
                  </div>
                  (maximum recommended limit)
                </div>
              </div>
              <v-text-field
                v-model="form.slug"
                :hide-details="true"
                @focus="onFocus('url')"
                @keyup="emitEvent"
                label="Descriptor (url)"
              />

              <v-textarea
                v-model="form.meta_description"
                ref="metaDescription"
                label="Meta description"
                :hide-details="true"
                @keyup="onMetaDescChanged"
                @focus="onFocus('meta_description')"
              ></v-textarea>

              <div class="sp-progress">
                <div
                  class="sp-progress-bar"
                  role="progressbar"
                  aria-valuemx="100"
                  :style="{ width: `${progress.meta_description}%` }"
                  :aria-valuenow="progress.meta_description"
                >
                  {{ progress.meta_description }}%
                </div>
              </div>
              <div class="wrap-seopress-counters">
                <div :style="{ color: metaDescPixelErr }">
                  {{ metaDescPixelLength }}
                </div>
                <strong>&nbsp; / {{ maxPixelDesc }}px - &nbsp;</strong>
                <div :style="{ color: metaDescErr }">
                  {{ metaDescLength }}
                </div>
                <div>
                  / <strong>{{ maxDescriptionLength }} &nbsp;</strong>
                </div>
                (maximum recommended limit)
              </div>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12">
          <div class="d-flex justify-content-center">
            <button-loading
              @on-click="save"
              :is-loading="isSave || saveDisabled"
              :btn-class="'btn-primary py-3 w-100 mb-4'"
              :icon="'fa-save'"
              style="max-width: 200px"
              :text="'Save'"
            />
          </div>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>
<script>
import GooglePreview from "./seo/GooglePreview";

export default {
  name: "SeoModule",
  components: { GooglePreview },
  props: {
    mainImage: {
      type: String,
      required: false,
    },
    saveDisabled: {
      type: Boolean,
      required: true,
      default: false,
    },
    defaultForm: {
      required: true,
    },
  },
  data() {
    return {
      isSave: false,
      focusElement: "",
      maxDescriptionLength: 160,
      maxTitleLength: 60,
      maxPixelTitle: 568,
      maxPixelDesc: 940,
      progress: {
        meta_description: 0,
        meta_title: 0,
      },
      mobileView: "mobile",
      firstLoad: true,
      form: {
        meta_title: "",
        meta_description: "",
        slug: "",
      },
    };
  },

  computed: {
    metaDescErr() {
      let color = "inherit";
      if (
        this.form.meta_description &&
        String(this.form.meta_description).length > this.maxDescriptionLength
      ) {
        color = "red";
      }
      return color;
    },
    metaDescPixelErr() {
      let color = "inherit";
      if (
        this.form.meta_description &&
        this.pixelDesc(this.form.meta_description) > this.maxPixelDesc
      ) {
        color = "red";
      }
      return color;
    },
    metaTitleErr() {
      let color = "inherit";
      if (!this.form.meta_title) return color;
      if (this.form.meta_title.length > this.maxTitleLength) {
        color = "red";
      }
      return color;
    },
    metaTitlePixelErr() {
      let color = "inherit";
      if (this.pixelTitle(this.form.meta_title) > this.maxPixelTitle) {
        color = "red";
      }
      return color;
    },
    metaDescLength() {
      if (
        this.form.meta_description &&
        String(this.form.meta_description).length > 0
      )
        return this.form.meta_description.length;
      return 0;
    },
    metaDescPixelLength() {
      if (
        this.form.meta_description &&
        String(this.form.meta_description).length > 0
      )
        return this.pixelDesc(this.form.meta_description);
      return 0;
    },
    metaTitleLength() {
      if (!this.form.meta_title) return 0;

      if (this.form.meta_title.length > 0) return this.form.meta_title.length;
      return 0;
    },
    metaTitlePixelLength() {
      if (String(this.form.meta_title).length > 0)
        return this.pixelTitle(this.form.meta_title);
      return 0;
    },
  },
  created() {
    if (typeof this.defaultForm !== "undefined") {
      const { meta_title, meta_description, slug } = this.defaultForm;

      this.form = {
        ...this.form,
        meta_title,
        meta_description,
        slug,
      };
    }
  },
  mounted() {
    this.$nextTick(() => {
      this.onMetaDescChanged();
      this.onTitleChanged();
    });
  },
  methods: {
    emitEvent() {
      this.$emit("seo:update", this.form);
    },

    onFocus(element) {
      this.focusElement = element;
    },

    pixelTitle(e) {
      let inputText = e;
      let font = "20px Arial";
      let canvas = document.createElement("canvas");
      let context = canvas.getContext("2d");
      context.font = font;
      let width = context.measureText(inputText).width;
      let formattedWidth = Math.ceil(width);
      return formattedWidth;
    },

    pixelDesc(e) {
      let inputText = e;
      let font = "14px Arial";
      let canvas = document.createElement("canvas");
      let context = canvas.getContext("2d");
      context.font = font;
      let width = context.measureText(inputText).width;
      let formattedWidth = Math.ceil(width);
      return formattedWidth;
    },

    onMetaDescChanged() {
      let val = this.form.meta_description;
      let progress = Math.round(
        (this.pixelDesc(val) / this.maxPixelDesc) * 100
      );

      if (progress >= 100) {
        progress = 100;
      }

      this.progress.meta_description = progress;
      this.emitEvent();
    },

    onTitleChanged() {
      let val = this.form.meta_title;

      let progress = Math.round(
        (this.pixelTitle(val) / this.maxPixelTitle) * 100
      );

      if (progress >= 100) {
        progress = 100;
      }

      this.progress.meta_title = progress;
      this.emitEvent();
    },

    save() {
      this.$emit("seo:save", this.form);
    },
  },
};
</script>
<style scoped>
.h-10 {
  height: 10px;
}
.seo-article-preview {
  margin-bottom: 1rem;
}
.sp-progress {
  display: flex;
  height: 1rem;
  overflow: hidden;
  font-size: 0.75rem;
  background-color: #e9ecef;
  border-radius: 0.25rem 0.25rem 0 0;
}
.sp-progress-bar {
  background-color: #2271b1;
  display: flex;
  flex-direction: column;
  justify-content: center;
  color: #fff;
  text-align: center;
  white-space: nowrap;
  transition: width 0.6s ease;
}
.wrap-seopress-counters {
  text-align: right;
  background: #e9ecef;
  padding: 2px 5px;
  display: flex;
  font-size: 12px;
  justify-content: flex-end;
  border-radius: 0 0 0.25rem 0.25rem;
  font-feature-settings: "tnum";
  font-variant-numeric: tabular-nums;
}
.wrap-seopress-counters > div {
  display: inline-block;
}
.form-control {
  background: #fff;
  border-radius: 0;
}
.form-control:focus {
  box-shadow: none;
}
.form-group {
  margin: 0.5rem 0;
}
</style>

