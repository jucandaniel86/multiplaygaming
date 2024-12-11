<template>
  <v-row>
    <v-col cols="12">
      <div class="bg-light rounded h-100 p-4 ml-4">
        <SharedPageHeader :title="pageTitle"></SharedPageHeader>
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
            <v-row class="align-start d-flex" no-gutters>
              <v-col cols="9">
                <div class="d-flex gap-2 align-center">
                  <v-text-field
                    v-model="filter.client_name"
                    label="Client Name"
                    disabled
                  />
                  <v-md-date-range-picker
                    v-model="filter.period"
                    :start-date="filter.fromDate"
                    :end-date="filter.toDate"
                    :show-activator-label="false"
                    @change="handleRange"
                  />
                  <v-btn color="primary" small @click.prevent="getDataFromApi">
                    <v-icon color="white" small>mdi-magnify</v-icon>
                  </v-btn>
                </div>
              </v-col>
              <v-col cols="3" class="d-flex justify-end">
                <div class="d-flex ga-2 align-center flex-column">
                  <v-btn
                    color="primary"
                    :disabled="items.length === 0"
                    @click="downloadCSVData"
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
              </v-col>
            </v-row>
          </template>

          <template v-slot:item="{ item }">
            <tr>
              <td v-if="checkActiveData('client_name')">
                {{ item.client_name }}
              </td>
              <td v-if="checkActiveData('brand')">{{ item.brand }}</td>
              <td v-if="checkActiveData('total_bets')">
                {{ item.total_bets }}
              </td>
              <td v-if="checkActiveData('total_wins')">
                {{ item.total_wins }}
              </td>
              <td v-if="checkActiveData('total_refunds')">
                {{ item.total_refunds }}
              </td>
              <td v-if="checkActiveData('total_refunds_native')">
                {{ item.total_refunds_native }}
              </td>
              <td v-if="checkActiveData('tax')">
                {{ item.tax }}
              </td>
              <td v-if="checkActiveData('ggr')">
                {{ item.ggr }}
              </td>
              <td v-if="checkActiveData('ngr')">
                {{ item.ngr }}
              </td>
              <td v-if="checkActiveData('bonus_deduction')">
                {{ item.bonus_deduction }}
              </td>
              <td v-if="checkActiveData('rev_share')">{{ item.rev_share }}</td>
              <td v-if="checkActiveData('rev_share_amount')">
                {{ item.rev_share_amount }}
              </td>
              <td v-if="checkActiveData('other_promo_discount')">
                {{ item.other_promo_discount }}
              </td>
              <td v-if="checkActiveData('total_due')">{{ item.total_due }}</td>
            </tr>
          </template>
        </v-data-table>
      </div>
    </v-col>
  </v-row>
</template>
<script>
import moment from "moment";
import { INVOICES_REPORT_HEADERS } from "./headers";

let fromDate = moment().subtract(1, "month");
let toDate = moment();

export default {
  name: "ReportsInvoices",
  layout: "backend",
  middleware: ["auth"],
  data: () => ({
    headers: INVOICES_REPORT_HEADERS,
    pageTitle: "Invoices",
    options: {},
    loading: true,
    items: [],
    hiddenColumns: [],
    filter: {
      period: null,
      fromDate: fromDate.format("YYYY-MM-DD"),
      toDate: toDate.format("YYYY-MM-DD"),
      client_name: "",
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
            ...this.filter,
            report: "invoices",
          },
        });
        this.items = data.data;
      } catch (err) {
        this.toastError("Something went wrong!");
      }
      this.loading = false;
    },
    handleRange(values) {
      this.filter.fromDate = values[0].format("YYYY-MM-DD");
      this.filter.toDate = values[1].format("YYYY-MM-DD");
    },
    downloadCSVData() {
      let csv = this.activeHeaders.map((el) => el.text).join(",") + "\n";
      let allowedHeaders = this.activeHeaders.map((el) => el.value);

      this.items.forEach((row) => {
        let values = [];
        allowedHeaders.forEach((el) => {
          if (typeof row[el] !== "undefined") {
            values.push(row[el]);
          }
        });
        csv += values.join(",");
        csv += "\n";
      });

      const anchor = document.createElement("a");
      anchor.href = "data:text/csv;charset=utf-8," + encodeURIComponent(csv);
      anchor.target = "_blank";
      anchor.download = "invoices-report.csv";
      anchor.click();
    },
    checkActiveData(_key) {
      return this.activeHeaders.map((el) => el.value).indexOf(_key) !== -1;
    },
  },
};
</script>
<style>
.mdrp__activator .activator-wrapper .text-field {
  padding: 4px 10px 2px 5px !important;
}
</style>