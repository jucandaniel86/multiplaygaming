<?php

  use Illuminate\Support\Facades\Route;
  use \App\Http\Controllers\{HomepageController,
    GamesController,
    ContactController,
    MarketingController,
    PartnersController,
    AboutController,
    ArticlesController,
    CarrerController,
    StaticPagesController,
    ClientAreaController,
    LoginController
  };

  /*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider and all of them will
  | be assigned to the "web" middleware group. Make something great!
  |
  */
  Route::get('/', [HomepageController::class, 'homepage'])->name('fe.home');
  Route::get('/contact', ContactController::class)->name('fe.contact');
//  Route::get('/homepage', [HomepageController::class, 'homepage'])->name('fe.homepage');

  //games
  Route::get('/games', [GamesController::class, 'index'])->name('fe.games');
  Route::get('/game/{slug}', [GamesController::class, 'game'])->name('fe.games.single');
  Route::get('/game-type/{slug}', [GamesController::class, 'index'])->name('fe.games.game_type');

  //marketing
  Route::prefix('marketing')->group(function () {
    Route::get('/tools', [MarketingController::class, 'tools'])->name('fe.marketing.tools');
    Route::get('/tailored-experiences', [MarketingController::class, 'brandsExclusive'])->name('fe.marketing.brandsExclusive');
    Route::get('/game-sets-promo', [MarketingController::class, 'gameSetsPromo'])->name('fe.marketing.gameSetsPromo');
  });
  //partners
  Route::prefix('partners')->group(function () {
    Route::get('/clients', [PartnersController::class, 'clients'])->name('fe.partners.clients');
    Route::get('/studios', [PartnersController::class, 'studios'])->name('fe.partners.studios');
  });
  //about
  Route::prefix('about')->group(function () {
    Route::get('/company', [AboutController::class, 'company'])->name('fe.about.company');
    Route::get('/careers', [AboutController::class, 'careers'])->name('fe.about.careers');
    Route::get('/responsible-gaming', [AboutController::class, 'responsibleGaming'])->name('fe.about.responsibleGaming');
  });
  //articles
  Route::prefix('/articles')->group(function () {
    Route::get('/', [ArticlesController::class, 'articles'])->name('fe.articles');
    Route::get('/news', [ArticlesController::class, 'news'])->name('fe.articles.news');
    Route::get('/{slug}/{id}', [ArticlesController::class, 'single'])->name('fe.articles.single');
  });
  //careers
  Route::get('/jobs/{slug}/{id}', [CarrerController::class, 'single'])->name('fe.careers.single');

  //static pages
  Route::get('/privacy-policy', [StaticPagesController::class, 'privacyPolicy'])->name('fe.privacy');
  Route::get('/sitemap', [StaticPagesController::class, 'sitemap'])->name('fe.sitemap');

  Route::get('/client-area', [ClientAreaController::class, 'index'])->middleware('auth')->name('fe.clientArea');
  Route::get('/client-area/{any}', [ClientAreaController::class, 'pages'])
    ->middleware('auth')
    ->where('any', '.*');

  Route::get('/login', LoginController::class)->name('login');
  Route::post('/user-login', [LoginController::class, 'postLogin'])->name('fe.login');

  Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'getLogout'])->name('fe.logout');
    Route::get('/me', function () {
      return auth()->user();
    });
  });

  Route::view('/mail-preview', 'mails.support');

  require __DIR__ . '/client-area.php';
