<template>
  <div :class="`seo-snippet-preview__${previewClass}`" v-if="details">
    <div
      class="seo-snippet-preview__top"
      :class="{ active: focusElement === 'url' }"
    >
      <div class="_container">
        <div class="logo" v-if="website.thumbnail">
          <img :src="website.thumbnail" />
        </div>
        <span :class="`website-info__${previewClass}`">
          <div class="domain">{{ website.name }}</div>
          <span class="root">{{ website.domain }}</span>
          <span class="link">› {{ details.slug }}</span>
          <span class="dots" v-if="previewClass === 'desktop'">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              fill="#70757a"
              style="width: 18px"
            >
              <path
                d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"
              ></path>
            </svg>
          </span>
        </span>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          fill="#70757a"
          style="width: 18px"
          v-if="previewType === 'mobile'"
        >
          <path
            d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"
          ></path>
        </svg>
      </div>
    </div>
    <!-- /preview top -->

    <div
      class="seo-snippet-preview__middle"
      :class="{
        active: focusElement === 'meta_title',
        mb_12: previewClass === 'mobile',
      }"
    >
      <div :class="`title__${previewClass}`">
        <span>{{ details.meta_title }}</span>
      </div>
    </div>
    <div>
      <div
        class="seo-article-content__container"
        :class="{ active: focusElement === 'meta_description' }"
      >
        <div class="wrapper">
          <div class="img" v-if="previewClass === 'mobile'">
            <img v-if="mainImage" :src="mainImage" alt="" />
          </div>
          <span class="seo-grey">{{ getCurrentDate() }} － </span>
          {{ details.meta_description }}
        </div>
        <div v-if="previewClass === 'desktop'" class="desktop_view_more">
          Scroll to see preview content.
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import moment from "moment";
export default {
  name: "DescktopArticleView",
  props: {
    previewType: {
      type: String | null,
      required: true,
    },
    details: {
      type: Object,
      required: true,
    },
    focusElement: {
      type: String,
      required: false,
      default: "",
    },
    mainImage: {
      type: String,
      required: false,
      default: "",
    },
  },
  data: () => ({
    focusItem: "",
  }),
  computed: {
    previewClass() {
      return this.previewType === "mobile" ? "mobile" : "desktop";
    },
    website() {
      return {
        domain: this.$config.FRONTEND_ENDPOINT,
        name: this.$config.APP_NAME,
      };
    },
  },
  methods: {
    getCurrentDate() {
      return moment().format("MMM. D, YYYY");
    },
  },
};
</script>
<style scoped>
@import url("./style.css");
</style>
