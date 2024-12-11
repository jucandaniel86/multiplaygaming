import {ref} from 'vue';
import axios from "axios";
import {baseURL} from "./selectors";

export default function useGames() {
  const games = ref([]);
  const totalGames = ref(0);
  const single_game = ref(null);
  const categories = ref([]);
  const gameCategories = ref([]);
  const loaders = ref({
    games: false,
    single_game: false,
  });

  const getGames = async (_data) => {
    loaders.value.games = true;
    try {
      const {data} = await axios.get('/ca-api/games-filter', {
        params: _data
      });
      if (data.data) {
        games.value = data.data.items;
        totalGames.value = data.data.total;
        console.log(data.data.total);
      }
    } catch (err) {
      console.log('useGames(): ', err);
    }
    loaders.value.games = false;
  }

  const getCategoriesWithGames = async () => {
    try {
      const {data} = await axios.get('/ca-api/categories-with-games');
      if (data.data) {
        gameCategories.value = data.data;
      }
    } catch (err) {
      console.log('useGames(): getCategoriesWithGames', err);
    }
  }

  const getSingleGame = async (slug) => {
    loaders.value.single_game = true;
    try {
      const {data} = await axios.get('/ca-api/get-game/' + slug);
      if (data.data) {
        single_game.value = data.data;
      }
    } catch (err) {
      console.log('useGames(): ', err);
    }

    loaders.value.single_game = false;
  }

  const getCategories = async () => {
    try {
      const {data} = await axios.get('/ca-api/game-categories');
      if (data.data) {
        categories.value = data.data;
      }
    } catch (err) {
      console.log('useGames() - getCategories():: ', err);
    }
  }

  return {
    games,
    totalGames,
    single_game,
    loaders,
    categories,
    gameCategories,
    getGames,
    getSingleGame,
    getCategories,
    getCategoriesWithGames
  }
}