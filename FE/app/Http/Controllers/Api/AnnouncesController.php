<?php

  namespace App\Http\Controllers\Api;

  use App\Classes\ApiResponseClass;
  use App\Http\Controllers\Controller;
  use App\Interfaces\AnnouncesRepositoryInterface;
  use Carbon\Carbon;
  use Illuminate\Http\JsonResponse;
  use Illuminate\Http\Request;
  use Illuminate\Support\Str;
  use DB;

  class AnnouncesController extends Controller
  {
    private AnnouncesRepositoryInterface $announcesRepository;

    public function __construct(AnnouncesRepositoryInterface $announcesRepository)
    {
      $this->announcesRepository = $announcesRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
      $data = $this->announcesRepository->index($request->all());

      return ApiResponseClass::sendResponse($data, '', 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function save(Request $request): JsonResponse
    {
      DB::beginTransaction();
      $details = [
        'title' => $request->title,
        'subtitle' => $request->subtitle,
        'slug' => Str::slug($request->title),
        'link' => $request->link,
        'is_active' => $request->has('is_active') ? (int)$request->is_active : 1,
        'started_at' => Carbon::createFromDate($request->started_at),
        'ended_at' => Carbon::createFromDate($request->ended_at),
        'description' => $request->description,
      ];

      try {
        $SavedItem = $this->announcesRepository->save($details, $request->get('id'));

        DB::commit();
        return ApiResponseClass::sendResponse(
          $SavedItem,
          'Announce was saved successfuly',
          201
        );

      } catch (\Exception $ex) {
        ApiResponseClass::rollback($ex);
        return ApiResponseClass::sendError(['error' => $ex->getMessage()], 'Error');
      }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteAnnounce(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse(
        $this->announcesRepository->delete((int)$request->get('id')),
        'Success'
      );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getActiveAnnounces(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse(
        $this->announcesRepository->getActiveAnnounce(
          $request->has('more_than_one') ? true : false,
          $request->has('random') ? true : false,
        ),
        'Success'
      );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getList(Request $request): JsonResponse
    {
      $data = $this->announcesRepository->itemList($request->all());

      return ApiResponseClass::sendResponse($data, '', 200);
    }
  }
