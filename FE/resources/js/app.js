import 'vuetify/styles' // Global CSS has to be imported
import {createApp} from 'vue';
import {createVuetify} from 'vuetify';
import {PerfectScrollbarPlugin} from 'vue3-perfect-scrollbar';
import App from './App.vue';
import router from "./router";
import axios from 'axios';

import {createPinia} from 'pinia';

import 'vuetify/styles';

// export const baseURL = "https://bluejackgaming.com";
import {baseURL} from "./config";

const axiosInstance = axios.create({
  withCredentials: true,
  baseURL: baseURL,
  headers: {
    'Content-Type': 'application/json;charset=utf-8',
    'Access-Control-Allow-Origin': '*'
  }
})

const app = createApp(App);
app.config.globalProperties.$axios = {...axiosInstance}

import 'material-design-icons-iconfont/dist/material-design-icons.css'

import {icons} from './layouts/theme/mdi-icon';
import {aliases, mdi} from 'vuetify/iconsets/mdi-svg';
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import {PurpleTheme} from "./layouts/theme/LightTheme";

const vuetify = createVuetify({
  components,
  directives,
  iconfont: 'mdi',
  icons: {
    defaultSet: 'mdi',
    aliases: {
      ...aliases,
      ...icons
    },
    sets: {
      mdi
    }
  },
  theme: {
    defaultTheme: 'PurpleTheme',
    themes: {
      PurpleTheme
    }
  },
})


app.use(router);
app.use(vuetify);
app.use(PerfectScrollbarPlugin);
app.use(createPinia());
app.mount('#app')
