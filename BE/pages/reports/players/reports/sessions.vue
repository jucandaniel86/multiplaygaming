<template>
  <div>
    <v-data-table
      :headers="activeHeaders"
      :items="items"
      :options.sync="options"
      :loading="loading"
      hide-default-footer
      class="pa-2"
      :height="450"
    >
      <template v-slot:top>
        <div class="d-flex align-center justify-space-between">
          <div class="d-flex ga-2 align-center">
            <v-breadcrumbs
              :items="[
                {
                  text: 'Players',
                  link: true,
                  exact: true,
                  disabled: false,
                  to: {
                    name: 'reports-players',
                    path: '/',
                  },
                },
                { text: 'Sessions', href: '#', disabled: true },
              ]"
            ></v-breadcrumbs>
          </div>
          <div class="d-flex gap-2 align-center">
            <v-btn
              color="primary"
              :disabled="items.length === 0"
              @click="download"
              small
            >
              <v-icon color="white">mdi-download</v-icon>
              Download Report
            </v-btn>
            <selector-fields
              v-model="hiddenColumns"
              :items="headers"
              style="max-width: 220px"
            ></selector-fields>
          </div>
        </div>
      </template>

      <template v-slot:item="{ item }">
        <tr>
          <td v-if="checkActiveData('session_id')">
            <a href="" @click.prevent="modal = true">{{ item.session_id }}</a>
          </td>
          <td v-if="checkActiveData('player_id')">{{ item.player_id }}</td>
          <td v-if="checkActiveData('brand')">{{ item.brand }}</td>
          <td v-if="checkActiveData('player_country')">
            {{ item.player_country }}
          </td>
          <td v-if="checkActiveData('total_bets')">{{ item.total_bets }}</td>
          <td v-if="checkActiveData('total_wins')">{{ item.total_wins }}</td>
          <td v-if="checkActiveData('total_refunds')">
            {{ item.total_refunds }}
          </td>
          <td v-if="checkActiveData('total_refunds_count')">
            {{ item.total_refunds_count }}
          </td>
          <td v-if="checkActiveData('ggr')">{{ item.ggr }}</td>
          <td v-if="checkActiveData('bonus_bets')">{{ item.bonus_bets }}</td>
          <td v-if="checkActiveData('bonus_wins')">{{ item.bonus_wins }}</td>
          <td v-if="checkActiveData('bonus_ggr')">{{ item.bonus_ggr }}</td>
          <td v-if="checkActiveData('rtp')">{{ item.rtp }}%</td>
          <td v-if="checkActiveData('total_sessions')">
            {{ item.total_sessions }}
          </td>
          <td v-if="checkActiveData('total_spins')">{{ item.total_spins }}</td>
          <td v-if="checkActiveData('total_spins')">{{ item.time_open }}</td>
          <td v-if="checkActiveData('total_spins')">{{ item.time_closed }}</td>
        </tr>
      </template>
    </v-data-table>
    <v-dialog v-model="modal" max-width="600">
      <v-card>
        <v-card-title>Bets Details</v-card-title>
        <v-card-text> ================ </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import { SESSIONS_REPORT_HEADERS } from "../headers";
export default {
  data: () => ({
    headers: SESSIONS_REPORT_HEADERS,
    options: {},
    loading: true,
    items: [],
    hiddenColumns: [],
    modal: false,
  }),
  computed: {
    activeHeaders() {
      return this.headers.filter(
        (el) => this.hiddenColumns.indexOf(el.value) === -1
      );
    },
  },
  watch: {
    options: {
      handler() {
        this.getDataFromApi();
      },
      deep: true,
    },
  },
  methods: {
    async getDataFromApi() {
      this.loading = true;
      try {
        const { data } = await this.$axios.get("/reports/summary-by-studios", {
          params: this.$route.query,
        });
        this.items = data.data;
      } catch (err) {
        this.toastError("Something went wrong!");
      }
      this.loading = false;
    },
    changeReport(options) {
      this.$emit("summary:change-report", options);
    },
    checkActiveData(_key) {
      return this.activeHeaders.map((el) => el.value).indexOf(_key) !== -1;
    },
    download() {
      this.$emit("players:download", {
        headers: this.activeHeaders,
        data: this.items,
      });
    },
  },
};
</script>