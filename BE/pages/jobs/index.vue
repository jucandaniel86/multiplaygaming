<template>
  <v-row>
    <v-col cols="12">
      <div class="bg-light rounded h-100 p-4">
        <SharedPageHeader :title="'Jobs'">
          <template v-slot:content>
            <div class="text-center">
              <v-btn v-can="'careers_add'" color="primary" @click.prevent="add">
                Add new
              </v-btn>
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
            <v-tabs v-if="departments.length">
              <v-tab @click="changeTab(0)">All</v-tab>
              <v-tab
                v-for="(item, i) in departments"
                :key="`ArticleType${i}`"
                @click.prevent="changeTab(item.id)"
                >{{ item.label }}</v-tab
              >
            </v-tabs>
            <v-row class="align-end">
              <v-col cols="8">
                <v-text-field
                  v-model="formSearch.title"
                  label="Search"
                  chips
                ></v-text-field>
              </v-col>
              <v-col cols="2">
                <selector-status
                  v-model="formSearch.job_status"
                  :default-value="formSearch.job_status"
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
                {{ item.job_title }}
                <br />
                <v-chip v-if="item.created_at" x-small>
                  Created at: {{ formatDate(item.created_at) }}</v-chip
                >
              </td>
              <td>
                {{ item.department ? item.department.name : "N/A" }}
              </td>
              <td>
                <v-btn
                  x-small
                  fab
                  color="primary"
                  @click.prevent="openCvModal(item.id)"
                  :disabled="item.cvs_count === 0"
                >
                  {{ item.cvs_count }}
                </v-btn>
              </td>
              <td>
                <span class="badge" :class="jobStatus(item)">{{
                  item.job_status
                }}</span>
              </td>
              <td>
                <button
                  type="button"
                  class="btn btn-square btn-primary m-2"
                  @click.prevent="edit(item)"
                >
                  <i class="fa fa-pencil-alt"></i>
                </button>
                <button
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
    <v-col>
      <!-- CV MODALS -->
      <v-dialog v-model="cvsModal" scrollable max-width="600px">
        <SharedCardHeader :title="'Cvs'">
          <template v-slot:content>
            <v-simple-table fixed-header height="300">
              <template v-slot:default>
                <thead>
                  <th>Name</th>
                  <th>Email</th>
                  <th>CV</th>
                </thead>
                <tbody>
                  <tr v-for="(cv, i) in cvs" :key="`Cv${i}`">
                    <td>{{ cv.name }}</td>
                    <td>{{ cv.email }}</td>
                    <td>
                      <a :href="cv.cv_url" target="_blank">download CV</a>
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </template>
          <template v-slot:footer>
            <v-btn @click.prevent="closeCvModal">Close</v-btn>
          </template>
        </SharedCardHeader>
      </v-dialog>
      <!-- ./ END CV MODALS -->
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
    cvsModal: false,
    items: [],
    loading: true,
    isDepartmentsLoading: false,
    searchText: "",
    options: {},
    departments: [],
    formSearch: {
      title: "",
      job_status: "",
      department_id: 0,
    },
    cvs: [],
    headers: [
      {
        text: "ID",
        align: "start",
        sortable: false,
        value: "id",
        width: "7%",
      },
      {
        text: "Job Title",
        align: "start",
        sortable: false,
        value: "title",
      },
      {
        text: "Department",
        align: "start",
        sortable: false,
        value: "department",
      },
      {
        text: "CVs",
        align: "start",
        sortable: false,
        value: "cv_counts",
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
    "formSearch.department_id"() {
      this.getDataFromApi();
    },
  },
  async created() {
    await this.getDepartments();
  },
  mounted() {
    this.$root.$on("refresh-list", () => this.getDataFromApi());
  },
  methods: {
    changeTab(_tab) {
      this.formSearch.department_id = _tab;
    },

    openCvModal(id) {
      this.cvsModal = true;
      this.getCvs(id);
    },

    closeCvModal() {
      this.cvs = [];
      this.cvsModal = false;
    },

    add(type) {
      this.$router.push({
        name: "jobs-add",
      });
    },

    edit(item) {
      this.$router.push({
        name: "jobs-edit-id",
        params: { id: item.id },
      });
    },

    formatDate(date) {
      return moment(date).format("DD MM YYYY hh:mm:ss");
    },

    jobStatus(item) {
      return {
        "badge-success": item.job_status === "published",
        "badge-warning": item.job_status === "draft",
        "badge-danger": item.job_status === "private",
      };
    },

    async getCvs(id) {
      try {
        const { data } = await this.$axios.get("/carrers/cvs", {
          params: {
            job_id: id,
          },
        });
        if (data.success) {
          this.cvs = data.data;
        }
      } catch (err) {
        console.warn("[Carrers]::", err);
      }
    },

    async getDepartments() {
      this.isDepartmentsLoading = true;
      try {
        const { data } = await this.$axios.get("/selector/departments");
        if (data.success) {
          this.departments = data.data;
        }
      } catch (err) {
        console.warn("[Carrers]::", err);
      }
      this.isDepartmentsLoading = false;
    },

    async getDataFromApi() {
      this.loading = true;
      try {
        const { page, itemsPerPage } = this.options;

        const { data } = await this.$axios.get("/carrers/list", {
          params: {
            start: page,
            length: itemsPerPage,
            search: this.formSearch.title,
            department_id: this.formSearch.department_id,
            status: this.formSearch.job_status,
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
            const { data } = await this.$axios.delete("/carrers/delete", {
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
