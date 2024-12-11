<?php

  namespace App\Http\Controllers\Api;

  use App\Http\Controllers\Controller;
  use App\Repositories\CurrencyRepository;
  use Illuminate\Http\Request;

  use Google\Cloud\BigQuery\BigQueryClient;
  use Google\Cloud\Core\ExponentialBackoff;
  use Illuminate\Support\Facades\Storage;
  use Illuminate\Support\Facades\File;


  class GoogleBigQueryController extends Controller
  {
    private $projectId = "fair-abbey-424714-i3";

    public function test()
    {

      return false;
      $query = "select
                    game_id,
                    SUM(stake) as total_bets,
                    COUNT(DISTINCT brand_id) as total_brands,
                    COUNT(returns) as total_wins,
                    SUM(CASE WHEN round_complete = false THEN stake ELSE 0 END) as total_refunds,
                    SUM(stake - returns) as ggr,
                    AVG(stake) as avg_bets,
                    COUNT( DISTINCT player_id) as total_players,
                    COUNT( DISTINCT  session_id) as total_session
                from `records.betrecord`
                group by game_id
                    ";
      $bigQuery = new BigQueryClient([
        'projectId' => $this->projectId,
        'keyFile' => json_decode(trim(File::get(storage_path('fair-abbey-424714-i3-5b196abe8edf.json'))), true)
      ]);

      $jobConfig = $bigQuery->query($query);
      $job = $bigQuery->startQuery($jobConfig);

      $backoff = new ExponentialBackoff(10);
      $backoff->execute(function () use ($job) {
        print('Waiting for job to complete' . PHP_EOL);
        $job->reload();
        if (!$job->isComplete()) {
          throw new \Exception('Job has not yet completed', 500);
        }
      });
      $queryResults = $job->queryResults();
      $i = 0;
      echo('<table border="1" style="border-collapse: collapse; border: 1px solid black;">');
      foreach ($queryResults as $row) {
        echo '<tr>';
        foreach ($row as $column => $value) {
          echo '<td style="padding: 10px;">' . $column . '</td>';
          echo '<td style="padding: 10px;">' . $value . '</td>';
        }
        echo '</tr>';
      }
      echo('</table>');

    }

    public function currencies(CurrencyRepository $currencyRepository)
    {
      return response()->json($currencyRepository->getCurrencies());
    }
  }
