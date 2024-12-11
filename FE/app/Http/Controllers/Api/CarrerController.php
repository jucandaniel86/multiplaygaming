<?php

  namespace App\Http\Controllers\Api;

  use App\Classes\ApiResponseClass;
  use App\Enums\StatusEnum;
  use App\Exceptions\ApiResponseException;
  use App\Http\Controllers\Controller;
  use App\Http\Requests\SaveDepartmentRequest;
  use App\Http\Requests\StoreCarrerRequest;
  use App\Interfaces\CarrerRepositoryInterface;
  use App\Interfaces\DepartmentsRepositoryInterface;
  use App\Models\Cv;
  use Illuminate\Http\JsonResponse;
  use Illuminate\Http\Request;

  use DB;

  class CarrerController extends Controller
  {
    private CarrerRepositoryInterface $carrerRepository;

    public function __construct(CarrerRepositoryInterface $carrerRepository)
    {
      $this->carrerRepository = $carrerRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
      $data = $this->carrerRepository->index($request->all());

      return ApiResponseClass::sendResponse($data, '', 200);
    }

    /**
     * @param StoreCarrerRequest $request
     * @return JsonResponse
     */
    public function store(StoreCarrerRequest $request): JsonResponse
    {
      DB::beginTransaction();
      $details = [
        'job_title' => $request->job_title,
        'job_status' => StatusEnum::DRAFT,
        'created_by' => auth()->user()->id,
        'is_active' => 1
      ];

      try {
        $Job = $this->carrerRepository->store($details);

        DB::commit();
        return ApiResponseClass::sendResponse(
          $Job,
          'The job was created as DRAFT at ' . now()->toDateTimeLocalString() . ' with ID ' . $Job->id,
          201
        );

      } catch (ApiResponseException $ex) {
        ApiResponseClass::rollback($ex);
        return ApiResponseClass::sendError(['message' => $ex->getMessage()], 'Error');
      }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getLastDraft(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->carrerRepository->getlastDraft($request->article_type), 'Success');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getJobById(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->carrerRepository->getById($request->get('id')), 'Success');
    }

    /**
     * @param SaveDepartmentRequest $request
     * @param DepartmentsRepositoryInterface $category
     * @return JsonResponse
     */
    public function saveDepartment(SaveDepartmentRequest $request, DepartmentsRepositoryInterface $departmentsRepository): JsonResponse
    {
      DB::beginTransaction();
      $details = [
        'name' => $request->name,
      ];

      try {
        $department = $departmentsRepository->save($details, $request->get('id'));

        DB::commit();
        return ApiResponseClass::sendResponse(
          $department,
          'Department was saved successfuly',
          201
        );

      } catch (\Exception $ex) {
        ApiResponseClass::rollback($ex);
        return ApiResponseClass::sendError(['error' => $ex->getMessage()], 'Error');
      }
    }

    /**
     * @param Request $request
     * @param DepartmentsRepositoryInterface $departmentsRepository
     * @return JsonResponse
     */
    public function deleteDepartment(Request $request, DepartmentsRepositoryInterface $departmentsRepository): JsonResponse
    {
      return ApiResponseClass::sendResponse($departmentsRepository->delete($request->get('id')), 'The department was deleted successfuly');
    }

    /**
     * @param Request $request
     * @param DepartmentsRepositoryInterface $category
     * @return JsonResponse
     */
    public function departmentList(Request $request, DepartmentsRepositoryInterface $departmentsRepository): JsonResponse
    {
      $data = $departmentsRepository->itemList($request->all());

      return ApiResponseClass::sendResponse($data, '', 200);
    }

    /**
     * @param DepartmentsRepositoryInterface $category
     * @return JsonResponse
     */
    public function departmentsSelector(DepartmentsRepositoryInterface $departmentsRepository): JsonResponse
    {
      return ApiResponseClass::sendResponse($departmentsRepository->index(), '');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
      DB::beginTransaction();
      $details = $request->except(['id', 'DELETED', 'deleted_by', 'created_at', 'updated_at', 'created_by', 'slug']);

      try {
        $Job = $this->carrerRepository->update($details, $request->get('id'));

        DB::commit();
        return ApiResponseClass::sendResponse(
          $Job,
          'The job is saved successfuly',
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
    public function deleteJob(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->carrerRepository->delete($request->get('id')), 'The job was deleted successfuly');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getCvs(Request $request): JsonResponse
    {
      $CVs = Cv::query()->where('job_id', $request->get('job_id'))->get();

      return ApiResponseClass::sendResponse($CVs, 'Success');
    }
  }
