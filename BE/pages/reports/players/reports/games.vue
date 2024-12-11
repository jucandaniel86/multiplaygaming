<template>
  <v-data-table
    :headers="activeHeaders"
    :items="items"
    :options.sync="options"
    :loading="loading"
    class="pa-2"
    :height="450"
  >
    <template v-slot:top>
      <v-row>
        <v-col cols="8">
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
              { text: 'Games', href: '#', disabled: true },
            ]"
          ></v-breadcrumbs>
        </v-col>
        <v-col cols="4" class="d-flex align-center justify-end gap-2">
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
            class="mb-0"
          ></selector-fields>
        </v-col>
      </v-row>
    </template>

    <template v-slot:item="{ item }">
      <tr>
        <td v-if="checkActiveData('game_id')">
          {{ item.game_id }}
        </td>
        <td v-if="checkActiveData('game_name')">{{ item.game_name }}</td>
        <td v-if="checkActiveData('studio')">{{ item.studio }}</td>
        <td v-if="checkActiveData('total_brands')">{{ item.total_brands }}</td>
        <td v-if="checkActiveData('total_bets')">{{ item.total_bets }}</td>
        <td v-if="checkActiveData('total_wins')">{{ item.total_wins }}</td>
        <td v-if="checkActiveData('total_refunds')">
          {{ item.total_refunds }}
        </td>
        <td v-if="checkActiveData('ggr')">{{ item.ggr }}</td>
        <td v-if="checkActiveData('bonus_bets')">{{ item.bonus_bets }}</td>
        <td v-if="checkActiveData('bonus_wins')">{{ item.bonus_wins }}</td>
        <td v-if="checkActiveData('bonus_ggr')">{{ item.bonus_ggr }}</td>
        <td v-if="checkActiveData('rtp')">{{ item.rtp }}%</td>
        <td v-if="checkActiveData('avg_bets')">{{ item.avg_bets }}</td>
        <td v-if="checkActiveData('total_players')">
          {{ item.total_players }}
        </td>
        <td v-if="checkActiveData('total_sessions')">
          {{ item.total_sessions }}
        </td>
        <td v-if="checkActiveData('total_spins')">{{ item.total_spins }}</td>
      </tr>
    </template>
  </v-data-table>
</template>
<script>
import moment from "moment";
import { GAMES_REPORT_HEADERS } from "../headers";

let fromDate = moment().subtract(1, "month");
let toDate = moment();

export default {
  data: () => ({
    headers: GAMES_REPORT_HEADERS,
    options: {},
    loading: true,
    items: [],
    hiddenColumns: [],
    filter: {
      period: null,
      fromDate: fromDate.format("YYYY-MM-DD"),
      toDate: toDate.format("YYYY-MM-DD"),
      game_search: "",
    },
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
      this.$emit("games:change-report", options);
    },
    checkActiveData(_key) {
      return this.activeHeaders.map((el) => el.value).indexOf(_key) !== -1;
    },
    handleRange(values) {
      this.filter.fromDate = values[0].format("YYYY-MM-DD");
      this.filter.toDate = values[1].format("YYYY-MM-DD");
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
<style>
.mdrp__activator .activator-wrapper .text-field {
  padding: 4px 10px 1px 5px !important;
}
.mdrp__activator .activator-wrapper .text-field {
  width: 100% !important;
}
</style>