<?php

  namespace App\Interfaces;

  use Illuminate\Http\Request;

  interface ReportsRepositoryInterface
  {
    public function gamesReport(Request $request): array;

    public function getDashboard(Request $request): array;

    public function getAvgPlayersPerDay(Request $request);

    public function top10Games();

    public function getSummaryByStudios(Request $request): array;

    public function getCurrencies();
  }
