export const state = () => ({
  currentWebsite: 0,
	websiteDetails: {},
});

export const mutations = {
  changeWebsite(state, payload) {
		state.currentWebsite = payload;

		if(process.client){
			localStorage.setItem("currentWebsite", JSON.stringify(payload));
		}
	},
	changeWebsiteDetails(state, payload) {
		state.websiteDetails = payload;
	}
}

export const getters = {
  getCurrentWebsite(state) {
    return state.currentWebsite;
  }
}