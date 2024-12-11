<template>
  <v-row>
    <v-col cols="12">
      <div class="bg-light rounded h-100 p-4">
        <SharedPageHeader :title="'Articles'">
          <template v-slot:content>
            <div class="text-center">
              <v-menu offset-y>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    v-can="'articles_add'"
                    color="primary"
                    dark
                    v-bind="attrs"
                    v-on="on"
                  >
                    Add new
                  </v-btn>
                </template>
                <v-list>
                  <v-list-item
                    v-for="(_type, i) in article_types"
                    :key="`ArticleTab${i}`"
                    :link="true"
                    @click.prevent="add(_type.id)"
                  >
                    <v-list-item-title>{{ _type.label }}</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
            </div>
          </template>
        </SharedPageHeader>

        <v-data-table
          :headers="headers"
          :items="items"
          :options.sync="options"
          :server-items-length="totalItems"
          :loading="loading"
          :search="searchText"
          class="pa-2"
          :height="550"
        >
          <template v-slot:top>
            <v-tabs v-if="article_types.length">
              <v-tab
                v-for="(_type, i) in article_types"
                :key="`ArticleType${i}`"
                @click.prevent="changeTab(_type.id)"
                >{{ _type.label }}</v-tab
              >
            </v-tabs>
            <v-row class="align-center">
              <v-col cols="3">
                <v-text-field
                  v-model="formSearch.title"
                  label="Search"
                  chips
                ></v-text-field>
              </v-col>
              <v-col cols="3">
                <selector-article-categories
                  v-model="formSearch.category_id"
                  :default-value="formSearch.category_id"
                  :key="`FilterCategory`"
                />
              </v-col>

              <v-col cols="2">
                <selector-status
                  v-model="formSearch.article_status"
                  :default-value="formSearch.article_status"
                />
              </v-col>
              <v-col cols="2">
                <button-loading
                  @on-click="getDataFromApi"
                  :is-loading="loading"
                  :btn-class="'btn-primary w-100 mb-4'"
                  :icon="'fa-search'"
                  :text="'Filter'"
                />
              </v-col>
            </v-row>
          </template>

          <template v-slot:item="{ item }">
            <tr>
              <td>{{ item.id || "N/A" }}</td>
              <td>
                <v-img
                  v-if="item.thumbnail"
                  :src="item.thumbnail"
                  lazy-src="https://picsum.photos/id/11/10/6"
                  width="100"
                  class="ma-1"
                >
                </v-img>
              </td>
              <td>
                {{ item.title }}
                <br />
                <v-chip v-if="item.created_at" x-small>
                  Created at: {{ formatDate(item.created_at) }}</v-chip
                >
              </td>
              <td>
                {{ item.category ? item.category.name : "N/A" }}
              </td>
              <td>
                <span
                  class="badge"
                  :class="{
                    'badge-success': item.is_highlighted,
                    'badge-warning': !item.is_highlighted,
                  }"
                  >{{ item.is_highlighted ? "Yes" : "No" }}</span
                >
              </td>
              <td>{{ articleTypeLabel(item.article_type) }}</td>
              <td>
                <span class="badge" :class="articleStatus(item)">{{
                  item.article_status
                }}</span>
              </td>
              <td>
                <button
                  v-can="'articles_edit'"
                  type="button"
                  class="btn btn-square btn-primary m-2"
                  @click.prevent="edit(item)"
                >
                  <i class="fa fa-pencil-alt"></i>
                </button>
                <button
                  v-can="'articles_delete'"
                  type="button"
                  class="btn btn-square btn-primary text-center"
                  @click.prevent="deleteItem(item.id)"
                >
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
          </template>
        </v-data-table>
      </div>
    </v-col>
  </v-row>
</template>
<script>
import moment from "moment";

export default {
  name: "Games",
  layout: "backend",
  middleware: ["auth"],
  data: () => ({
    totalItems: 0,
    items: [],
    loading: true,
    isArticleTypesLoading: false,
    searchText: "",
    options: {},
    article_types: [],
    formSearch: {
      status: "",
      title: "",
      category_id: 0,
      article_status: "",
      article_type: "",
    },
    headers: [
      {
        text: "ID",
        align: "start",
        sortable: false,
        value: "id",
        width: "7%",
      },
      {
        text: "Thumbnail",
        align: "start",
        sortable: false,
        value: "thumbnail",
        width: "7%",
      },
      {
        text: "Title",
        align: "start",
        sortable: false,
        value: "title",
      },
      {
        text: "Category",
        align: "start",
        sortable: false,
        value: "category",
      },
      {
        text: "Highlighted",
        align: "start",
        sortable: false,
        value: "rtp",
      },
      {
        text: "Article Type",
        align: "start",
        sortable: false,
        value: "article_type",
      },
      {
        text: "Status",
        align: "start",
        sortable: false,
        value: "active",
      },
      { text: "Actions", value: "iron", width: "15%" },
    ],
  }),
  watch: {
    options: {
      handler() {
        this.getDataFromApi();
      },
      deep: true,
    },
    "formSearch.article_type"() {
      this.getDataFromApi();
    },
  },
  async created() {
    await this.getArticleTypes();
  },
  mounted() {
    this.$root.$on("refresh-list", () => this.getDataFromApi());
  },
  methods: {
    changeTab(_tab) {
      this.formSearch.article_type = _tab;
    },

    articleTypeLabel(_type) {
      try {
        return this.article_types.find((el) => el.id === _type).label;
      } catch (e) {
        return "N/A";
      }
    },

    add(type) {
      this.$router.push({
        name: "articles-add",
        query: { article_type: type },
      });
    },

    edit(item) {
      this.$router.push({
        name: "articles-edit-id",
        params: { id: item.id },
      });
    },

    formatDate(date) {
      return moment(date).format("DD MM YYYY hh:mm:ss");
    },

    articleStatus(item) {
      return {
        "badge-success": item.article_status === "published",
        "badge-warning": item.article_status === "draft",
        "badge-danger": item.article_status === "private",
      };
    },

    async getArticleTypes() {
      this.isArticleTypesLoading = true;
      try {
        const { data } = await this.$axios.get("/selector/article-types");
        if (data.success) {
          this.article_types = data.data;
          this.formSearch.article_type = data.data[0].id;
        }
      } catch (err) {
        console.warn("[ArticleList]::", err);
      }
      this.isArticleTypesLoading = false;
    },

    async getDataFromApi() {
      this.loading = true;
      if (!this.formSearch.article_type) return;
      try {
        const { page, itemsPerPage } = this.options;

        const { data } = await this.$axios.get("/articles/list", {
          params: {
            start: page,
            length: itemsPerPage,
            status: this.formSearch.status,
            search: this.formSearch.title,
            category_id: this.formSearch.category_id,
            article_type: this.formSearch.article_type,
            article_status: this.formSearch.article_status,
          },
        });

        this.items = data.data.items;
        this.totalItems = data.data.total;
      } catch (err) {
        this.toastError("Something went wrong!");
      }
      this.loading = false;
    },

    async deleteItem(ID) {
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
              this.getDataFromApi();
            } else {
              this.toastError(data.err || "Something went wrong!");
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
