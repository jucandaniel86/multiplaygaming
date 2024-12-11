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
                    v-model="form.job_title"
                    :counter="true"
                    @blur="createJob"
                    label="Title"
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
                        Job URL:
                        <a
                          :href="`${$config.FRONTEND_ENDPOINT}/jobs/${form.slug}/${form.id}`"
                          target="_blank"
                          >{{
                            `${$config.FRONTEND_ENDPOINT}/jobs/${form.slug}/${form.id}`
                          }}</a
                        >
                      </div>
                    </div>
                  </div>

                  <v-text-field
                    v-model="form.required_experience"
                    label="Required Experience"
                  />

                  <v-select
                    v-model="form.employment_type"
                    label="Employment Type"
                    :options="[
                      { id: 'full-time', label: 'Full-time' },
                      { id: 'part-time', lable: 'Part-time' },
                    ]"
                    :item-text="'label'"
                    :item-value="'id'"
                  ></v-select>

                  <app-texteditor
                    :label="'Content'"
                    v-model="form.content"
                    :default-value="form.content"
                    :height="600"
                  />

                  <app-texteditor
                    :label="'Role Overview'"
                    v-model="form.role_overview"
                    :default-value="form.role_overview"
                    :height="600"
                  />

                  <app-texteditor
                    :label="'Responsibilities'"
                    v-model="form.responsibilities"
                    :default-value="form.responsibilities"
                    :height="600"
                  />

                  <app-texteditor
                    :label="'Requirements'"
                    v-model="form.requirements"
                    :default-value="form.requirements"
                    :height="600"
                  />

                  <app-texteditor
                    :label="'Work Conditions'"
                    v-model="form.work_conditions"
                    :default-value="form.work_conditions"
                    :height="600"
                  />
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

                <SharedCardHeader :title="'Department'">
                  <template v-slot:content>
                    <selector-department
                      v-model="form.department_id"
                      :default-value="form.department_id"
                      :key="`Category${newCategoryID}`"
                    />
                    <v-btn
                      text
                      @click.prevent="isCategoryOpen = !isCategoryOpen"
                    >
                      <v-icon>add</v-icon>
                      Add new department
                    </v-btn>
                    <div
                      v-if="isCategoryOpen"
                      class="d-flex justify-content-center align-center"
                    >
                      <v-text-field v-model="department.name" />
                      <v-btn
                        small
                        :disabled="isCategoryLoading"
                        @click.prevent="saveDepartment"
                        >Save</v-btn
                      >
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

export default {
  name: "ArticlesForm",
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
      department: {
        name: "",
      },
      form: {
        id: 0,
        job_title: "",
        department_id: 0,
        content: "",
        required_experience: "",
        employment_type: "",
        role_overview: "",
        responsibilities: "",
        requirements: "",
        work_conditions: "",
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

    async saveStatus(_status) {
      if (!this.form.id) return false;
      try {
        const { data } = await this.$axios.post("/carrers/update", {
          job_status: _status,
          id: this.form.id,
        });

        if (data.success) {
          this.toastSuccess(data.message);
          this.$router.push({
            name: "jobs-edit-id",
            params: { id: this.form.id },
          });
        }
        //@todo :: redirect to games edit
      } catch (err) {
        console.warn("[CarrersController::Err]", err);
      }
    },

    async saveDepartment() {
      if (this.department.name === "") return false;

      this.isCategoryLoading = true;
      try {
        const { data } = await this.$axios.post(
          "/departments/save",
          this.department
        );
        if (data.success) {
          this.form.department_id = data.data.id;
          this.department.name = "";
          this.isCategoryOpen = false;
          this.$root.$emit("departments:save");
        } else {
          this.toastError("Something went wrong!");
        }
      } catch (err) {
        console.warn("[CarrersController::Err]", err);
        this.toastError("Something went wrong!");
      }
      this.isCategoryLoading = false;
    },

    async createJob() {
      if (this.form.id !== 0 || this.form.game_name === "") return false;
      try {
        const { data } = await this.$axios.post("/carrers/create", {
          job_title: this.form.job_title,
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
        console.warn("[CarrersController::Err]", err);
      }
    },

    async save() {
      this.isSaveLoading = true;
      try {
        const { data } = await this.$axios.post("/carrers/update", {
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
            const { data } = await this.$axios.delete("/carrers/delete", {
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
