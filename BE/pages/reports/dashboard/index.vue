<template>
  <v-row>
    <v-col cols="12" class="h-100">
      <div class="p-4">
        <selector-games v-model="game_id" />
      </div>

      <div class="bg-light rounded h-100 p-4">
        <v-progress-linear color="primary" indeterminate v-if="isLoading" />
        <v-row v-else align-content="center">
          <v-col cols="3">
            <v-card>
              <v-card-title>Players playing Today</v-card-title>
              <v-card-text
                ><h2 class="text-h2">
                  {{ report.total_players }}
                </h2></v-card-text
              >
            </v-card>
          </v-col>
          <v-col cols="3">
            <v-card>
              <v-card-title>Bets Today </v-card-title>
              <v-card-text
                ><h2 class="text-h2">
                  {{ report.total_bets }}
                </h2></v-card-text
              >
            </v-card>
          </v-col>

          <v-col cols="3">
            <v-card>
              <v-card-title>GGR Today </v-card-title>
              <v-card-text
                ><h2 class="text-h2">€{{ report.ggr }}</h2></v-card-text
              >
            </v-card>
          </v-col>

          <v-col cols="3">
            <v-card>
              <v-card-title>Wins Today </v-card-title>
              <v-card-text
                ><h2 class="text-h2">€{{ report.total_wins }}</h2></v-card-text
              >
            </v-card>
          </v-col>

          <v-col cols="6">
            <v-card>
              <v-card-title>Top 10 Games</v-card-title>
              <v-card-text>
                <v-select
                  :items="[
                    { label: 'Bets', value: 'bets' },
                    { label: 'Wins', value: 'wins' },
                    { label: 'GGR', value: 'ggr' },
                    { label: 'spins', value: 'spins' },
                  ]"
                  item-text="label"
                  item-value="value"
                  v-model="topGamesModel"
                />
                <apexchart
                  type="pie"
                  :height="300"
                  :options="chartOptions"
                  :series="series"
                ></apexchart>
              </v-card-text>
            </v-card>
          </v-col>
          <v-col cols="6">
            <v-row>
              <v-col cols="12">
                <v-card>
                  <v-card-title>Avg playing players per day</v-card-title>
                  <v-card-text>
                    <v-select
                      :items="[
                        { label: '7 Days', value: 7 },
                        { label: '30 Days', value: 30 },
                        { label: '90 Days', value: 90 },
                      ]"
                      item-text="label"
                      item-value="value"
                      v-model="days"
                    />
                    <h2 class="text-h2">{{ playersPerDay }}</h2>
                  </v-card-text>
                </v-card>
              </v-col>
              <v-col cols="12">
                <v-card>
                  <v-card-title>Players playing per hour (avg)</v-card-title>
                  <v-card-text>
                    <h2 class="text-h2">{{ report.players_per_hour }}</h2>
                  </v-card-text>
                </v-card>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
      </div>
    </v-col>
  </v-row>
</template>
<script>
export default {
  name: "ReportsDashboard",
  layout: "backend",
  middleware: ["auth"],
  data: () => ({
    isLoading: false,
    report: {},
    playersPerDay: 0,
    game_id: 0,
    days: 7,
    topGames: [],
    topGamesModel: "bets",
    chartOptions: {
      legend: {
        position: "top",
      },
      chart: {
        id: "ApexChart" + new Date().getTime(),
        type: "pie",
      },
      labels: [],
    },
  }),
  watch: {
    game_id() {
      this.getDashboad();
    },
    days() {
      this.playerPerDay();
    },
  },
  async created() {
    this.isLoading = true;
    await this.getDashboad();
    await this.playerPerDay();
    await this.top10Games();
    this.isLoading = false;
  },
  computed: {
    series() {
      switch (this.topGamesModel) {
        case "bets":
          return this.topGames.map((el) => el.total_bets);
        case "spins":
          return this.topGames.map((el) => el.spins);
        case "wins":
          return this.topGames.map((el) => el.total_wins);
        case "ggr":
          return this.topGames.map((el) => el.ggr);
        default:
          return this.topGames.map((el) => el.total_bets);
      }
    },
  },
  methods: {
    async getDashboad() {
      try {
        const { data } = await this.$axios.get("/reports/dashboard", {});
        this.report = data.data;
      } catch (err) {
        console.warn("getDashboard()::", err);
      }
    },
    async playerPerDay() {
      try {
        const { data } = await this.$axios.get("/reports/players-per-day", {
          params: {
            days: this.days,
          },
        });
        this.playersPerDay = data.data.totalPlayers;
      } catch (err) {
        console.warn("playerPerDay()::", err);
      }
    },
    async top10Games() {
      try {
        const { data } = await this.$axios.get("/reports/top-10-games");
        this.topGames = data.data;

        this.chartOptions.labels = data.data.map((el) => el.game_id);
      } catch (err) {
        console.warn("top10Games()::", err);
      }
    },
  },
};
</script>