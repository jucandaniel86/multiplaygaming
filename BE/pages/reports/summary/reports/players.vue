<template>
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
                text: 'Summary',
                href: '#',
                exact: true,
                to: {
                  name: 'reports-summary',
                },
              },
              { text: 'Players', href: '#', disabled: true },
            ]"
          ></v-breadcrumbs>
        </div>
        <div class="d-flex ga-2 align-center">
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
        <td v-if="checkActiveData('player_id')">{{ item.player_id }}</td>
        <td v-if="checkActiveData('client_name')">{{ item.client_name }}</td>
        <td v-if="checkActiveData('brand')">{{ item.brand }}</td>
        <td v-if="checkActiveData('total_bets')">{{ item.total_bets }}</td>
        <td v-if="checkActiveData('total_wins')">{{ item.total_wins }}</td>
        <td v-if="checkActiveData('total_refunds')">
          {{ item.total_refunds }}
        </td>
        <td v-if="checkActiveData('ggr')">{{ item.ggr }}</td>
        <td v-if="checkActiveData('bonus_bets')">{{ item.bonus_bets }}</td>
        <td v-if="checkActiveData('bonus_wins')">{{ item.bonus_wins }}</td>
        <td v-if="checkActiveData('bonus_ggr')">{{ item.bonus_ggr }}</td>
        <td v-if="checkActiveData('total_games')">{{ item.total_games }}</td>
        <td v-if="checkActiveData('total_studios')">
          {{ item.total_studios }}
        </td>
        <td v-if="checkActiveData('total_sessions')">
          {{ item.total_sessions }}
        </td>
        <td v-if="checkActiveData('total_spins')">{{ item.total_spins }}</td>
        <td v-if="checkActiveData('ltv')">{{ item.ltv }}</td>
      </tr>
    </template>
  </v-data-table>
</template>
<script>
import { PLAYERS_REPORT_HEADERS } from "../headers";
export default {
  data: () => ({
    headers: PLAYERS_REPORT_HEADERS,
    options: {},
    loading: true,
    items: [],
    hiddenColumns: [],
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
  },
};
</script>