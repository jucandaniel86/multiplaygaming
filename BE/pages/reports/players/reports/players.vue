<template>
  <v-data-table
    :headers="activeHeaders"
    :items="activeItems"
    :options.sync="options"
    :loading="loading"
    hide-default-footer
    class="pa-2"
    :height="450"
  >
    <template v-slot:top>
      <div class="d-flex align-center justify-space-between">
        <div class="d-flex gap-2 align-center">
          <v-text-field
            v-model="filter.player_id"
            label="Player ID"
            class="w-100"
            style="max-width: 250px"
          />
          <selector-currency
            v-model="filter.currency"
            @currency:exchange="exchange"
          />
          <v-md-date-range-picker
            v-model="filter.period"
            :start-date="filter.fromDate"
            :end-date="filter.toDate"
            :show-activator-label="false"
            @change="handleRange"
          />
          <v-btn
            color="primary"
            small
            @click.prevent="getDataFromApi"
            :disabled="loading"
          >
            <v-icon color="white" small>mdi-magnify</v-icon>
          </v-btn>
        </div>
        <div class="d-flex gap-2 align-center ml-1">
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
        <td v-if="checkActiveData('player_id')">
          <a
            href=""
            @click.prevent="
              changeReport({
                player_id: item.player_id,
                toDate: filter.toDate,
                fromDate: filter.fromDate,
                report: 'session',
              })
            "
          >
            {{ item.player_id }}
          </a>
        </td>
        <td v-if="checkActiveData('brand')">{{ item.brand }}</td>
        <td v-if="checkActiveData('total_bets')">
          <span v-html="getCurrencySymbol()"></span>
          {{ item.total_bets }}
        </td>
        <td v-if="checkActiveData('total_wins')">{{ item.total_wins }}</td>
        <td v-if="checkActiveData('total_refunds')">
          <span v-html="getCurrencySymbol()"></span>
          {{ item.total_refunds }}
        </td>
        <td v-if="checkActiveData('ggr')">
          <span v-html="getCurrencySymbol()"></span>
          {{ item.ggr }}
        </td>
        <td v-if="checkActiveData('bonus_bets')">{{ item.bonus_bets }}</td>
        <td v-if="checkActiveData('bonus_wins')">{{ item.bonus_wins }}</td>
        <td v-if="checkActiveData('bonus_ggr')">{{ item.bonus_ggr }}</td>
        <td v-if="checkActiveData('rtp')">{{ item.rtp }}%</td>
        <td v-if="checkActiveData('avg_bets')">
          <span v-html="getCurrencySymbol()"></span>
          {{ item.avg_bets }}
        </td>
        <td v-if="checkActiveData('games')">
          <a
            href=""
            @click.prevent="
              changeReport({
                player_id: item.player_id,
                toDate: filter.toDate,
                fromDate: filter.fromDate,
                report: 'games',
              })
            "
          >
            {{ item.total_games }}
          </a>
        </td>
        <td v-if="checkActiveData('total_studios')">
          {{ item.total_studios }}
        </td>
        <td v-if="checkActiveData('total_sessions')">
          <a
            href=""
            @click.prevent="
              changeReport({
                player_id: item.player_id,
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
import { PLAYERS_REPORT_HEADERS } from "../headers";
import CountriesMixin from "../../../../mixins/countries";

let fromDate = moment().subtract(1, "month");
let toDate = moment();

export default {
  mixins: [CountriesMixin],
  data: () => ({
    headers: PLAYERS_REPORT_HEADERS,
    options: {},
    loading: true,
    items: [],
    hiddenColumns: [],
    exchangeValue: {
      label: "EUR",
      value: 1,
    },
    filter: {
      currency: "",
      player_id: "",
      period: null,
      fromDate: fromDate.format("YYYY-MM-DD"),
      toDate: toDate.format("YYYY-MM-DD"),
    },
  }),
  computed: {
    activeHeaders() {
      return this.headers.filter(
        (el) => this.hiddenColumns.indexOf(el.value) === -1
      );
    },
    activeItems() {
      return this.items.map((el) => ({
        ...el,
        total_bets: Number(this.exchangeValue.value * el.total_bets).toFixed(2),
        total_refunds: Number(
          this.exchangeValue.value * el.total_refunds
        ).toFixed(2),
        ggr: Number(this.exchangeValue.value * el.ggr).toFixed(2),
        avg_bets: Number(this.exchangeValue.value * el.avg_bets).toFixed(2),
      }));
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
            ...this.filter,
            report: "players",
          },
        });
        this.items = data.data;
      } catch (err) {
        this.toastError("Something went wrong!");
      }
      this.loading = false;
    },
    changeReport(options) {
      this.$emit("players:change-report", options);
    },
    checkActiveData(_key) {
      return this.activeHeaders.map((el) => el.value).indexOf(_key) !== -1;
    },
    handleRange(values) {
      this.filter.fromDate = values[0].format("YYYY-MM-DD");
      this.filter.toDate = values[1].format("YYYY-MM-DD");
    },
    exchange(value) {
      this.exchangeValue = value;
    },
    getCurrencySymbol() {
      let currencySpit = this.exchangeValue.label.split("-");
      let currency =
        currencySpit.length > 1 ? currencySpit[1] : this.exchangeValue.label;

      return this.currencySymbol(currency);
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
  padding: 4px 10px 2px 5px !important;
}
.v-data-table > .v-data-table__wrapper > table > tbody > tr > td,
.v-data-table > .v-data-table__wrapper > table > tbody > tr > th,
.v-data-table > .v-data-table__wrapper > table > thead > tr > td,
.v-data-table > .v-data-table__wrapper > table > thead > tr > th,
.v-data-table > .v-data-table__wrapper > table > tfoot > tr > td,
.v-data-table > .v-data-table__wrapper > table > tfoot > tr > th {
  padding: 0 !important;
}
</style>