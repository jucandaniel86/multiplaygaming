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
        <v-col cols="9">
          <v-row>
            <v-col cols="6" class="d-flex align-center">
              <v-text-field
                v-model="filter.game_search"
                label=" Client Name/ Round ID/ Transaction ID/ Player ID/ Game ID/Game Name"
              />
            </v-col>
            <v-col cols="4" class="d-flex align-center">
              <v-md-date-range-picker
                v-model="filter.period"
                :start-date="filter.fromDate"
                :end-date="filter.toDate"
                :show-activator-label="false"
                @change="handleRange"
                style="max-width: 100%"
              />
            </v-col>
            <v-col cols="2" class="d-flex align-center">
              <v-btn
                color="primary"
                small
                :disabled="loading"
                @click.prevent="getDataFromApi"
              >
                <v-icon color="white" small>mdi-magnify</v-icon>
              </v-btn>
            </v-col>
          </v-row>
        </v-col>
        <v-col cols="3" class="d-flex align-end flex-column justify-end">
          <selector-fields
            v-model="hiddenColumns"
            :items="headers"
            class="mb-0"
          ></selector-fields>
          <v-btn
            color="primary"
            :disabled="items.length === 0"
            @click="download"
            small
            class="mb-2"
          >
            <v-icon color="white">mdi-download</v-icon>
            Download Report
          </v-btn>
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
          <a
            href=""
            @click.prevent="
              changeReport({
                game_id: item.game_id,
                toDate: filter.toDate,
                fromDate: filter.fromDate,
                report: 'players',
              })
            "
            >{{ item.total_players }}</a
          >
        </td>
        <td v-if="checkActiveData('total_sessions')">
          <a
            href=""
            @click.prevent="
              changeReport({
                game_id: item.game_id,
                toDate: filter.toDate,
                fromDate: filter.fromDate,
                report: 'session',
              })
            "
            >{{ item.total_sessions }}</a
          >
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
          params: {
            report: "games",
            ...this.filter,
          },
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
      this.$emit("games:download", {
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