<?php

	namespace App\Http\Controllers\Api;

	use App\Classes\ApiResponseClass;
	use App\Http\Controllers\Controller;
	use App\Http\Requests\GameDownloadsRequest;
	use App\Interfaces\GameDownloadsInterface;
	use App\Models\Game;
	use App\Traits\QueryTrait;
	use Illuminate\Http\JsonResponse;
	use Illuminate\Http\Request;

	use DB;

	class GameDownloadsController extends Controller
	{
		use QueryTrait;

		private GameDownloadsInterface $service;

		public function __construct(GameDownloadsInterface $service)
		{
			$this->service = $service;
		}

		/**
		 * @param Request $request
		 * @return JsonResponse
		 */
		public function getGame(Request $request): JsonResponse
		{
			return ApiResponseClass::sendResponse($this->getByID(Game::query(), $request->get('id'))['item'], '');
		}

		/**
		 * @param GameDownloadsRequest $request
		 * @return JsonResponse
		 */
		public function upload(GameDownloadsRequest $request): JsonResponse
		{
			DB::beginTransaction();

			try {
				$SavedItem = $this->service->upload($request);

				DB::commit();
				return ApiResponseClass::sendResponse(
					$SavedItem,
					'Entry was saved successfuly',
					201
				);

			} catch (\Exception $ex) {
				ApiResponseClass::rollback($ex);
			}
		}

		/**
		 * @param GameDownloadsRequest $request
		 * @return JsonResponse
		 */
		public function uploadAssets(Request $request): JsonResponse
		{
			$request->validate([
				'download_file' => 'required|mimes:zip'
			]);

			DB::beginTransaction();

			try {
				$SavedItem = $this->service->uploadAssets($request);

				DB::commit();
				return ApiResponseClass::sendResponse(
					$SavedItem,
					'Entry was saved successfuly',
					201
				);

			} catch (\Exception $ex) {
				ApiResponseClass::rollback($ex);
			}
		}

		/**
		 * @param Request $request
		 * @return JsonResponse
		 */
		public function list(Request $request): JsonResponse
		{
			return ApiResponseClass::sendResponse($this->service->list($request->get('game_id')), '');
		}

		/**
		 * @param Request $request
		 * @return JsonResponse
		 */
		public function delete(Request $request): JsonResponse
		{
			return ApiResponseClass::sendResponse($this->service->delete($request->get('id')), '');
		}
	}