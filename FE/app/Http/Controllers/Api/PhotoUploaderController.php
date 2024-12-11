<?php

  namespace App\Http\Controllers\Api;

  use App\Classes\ApiResponseClass;
  use App\Exceptions\ApiResponseException;
  use App\Http\Controllers\Controller;
  use App\Http\Requests\PhotoUploaderRequest;
  use App\Interfaces\PhotoUploaderInterface;
  use Illuminate\Http\JsonResponse;

  class PhotoUploaderController extends Controller
  {
    private PhotoUploaderInterface $photoUploader;

    public function __construct(PhotoUploaderInterface $photoUploader)
    {
      $this->photoUploader = $photoUploader;
    }

    /**
     * @param PhotoUploaderRequest $request
     * @return JsonResponse
     */
    public function upload(PhotoUploaderRequest $request): JsonResponse
    {
      try {
        return ApiResponseClass::sendResponse($this->photoUploader->upload($request->validated()), 'The Photo was successfuly saved');
      } catch (ApiResponseException $exception) {
        return ApiResponseClass::sendError([
          'message' => $exception->getMessage(),
          'line' => $exception->getLine(),
          'code' => $exception->getCode(),
          'file' => $exception->getFile(),
        ], 'Error');
      }
    }
  }
