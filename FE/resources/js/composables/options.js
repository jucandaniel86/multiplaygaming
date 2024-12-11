import {ref} from "vue";
import axios from "axios";
import {baseURL} from "./selectors";

axios.defaults.baseURL = baseURL;
axios.defaults.headers.post['Content-Type'] = 'application/json;charset=utf-8';
axios.defaults.headers.post['Access-Control-Allow-Origin'] = '*';

export default function useOptions() {

  const options = ref([])
  const option = ref(null);

  const getOptions = async (_options) => {
    try {
      const {data} = await axios.get('/ca-api/options', {
        params: {
          options: _options
        }
      });
      if (data.data) {
        let _options = {};
        data.data.forEach(el => {
          _options[el.option_name] = el.option_value;
        })
        options.value = _options;
      }
    } catch (err) {
      console.warn('getOptions()', err);
    }
  }

  const getOption = async (_optionName) => {
    const {data} = await axios.get('/ca-api/option', {
      params: {
        option_name: _optionName
      }
    });
    if (data.data) {
      option.value = data.data;
    }
    if (data.data) {
      options.value = data;
    }
  }

  return {
    option,
    options,
    getOption,
    getOptions
  }
}
