<template>
	<v-row>
		<v-col cols="12">
			<div class="px-4">
				<v-progress-linear v-if="loading" indeterminate color="primary"></v-progress-linear>
			</div>
			<div :class="{ 'disabled-user-actions': loading }">
				<games-form :page-title="pageTitle" :default-form="item" />
			</div>
		</v-col>
	</v-row>
</template>
<script>
export default {
	layout: "backend",
	middleware: ["auth"],
	data: () => ({
		pageTitle: "Edit game",
		loading: true,
		item: {},
	}),
	created() {
		this.getGame();
	},
	methods: {
		async getGame() {
			const id = this.$route.params.id;
			try {
				const { data } = await this.$axios.get("/games/game-by-id", {
					params: {
						id,
					},
				});
				if (data.success) {
					this.item = data.data;
				} else {
					this.goBackToGames();
				}
			} catch (err) {
				console.warn("[GameController]", err);
				this.toastError("Game not found!");
				this.goBackToGames();
			}
			this.loading = false;
		},
		goBackToGames() {
			this.$router.push({
				name: "games",
				query: {
					page: this.$route.query.page || 1,
				}
			});
		},
	},
};
</script>
