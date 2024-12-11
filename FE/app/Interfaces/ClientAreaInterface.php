<?php

  namespace App\Interfaces;

  interface  ClientAreaInterface
  {
    public function option($optionName);

    public function options(array $options);

    public function save(array $options);
  }
