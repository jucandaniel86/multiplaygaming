<?php

  namespace App\Http\Controllers\Api;

  use App\Classes\ApiResponseClass;
  use App\Enums\ArticleTypesEnum;
  use App\Enums\DownloadType;
  use App\Enums\StatusEnum;
  use App\Enums\VolatilityEnum;
  use App\Http\Controllers\Controller;
  use App\Models\ClientBrand;
  use App\Models\Country;
  use App\Models\Game;
  use App\Models\GameDetails;
  use App\Models\GameDownload;
  use App\Models\GameMechanics;
  use App\Models\Jurisdiction;
  use App\Models\Language;
  use App\Models\PermissionsCategory;
  use Illuminate\Http\JsonResponse;
  use Illuminate\Http\Request;
  use Spatie\Permission\Models\Role;

  class SelectorsController extends Controller
  {
    /**
     * @return JsonResponse
     */
    public function getStatusTypes(): JsonResponse
    {
      $_return = [];
      foreach (StatusEnum::cases() as $case) {
        if ($case->value === StatusEnum::DELETED->value) continue;
        $_return[] = [
          'id' => $case->value,
          'label' => $case->description(),
        ];
      }
      return ApiResponseClass::sendResponse($_return, '');
    }

    /**
     * @return JsonResponse
     */
    public function getVolatility(): JsonResponse
    {
      $_return = [];
      foreach (VolatilityEnum::cases() as $case) {
        $_return[] = [
          'id' => $case->value,
          'label' => $case->description(),
        ];
      }
      return ApiResponseClass::sendResponse($_return, '');
    }

    /**
     * @return JsonResponse
     */
    public function getArticleTypes(): JsonResponse
    {
      $_return = [];
      foreach (ArticleTypesEnum::cases() as $case) {
        $_return[] = [
          'id' => $case->value,
          'label' => $case->description(),
        ];
      }
      return ApiResponseClass::sendResponse($_return, '');
    }

    public function getRTP(): JsonResponse
    {
      $DistrinctRTP = Game::query()
        ->selectRaw('DISTINCT rtp as d_rtp')
        ->where('rtp', '!=', 0)
        ->where('game_status', StatusEnum::PUBLISHED->value)
        ->where('DELETED', 0)
        ->orderBy('rtp', 'desc')
        ->get();
      $_return = [];

      foreach ($DistrinctRTP as $rtp) {
        $_return[] = [
          'id' => $rtp->d_rtp,
          'label' => $rtp->d_rtp . '%',
        ];
      }
      return ApiResponseClass::sendResponse($_return, '');
    }

    public function getGames(Request $request): JsonResponse
    {
      $type = $request->get('type');

      switch ($type) {
        case "media-pack":
          {
            return ApiResponseClass::sendResponse(Game::query()->where(
              'game_status', StatusEnum::PUBLISHED->value
            )
              ->where('mediapack_url', '!=', '')
              ->selectRaw('id, mediapack_url, game_name as label')
              ->get()
              , '');
          }
          break;
        default:
          {
            return ApiResponseClass::sendResponse(Game::query()->where(
              'game_status', StatusEnum::PUBLISHED->value
            )->selectRaw('id, game_name as label')
              ->get()
              , '');
          }
      }

    }

    public function getJurisdictions(Request $request): JsonResponse
    {
      $type = $request->get('type');

      switch ($type) {
        case "downloads":
          {
            $jurisdictions = Jurisdiction::query()
              ->selectRaw('jurisdictions.name, game_downloads.download_value, game_downloads.download_type')
              ->join('game_downloads', 'jurisdictions.id', '=', 'game_downloads.jurisdiction_id')
              ->where('game_id', $request->get('game_id'))
              ->get();
            $_return = [];
            foreach ($jurisdictions as $jurisdiction) {
              $downloadUrl = '';
              if ($jurisdiction->download_type === DownloadType::FILE->value) {
                $downloadUrl = url(config('website.paths.downloads') . $jurisdiction->download_value);
              } else {
                $downloadUrl = $jurisdiction->download_value;
              }

              $_return[] = [
                'id' => $downloadUrl,
                'label' => $jurisdiction->name,
              ];
            }

            return ApiResponseClass::sendResponse($_return, '');
          }
          break;
        default:
          return ApiResponseClass::sendResponse(Jurisdiction::query()
            ->selectRaw('id, name as label')->get(), '');
      }
    }

    public function getLanguages(): JsonResponse
    {
      return ApiResponseClass::sendResponse(Language::query()
        ->selectRaw('iso as value, language as label')->get(), '');
    }

    public function getPermissionsCategory(): JsonResponse
    {
      return ApiResponseClass::sendResponse(
        PermissionsCategory::query()->selectRaw('id, name as label')->get(), '');
    }

    public function getRoles(): JsonResponse
    {
      return ApiResponseClass::sendResponse(
        Role::query()->selectRaw('id, name as label')->get(), '');
    }

    public function getMechanics(): JsonResponse
    {
      return ApiResponseClass::sendResponse(
        GameMechanics::query()->selectRaw('id, name as label')->get(), '');
    }

    public function getRangeSliders(): JsonResponse
    {
      $MaxMultiplier = Game::query()->selectRaw('MAX(max_multiplier) as max_multiplier_big')->first();
      $MinTotalBet = GameDetails::query()->selectRaw('MAX(min_total_bet) as min_total_bet_big')->first();

      return ApiResponseClass::sendResponse([
        'max_multiplier' => $MaxMultiplier->max_multiplier_big,
        'min_total_bet' => $MinTotalBet->min_total_bet_big
      ], '');
    }

    public function getCountries(): JsonResponse
    {
      return ApiResponseClass::sendResponse(Country::all(), '');
    }

    public function getBrands(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse(ClientBrand::where('client_id', $request->get('client_id'))->get(), '');
    }
  }
