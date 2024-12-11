<template>
	<v-row>
		<v-col cols="12">
			<div class="bg-light rounded h-100 p-4">
				<SharedPageHeader :title="'Games'">
					<template v-slot:content>
						<button class="btn btn-primary" @click.prevent="add">
							Add new
						</button>
					</template>
				</SharedPageHeader>

				<v-data-table :headers="headers" :items="items" :options.sync="options" :server-items-length="totalItems"
					:loading="loading" :search="searchText" class="pa-2" :height="550">
					<template v-slot:top>
						<v-row class="align-end">
							<v-col cols="3">
								<v-text-field v-model="formSearch.title" label="Search" chips></v-text-field>
							</v-col>
							<v-col cols="3">
								<selector-game-categories v-model="formSearch.category_id" :default-value="formSearch.category_id"
									:key="`FilterCategory`" />
							</v-col>
							<v-col cols="2">
								<v-select :items="[
									{ id: -1, label: 'all' },
									{ id: 1, label: 'yes' },
									{ id: 0, label: 'no' },
								]" :item-text="'label'" :item-value="'id'" v-model="formSearch.featured_game" label="Featured Game"></v-select>
							</v-col>
							<v-col cols="2">
								<selector-status v-model="formSearch.game_status" :default-value="formSearch.game_status" />
							</v-col>
							<v-col cols="2" class="d-flex align-self-center">
								<button-loading @on-click="getDataFromApi" :is-loading="loading" :btn-class="'btn-primary w-100'"
									:icon="'fa-search'" :text="'Filter'" />
							</v-col>
						</v-row>
					</template>

					<template v-slot:item="{ item }">
						<tr>
							<td>{{ item.game_id || "N/A" }}</td>
							<td>
								<v-img v-if="item.thumbnail_url" :src="item.thumbnail_url" lazy-src="https://picsum.photos/id/11/10/6"
									width="100" class="ma-1">
								</v-img>
							</td>
							<td>
								{{ item.game_name }}
								<br />
								<v-chip v-if="item.created_at" x-small>
									Created at: {{ formatDate(item.created_at) }}</v-chip>
							</td>
							<td>
								{{ item.category ? item.category.name : "N/A" }}
							</td>
							<td>{{ item.rtp || "N/A" }}</td>
							<td>{{ item.fs_rate || "N/A" }}</td>
							<td>{{ item.hit_rate || "N/A" }}</td>
							<td>
								<span class="badge" :class="gameStatus(item)">{{
									item.game_status
								}}</span>
							</td>
							<td>
								<span class="badge" :class="{
									'badge-success': item.featured_game,
									'badge-warning': !item.featured_game,
								}">{{ item.featured_game ? "Yes" : "No" }}</span>
							</td>
							<td>
								<button type="button" class="btn btn-square btn-primary m-2" @click.prevent="edit(item)">
									<i class="fa fa-pencil-alt"></i>
								</button>
								<button type="button" class="btn btn-square btn-primary text-center"
									@click.prevent="deleteItem(item.id)">
									<i class="fas fa-trash"></i>
								</button>
								<game-flags :game="item" />
							</td>
						</tr>
					</template>
				</v-data-table>
			</div>
		</v-col>
	</v-row>
</template>
<script>
import moment from "moment";
import GameFlags from "./flags.vue";

export default {
	name: "Games",
	layout: "backend",
	middleware: ["auth"],
	components: { GameFlags },
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
			featured_game: -1,
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
				text: "Thumbnail",
				align: "start",
				sortable: false,
				value: "thumbnail_url",
				width: "7%",
			},
			{
				text: "Name",
				align: "start",
				sortable: false,
				value: "game_name",
			},
			{
				text: "Category",
				align: "start",
				sortable: false,
				value: "category",
			},
			{
				text: "RTP",
				align: "start",
				sortable: false,
				value: "rtp",
			},
			{
				text: "FS Rate",
				align: "start",
				sortable: false,
				value: "fs_rate",
			},
			{
				text: "Hit Rate",
				align: "start",
				sortable: false,
				value: "fs_rate",
			},
			{
				text: "Status",
				align: "start",
				sortable: false,
				value: "active",
			},
			{
				text: "Featured Game",
				align: "start",
				sortable: false,
				value: "featured_game",
			},
			{ text: "Actions", value: "iron", width: "15%" },
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

		if (this.$route.query.page) {
			this.options.page = this.$route.query.page;
		}
	},
	methods: {
		add() {
			this.$router.push({ name: "games-add" });
		},

		edit(item) {
			this.$router.push({
				name: "games-edit-id",
				params: { id: item.id },
				query: { page: this.page }
			});
		},

		formatDate(date) {
			return moment(date).format("DD MM YYYY hh:mm:ss");
		},

		gameStatus(item) {
			return {
				"badge-success": item.game_status === "published",
				"badge-warning": item.game_status === "draft",
				"badge-danger": item.game_status === "private",
			};
		},

		async getDataFromApi() {
			this.loading = true;
			try {
				let { page, itemsPerPage } = this.options;

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

				this.page = page;
				this.items = data.data.items;
				this.totalItems = data.data.total;
			} catch (err) {
				this.toastError("Something went wrong!");
			}
			this.loading = false;
		},

		async deleteItem(ID) {
			this.confirmDelete().then(async (result) => {
				if (result.value) {
					try {
						const { data } = await this.$axios.delete("/games/delete", {
							params: {
								id: ID,
							},
						});
						if (data.success) {
							this.toastSuccess(data.message);
							this.getDataFromApi();
						} else {
							this.toastError(data.err || "Something went wrong!");
						}
					} catch (err) {
						this.toastError("Something went wrong!");
					}
				}
			});
		},
	},
};
</script>
