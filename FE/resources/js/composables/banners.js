import {ref} from 'vue';
import axios from "axios";

export default function useBanners() {
  const banners = ref([]);

  const getBanners = async () => {
    try {
      const {data} = await axios.get('/ca-api/banners');
      banners.value = data.data;
    } catch (err) {
      console.warn('useBanners(): getBanners', err);
    }
  }

  return {
    banners,
    getBanners
  }
}
