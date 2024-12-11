<?php

  namespace App\Traits;

  use Illuminate\Support\Str;
  use Storage;

  trait UploadFilesTrait
  {
    function uploadThumbnail($file, $path, $name = '', $is_updated = false, $old_file = false)
    {
      $new_thumbnail_name = Str::slug($name, '-') . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();

      if ($is_updated && ($old_file && @is_file(public_path($path . $old_file)))) {
        @unlink(public_path($path . $old_file));
      }

      $file->move(public_path($path), $new_thumbnail_name);

      return $new_thumbnail_name;
    }

    function deleteFile($filePath)
    {
      if (file_exists(public_path($filePath)) && is_file(public_path($filePath))) {
        @unlink(public_path($filePath));
        return true;
      }
      return false;
    }
  }
