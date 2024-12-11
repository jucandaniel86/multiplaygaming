<?php

  namespace App\Http\Controllers\Api;

  use App\Classes\ApiResponseClass;
  use App\Http\Controllers\Controller;
  use App\Interfaces\ReportsRepositoryInterface;
  use Illuminate\Http\JsonResponse;
  use Illuminate\Http\Request;

  class ReportsController extends Controller
  {
    private ReportsRepositoryInterface $reportsRepository;

    public function __construct(ReportsRepositoryInterface $reportsRepository)
    {
      $this->reportsRepository = $reportsRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function gamesReport(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->reportsRepository->gamesReport($request), '');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDashboard(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->reportsRepository->getDashboard($request), '');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAvgPlayersPerDay(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->reportsRepository->getAvgPlayersPerDay($request), '');
    }

    /**
     * @return JsonResponse
     */
    public function top10Games(): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->reportsRepository->top10Games(), '');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getSummaryByStudios(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->reportsRepository->getSummaryByStudios($request), '');
    }

    /**
     * @return JsonResponse
     */
    public function getCurrencies(): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->reportsRepository->getCurrencies(), '');
    }
  }
