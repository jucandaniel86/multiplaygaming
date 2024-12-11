<template>
  <div>
    <v-overlay v-if="loading" color="white" z-index="9999" opacity="1">
      <v-progress-circular indeterminate color="primary"></v-progress-circular>
    </v-overlay>
    <v-row v-else>
      <v-col cols="12">
        <div class="bg-light rounded h-100 p-4">
          <SharedPageHeader :title="'Downloads (' + game_name + ')'">
            <template v-slot:content>
              <button class="btn btn-primary" @click.prevent="backToGames">
                Back to games
              </button>
            </template>
          </SharedPageHeader>

          <v-row>
            <v-col cols="12" md="5">
              <v-text-field v-model="form.name" label="Name" />

              <v-select
                v-model="form.download_type"
                :items="[
                  { id: 'FILE', label: 'File' },
                  { id: 'LINK', label: 'Link' },
                ]"
                :item-text="'label'"
                :item-value="'id'"
                label="Download Type"
              ></v-select>

              <v-file-input
                v-model="form.download_file"
                label="File"
                v-if="form.download_type === 'FILE'"
              />

              <v-textarea
                v-model="form.download_link"
                label="Link"
                v-if="form.download_type === 'LINK'"
              ></v-textarea>

              <v-checkbox
                v-model="form.is_certificate"
                :false-value="0"
                :true-value="1"
                :value="1"
                label="Certificate"
              />

              <selector-jurisdiction
                v-model="form.jurisdiction_id"
                v-if="form.is_certificate"
              />

              <button-loading
                @on-click="save"
                :is-loading="isSaveLoading"
                :btn-class="'btn-primary py-3 w-100 mb-4'"
                :icon="'fa-save'"
                style="max-width: 200px"
                :text="'Save'"
              />
            </v-col>
            <v-col cols="12" md="7">
              <v-card>
                <v-card-title>Downloads List</v-card-title>
                <v-card-text>
                  <v-progress-linear
                    indeterminate
                    v-if="listLoading"
                  ></v-progress-linear>
                  <v-simple-table
                    fixed-header
                    height="300"
                    :class="{ opacity: listLoading }"
                  >
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Certification</th>
                        <th>Jurisdiction</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(download, i) in list" :key="`Downloads${i}`">
                        <td>
                          <span>{{ download.name }}</span>
                          <a
                            :href="download.download_url"
                            target="blank"
                            v-if="download.download_url !== 'undefined'"
                          >
                            <v-icon
                              color="primary"
                              v-if="download.download_type === 'FILE'"
                              >mdi-download</v-icon
                            >
                            <v-icon
                              color="primary"
                              v-if="download.download_type === 'LINK'"
                              >mdi-link</v-icon
                            >
                          </a>
                        </td>
                        <td>
                          <v-chip
                            x-small
                            :color="download.is_certificate ? 'green' : 'red'"
                          >
                            {{ download.is_certificate ? "YES" : "NO" }}
                          </v-chip>
                        </td>
                        <td>
                          {{
                            download.jurisdiction
                              ? download.jurisdiction.name
                              : "N/A"
                          }}
                        </td>
                        <td>
                          <div class="d-flex ga-2 align-center">
                            <download-update :item="download" />
                            <v-btn
                              color="primary"
                              x-small
                              @click="deleteItem(download.id)"
                            >
                              <i class="fas fa-trash"></i>
                            </v-btn>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </v-simple-table>
                </v-card-text>
              </v-card>
            </v-col>
          </v-row>
        </div>
      </v-col>
    </v-row>
  </div>
</template>
<script>
import DownloadUpdate from "./update.vue";
export default {
  name: "GamesCAEdit",
  layout: "backend",
  middleware: ["auth"],
  components: { DownloadUpdate },
  data: () => ({
    loading: false,
    listLoading: false,
    isSaveLoading: false,
    list: [],
    form: {
      name: "",
      download_type: "LINK",
      download_file: [],
      download_link: "",
      is_mediapack: 0,
      is_certificate: 0,
      jurisdiction_id: "",
    },
    rtps: [],
    hit_frequency: [],
    game_name: "",
  }),
  async created() {
    await this.getDetails();
    await this.getList();
  },
  mounted() {
    this.$root.$on("downloads:update-item", this.getList);
  },
  methods: {
    resetForm() {
      this.form = {
        name: "",
        download_type: "LINK",
        download_file: [],
        download_link: "",
        is_mediapack: 0,
        is_certificate: 0,
        jurisdiction_id: "",
      };
    },
    backToGames() {
      this.$router.push({
        name: "client-area-games",
      });
    },
    async getDetails() {
      this.loading = true;
      try {
        const { data } = await this.$axios.get("/games/get", {
          params: {
            id: this.$route.params.id,
          },
        });

        this.game_name = data.data.game_name;
      } catch (err) {
        console.warn("GameController [id]:: ", err);
      }
      this.loading = false;
    },
    async getList() {
      this.listLoading = true;
      try {
        const { data } = await this.$axios.get("/games/downloads-list", {
          params: {
            game_id: this.$route.params.id,
          },
        });
        this.list = data.data;
      } catch (err) {
        console.warn("GameDownloadsList err::", err);
      }
      this.listLoading = false;
    },
    async save() {
      this.isSaveLoading = true;
      try {
        var formData = new FormData();
        formData.append("game_id", this.$route.params.id);
        formData.append("name", this.form.name);
        formData.append("download_type", this.form.download_type);
        formData.append("download_file", this.form.download_file);
        formData.append("download_link", this.form.download_link);
        formData.append("is_media_pack", this.form.is_mediapack);
        formData.append("is_certificate", this.form.is_certificate);
        formData.append("jurisdiction_id", this.form.jurisdiction_id);

        const { data } = await this.$axios.post(
          "/games/upload-download",
          formData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        );

        if (data.success) {
          this.toastSuccess(data.message);
          this.getList();
          this.resetForm();
        } else {
          this.toastError(data.msg);
        }
      } catch (err) {
        this.toastError("Something went wrong!");
      }
      this.isSaveLoading = false;
    },

    async deleteItem(ID) {
      this.confirmDelete().then(async (result) => {
        if (result.value) {
          try {
            const { data } = await this.$axios.delete(
              "/games/delete-download",
              {
                params: {
                  id: ID,
                },
              }
            );
            if (data.success) {
              this.toastSuccess("The entry was saved successfuly");
              this.getList();
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
<style scoped>
.opacity {
  opacity: 0.5;
}
</style>
