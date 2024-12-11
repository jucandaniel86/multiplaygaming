<template>
  <v-row>
    <v-col cols="12">
      <div class="bg-light rounded h-100 p-4 ml-4">
        <SharedPageHeader :title="pageTitle"></SharedPageHeader>
        <!-- REPORTS LOGIC -->
        <summary-report
          @summary:change-report="changeReport"
          @summary:download="downloadCSVData"
          v-if="currentReport === 'summary'"
        />
        <brands-report
          @summary:change-report="changeReport"
          @summary:download="downloadCSVData"
          v-if="currentReport === 'brands'"
        />
        <games-report
          @summary:change-report="changeReport"
          @summary:download="downloadCSVData"
          v-if="currentReport === 'games'"
        />
        <players-report
          @summary:change-report="changeReport"
          @summary:download="downloadCSVData"
          v-if="currentReport === 'players'"
        />
        <!-- /REPORTS LOGIC -->
      </div>
    </v-col>
  </v-row>
</template>
<script>
//import reports
import SummaryReport from "./reports/summary";
import BrandsReport from "./reports/brands";
import GamesReport from "./reports/games";
import PlayersReport from "./reports/players";

export default {
  name: "ReportsSummary",
  layout: "backend",
  middleware: ["auth"],
  components: { SummaryReport, BrandsReport, GamesReport, PlayersReport },
  data: () => ({
    pageTitle: "Summary",
    currentReport: "summary",
  }),
  watch: {
    "$route.query.report"() {
      if (this.$route.query.report) {
        this.currentReport = this.$route.query.report;
      } else {
        this.currentReport = "summary";
      }
    },
  },
  created() {
    if (typeof this.$route.query.report !== "undefined") {
      this.currentReport = this.$route.query.report;
    }
  },
  methods: {
    changeReport(params) {
      this.$router.push({ name: "reports-summary", query: params });
    },
    downloadCSVData({ headers, data }) {
      let csv = headers.map((el) => el.text).join(",") + "\n";
      let allowedHeaders = headers.map((el) => el.value);

      data.forEach((row) => {
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
      anchor.download = "summary-report.csv";
      anchor.click();
    },
  },
};
</script>
