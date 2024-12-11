<template>
  <div class="container-fluid pt-4 px-4">
    <div class="row g-4">
      <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">{{ pageTitle }}</h6>
            <div>
              <button
                class="btn btn-primary"
                style="margin-left: 0.5rem"
                @click="goBack"
              >
                Go back to list
              </button>
            </div>
          </div>
          <!-- d-flex align-items-center justify-content-between mb-4 -->

          <v-row>
            <v-col cols="9">
              <SharedCardHeader :title="'General Settings'">
                <template v-slot:content>
                  <v-text-field
                    v-model="form.title"
                    :counter="true"
                    @blur="createArticle"
                    label="Title"
                  />
                  <v-text-field
                    v-model="form.short_title"
                    :counter="true"
                    @blur="createArticle"
                    label="Short Title"
                  />
                  <div
                    class="v-messages theme--light"
                    role="alert"
                    v-if="form.slug"
                  >
                    <div class="v-messages__wrapper">
                      <div
                        class="v-messages__message message-transition-enter-to"
                      >
                        Article URL:
                        <a
                          :href="`${$config.FRONTEND_ENDPOINT}/articles/${form.slug}/${form.id}`"
                          target="_blank"
                          >{{
                            `${$config.FRONTEND_ENDPOINT}/articles/${form.slug}/${form.id}`
                          }}</a
                        >
                      </div>
                    </div>
                  </div>

                  <app-texteditor
                    :label="'Short Content'"
                    v-model="form.short_content"
                    :default-value="form.short_content"
                  />
                  <app-texteditor
                    :label="'Content'"
                    v-model="form.content"
                    :default-value="form.content"
                    :height="600"
                  />
                  <selector-date
                    v-model="form.published_date"
                    :default-value="form.published_date"
                    :label="'Publish Date'"
                  />
                  <v-checkbox
                    v-model="form.is_highlighted"
                    label="Highlighted"
                    :true-value="1"
                    :false-value="0"
                  ></v-checkbox>
                </template>
              </SharedCardHeader>

              <SharedCardHeader :title="'SEO'" v-if="!actionsDisabled">
                <template v-slot:content>
                  <seo
                    :main-image="form.thumbnail"
                    :save-disabled="actionsDisabled"
                    :default-form="form"
                    @seo:update="onSeoUpdate"
                    @seo:save="saveSeo"
                  />
                </template>
              </SharedCardHeader>

              <SharedCardHeader :title="'Banner'" v-if="!actionsDisabled">
                <template v-slot:content>
                  <v-img
                    v-if="form.banner"
                    :src="
                      form.banner
                        ? form.banner
                        : `https://via.assets.so/img.jpg?w=${sizes.banner.w}&h=${sizes.banner.h}&tc=blue&bg=#cccccc`
                    "
                    lazy-src="https://picsum.photos/id/11/10/6"
                    height="30vh"
                  >
                  </v-img>
                </template>
                <template v-slot:footer>
                  <div class="d-flex justify-center pa-2">
                    <selector-image
                      @photo:save="saveBanner"
                      :img-sizes="sizes.banner"
                      :key="'BannerSelector'"
                    />
                  </div>
                </template>
              </SharedCardHeader>
            </v-col>
            <v-col cols="3">
              <!-- save options -->
              <div class="sticky-top">
                <SharedCardHeader :title="'Save Options'">
                  <template v-slot:content>
                    <v-row v-if="!actionsDisabled">
                      <v-col cols="12">
                        <v-chip small class="mb-1"
                          >Created at: {{ formatDate(form.created_at) }}</v-chip
                        >

                        <v-chip small class="mb-1"
                          >Status: <b>{{ form.article_status }}</b></v-chip
                        >
                        <v-chip small
                          >Article Type: <b>{{ form.article_type }}</b></v-chip
                        >
                      </v-col>
                    </v-row>

                    <v-row v-if="!actionsDisabled">
                      <v-col cols="12">
                        <v-btn
                          small
                          text
                          color="red"
                          @click.prevent="deleteItem"
                        >
                          <v-icon color="red">mdi-delete-alert</v-icon>
                          Delete
                        </v-btn>
                      </v-col>
                    </v-row>
                    <v-row v-if="!actionsDisabled">
                      <v-col cols="12">
                        <div
                          class="d-flex justify-between align-center pt-2 pb-2 gap-2"
                        >
                          <v-btn
                            small
                            color="green"
                            @click.prevent="saveStatus('published')"
                          >
                            <v-icon color="white">mdi-publish</v-icon>
                            Publish
                          </v-btn>
                          <v-btn
                            small
                            color="yellow"
                            @click.prevent="saveStatus('private')"
                          >
                            <v-icon color="white">mdi-publish-off</v-icon>
                            Private
                          </v-btn>
                        </div>
                      </v-col>
                    </v-row>
                  </template>
                  <template v-slot:footer>
                    <button-loading
                      v-if="!actionsDisabled"
                      @on-click="save"
                      :is-loading="isSaveLoading"
                      :btn-class="'btn-primary py-3 w-100 mb-4'"
                      :icon="'fa-save'"
                      style="max-width: 100%"
                      :text="'General Save'"
                    />
                  </template>
                </SharedCardHeader>

                <SharedCardHeader :title="'Category'">
                  <template v-slot:content>
                    <selector-article-categories
                      v-model="form.category_id"
                      :default-value="form.category_id"
                      :key="`Category${newCategoryID}`"
                    />
                    <v-btn
                      text
                      @click.prevent="isCategoryOpen = !isCategoryOpen"
                    >
                      <v-icon>add</v-icon>
                      Add new category
                    </v-btn>
                    <div
                      v-if="isCategoryOpen"
                      class="d-flex justify-content-center align-center"
                    >
                      <v-text-field v-model="category.name" />
                      <v-btn
                        small
                        :disabled="isCategoryLoading"
                        @click.prevent="saveCategory"
                        >Save</v-btn
                      >
                    </div>
                  </template>
                </SharedCardHeader>

                <SharedCardHeader :title="'Thumbnail'" v-if="!actionsDisabled">
                  <template v-slot:content>
                    <v-img
                      v-if="form.thumbnail"
                      :src="
                        form.thumbnail
                          ? form.thumbnail
                          : `https://via.assets.so/img.jpg?w=${sizes.thumbnail.w}&h=${sizes.thumbnail.h}&tc=blue&bg=#cccccc`
                      "
                      lazy-src="https://picsum.photos/id/11/10/6"
                      height="30vh"
                    >
                    </v-img>
                  </template>
                  <template v-slot:footer>
                    <div class="d-flex justify-center pa-2">
                      <selector-image
                        @photo:save="saveThumbnail"
                        :img-sizes="sizes.thumbnail"
                        :key="'ThumbnailSelector'"
                      />
                    </div>
                  </template>
                </SharedCardHeader>
              </div>
            </v-col>
          </v-row>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import moment from "moment";
import Seo from "../Seo.vue";

export default {
  name: "ArticlesForm",
  components: { Seo },
  props: {
    pageTitle: {
      type: String,
      required: false,
      default: "Undefined Title",
    },
    defaultForm: {
      type: Object | null,
      required: true,
    },
  },
  data() {
    return {
      sizes: {
        thumbnail: {
          w: 628,
          h: 486,
        },
        banner: {
          w: 1397,
          h: 574,
        },
      },
      actionsDisabled: true,
      item: null,
      isLoading: false,
      isSaveLoading: false,
      isCategoryOpen: false,
      isCategoryLoading: false,
      newCategoryID: "",
      category: {
        name: "",
      },
      form: {
        id: 0,
        title: "",
        short_title: "",
        category_id: 0,
        slug: "",
        short_content: "",
        content: "",
        published_date: "",
        meta_title: "",
        meta_description: "",
        is_highlighted: 0,
        thumbnail: "",
        banner: "",
      },
    };
  },
  watch: {
    "form.id"() {
      if (this.form.id > 0) {
        this.actionsDisabled = false;
      } else {
        this.actionsDisabled = true;
      }
    },
    defaultForm() {
      this.form = {
        ...this.form,
        ...this.defaultForm,
      };
    },
  },

  created() {
    if (this.defaultForm) {
      this.form = {
        ...this.form,
        ...this.defaultForm,
      };
    }
  },

  methods: {
    goBack() {
      this.$emit("articles:back");
    },

    onSeoUpdate(form) {
      this.form = { ...this.form, ...form };
    },

    async saveSeo() {
      if (!this.form.id) return false;
      try {
        const { data } = await this.$axios.post("/articles/update", {
          meta_title: this.form.meta_title,
          meta_description: this.form.meta_description,
          slug: this.form.slug,
          id: this.form.id,
        });

        if (data.success) {
          this.toastSuccess(data.message);
        }
      } catch (err) {
        console.warn("[GameCreate::Err]", err);
      }
    },

    async saveStatus(_status) {
      if (!this.form.id) return false;
      try {
        const { data } = await this.$axios.post("/articles/update", {
          ...this.form,
          article_status: _status,
          id: this.form.id,
        });

        if (data.success) {
          this.toastSuccess(data.message);
          this.$router.push({
            name: "articles-edit-id",
            params: { id: this.form.id },
          });
        }
        //@todo :: redirect to games edit
      } catch (err) {
        console.warn("[GameCreate::Err]", err);
      }
    },

    async saveCategory() {
      if (this.category.name === "") return false;

      this.isCategoryLoading = true;
      try {
        const { data } = await this.$axios.post(
          "/article-categories/save",
          this.category
        );
        if (data.success) {
          this.form.category_id = data.data.id;
          this.category.name = "";
          this.isCategoryOpen = false;
          this.$root.$emit("categoies:save-category");
        } else {
          this.toastError("Something went wrong!");
        }
      } catch (err) {
        console.warn("[ArticlesController::Err]", err);
        this.toastError("Something went wrong!");
      }
      this.isCategoryLoading = false;
    },

    async saveThumbnail(_input) {
      await this.savePhoto(_input, "thumbnail_url", "thumbnail");
    },

    async saveBanner(_input) {
      await this.savePhoto(_input, "banner_url", "banner");
    },

    async savePhoto(_input, _column, _displayedColumn) {
      try {
        var formData = new FormData();

        formData.append("file", _input);
        formData.append("id", this.form.id);
        formData.append("table", "articles");
        formData.append("column", _column);

        const { data } = await this.$axios.post("/photo-uploader", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });

        if (data.success) {
          this.toastSuccess(data.message);
          this.form[_displayedColumn] = data.data.file;
          this.$forceUpdate();
        } else {
          this.toastError(data.message);
        }
      } catch (err) {
        console.warn("[GameGallery]", err);
      }
    },

    async createArticle() {
      if (this.form.id !== 0 || this.form.game_name === "") return false;
      try {
        const { data } = await this.$axios.post("/articles/create", {
          title: this.form.title,
          article_type: this.$route.query.article_type,
        });
        if (data.success) {
          this.form = {
            ...data.data,
          };
          if (typeof data.message !== "undefined") {
            this.toastSuccess(data.message);
          }
        }
      } catch (err) {
        console.warn("[GameCreate::Err]", err);
      }
    },

    async save() {
      this.isSaveLoading = true;
      try {
        const { data } = await this.$axios.post("/articles/update", {
          ...this.form,
        });

        if (data.success) {
          this.toastSuccess(data.message);
        } else {
          this.toastError(data.message);
        }
      } catch (err) {
        this.axiosErrorAlert(err);
      }
      this.isSaveLoading = false;
    },

    formatDate(date) {
      return moment(date).format("DD MM YYYY hh:mm:ss");
    },

    async deleteItem() {
      const ID = this.form.id;
      this.confirmDelete().then(async (result) => {
        if (result.value) {
          try {
            const { data } = await this.$axios.delete("/articles/delete", {
              params: {
                id: ID,
              },
            });
            if (data.success) {
              this.toastSuccess(data.message);
              this.goBack();
            } else {
              this.toastError(data.message || "Something went wrong!");
            }
          } catch (err) {
            this.toastError("Something went wrong!");
          }
        }
      });
    },
  },
};
</script>
