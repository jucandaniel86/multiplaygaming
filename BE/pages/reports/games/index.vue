<template>
  <v-row>
    <v-col cols="12">
      <div class="bg-light rounded h-100 p-4 ml-4">
        <SharedPageHeader :title="pageTitle"></SharedPageHeader>
        <!-- REPORTS LOGIC -->
        <games-report
          @games:change-report="changeReport"
          @games:download="downloadCSVData"
          v-if="currentReport === 'games'"
        />
        <players-report
          @games:change-report="changeReport"
          @games:download="downloadCSVData"
          v-if="currentReport === 'players'"
        />
        <session-report
          @games:change-report="changeReport"
          @games:download="downloadCSVData"
          v-if="currentReport === 'session'"
        />
        <!-- /REPORTS LOGIC -->
      </div>
    </v-col>
  </v-row>
</template>
<script>
//import reports
import GamesReport from "./reports/games";
import PlayersReport from "./reports/players";
import SessionReport from "./reports/sessions";

export default {
  name: "ReportsGames",
  layout: "backend",
  middleware: ["auth"],
  components: { GamesReport, PlayersReport, SessionReport },
  data: () => ({
    pageTitle: "Reports Games",
    currentReport: "games",
  }),
  watch: {
    "$route.query.report"() {
      if (this.$route.query.report) {
        this.currentReport = this.$route.query.report;
      } else {
        this.currentReport = "games";
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
      this.$router.push({ name: "reports-games", query: params });
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
      anchor.download = "games-report.csv";
      anchor.click();
    },
  },
};
</script>
