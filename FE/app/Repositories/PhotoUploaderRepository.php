<?php

  namespace App\Repositories;

  use Intervention\Image\Image;
  use App\Exceptions\ApiResponseException;
  use App\Interfaces\PhotoUploaderInterface;
  use App\Models\Article;
  use App\Models\Game;
  use App\Models\Partner;
  use App\Traits\UploadFilesTrait;

  class PhotoUploaderRepository implements PhotoUploaderInterface
  {
    use UploadFilesTrait;

    private $paths = [];
    private $gamesAspectRatio = 0.79;

    public function __construct()
    {
      $this->paths = config('website.paths');
    }

    private function _getConfig($table)
    {
      $_return = [
        'is_valid' => false,
        'path' => '',
        'model' => ''
      ];

      switch ($table) {
        case "articles":
          {
            $_return = [
              'is_valid' => true,
              'path' => $this->paths[$table],
              'model' => Article::query(),
              'name' => 'title',
            ];
          }
          break;
        case "games":
          {
            $_return = [
              'is_valid' => true,
              'path' => $this->paths[$table],
              'model' => Game::query(),
              'name' => 'game_name',
            ];
          }
          break;
        case "partners":
          {
            $_return = [
              'is_valid' => true,
              'path' => $this->paths[$table],
              'model' => Partner::query(),
              'name' => 'name'
            ];
          }
          break;
      }

      return $_return;
    }

    /**
     * @param array $_params [
     *   table
     *   column
     *   id
     *   file
     * ]
     * @return void
     * @throws ApiResponseException
     */
    public function upload(array $_params = []): array
    {
      if (!isset($_params['table'])) {
        throw new ApiResponseException("Invalid [table] param");
      }

      if (!isset($_params['column'])) {
        throw new ApiResponseException("Invalid [column] param");
      }

      if (!isset($_params['file'])) {
        throw new ApiResponseException("Invalid [file] param");
      }

      $config = $this->_getConfig($_params['table']);

      if (!$config['is_valid']) {
        throw new ApiResponseException("Invalid [configuration]");
      }

      $CurrentModel = $config['model']->find((int)$_params['id']);

      if (!$CurrentModel) {
        throw new ApiResponseException(("Invalid [model]:: {$config['model']}"));
      }
      $OldFile = "";
      if (isset($CurrentModel->{$_params['column']}) && $CurrentModel->{$_params['column']} !== "") {
        $OldFile = $CurrentModel->{$_params['column']};
      }

      $newFile = $this->uploadThumbnail($_params['file'], $config['path'], $CurrentModel->{$config['name']}, true, $OldFile);

      $updateOptions = new \stdClass();
      $updateOptions->{$_params['column']} = $newFile;

      $CurrentModel->update(get_object_vars($updateOptions));

      return [
        'file' => url($config['path'] . $newFile),
        'col' => get_object_vars($updateOptions)
      ];
    }
 
  }
