<template>
  <div>
    <v-overlay v-if="loading" color="white" z-index="9999" opacity="1">
      <v-progress-circular indeterminate color="primary"></v-progress-circular>
    </v-overlay>
    <v-row v-else>
      <v-col cols="12">
        <div class="bg-light rounded h-100 p-4">
          <SharedPageHeader :title="'Edit Game Details (' + game_name + ')'">
            <template v-slot:content>
              <button class="btn btn-primary" @click.prevent="backToGames">
                Back to games
              </button>
            </template>
          </SharedPageHeader>

          <v-text-field
            v-model="form.game_string_id"
            label="Alphanumeric Game ID"
          />

          <selector-jurisdiction
            v-model="form.jurisdictions"
            :default-value="form.jurisdictions"
            :multiple="true"
          />

          <v-textarea v-model="form.game_symbols" label="Game Symbols" />

          <v-row>
            <v-col cols="12" md="3">
              <v-text-field
                v-model="form.bet_per_lines"
                label="Minimum Bet per Line"
              />
            </v-col>
            <v-col cols="12" md="3">
              <v-text-field
                v-model="form.min_total_bet"
                label="Min Total Bet"
              />
            </v-col>
            <v-col cols="12" md="3">
              <v-text-field
                v-model="form.max_total_bet"
                label="Maximum Total Bet"
              />
            </v-col>
            <v-col cols="12" md="3">
              <v-text-field
                v-model="form.max_total_bet_ante"
                label="Maximum Total Bet with Ante"
              />
            </v-col>
          </v-row>

          <v-text-field v-model="form.max_exposure" label="Max Exposure" />

          <v-text-field v-model="form.total_bet" label="Total Bet" />

          <v-text-field v-model="form.reels" label="Reels" />

          <v-text-field v-model="form.rows" label="Rows" />

          <v-text-field v-model="form.bet_multiplier" label="Bet Multiplier" />

          <div class="d-flex justify-space-between pa-1">
            <span class="font-weight-bold">Rtp's</span>
            <v-btn x-small @click="addRts">add <v-icon>mdi-plus</v-icon></v-btn>
          </div>

          <div class="d-flex">
            <v-text-field
              v-model="form.rtps[i]"
              v-for="(rtp, i) in rtps"
              :key="`Rtp${i}`"
              :label="`RTP ${i + 1}`"
              class="mr-2"
              :value="rtp"
            >
              <template v-slot:prepend>
                <v-icon color="red" dense> mdi-percent </v-icon>
              </template>
              <template v-slot:append>
                <v-btn small icon @click="deleteRtp(i)">
                  <v-icon color="red" dense> mdi-minus </v-icon>
                </v-btn>
              </template>
            </v-text-field>
          </div>

          <div class="d-flex justify-space-between pa-1">
            <span class="font-weight-bold">Hit Frequency</span>
            <v-btn x-small @click="addFrequency"
              >add <v-icon>mdi-plus</v-icon></v-btn
            >
          </div>
          <div class="d-flex flex-column">
            <v-text-field
              v-model="form.hit_frequency[i]"
              v-for="(hit, i) in hit_frequency"
              :key="`HitFrequency${i}`"
              :label="`Hit Frequency ${i + 1}`"
              class="mr-2"
              :value="hit"
            >
              <template v-slot:append>
                <v-btn small icon @click="deleteHit(i)">
                  <v-icon color="red" dense> mdi-minus </v-icon>
                </v-btn>
              </template>
            </v-text-field>
          </div>

          <v-row class="d-flex align-center ga-4">
            <v-col cols="12">
              <span class="font-weight-bold">Devices</span>
            </v-col>
            <v-col>
              <v-checkbox
                label="Desktop"
                value="desktop"
                v-model="form.devices"
                prepend-icon="monitor"
                class="ma-0"
              />
            </v-col>
            <v-col>
              <v-checkbox
                label="Tablet"
                value="tablet"
                v-model="form.devices"
                prepend-icon="tablet"
                class="ma-0"
              />
            </v-col>
            <v-col>
              <v-checkbox
                label="Mobile"
                value="mobile"
                v-model="form.devices"
                prepend-icon="phone"
              />
            </v-col>
          </v-row>

          <div class="d-flex align-center justify-space-between">
            <v-checkbox
              v-model="form.has_replay"
              label="Has Replay"
              :true-value="1"
              :false-value="0"
              class="mr-3"
            />

            <v-checkbox
              v-model="form.has_buy_spins"
              label="Has Buy Spins"
              :true-value="1"
              :false-value="0"
              class="mr-3"
            />

            <v-checkbox
              v-model="form.has_ante_bet"
              label="Has Ante Bet"
              :true-value="1"
              :false-value="0"
            />

            <v-checkbox
              v-model="form.has_jackpot"
              label="Has Jackpot"
              :true-value="1"
              :false-value="0"
            />

            <v-checkbox
              v-model="form.has_free_spins"
              label="Has Free Spins"
              :true-value="1"
              :false-value="0"
            />

            <v-checkbox
              v-model="form.has_instant_bonus"
              label="Has Instant Bonus"
              :true-value="1"
              :false-value="0"
            />
          </div>

          <button-loading
            @on-click="save"
            :is-loading="isSaveLoading"
            :btn-class="'btn-primary py-3 w-100 mb-4'"
            :icon="'fa-save'"
            style="max-width: 200px"
            :text="'Save'"
          />
        </div>
      </v-col>
    </v-row>
  </div>
</template>
<script>
export default {
  name: "GamesCAEdit",
  layout: "backend",
  middleware: ["auth"],
  data: () => ({
    loading: false,
    isSaveLoading: false,
    form: {
      game_string_id: "",
      game_symbols: "",
      bet_per_lines: "",
      max_total_bet: "",
      max_total_bet_ante: "",
      reels: "",
      rows: "",
      bet_multiplier: "",
      rtps: [],
      hit_frequency: [],
      devices: [],
      has_replay: 0,
      has_buy_spins: 0,
      has_ante_bet: 0,
      has_jackpot: 0,
      has_free_spins: 0,
      has_instant_bonus: 0,
      min_total_bet: "",
      max_exposure: "",
      total_bet: "",
    },
    rtps: [],
    hit_frequency: [],
    game_name: "",
    jurisdictions: [],
  }),
  async created() {
    await this.getDetails();

    if (!this.rtps.length) {
      this.addRts();
    }
    if (!this.hit_frequency.length) {
      this.addFrequency();
    }
  },
  methods: {
    addRts() {
      this.rtps.push("");
    },
    addFrequency() {
      this.hit_frequency.push("");
    },
    backToGames() {
      this.$router.push({
        name: "client-area-games",
      });
    },
    arrayConvert(data) {
      try {
        const rtps = Array.from(JSON.parse(data.rtps));
        const hitFrequency = Array.from(JSON.parse(data.hit_frequency));
        const devices = Array.from(JSON.parse(data.devices));

        this.rtps = rtps.length === 0 ? [] : rtps;
        this.hit_frequency = hitFrequency.length === 0 ? [] : hitFrequency;
        this.form.rtps = rtps.length === 0 ? [] : rtps;
        this.form.hit_frequency = hitFrequency.length === 0 ? [] : hitFrequency;
        this.form.devices = devices.length === 0 ? [] : devices;
      } catch (err) {
        console.warn("arrayConvert()::", err);
      }
    },

    deleteRtp(index) {
      this.rtps.splice(index, 1);
    },
    deleteHit(index) {
      this.hit_frequency.splice(index, 1);
    },
    async getDetails() {
      this.loading = true;
      try {
        const { data } = await this.$axios.get("/games/details", {
          params: {
            game_id: this.$route.params.id,
          },
        });

        this.form = {
          ...this.form,
          ...data.data.details,
        };
        this.game_name = data.data.game_name;
        this.arrayConvert(data.data.details);

        if (data.data.jurisdictions) {
          this.form.jurisdictions = data.data.jurisdictions.map((el) => el.id);
        }
      } catch (err) {
        console.warn("GameController [id]:: ", err);
      }
      this.loading = false;
    },
    async save() {
      this.isSaveLoading = true;
      try {
        const { data } = await this.$axios.post("/games/update-details", {
          ...this.form,
          game_id: this.$route.params.id,
        });

        if (data.success) {
          this.toastSuccess(data.message);
        } else {
          this.toastError(data.msg);
        }
      } catch (err) {
        this.toastError("Something went wrong!");
      }
      this.isSaveLoading = false;
    },
  },
};
</script>
