<?php

	namespace App\Http\Controllers\Api;

	use App\Classes\ApiResponseClass;
	use App\Http\Controllers\Controller;
	use App\Http\Requests\NewsletterRequest;
	use App\Http\Requests\UploadCvRequest;
	use App\Interfaces\ArticleRepositoryInterface;
	use App\Interfaces\CarrerRepositoryInterface;
	use App\Interfaces\GameRepositoryInterface;
	use App\Models\Cv;
	use App\Models\Newsletter;
	use Illuminate\Http\JsonResponse;
	use Illuminate\Http\Request;
	use Illuminate\Support\Js;
	use Illuminate\Support\Str;
	use Spatie\FlareClient\Api;

	class FrontendController extends Controller
	{

		/**
		 * @param Request $request
		 * @return array
		 */
		private function generateSort(Request $request): array
		{
			$sort = [
				'column' => 'id',
				'direction' => 'desc'
			];

			if ($request->has('sort_by')) {
				switch ($request->get('sort_by')) {
					case 'release_date_recent':
						{
							$sort = [
								'column' => 'release_date',
								'direction' => 'desc'
							];
						}
						break;
					case 'date_recent':
						{
							$sort = [
								'column' => 'id',
								'direction' => 'desc'
							];
						}
						break;
					case 'date_oldest':
						{
							$sort = [
								'column' => 'id',
								'direction' => 'asc'
							];
						}
						break;
					case 'az':
						{
							$sort = [
								'column' => 'game_name',
								'direction' => 'asc'
							];
						}
						break;
					case 'rtp_high':
						{
							$sort = [
								'column' => 'rtp',
								'direction' => 'desc'
							];
						}
						break;
					case 'rtp_low':
						{
							$sort = [
								'column' => 'rtp',
								'direction' => 'asc'
							];
						}
						break;
					case 'volatility_very_high':
						{
							$sort = [
								'column' => 'volatility_order_points',
								'direction' => 'desc'
							];
						}
						break;
					case 'volatility_low':
						{
							$sort = [
								'column' => 'volatility_order_points',
								'direction' => 'asc'
							];
						}
						break;
					case 'multiplier_high':
						{
							$sort = [
								'column' => 'max_multiplier',
								'direction' => 'desc'
							];
						}
						break;
					case 'multiplier_low':
						{
							$sort = [
								'column' => 'max_multiplier',
								'direction' => 'asc'
							];
						}
						break;
					default:
						{
							$sort = [
								'column' => 'id',
								'direction' => 'desc'
							];
						}
				}
			}

			return $sort;
		}

		/**
		 * @param Request $request
		 * @param ArticleRepositoryInterface $articleRepository
		 * @return JsonResponse
		 */
		public function filterArticles(Request $request, ArticleRepositoryInterface $articleRepository): JsonResponse
		{
			try {
				$sort = $this->generateSort($request);

				return ApiResponseClass::sendResponse(
					$articleRepository->filterArticles($request->all(), ['category'], $sort)
					, '');
			} catch (\Exception $exception) {
				return ApiResponseClass::sendError(['message' => $exception->getMessage()], 'Error');
			}
		}

		/**
		 * @param Request $request
		 * @param CarrerRepositoryInterface $carrerRepository
		 * @return JsonResponse
		 */
		public function filterJobs(Request $request, CarrerRepositoryInterface $carrerRepository): JsonResponse
		{
			try {
				$params = $request->all();
				$sort = $this->generateSort($request);
				if (!$request->has('search')) {
					$params['search'] = "";
				}
				return ApiResponseClass::sendResponse(
					$carrerRepository->filterJobs($params, ['department'], $sort), '');
			} catch (\Exception $exception) {
				return ApiResponseClass::sendError(['message' => $exception->getMessage()], 'Error');
			}
		}

		/**
		 * @param NewsletterRequest $request
		 * @return JsonResponse
		 */
		public function subscribeToNewsletter(NewsletterRequest $request): JsonResponse
		{
			try {
				$Newsletter = new Newsletter();
				$Newsletter->email = $request->get('email');
				$Newsletter->news_subscription = $request->has('news_subscription') ? (int)$request->get('news_subscription') : 0;
				$Newsletter->catalog_subscription = $request->has('catalog_subscription') ? (int)$request->get('catalog_subscription') : 0;
				$Newsletter->consultation_subscription = $request->has('consultation_subscription') ? (int)$request->get('consultation_subscription') : 0;
				$Newsletter->save();

				return ApiResponseClass::sendResponse($Newsletter, 'Success');
			} catch (\Exception $exception) {
				return ApiResponseClass::sendError(['message' => $exception->getMessage()], 'Error');
			}
		}

		/**
		 * @param Request $request
		 * @return JsonResponse
		 */
		public function submitContact(Request $request): JsonResponse
		{
			$request->validate([
				'name' => 'required',
				'email' => 'required|email',
				'subject' => 'required',
				'message' => 'required'
			]);

			try {

				$email = $request->get('email');
				$name = $request->get('name');

				$to = config('website.support_email');
//        $to = "jucan.daniel1@gmail.com";
				$subject = 'Contact :: ' . env('APP_NAME');

				$headers = 'From: ' . config('website.support_email') . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

				$message = view('mails.support', [
					'name' => $name,
					'email' => $email,
					'subject' => $request->get('subject'),
					'message' => $request->get('message'),
				])->render();

				mail($to, $subject, $message, $headers);

				return ApiResponseClass::sendResponse([
					'success' => true,
					'message' => 'Success',
					'data' => 'Sended to:: ' . config('website.support_email')
				], 'Success');
			} catch (\Exception $exception) {
				return ApiResponseClass::sendError(['message' => $exception->getMessage()], 'Error');
			}
		}

		/**
		 * @param Request $request
		 * @param GameRepositoryInterface $gameRepository
		 * @return JsonResponse
		 */
		public function filterGames(Request $request, GameRepositoryInterface $gameRepository): JsonResponse
		{
			try {
				$params = $request->all();
				$sort = $this->generateSort($request);

				return ApiResponseClass::sendResponse(
					$gameRepository->filterGames($params, [
						'category',
						'details',
					], $sort),
					'Success'
				);
			} catch (\Exception $exception) {
				return ApiResponseClass::sendError(['message' => $exception->getMessage()], 'Error');
			}
		}

		/**
		 * @param $slug
		 * @param GameRepositoryInterface $gameRepository
		 * @return JsonResponse
		 */
		public function getGameBySlug($slug, GameRepositoryInterface $gameRepository): JsonResponse
		{
			try {
				return ApiResponseClass::sendResponse($gameRepository->getBySlug($slug, ['downloads']), 'Success');
			} catch (\Exception $exception) {
				return ApiResponseClass::sendError(['message' => $exception->getMessage()], 'Error');
			}
		}

		/**
		 * @param UploadCvRequest $request
		 * @return JsonResponse
		 */
		public function uploadCV(UploadCvRequest $request): JsonResponse
		{
			$path = config('website.paths.cvs');
			$fileName = "";

			//upload cv
			if ($request->hasFile('cv')) {
				$cvFile = $request->file('cv');
				$fileName = Str::slug($request->get('name')) . '_' . Str::random(6) . '.' . $cvFile->getClientOriginalExtension();

				$cvFile->move(public_path($path), $fileName);
			}

			//save to database
			try {
				$Cv = new Cv();
				$Cv->name = $request->input('name');
				$Cv->email = $request->input('email');
				$Cv->job_id = (int)$request->input('career');
				$Cv->cv = $fileName;
				$Cv->save();

				return ApiResponseClass::sendResponse([], 'Thank you! Your submission has been received!');

			} catch (\Exception $exception) {
				return ApiResponseClass::sendError(['message' => $exception->getMessage()], 'Oops! Something went wrong while submitting the form.');
			}
		}

		/**
		 * @param GameRepositoryInterface $gameRepository
		 * @return JsonResponse
		 */
		public function getCategoriesWithGames(GameRepositoryInterface $gameRepository): JsonResponse
		{
			return ApiResponseClass::sendResponse($gameRepository->getCategoriesWithGames(), '');
		}
	}