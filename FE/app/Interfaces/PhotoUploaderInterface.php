<?php

  namespace App\Interfaces;

  interface PhotoUploaderInterface
  {
    public function upload(array $_params = []): array;
  }
