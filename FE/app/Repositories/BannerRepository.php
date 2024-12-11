<?php

  namespace App\Repositories;

  use App\Interfaces\BannerRepositoryInterface;
  use App\Models\Banner;
  use App\Models\Partner;
  use App\Traits\QueryTrait;
  use App\Traits\UploadFilesTrait;
  use Illuminate\Database\Eloquent\ModelNotFoundException;
  use Illuminate\Http\Request;

  class BannerRepository implements BannerRepositoryInterface
  {
    use UploadFilesTrait, QueryTrait;

    private string $path = '';

    public function __construct()
    {
      $this->path = config('website.paths.banners');
    }

    public function save(Request $request)
    {
      $id = 0;
      if ($request->has('id') && (int)$request->get('id') > 0) {
        $id = (int)$request->get('id');
      }

      if (!$id) {
        $Banner = Banner::create($request->except('slide_file', 'slide_url'));
      } else {
        $Banner = Banner::find($id);
        $Banner->update($request->except('slide_file', 'slide_url'));
      }

      if ($request->hasFile('slide_file')) {
        $uploadedFile = $this->uploadThumbnail(
          $request->file('slide_file'), $this->path, $request->get('name'), true, $this->path . $Banner->slide_file);
        $Banner->slide_file = $uploadedFile;
        $Banner->save();
      }

      return $Banner;
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


      return $this->getFilteredList(Banner::query(), $params, $search);
    }

    public function delete($id)
    {
      $DModel = Banner::find($id);

      if (!$DModel) {
        throw new ModelNotFoundException();
      }

      $this->deleteFile($this->path . $DModel->slide_file);
      $DModel->delete();

      return 'The entry was deleted successfuly!';
    }

    public function clientArea()
    {
      return Banner::query()->where('slide_type', 'CLIENT_AREA')->where('is_active', 1)->get();
    }
  }
