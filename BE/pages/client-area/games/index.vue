<template>
	<v-row>
		<v-col cols="12">
			<div class="bg-light rounded h-100 p-4">
				<SharedPageHeader :title="'Games'"></SharedPageHeader>

				<v-data-table :headers="headers" :items="items" :options.sync="options" :server-items-length="totalItems"
					:loading="loading" :search="searchText" class="pa-2" :height="550">
					<template v-slot:top>
						<v-row class="align-center">
							<v-col cols="3">
								<v-text-field v-model="formSearch.title" label="Search" chips></v-text-field>
							</v-col>
							<v-col cols="3">
								<selector-game-categories v-model="formSearch.category_id" :default-value="formSearch.category_id"
									:key="`FilterCategory`" />
							</v-col>
							<v-col cols="2">
								<selector-status v-model="formSearch.game_status" :default-value="formSearch.game_status" />
							</v-col>
							<v-col cols="2">
								<button-loading @on-click="getDataFromApi" :is-loading="loading" :btn-class="'btn-primary w-100 mb-4'"
									:icon="'fa-search'" :text="'Filter'" />
							</v-col>
						</v-row>
					</template>

					<template v-slot:item="{ item }">
						<tr>
							<td>{{ item.game_id || "N/A" }}</td>
							<td>{{ item.game_name }}</td>
							<td style="width: 35%">
								<v-btn color="primary" v-can="'clients_area_games_downloads'" small @click.prevent="assets(item)">
									<v-icon color="white" small>mdi-multimedia</v-icon>
								</v-btn>
								<v-btn color="primary" v-can="'clients_area_games_downloads'" small @click.prevent="downloads(item)">
									<v-icon color="white" small>mdi-download</v-icon>
								</v-btn>
								<v-btn v-can="'clients_area_games_edit'" color="primary" small @click.prevent="edit(item)">
									<v-icon color="white" small>mdi-pencil</v-icon>
								</v-btn>
							</td>
						</tr>
					</template>
				</v-data-table>
			</div>
		</v-col>
	</v-row>
</template>
<script>
export default {
	name: "Games",
	layout: "backend",
	middleware: ["auth"],
	data: () => ({
		page: 1,
		totalItems: 0,
		items: [],
		loading: true,
		searchText: "",
		options: {},
		formSearch: {
			status: "",
			title: "",
			category_id: 0,
			game_status: "",
		},
		headers: [
			{
				text: "Game ID",
				align: "start",
				sortable: false,
				value: "game_id",
				width: "7%",
			},
			{
				text: "Name",
				align: "start",
				sortable: false,
				value: "game_name",
				width: "70%",
			},
			{ text: "Actions", value: "iron", width: "20%" },
		],
	}),
	watch: {
		options: {
			handler() {
				this.getDataFromApi();
			},
			deep: true,
		},
		'formSearch.title'() {
			if (this.formSearch.title.length > 2 || this.formSearch.title.length === 0) {
				this.options.page = 1;
				this.getDataFromApi();
			}
		}
	},
	mounted() {
		this.$root.$on("refresh-list", () => this.getDataFromApi());
		this.$root.$on("games:edit-flags", () => this.getDataFromApi());
	},
	methods: {
		edit(item) {
			this.$router.push({
				name: "client-area-games-id",
				params: { id: item.id },
			});
		},

		downloads(item) {
			this.$router.push({
				name: "client-area-games-downloads-id",
				params: { id: item.id },
			});
		},

		assets(item) {
			this.$router.push({
				name: "client-area-games-assets-id",
				params: { id: item.id },
			});
		},

		async getDataFromApi() {
			this.loading = true;
			try {
				const { page, itemsPerPage } = this.options;

				const { data } = await this.$axios.get("/games/list", {
					params: {
						start: page,
						length: itemsPerPage,
						status: this.formSearch.status,
						search: this.formSearch.title,
						category_id: this.formSearch.category_id,
						featured_game: this.formSearch.featured_game,
						game_status: this.formSearch.game_status,
					},
				});

				this.items = data.data.items;
				this.totalItems = data.data.total;
				this.page = page;
			} catch (err) {
				this.toastError("Something went wrong!");
			}
			this.loading = false;
		},
	},
};
</script>
