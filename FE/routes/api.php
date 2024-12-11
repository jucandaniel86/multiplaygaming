<?php

	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Route;

	use App\Http\Controllers\Auth\LoginController;
	use App\Http\Controllers\Auth\LogoutController;

	use App\Http\Controllers\Api\{SelectorsController,
		GamesController,
		UsersController,
		ArticlesController,
		PhotoUploaderController,
		CarrerController,
		FrontendController,
		AnnouncesController,
		PartnersController,
		JurisdictionController,
		GameDownloadsController,
		ClientAreaController,
		GameMechanicsController,
		GoogleBigQueryController,
		BannerController,
		ReportsController,
		TranslateController,
		ClientsController
	};

	use App\Http\Controllers\Permissions\{PermissionsController, RolesController};

	/*
	|--------------------------------------------------------------------------
	| API Routes
	|--------------------------------------------------------------------------
	|
	| Here is where you can register API routes for your application. These
	| routes are loaded by the RouteServiceProvider and all of them will
	| be assigned to the "api" middleware group. Make something great!
	|
	*/

	Route::middleware('auth:api')->get('/user', function (Request $request) {
		$User = $request->user();
		$User->permissions = $User->getPermissionsViaRoles();

		return ['user' => $User];
	});

	Route::post('/login', LoginController::class);

	Route::middleware('auth:api')->group(function () {
		#logout
		Route::post('/logout', LogoutController::class);

		#selectors
		Route::prefix('selector')->group(function () {
			Route::get('/status', [SelectorsController::class, 'getStatusTypes']);
			Route::get('/volatility', [SelectorsController::class, 'getVolatility']);
			Route::get('/game-categories', [GamesController::class, 'gameCategoriesSelector']);
			Route::get('/article-categories', [ArticlesController::class, 'categoriesSelector']);
			Route::get('/features', [GamesController::class, 'getFeaturesDropdown']);
			Route::get('/article-types', [SelectorsController::class, 'getArticleTypes']);
			Route::get('/departments', [CarrerController::class, 'departmentsSelector']);
			Route::get('/jurisdictions', [SelectorsController::class, 'getJurisdictions']);
			Route::get('/permission-categories', [SelectorsController::class, 'getPermissionsCategory']);
			Route::get('/roles', [SelectorsController::class, 'getRoles']);
			Route::get('/mechanics', [SelectorsController::class, 'getMechanics']);
			Route::get('/games', [SelectorsController::class, 'getGames']);
			Route::get('/countries', [SelectorsController::class, 'getCountries']);
			Route::get('/brands', [SelectorsController::class, 'getBrands']);
		});

		#games
		Route::prefix('games')->group(function () {
			Route::post('/create', [GamesController::class, 'store']);
			Route::post('/update', [GamesController::class, 'update']);
			Route::get('/draft', [GamesController::class, 'getLastDraft']);
			Route::get('/game-by-id', [GamesController::class, 'getGameById']);
			Route::delete('/delete', [GamesController::class, 'deleteGame']);
			Route::get('/list', [GamesController::class, 'index']);
			Route::post('/add-feature', [GamesController::class, 'addFeatureToGame']);
			Route::post('/update-feature', [GamesController::class, 'updateGameFeature']);
			Route::get('/game-features', [GamesController::class, 'getGameFeatures']);
			Route::delete('/remove-feature', [GamesController::class, 'deleteGameFeature']);
			Route::post('/add-photo', [GamesController::class, 'addPhotoGallery']);
			Route::get('/gallery', [GamesController::class, 'getGallery']);
			Route::delete('/delete-photo', [GamesController::class, 'deletePhotoGallery']);
			Route::post('/update-details', [GamesController::class, 'updateDetails']);
			Route::get('/details', [GamesController::class, 'getDetails']);
			Route::get('/get', [GameDownloadsController::class, 'getGame']);
			Route::post('/upload-download', [GameDownloadsController::class, 'upload']);
			Route::post('/upload-assets', [GameDownloadsController::class, 'uploadAssets']);
			Route::get('/downloads-list', [GameDownloadsController::class, 'list']);
			Route::delete('/delete-download', [GameDownloadsController::class, 'delete']);
		});

		#features
		Route::prefix('features')->group(function () {
			Route::post('/save', [GamesController::class, 'saveFeature']);
			Route::get('/list', [GamesController::class, 'featuresList']);
			Route::delete('/delete', [GamesController::class, 'deleteFeature']);
		});

		#mechanics
		Route::prefix('mechanics')->group(function () {
			Route::get('/list', [GameMechanicsController::class, 'list']);
			Route::post('/save', [GameMechanicsController::class, 'save']);
			Route::delete('/delete', [GameMechanicsController::class, 'delete']);
		});

		#jurisdictions
		Route::prefix('jurisdictions')->group(function () {
			Route::post('/save', [JurisdictionController::class, 'save']);
			Route::get('/list', [JurisdictionController::class, 'list']);
			Route::delete('/delete', [JurisdictionController::class, 'delete']);
		});

		#game categories
		Route::prefix('categories')->group(function () {
			Route::post('/save', [GamesController::class, 'saveCategory']);
			Route::delete('/delete', [GamesController::class, 'deleteCategory']);
			Route::get('/list', [GamesController::class, 'categoriesList']);
		});

		#users
		Route::prefix('users')->group(function () {
			Route::get('/list', [UsersController::class, 'getUsersList']);
			Route::post('/save', [UsersController::class, 'createUser']);
			Route::post('/update', [UsersController::class, 'updateUser']);
			Route::delete('/delete', [UsersController::class, 'deleteUser']);
			Route::post('/change-password', [UsersController::class, 'changePassword']);
		});

		#articles
		Route::prefix('articles')->group(function () {
			Route::get('/list', [ArticlesController::class, 'index']);
			Route::post('/create', [ArticlesController::class, 'store']);
			Route::post('/update', [ArticlesController::class, 'update']);
			Route::get('/draft', [ArticlesController::class, 'getLastDraft']);
			Route::get('/game-by-id', [ArticlesController::class, 'getGameById']);
			Route::delete('/delete', [ArticlesController::class, 'deleteArticle']);
		});

		#articles categories
		Route::prefix('article-categories')->group(function () {
			Route::post('/save', [ArticlesController::class, 'saveCategory']);
			Route::delete('/delete', [ArticlesController::class, 'deleteCategory']);
			Route::get('/list', [ArticlesController::class, 'categoriesList']);
		});

		#partners
		Route::prefix('partners')->group(function () {
			Route::post('/save', [PartnersController::class, 'save']);
			Route::post('/priority', [PartnersController::class, 'updatePriority']);
			Route::delete('/delete', [PartnersController::class, 'delete']);
			Route::get('/list', [PartnersController::class, 'list']);
		});

		#banners
		Route::prefix('banners')->group(function () {
			Route::post('/save', [BannerController::class, 'save']);
			Route::delete('/delete', [BannerController::class, 'delete']);
			Route::get('/list', [BannerController::class, 'list']);
		});


		#departments
		Route::prefix('departments')->group(function () {
			Route::post('/save', [CarrerController::class, 'saveDepartment']);
			Route::delete('/delete', [CarrerController::class, 'deleteDepartment']);
			Route::get('/list', [CarrerController::class, 'departmentList']);
		});

		#carrers
		Route::prefix('carrers')->group(function () {
			Route::get('/list', [CarrerController::class, 'index']);
			Route::post('/create', [CarrerController::class, 'store']);
			Route::post('/update', [CarrerController::class, 'update']);
			Route::get('/draft', [CarrerController::class, 'getLastDraft']);
			Route::get('/game-by-id', [CarrerController::class, 'getJobById']);
			Route::delete('/delete', [CarrerController::class, 'deleteJob']);
			Route::get('/cvs', [CarrerController::class, 'getCvs']);
		});

		#announces
		Route::prefix('announces')->group(function () {
			Route::post('/save', [AnnouncesController::class, 'save']);
			Route::delete('/delete', [AnnouncesController::class, 'deleteAnnounce']);
			Route::get('/list', [AnnouncesController::class, 'getList']);
			Route::get('/active', [AnnouncesController::class, 'getActiveAnnounces']);
		});

		#client area options
		Route::prefix('client-area')->group(function () {
			Route::get('option', [ClientAreaController::class, 'option']);
			Route::get('options', [ClientAreaController::class, 'options']);
			Route::post('save', [ClientAreaController::class, 'save']);
		});

		#permissions
		Route::prefix('permissions')->group(function () {
			Route::get('list', [PermissionsController::class, 'list']);
			Route::get('all', [PermissionsController::class, 'all']);
			Route::post('save', [PermissionsController::class, 'save']);
			Route::delete('delete', [PermissionsController::class, 'delete']);
		});

		#roles
		Route::prefix('roles')->group(function () {
			Route::get('list', [RolesController::class, 'list']);
			Route::post('save', [RolesController::class, 'save']);
			Route::get('get', [RolesController::class, 'get']);
			Route::delete('delete', [RolesController::class, 'delete']);
		});

		Route::post('/photo-uploader', [PhotoUploaderController::class, 'upload']);

		#translation
		Route::prefix('lang')->group(function () {
			Route::get('/files', [TranslateController::class, 'getFiles']);
			Route::get('/lines', [TranslateController::class, 'getLines']);
			Route::get('/clear-cache', [TranslateController::class, 'reloadCache']);
			Route::post('/save', [TranslateController::class, 'saveFile']);
		});

		#reports
		Route::prefix('reports')->group(function () {
			Route::get('games', [ReportsController::class, 'gamesReport']);
			Route::get('dashboard', [ReportsController::class, 'getDashboard']);
			Route::get('players-per-day', [ReportsController::class, 'getAvgPlayersPerDay']);
			Route::get('top-10-games', [ReportsController::class, 'top10Games']);
			Route::get('summary-by-studios', [ReportsController::class, 'getSummaryByStudios']);
			Route::get('currencies', [ReportsController::class, 'getCurrencies']);
		});

		#clients
		Route::prefix('clients')->group(function () {
			Route::get('/list', [ClientsController::class, 'list']);
			Route::post('/save', [ClientsController::class, 'store']);
			Route::delete('/delete', [ClientsController::class, 'delete']);
			Route::get('/brands-list', [ClientsController::class, 'brandsList']);
			Route::post('/save-brand', [ClientsController::class, 'storeBrand']);
			Route::delete('/delete-brand', [ClientsController::class, 'deleteBrand']);
			Route::post('/save-tax', [ClientsController::class, 'storeTax']);
			Route::delete('/delete-tax', [ClientsController::class, 'deleteTax']);
			Route::get('/taxes-list', [ClientsController::class, 'getTaxesList']);
		});
	});

	#FRONTEND
	Route::get('/article-filter', [FrontendController::class, 'filterArticles']);
	Route::get('/jobs-filter', [FrontendController::class, 'filterJobs']);
	Route::get('/games-filter', [FrontendController::class, 'filterGames']);
	Route::post('/newsletter', [FrontendController::class, 'subscribeToNewsletter']);
	Route::post('/submit-contact', [FrontendController::class, 'submitContact']);
	Route::post('/submit-your-cv', [FrontendController::class, 'uploadCV']);


	Route::get('/big-query', [GoogleBigQueryController::class, 'test']);
	Route::get('/currency', [GoogleBigQueryController::class, 'currencies']);