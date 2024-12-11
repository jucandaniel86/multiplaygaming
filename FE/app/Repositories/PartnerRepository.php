<?php

  namespace App\Repositories;

  use App\Interfaces\PartnersRepositoryInterface;
  use App\Models\Partner;
  use App\Traits\QueryTrait;
  use App\Traits\UploadFilesTrait;
  use Illuminate\Database\Eloquent\ModelNotFoundException;
  use Illuminate\Http\Request;

  class PartnerRepository implements PartnersRepositoryInterface
  {
    use UploadFilesTrait, QueryTrait;

    private string $path = '';

    public function __construct()
    {
      $this->path = config('website.paths.partners');
    }

    public function save(Request $request)
    {
      $id = 0;
      if ($request->has('id') && (int)$request->get('id') > 0) {
        $id = (int)$request->get('id');
      }

      if (!$id) {
        $Partner = Partner::create([
          ...$request->except('logo', 'logo_url', 'priority'),
          "created_by" => auth()->user()->id
        ]);
      } else {
        $Partner = Partner::find($id);
        $Partner->update($request->except('logo', 'logo_url', 'priority'));
      }

      if ($request->hasFile('logo')) {
        $uploadedFile = $this->uploadThumbnail(
          $request->file('logo'), $this->path, $request->get('name'), true, $this->path . $Partner->logo);
        $Partner->logo = $uploadedFile;
        $Partner->save();
      }

      return $Partner;
    }

    public function list(array $params = []): array
    {
      $search = [];

      if (isset($params['search']) && $params['search'] != "" && strlen($params['search']) > 2) {
        $search[] = [
          "condition" => true,
          "query" => "name LIKE '%{$params['search']}%'"
        ];
      }

      if (isset($params['partner_type'])) {
        $search[] = [
          "condition" => true,
          "query" => "partner_type = '" . $params['partner_type'] . "'"
        ];
      }

      if (isset($params['partner_category'])) {
        $search[] = [
          "condition" => true,
          "query" => "partner_category = '" . $params['partner_category'] . "'"
        ];
      }

      return $this->getFilteredList(Partner::query(), $params, $search);
    }

    public function delete($id)
    {
      $DModel = Partner::find($id);

      if (!$DModel) {
        throw new ModelNotFoundException();
      }

      $this->deleteFile($this->path . $DModel->logo);
      $DModel->delete();

      return 'The entry was deleted successfuly!';
    }

    public function updatePriority(Request $request)
    {
      $Partner = Partner::find($request->id);
      $Partner->update(['priority' => $request->priority]);

      return $Partner;
    }

    /**
     * @return array
     */
    public function getOrderedItems(): array
    {
      return [
        'operators' => Partner::query()->where('partner_type', 'operator')->orderByRaw('-priority DESC')->get(),
        'platform' => Partner::query()->where('partner_type', 'partner')->orderByRaw()
      ];
    }
  }
