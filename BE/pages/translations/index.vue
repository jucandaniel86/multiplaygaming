<template>
  <v-row>
    <v-col cols="12">
      <div class="bg-light rounded h-100 p-4">
        <SharedPageHeader :title="'Translations'"></SharedPageHeader>
        <v-row>
          <v-col cols="4">
            <selector-translations v-model="group" />
          </v-col>
          <v-col cols="6" class="d-flex align-center">
            <v-text-field v-model="search" label="Search" />
          </v-col>
          <v-col cols="2" class="d-flex align-center">
            <v-btn
              color="primary"
              :disabled="isLoading"
              @click.prevent="getLines"
            >
              <v-icon color="white">mdi-magnify</v-icon>
              Search
            </v-btn>
          </v-col>
        </v-row>

        <v-simple-table fixed-header height="450">
          <thead>
            <tr>
              <th>Key</th>
              <th>Value</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(line, i) in lines" :key="`Line${i}`">
              <td>
                <b>{{ line.key }}</b>
              </td>
              <td>
                <v-textarea v-model="line.text.en" />
              </td>
              <td>
                <v-btn color="primary" small @click.prevent="save(line)">
                  <v-icon color="white">mdi-content-save-check</v-icon>
                </v-btn>
              </td>
            </tr>
          </tbody>
        </v-simple-table>

        <div
          class="d-flex justify-center w-100 mt-2 flex-column gap-2 align-center"
        >
          <v-btn
            large
            color="green"
            @click="clearCache"
            style="max-width: 200px"
          >
            CLEAR CACHE
          </v-btn>

          <!-- <v-alert colored-border type="warning" border="bottom">
            * in order for changes to take effect properly, please select "Clear
            Cache" button above
          </v-alert> -->
        </div>
      </div>
    </v-col>
  </v-row>
</template>
<script>
export default {
  name: "Translations",
  layout: "backend",
  middleware: ["auth"],
  data() {
    return {
      isLoading: false,
      search: "",
      group: "",
      lines: [],
    };
  },

  methods: {
    async clearCache() {
      this.confirm(
        "Are you sure you want to clear website templates cache?"
      ).then(async (result) => {
        if (result.value) {
          try {
            const { data } = await this.$axios.get("/lang/clear-cache");
            if (data.success) {
              this.toastSuccess(data.data.message);
            }
          } catch (err) {
            this.toastError("Something went wrong!");
          }
        }
      });
    },

    async getLines() {
      this.isLoading = true;
      try {
        const { data } = await this.$axios.get("/lang/lines", {
          params: {
            group: this.group,
            search: this.search,
          },
        });
        if (data.success) {
          this.lines = data.data;
        }
      } catch (err) {
        console.warn("getLines()::", err);
      }
      this.isLoading = false;
    },

    async save(line) {
      try {
        const { data } = await this.$axios.post("/lang/save", {
          language: [line],
        });

        if (data.success) {
          this.toastSuccess(data.message);
        } else {
          this.toastError(data.msg);
        }
      } catch (err) {
        this.toastError("Something went wrong!");
        console.warn("save()::", err);
      }
    },
  },
};
</script>
