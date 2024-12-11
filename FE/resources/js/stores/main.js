import {defineStore} from 'pinia';

export const useMainStore = defineStore({
  id: 'customizer',
  state: () => ({
    sidebar_drawer: true,
    breadcrumbs: [],
  }),

  getters: {},
  actions: {
    SET_SIDEBAR_DRAWER() {
      this.sidebar_drawer = !this.sidebar_drawer;
    },

    SET_BREADCRUMBS(payload) {
      this.breadcrumbs = payload;
    }
  }
});
