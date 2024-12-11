<template>
	<div class="container-fluid pt-4 px-4">
		<div class="row g-4">
			<div class="col-12">
				<div class="bg-light rounded h-100 p-4">
					<div class="d-flex align-items-center justify-content-between mb-4">
						<h6 class="mb-0">{{ pageTitle }}</h6>
						<div>
							<button class="btn btn-primary" style="margin-left: 0.5rem" @click="goBackToGames">
								Go back to list
							</button>
						</div>
					</div>
					<!-- d-flex align-items-center justify-content-between mb-4 -->

					<v-row>
						<v-col cols="9">
							<SharedCardHeader :title="'General Settings'">
								<template v-slot:content>
									<v-text-field v-model="form.game_name" :counter="true" @blur="createGame" label="Game name" />
									<div class="v-messages theme--light" role="alert" v-if="form.slug">
										<div class="v-messages__wrapper">
											<div class="v-messages__message message-transition-enter-to">
												Game URL:
												<a :href="`${$config.FRONTEND_ENDPOINT}/game/${form.slug}`" target="_blank">{{
													`${$config.FRONTEND_ENDPOINT}/game/${form.slug}`
												}}</a>
											</div>
										</div>
									</div>

									<app-texteditor :label="'Short Description'" v-model="form.short_description"
										:default-value="form.short_description" />
									<app-texteditor :label="'Description'" v-model="form.description" :default-value="form.description" />
									<selector-date v-model="form.release_date" :default-value="form.release_date"
										:label="'Release Date'" />
									<selector-mechanics v-model="form.mechanics_id" :default-value="form.mechanics_id" />

									<h6>Description Image</h6>
									<v-img v-if="form.description_img_url" :src="form.description_img_url
											? form.description_img_url
											: `https://via.assets.so/img.jpg?w=${sizes.descriptionImage.w}&h=${sizes.descriptionImage.h}&tc=blue&bg=#cccccc`
										" lazy-src="https://picsum.photos/id/11/10/6" height="250" contain>
									</v-img>
									<selector-image @photo:save="saveDescriptionImg" :img-sizes="sizes.descriptionImage"
										:key="'DescriptionImageSelector'" />
								</template>
							</SharedCardHeader>

							<SharedCardHeader :title="'SEO'" v-if="!actionsDisabled">
								<template v-slot:content>
									<seo :main-image="form.thumbnail_url" :save-disabled="actionsDisabled" :default-form="form"
										@seo:update="onSeoUpdate" @seo:save="saveSeo" />
								</template>
							</SharedCardHeader>

							<SharedCardHeader :title="'Features'">
								<template v-slot:content>
									<v-simple-table class="no-border">
										<template v-slot:default>
											<tbody>
												<tr>
													<td>
														<selector-volatility v-model="form.volatility" :default-value="form.volatility" />
													</td>
													<td>
														<v-text-field v-model="form.rtp" label="RTP (without %)" />
													</td>
												</tr>
												<tr>
													<td>
														<v-text-field v-model="form.lines" label="Lines  (numbers only)" />
													</td>
													<td>
														<v-text-field v-model="form.fs_rate" label="FS Rate  (numbers only)" />
													</td>
												</tr>
												<tr>
													<td>
														<v-text-field v-model="form.hit_rate" label="Hit Rate (numbers only)" />
													</td>
													<td>
														<v-text-field v-model="form.max_multiplier" label="Max Multiplier (numbers only)" />
													</td>
												</tr>
												<tr>
													<td>
														<v-text-field v-model="form.max_win" label="Max Win  (numbers only)" />
													</td>
													<td>
														<v-text-field v-model="form.game_id" label="Game ID" />
													</td>
												</tr>
											</tbody>
										</template>
									</v-simple-table>
								</template>
							</SharedCardHeader>

							<SharedCardHeader :title="'Features Details'" v-if="!actionsDisabled">
								<template v-slot:content>
									<v-responsive :max-width="'100%'" class="mx-auto mb-4">
										<selector-features v-model="searchFeature" />
									</v-responsive>

									<v-progress-linear v-if="isFeaturesLoading" indeterminate color="primary"></v-progress-linear>
									<div style="
                      overflow-x: hidden;
                      overflow-y: scroll;
                      height: 300px;
                    ">
										<v-row v-for="(feature, i) in features" :key="`${feature.feature_id}_${i}`" class="align-center">
											<v-col cols="4">
												{{ feature.feature.name }}
											</v-col>
											<v-col cols="5">
												<v-textarea label="Content" v-model="feature.content" />
											</v-col>
											<v-col cols="3">
												<div class="d-flex gap-2">
													<v-btn x-small text color="primary" @click.prevent="saveFeature(feature)">
														<v-icon>mdi-content-save</v-icon>
													</v-btn>
													<v-btn x-small text color="primary" @click.prevent="removeFeature(feature)">
														<v-icon>mdi-trash-can-outline</v-icon>
													</v-btn>
												</div>
											</v-col>
										</v-row>
									</div>
								</template>
							</SharedCardHeader>

							<SharedCardHeader :title="'Gallery'" v-if="!actionsDisabled">
								<template v-slot:content>
									<v-progress-linear v-if="isGalleryLoading" indeterminate color="primary"></v-progress-linear>
									<v-row>
										<v-col cols="3" v-for="(img, i) in gallery" :key="`Gallery${i}`">
											<v-card>
												<v-img :src="img.thumbnail" height="125" class="grey darken-4">
													<template v-slot:placeholder>
														<v-row class="fill-height ma-0" align="center" justify="center">
															<v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
														</v-row>
													</template>
												</v-img>
												<v-card-title class="text-h6">
													<v-btn x-small text color="primary" @click.prevent="deletePhoto(img.id)">
														<v-icon>mdi-trash-can-outline</v-icon>
														<span>Delete Photo</span>
													</v-btn>
												</v-card-title>
											</v-card>
										</v-col>
									</v-row>
								</template>
								<template v-slot:footer>
									<div class="d-flex w-100 justify-end align-end mt-2 pa-2">
										<selector-image @photo:save="savePhotoGallery" :img-sizes="{ w: 664, h: 420 }" />
									</div>
								</template>
							</SharedCardHeader>

							<SharedCardHeader :title="'External Link'">
								<template v-slot:content>
									<v-textarea v-model="form.demo_url" label="Demo URL" />
									<v-textarea v-model="form.trailer_url" label="Trailer URL" />
									<v-textarea v-model="form.rules_url" label="Rules URL" />
									<v-textarea v-model="form.promo_pack_url" label="Promo Pack URL" />
									<v-textarea v-model="form.mediapack_url" label="Media Pack URL" />
								</template>
							</SharedCardHeader>

							<SharedCardHeader :title="'DEMO'" v-if="!actionsDisabled">
								<template v-slot:content>
									<v-text-field v-model="form.demo_text_header" label="Header Text" />
									<v-img v-if="form.demo_img_url" :src="form.demo_img_url
											? form.demo_img_url
											: `https://via.assets.so/img.jpg?w=${sizes.demo.w}&h=${sizes.demo.h}&tc=blue&bg=#cccccc`
										" lazy-src="https://picsum.photos/id/11/10/6" height="30vh">
									</v-img>
								</template>
								<template v-slot:footer>
									<div class="d-flex justify-end pa-2">
										<selector-image @photo:save="saveDemoImg" :img-sizes="sizes.demo" :key="'DemoSelector'" />
									</div>
								</template>
							</SharedCardHeader>
						</v-col>
						<v-col cols="3">
							<!-- save options -->
							<div class="sticky-top">
								<SharedCardHeader :title="'Save Options'">
									<template v-slot:content>
										<v-row v-if="form.created_at">
											<v-col cols="12">
												<v-chip small>Created at: {{ formatDate(form.created_at) }}</v-chip>
											</v-col>
										</v-row>
										<v-row v-if="form.game_status">
											<v-col cols="12">
												<v-chip small>Status: <b>{{ form.game_status }}</b></v-chip>
											</v-col>
										</v-row>

										<v-row v-if="!actionsDisabled">
											<v-col cols="12">
												<v-checkbox :hide-details="true" v-model="form.featured_game" :value="1" :true-value="1"
													:false-value="0" label="Featured Game" />
												<v-checkbox :hide-details="true" v-model="form.is_branded" :value="1" :true-value="1"
													:false-value="0" label="Branded" />
												<v-checkbox :hide-details="true" v-model="form.is_coming_soon" :value="1" :true-value="1"
													:false-value="0" label="Coming Soon" />
												<v-checkbox :hide-details="true" v-model="form.homepage_slider" :value="1" :true-value="1"
													:false-value="0" label="HP Carousel" />
											</v-col>
										</v-row>

										<v-row v-if="!actionsDisabled">
											<v-col cols="12">
												<v-btn small text color="red" @click.prevent="deleteItem">
													<v-icon color="red">mdi-delete-alert</v-icon>
													Delete
												</v-btn>
											</v-col>
										</v-row>
										<v-row v-if="!actionsDisabled">
											<v-col cols="12">
												<div class="d-flex justify-between align-center pt-2 pb-2 gap-2">
													<v-btn small color="green" @click.prevent="saveStatus('published')">
														<v-icon color="white">mdi-publish</v-icon>
														Publish
													</v-btn>
													<v-btn small color="yellow" @click.prevent="saveStatus('private')">
														<v-icon color="white">mdi-publish-off</v-icon>
														Private
													</v-btn>
												</div>
											</v-col>
										</v-row>
									</template>
									<template v-slot:footer>
										<button-loading v-if="!actionsDisabled" @on-click="save" :is-loading="isSaveLoading"
											:btn-class="'btn-primary py-3 w-100 mb-4'" :icon="'fa-save'" style="max-width: 100%"
											:text="'General Save'" />
									</template>
								</SharedCardHeader>

								<SharedCardHeader :title="'Category'">
									<template v-slot:content>
										<selector-game-categories v-model="form.category_id" :default-value="form.category_id"
											:key="`Category${newCategoryID}`" />
										<v-btn text @click.prevent="isCategoryOpen = !isCategoryOpen">
											<v-icon>add</v-icon>
											Add new category
										</v-btn>
										<div v-if="isCategoryOpen" class="d-flex justify-content-center align-center">
											<v-text-field v-model="category.name" />
											<v-btn small :disabled="isCategoryLoading" @click.prevent="saveCategory">Save</v-btn>
										</div>
									</template>
								</SharedCardHeader>

								<SharedCardHeader :title="'Thumbnail (landscape)'" v-if="!actionsDisabled">
									<template v-slot:content>
										<v-img v-if="form.thumbnail_url" :src="form.thumbnail_url
												? form.thumbnail_url
												: `https://via.assets.so/img.jpg?w=${sizes.thumbnail.w}&h=${sizes.thumbnail.h}&tc=blue&bg=#cccccc`
											" lazy-src="https://picsum.photos/id/11/10/6" height="30vh">
										</v-img>
									</template>
									<template v-slot:footer>
										<div class="d-flex justify-center pa-2">
											<selector-image @photo:save="saveThumbnail" :img-sizes="sizes.thumbnail"
												:key="'ThumbnailSelector'" />
										</div>
									</template>
								</SharedCardHeader>

								<SharedCardHeader :title="'Thumbnail (portrait)'" v-if="!actionsDisabled">
									<template v-slot:content>
										<v-img v-if="form.thumbnail_small_url" :src="form.thumbnail_small_url
												? form.thumbnail_small_url
												: `https://via.assets.so/img.jpg?w=${sizes.thumbnail_small.w}&h=${sizes.thumbnail_small.h}&tc=blue&bg=#cccccc`
											" lazy-src="https://picsum.photos/id/11/10/6" height="30vh">
										</v-img>
									</template>
									<template v-slot:footer>
										<div class="d-flex justify-center pa-2">
											<selector-image @photo:save="saveThumbnailSmall" :img-sizes="sizes.thumbnail_small"
												:key="'ThumbnailSelector'" />
										</div>
									</template>
								</SharedCardHeader>
							</div>
						</v-col>
					</v-row>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import moment from "moment";
import Seo from "../Seo.vue";

export default {
	name: "GamesForm",
	components: { Seo },
	props: {
		pageTitle: {
			type: String,
			required: false,
			default: "Undefined Title",
		},
		defaultForm: {
			type: Object,
			required: true,
		},
	},
	data() {
		return {
			actionsDisabled: true,
			item: null,
			isLoading: false,
			isSaveLoading: false,
			isCategoryOpen: false,
			isCategoryLoading: false,
			isFeaturesLoading: false,
			isGalleryLoading: false,
			newCategoryID: "",
			searchFeature: "",
			sizes: {
				thumbnail: {
					w: 800,
					h: 485,
				},
				thumbnail_small: {
					w: 711,
					h: 900,
				},
				demo: {
					w: 1728,
					h: 670,
				},
				descriptionImage: {
					w: 614,
					h: 507,
				},
			},
			features: [],
			gallery: [],
			category: {
				name: "",
			},
			form: {
				id: 0,
				game_name: "",
				category_id: 0,
				featured_game: 0,
				is_branded: 0,
				is_coming_soon: 0,
				homepage_slider: 0,
				slug: "",
				short_description: "",
				game_status: "",
				description: "",
				game_id: "",
				volatility: "na",
				rtp: "",
				lines: "",
				fs_rate: "",
				hit_rate: "",
				max_multiplier: "",
				max_win: "",
				release_date: "",
				demo_url: "",
				trailer_url: "",
				rules_url: "",
				thumbnail: "",
				meta_title: "",
				meta_description: "",
				thumbnail_url: "",
				demo_img_url: "",
				description_img_url: "",
				demo_text_header: "",
				thumbnail_small_url: "",
				thumbnail_small: "",
				mediapack_url: "",
				mechanics_id: 0,
			},
		};
	},
	watch: {
		"form.id"() {
			if (this.form.id > 0) {
				this.actionsDisabled = false;
				this.getFeatures();
				this.getGallery();
			} else {
				this.actionsDisabled = true;
			}
		},
		defaultForm() {
			this.form = {
				...this.form,
				...this.defaultForm,
			};
		},
		searchFeature() {
			this.addFeature(this.searchFeature);
		},
	},

	created() {
		if (this.defaultForm) {
			this.form = {
				...this.form,
				...this.defaultForm,
			};
		}
	},

	methods: {
		goBackToGames() {
			this.$router.push({
				name: "games",
				query: {
					page: this.$route.query.page || 1,
				}
			});
		},

		onSeoUpdate(form) {
			this.form = { ...this.form, ...form };
		},

		async savePhotoGallery(_input) {
			try {
				var formData = new FormData();

				formData.append("file", _input);
				formData.append("game_id", this.form.id);
				formData.append(
					"details",
					JSON.stringify({
						width: 664,
						height: 420,
					})
				);

				const { data } = await this.$axios.post("/games/add-photo", formData, {
					headers: {
						"Content-Type": "multipart/form-data",
					},
				});

				if (data.success) {
					this.toastSuccess(data.message);
					this.getGallery();
				} else {
					this.toastError(data.message);
				}
			} catch (err) {
				console.warn("[GameGallery]", err);
			}
		},

		async getGallery() {
			if (this.actionsDisabled) return false;

			this.isGalleryLoading = true;

			try {
				const { data } = await this.$axios.get("/games/gallery", {
					params: {
						game_id: this.form.id,
					},
				});
				if (data.success) {
					this.gallery = data.data;
				}
			} catch (err) {
				console.warn("[GameGallery::Err]", err);
			}

			this.isGalleryLoading = false;
		},

		async deletePhoto(ID) {
			this.confirmDelete().then(async (result) => {
				if (result.value) {
					try {
						const { data } = await this.$axios.delete("/games/delete-photo", {
							params: {
								img_id: ID,
							},
						});
						if (data.success) {
							this.toastSuccess(data.message);
							this.getGallery();
						} else {
							this.toastError(data.message || "Something went wrong!");
						}
					} catch (err) {
						this.toastError("Something went wrong!");
					}
				}
			});
		},

		async addFeature(feature_id) {
			if (this.features.findIndex((el) => el === feature_id) !== -1) {
				return false;
			}

			try {
				const { data } = await this.$axios.post("/games/add-feature", {
					feature_id,
					game_id: this.form.id,
				});
				if (data.success) {
					this.getFeatures();
				}
			} catch (err) {
				console.warn("[GameCreate::Err]", err);
			}
		},

		async saveFeature(feature) {
			try {
				const { data } = await this.$axios.post(
					"/games/update-feature",
					feature
				);
				if (data.success) {
					this.toastSuccess(data.message);
				}
			} catch (err) {
				console.warn("[GameCreate::Err]", err);
			}
		},

		async removeFeature(feature) {
			try {
				const { data } = await this.$axios.delete("/games/remove-feature", {
					params: feature,
				});
				if (data.success) {
					this.getFeatures();
				}
			} catch (err) {
				console.warn("[GameCreate::Err]", err);
			}
		},

		async getFeatures() {
			if (this.actionsDisabled) return false;
			this.isFeaturesLoading = true;
			try {
				const { data } = await this.$axios.get("/games/game-features", {
					params: {
						game_id: this.form.id,
					},
				});
				if (data.success) {
					this.features = data.data;
				}
			} catch (err) {
				console.warn("[GameFeatures::Err]", err);
			}
			this.isFeaturesLoading = false;
		},

		async saveSeo() {
			if (!this.form.id) return false;
			try {
				const { data } = await this.$axios.post("/games/update", {
					meta_title: this.form.meta_title,
					meta_description: this.form.meta_description,
					slug: this.form.slug,
					id: this.form.id,
				});

				if (data.success) {
					this.toastSuccess(data.message);
				}
			} catch (err) {
				console.warn("[GameCreate::Err]", err);
			}
		},

		async saveStatus(_status) {
			if (!this.form.id) return false;
			try {
				const { data } = await this.$axios.post("/games/update", {
					...this.form,
					game_status: _status,
					id: this.form.id,
				});

				if (data.success) {
					this.toastSuccess(data.message);
					this.$router.push({
						name: "games-edit-id",
						params: { id: this.form.id },
					});
				}
				//@todo :: redirect to games edit
			} catch (err) {
				console.warn("[GameCreate::Err]", err);
			}
		},

		async saveCategory() {
			if (this.category.name === "") return false;

			this.isCategoryLoading = true;
			try {
				const { data } = await this.$axios.post(
					"/categories/save",
					this.category
				);
				if (data.success) {
					this.form.category_id = data.data.id;
					this.category.name = "";
					this.isCategoryOpen = false;
					this.$root.$emit("categoies:save-category");
				} else {
					this.toastError("Something went wrong!");
				}
			} catch (err) {
				console.warn("[GameCreate::Err]", err);
				this.toastError("Something went wrong!");
			}
		},

		async createGame() {
			if (this.form.id !== 0 || this.form.game_name === "") return false;
			try {
				const { data } = await this.$axios.post("/games/create", {
					game_name: this.form.game_name,
				});
				if (data.success) {
					this.form = {
						...data.data,
					};
					if (typeof data.message !== "undefined") {
						this.toastSuccess(data.message);
					}
				}
			} catch (err) {
				console.warn("[GameCreate::Err]", err);
			}
		},

		async save() {
			this.isSaveLoading = true;
			try {
				const { data } = await this.$axios.post("/games/update", {
					...this.form,
				});

				if (data.success) {
					this.toastSuccess(data.message);
				} else {
					this.toastError(data.message);
				}
			} catch (err) {
				this.axiosErrorAlert(err);
			}
			this.isSaveLoading = false;
		},

		formatDate(date) {
			return moment(date).format("DD MM YYYY hh:mm:ss");
		},

		async deleteItem() {
			const ID = this.form.id;
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
							this.goBackToGames();
						} else {
							this.toastError(data.message || "Something went wrong!");
						}
					} catch (err) {
						this.toastError("Something went wrong!");
					}
				}
			});
		},

		async saveThumbnail(_input) {
			await this.savePhoto(_input, "thumbnail", "thumbnail_url");
		},

		async saveThumbnailSmall(_input) {
			await this.savePhoto(_input, "thumbnail_small", "thumbnail_small_url");
		},

		async saveDemoImg(_input) {
			await this.savePhoto(_input, "demo_img", "demo_img_url");
		},

		async saveDescriptionImg(_input) {
			await this.savePhoto(_input, "description_img", "description_img_url");
		},

		async savePhoto(_input, _column, _displayedColumn) {
			try {
				var formData = new FormData();

				formData.append("file", _input);
				formData.append("id", this.form.id);
				formData.append("table", "games");
				formData.append("column", _column);

				const { data } = await this.$axios.post("/photo-uploader", formData, {
					headers: {
						"Content-Type": "multipart/form-data",
					},
				});

				if (data.success) {
					this.toastSuccess(data.message);
					this.form[_displayedColumn] = data.data.file;
					this.$forceUpdate();
				} else {
					this.toastError(data.message);
				}
			} catch (err) {
				console.warn("[GameGallery]", err);
			}
		},
	},
};
</script>
