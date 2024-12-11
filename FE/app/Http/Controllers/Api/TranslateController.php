<?php

  namespace App\Http\Controllers\Api;

  use App\Classes\ApiResponseClass;
  use App\Http\Controllers\Controller;
  use Illuminate\Http\JsonResponse;
  use Illuminate\Http\Request;
  use Spatie\TranslationLoader\LanguageLine;
  use Artisan;

  class TranslateController extends Controller
  {
    /**
     * @return JsonResponse
     */
    public function getFiles(): JsonResponse
    {
      $Files = LanguageLine::query()->selectRaw('DISTINCT `group` as label')->get();
      return ApiResponseClass::sendResponse($Files, '');
    }

    /**
     * @return JsonResponse
     */
    public function reloadCache(): JsonResponse
    {
      Artisan::call('view:clear');
      Artisan::call('queue:restart');
//      Artisan::call('config:cache');
      return ApiResponseClass::sendResponse(['success' => true, 'message' => 'Cache was clear successfuly!'], '');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveFile(Request $request): JsonResponse
    {
      $request->validate([
        'language' => 'required|array'
      ]);

      foreach ($request->get('language') as $lang) {
        LanguageLine::updateOrCreate(
          ['group' => $lang['group'], 'key' => $lang['key']],
          [
            'group' => $lang['group'],
            'key' => $lang['key'],
            'text' => [
              'en' => $lang['text']['en']
            ],
          ]);
      }

      return ApiResponseClass::sendResponse(['success' => true], 'Language successfuly updated!');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getLines(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse(
        LanguageLine::query()
          ->where('group', $request->get('group'))
          ->when($request->has('search'), function ($query) use ($request) {
            $query->whereRaw('(`key` LIKE "%' . $request->get('search') . '%" OR `text` LIKE "%' . $request->get('search') . '%")');
          })
          ->get(),
        ''
      );
    }
  }
