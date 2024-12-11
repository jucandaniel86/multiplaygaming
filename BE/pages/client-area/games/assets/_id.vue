<template>
	<div>
		<v-overlay v-if="loading" color="white" z-index="9999" opacity="1">
			<v-progress-circular indeterminate color="primary"></v-progress-circular>
		</v-overlay>
		<v-row v-else>
			<v-col cols="12">
				<div class="bg-light rounded h-100 p-4">
					<SharedPageHeader :title="'Assets (' + game_name + ')'">
						<template v-slot:content>
							<button class="btn btn-primary" @click.prevent="backToGames">
								Back to games
							</button>
						</template>
					</SharedPageHeader>

					<v-row>
						<v-col cols="12" md="12">
							<div class="d-flex justify-space-between align-center gap-2">
								<v-file-input v-model="form.download_file" label="Zip File" accept=".zip" />
								<button-loading @on-click="save" :is-loading="isSaveLoading" :btn-class="'btn-primary py-3 w-100 mb-4'"
									:icon="'fa-save'" style="max-width: 200px" :text="'Save'" />
							</div>
						</v-col>
						<v-col cols="12" md="12">
							<v-card>
								<v-card-title>Assets List</v-card-title>
								<v-card-text>
									<v-progress-linear indeterminate v-if="listLoading"></v-progress-linear>
									<v-simple-table fixed-header height="300" :class="{ opacity: listLoading }">
										<thead>
											<tr>
												<th>Image</th>
												<th>Name</th>
												<th>Width</th>
												<th>Height</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
											<tr v-for="(download, i) in list" :key="`Downloads${i}`">
												<td>
													<v-img v-if="download.download_url" :src="download.download_url" width="100" class="ma-1">
													</v-img>
												</td>
												<td>{{ download.name }}</td>
												<td>{{ formatSize(download.width) }}px</td>
												<td>{{ formatSize(download.height) }}px</td>
												<td>
													<div class="d-flex ga-2 align-center">
														<v-btn color="primary" x-small @click="deleteItem(download.id)">
															<i class="fas fa-trash"></i>
														</v-btn>
													</div>
												</td>
											</tr>
										</tbody>
									</v-simple-table>
								</v-card-text>
							</v-card>
						</v-col>
					</v-row>
				</div>
			</v-col>
		</v-row>
	</div>
</template>
<script>
export default {
	name: "GamesCAAssets",
	layout: "backend",
	middleware: ["auth"],
	data: () => ({
		loading: false,
		listLoading: false,
		isSaveLoading: false,
		list: [],
		form: {
			download_file: [],
		},
	}),
	async created() {
		await this.getDetails();
		await this.getList();
	},
	mounted() {
		this.$root.$on("downloads:update-item", this.getList);
	},
	methods: {
		resetForm() {
			this.form = {
				download_file: [],
			};
		},
		backToGames() {
			this.$router.push({
				name: "client-area-games",
			});
		},
		formatSize(size) {
			return new Number(size).toFixed(0)
		},
		async getDetails() {
			this.loading = true;
			try {
				const { data } = await this.$axios.get("/games/get", {
					params: {
						id: this.$route.params.id,
					},
				});

				this.game_name = data.data.game_name;
			} catch (err) {
				console.warn("GameController [id]:: ", err);
			}
			this.loading = false;
		},
		async getList() {
			this.listLoading = true;
			try {
				const { data } = await this.$axios.get("/games/downloads-list", {
					params: {
						game_id: this.$route.params.id,
					},
				});
				this.list = data.data;
			} catch (err) {
				console.warn("GameDownloadsList err::", err);
			}
			this.listLoading = false;
		},
		async save() {
			this.isSaveLoading = true;
			try {
				var formData = new FormData();
				formData.append("game_id", this.$route.params.id);
				formData.append("download_file", this.form.download_file);

				const { data } = await this.$axios.post(
					"/games/upload-assets",
					formData,
					{
						headers: {
							"Content-Type": "multipart/form-data",
						},
					}
				);

				if (data.success) {
					this.toastSuccess(data.message);
					this.getList();
				} else {
					this.toastError(data.msg);
				}
			} catch (err) {
				this.toastError("Something went wrong!");
			}
			this.isSaveLoading = false;
		},

		async deleteItem(ID) {
			this.confirmDelete().then(async (result) => {
				if (result.value) {
					try {
						const { data } = await this.$axios.delete(
							"/games/delete-download",
							{
								params: {
									id: ID,
								},
							}
						);
						if (data.success) {
							this.toastSuccess("The entry was saved successfuly");
							this.getList();
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
<style scoped>
.opacity {
	opacity: 0.5;
}
</style>
