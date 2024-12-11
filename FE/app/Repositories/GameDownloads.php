<?php

	namespace App\Repositories;

	use App\Enums\DownloadType;
	use App\Exceptions\ApiResponseException;
	use App\Interfaces\GameDownloadsInterface;
	use App\Models\GameDownload;
	use App\Traits\UploadFilesTrait;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\File;

	class GameDownloads implements GameDownloadsInterface
	{
		use UploadFilesTrait;

		public function upload(Request $request)
		{
			$uploadType = $request->get('download_type');
			$download_value = "";
			$ID = (int)$request->get('id');

			if ($uploadType === DownloadType::FILE->value && $request->hasFile('download_file')) {
				$download_value = $this->uploadThumbnail(
					$request->file('download_file'),
					config('website.paths.downloads'),
					$request->name);
			} else if ($uploadType === DownloadType::LINK->value) {
				$download_value = $request->get('download_link');
			}

			if (!$ID) {
				$Download = GameDownload::create($request->only([
						'download_type',
						'name',
						'is_mediapack',
						'is_certificate',
						'jurisdiction_id',
						'game_id'
					]) + [
						'download_value' => $download_value
					]);
			} else {
				$Download = GameDownload::find($ID);

				if (!$Download) throw new ApiResponseException("Invalid model");

				$Download->update($request->only([
					'name',
					'is_mediapack',
					'is_certificate',
					'jurisdiction_id'
				]));
			}

			return $Download;
		}

		private function storeGameAssets($gameID)
		{
			$path = public_path(config('website.paths.assets') . $gameID);
			$files = File::allFiles($path);
			$_return = [];
			foreach ($files as $file) {
				$info = @getimagesize($file->getRealPath());
				$_return[] = GameDownload::create([
					'name' => $file->getFilenameWithoutExtension(),
					'game_id' => $gameID,
					'download_type' => DownloadType::ASSET->value,
					'is_certificate' => 0,
					'width' => $info[0],
					'height' => $info[1],
					'download_value' => $file->getFilename(),
				]);
			}
			return $_return;
		}

		public function uploadAssets(Request $request)
		{
			$path = public_path(config('website.paths.assets'));
			$gameID = $request->get('game_id');

			$uploadedFile = $request->file('download_file');

			$zip = new \ZipArchive;
			$res = $zip->open($uploadedFile);
			if ($res === TRUE) {
				$zip->extractTo($path . $gameID);
				$zip->close();

				$files = $this->storeGameAssets($gameID);
				$uploadedFile->move($path . $gameID, 'assets_download.zip');

				return [
					'success' => true,
					'path' => $path . $gameID,
					'files' => $files
				];
			} else {
				return [
					'success' => false
				];
			}
		}

		public function list($gameID)
		{
			return GameDownload::where('game_id', $gameID)->with('jurisdiction')->get();
		}

		public function delete($ID)
		{
			$Entry = GameDownload::find($ID);

			if (!$Entry) throw new ApiResponseException("Invalid model");

			if ($Entry->download_type === DownloadType::FILE->value) {
				$this->deleteFile(config('website.paths.downloads') . $Entry->download_value);
			}

			$Entry->delete();

		}
	}