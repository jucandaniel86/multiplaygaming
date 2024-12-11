<?php

  namespace App\Interfaces;

  use Illuminate\Http\Request;

  interface GameRepositoryInterface
  {
    public function index(array $params = []);

    public function getById($id);

    public function getBySlug($slug);

    public function store(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function getlastDraft();

    public function addFeatureToGame(array $params = []);

    public function getGameFeatures($gameID);

    public function updateGameFeature($params);

    public function deleteGameFeature($params);

    public function addPhotoGallery($params);

    public function getGallery($gameID);

    public function deletePhotoGallery($imgID);

    public function getRelatedGamesByCatgory($categoryID, $currentGameID, $limit = 3);

    public function filterGames(array $params, array $relations, $sort = []): array;

    public function mechanicsList(Request $request): array;

    public function allMechanics();

    public function saveMechanics(Request $request);

    public function deleteMechanics(Request $request);

    public function getCategoriesWithGames();
  }
