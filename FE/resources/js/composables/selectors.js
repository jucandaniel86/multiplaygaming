import {ref} from 'vue';
import axios from "axios";

// export const baseURL = "https://bluejackgaming.com";
//
// axios.defaults.baseURL = baseURL;
// axios.defaults.headers.post['Content-Type'] = 'application/json;charset=utf-8';
// axios.defaults.headers.post['Access-Control-Allow-Origin'] = '*';

export default function useSelectors() {
  const volatility = ref([]);
  const rtp = ref([]);
  const volatilityLoading = ref(false);
  const rtpLoading = ref(false);
  const games = ref([]);
  const gamesLoading = ref(false);
  const languages = ref([]);
  const languagesLoading = ref(false);
  const jurisdictions = ref([]);
  const jurisdictionLoader = ref(false);
  const mechanics = ref([]);
  const mechanicsLoader = ref(false);
  const rangeSliders = ref([]);
  const rangeSlidersLoader = ref(false);

  const getVolatility = async () => {
    volatilityLoading.value = true;
    try {
      let {data} = await axios.get('/ca-api/selector/volatility')
      volatility.value = data.data;
    } catch (err) {
      console.log(err);
    }
    volatilityLoading.value = false;
  }

  const getRangeSliders = async () => {
    rangeSlidersLoader.value = true;
    try {
      let {data} = await axios.get('/ca-api/selector/range-sliders')
      rangeSliders.value = data.data;
    } catch (err) {
      console.log(err);
    }
    rangeSlidersLoader.value = false;
  }

  const getMechanics = async () => {
    mechanicsLoader.value = true;
    try {
      let {data} = await axios.get('/ca-api/selector/mechanics')
      mechanics.value = data.data;
    } catch (err) {
      console.log(err);
    }
    mechanicsLoader.value = false;
  }

  const getJurisdictions = async (_params) => {
    jurisdictionLoader.value = true;
    try {
      let {data} = await axios.get('/ca-api/selector/jurisdictions', {
        params: _params,
      })
      jurisdictions.value = data.data;
      throw data.data
    } catch (err) {
      console.log(err);
    }
    jurisdictionLoader.value = false;

  }


  const getLanguages = async () => {
    languagesLoading.value = true;
    try {
      let {data} = await axios.get('/ca-api/selector/languages')
      languages.value = data.data;
    } catch (err) {
      console.log(err);
    }
    languagesLoading.value = false;
  }

  const getRTP = async () => {
    rtpLoading.value = true;
    try {
      let {data} = await axios.get('/ca-api/selector/rtp');
      rtp.value = data.data;
    } catch (err) {
      console.log(err);
    }
    rtpLoading.value = false;
  }

  const getGames = async (type) => {
    gamesLoading.value = true;
    try {
      let {data} = await axios.get('/ca-api/selector/games', {
        params: {
          type
        }
      });
      games.value = data.data;
    } catch (err) {
      console.log(err);
    }
    gamesLoading.value = false;
  }

  return {
    volatility,
    rtp,
    games,
    volatilityLoading,
    rtpLoading,
    gamesLoading,
    languages,
    mechanics,
    rangeSliders,
    languagesLoading,
    jurisdictions,
    jurisdictionLoader,
    mechanicsLoader,
    rangeSlidersLoader,
    getVolatility,
    getRTP,
    getGames,
    getLanguages,
    getJurisdictions,
    getMechanics,
    getRangeSliders
  }
}
