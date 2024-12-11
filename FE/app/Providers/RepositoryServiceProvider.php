<?php

  namespace App\Providers;

  use App\Interfaces\{AnnouncesRepositoryInterface,
    ArticleCategoryInterface,
    ArticleRepositoryInterface,
    BannerRepositoryInterface,
    CarrerRepositoryInterface,
    ClientAreaInterface,
    ClientsRepositoryInterface,
    DepartmentsRepositoryInterface,
    FeatureInterface,
    GameDownloadsInterface,
    GameRepositoryInterface,
    GameCategoryInterface,
    PartnersRepositoryInterface,
    PermissionsInterface,
    PhotoUploaderInterface,
    ReportsRepositoryInterface,
    UserInterface
  };
  use App\Repositories\{AnnouncesRepository,
    ArticleCategoryRepository,
    ArticleRepository,
    BannerRepository,
    CarrerRepository,
    ClientAreaRepository,
    ClientsRepository,
    DepartmentRepository,
    FeatureRepository,
    GameDownloads,
    GameRepository,
    GameCategoryRepository,
    PartnerRepository,
    PermissionsRepository,
    PhotoUploaderRepository,
    ReportsRepository,
    UserRepository
  };
  use Illuminate\Support\ServiceProvider;

  class RepositoryServiceProvider extends ServiceProvider
  {
    /**
     * Register services.
     */
    public function register(): void
    {
      $this->app->bind(GameRepositoryInterface::class, GameRepository::class);
      $this->app->bind(GameCategoryInterface::class, GameCategoryRepository::class);
      $this->app->bind(FeatureInterface::class, FeatureRepository::class);
      $this->app->bind(UserInterface::class, UserRepository::class);
      $this->app->bind(ArticleCategoryInterface::class, ArticleCategoryRepository::class);
      $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
      $this->app->bind(PhotoUploaderInterface::class, PhotoUploaderRepository::class);
      $this->app->bind(CarrerRepositoryInterface::class, CarrerRepository::class);
      $this->app->bind(DepartmentsRepositoryInterface::class, DepartmentRepository::class);
      $this->app->bind(AnnouncesRepositoryInterface::class, AnnouncesRepository::class);
      $this->app->bind(PartnersRepositoryInterface::class, PartnerRepository::class);
      $this->app->bind(GameDownloadsInterface::class, GameDownloads::class);
      $this->app->bind(ClientAreaInterface::class, ClientAreaRepository::class);
      $this->app->bind(PermissionsInterface::class, PermissionsRepository::class);
      $this->app->bind(BannerRepositoryInterface::class, BannerRepository::class);
      $this->app->bind(ReportsRepositoryInterface::class, ReportsRepository::class);
      $this->app->bind(ClientsRepositoryInterface::class, ClientsRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
      //
    }
  }
