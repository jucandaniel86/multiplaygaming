<?php

	namespace App\Interfaces;

	use Illuminate\Http\Request;

	interface GameDownloadsInterface
	{
		public function upload(Request $request);

		public function list($gameID);

		public function delete($ID);

		public function uploadAssets(Request $request);
	}