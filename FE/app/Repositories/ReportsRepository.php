<?php

  namespace App\Repositories;

  use App\Interfaces\ReportsRepositoryInterface;
  use App\Models\Exchange;
  use Google\Cloud\BigQuery\BigQueryClient;
  use Google\Cloud\Core\Exception\GoogleException;
  use Google\Cloud\Core\ExponentialBackoff;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\File;
  use Illuminate\Support\Facades\Log;

  class ReportsRepository implements ReportsRepositoryInterface
  {
    private $projectId = "fair-abbey-424714-i3";
    private BigQueryClient $client;
    private CurrencyRepository $currencyRepository;
    private $currencies;

    public function __construct(CurrencyRepository $currencyRepository)
    {
      $this->currencyRepository = $currencyRepository;
      $this->client = new BigQueryClient([
        'projectId' => $this->projectId,
        'keyFile' => json_decode(trim(File::get(storage_path('fair-abbey-424714-i3-5b196abe8edf.json'))), true)
      ]);
      $this->currencies = $this->currencyRepository->getCurrencies();
    }

    private function execQuery($SQL): array
    {
      $start = microtime(true);
      $jobConfig = $this->client->query($SQL);
      $job = $this->client->startQuery($jobConfig);

      $backoff = new ExponentialBackoff(10);
      $backoff->execute(function () use ($job) {
        $job->reload();
        if (!$job->isComplete()) {
          throw new \Exception('Job has not yet completed', 500);
        }
      });
      $queryResults = $job->queryResults();
      $return = [];

      foreach ($queryResults as $key => $row) {
        foreach ($row as $column => $value) {
          $return[$key][$column] = $value;
        }
      }
      $time_elapsed_secs = microtime(true) - $start;

//      Log::channel('googlequery')->info(
//        json_encode([
//          'SQL' => $SQL,
//          'execution_time' => $time_elapsed_secs
//        ])
//      );

      return $return;
    }

    private function convertCurrency($value, $currency, $currencies)
    {
      $tmp_val = json_decode($value);
      if (isset($currencies[$currency])) {
        return (float)number_format($tmp_val * $currencies[$currency], 2);
      }
      return (float)number_format($tmp_val, 2);
    }

    private function numberFormat($value)
    {
      return (float)number_format((float)json_decode($value), 2);
    }

    public function gamesReport(Request $request): array
    {
      $SQL = "SELECT
                game_id,
                SUM(stake) AS total_bets,
                COUNT(DISTINCT brand_id) AS total_brands,
                COUNT(returns) as total_wins,
                SUM(CASE WHEN round_complete = false THEN stake ELSE 0 END) as total_refunds,
                SUM(stake - returns) as ggr,
                AVG(stake) as avg_bets,
                COUNT( DISTINCT player_id) as total_players,
                COUNT( DISTINCT  session_id) as total_session,
                (SUM(returns)/SUM(stake)) * 100 as rtp,
                currency
                FROM `records.betrecord`
                WHERE 1 = 1";

      if ($request->has('game_id') && (int)$request->get('game_id')) {
        $SQL .= " AND `game_id` = '" . (int)$request->get('game_id') . "'";
      }

      $SQL .= " group by game_id, currency";
      $result = $this->execQuery($SQL);

      if (count($result)) {
        foreach ($result as &$row) {
          $row['total_bets'] = $this->convertCurrency($row['total_bets'], $row['currency'], $this->currencies);
          $row['total_refunds'] = $this->convertCurrency($row['total_refunds'], $row['currency'], $this->currencies);
          $row['ggr'] = $this->convertCurrency($row['ggr'], $row['currency'], $this->currencies);
          $row['avg_bets'] = $this->convertCurrency($row['avg_bets'], $row['currency'], $this->currencies);
          $row['rtp'] = $this->numberFormat($row['rtp']);
        }
      }

      return $result;
    }

    public function getDashboard(Request $request): array
    {

      $gameID = (int)$request->get('game_id');

      $SQL = "SELECT
                COUNT( DISTINCT player_id) as total_players,
                COUNT(id) as total_bets,
                SUM(stake - returns) as ggr,
                SUM(returns) as total_wins,
                currency
                FROM `records.betrecord`
                WHERE DATE(`timestamp`) = CURRENT_DATE()
            ";

      if ($gameID) {
        $SQL .= " AND `game_id` = '" . $gameID . "'";
      }

      $SQL .= " group by currency";
      $result = $this->execQuery($SQL);


      $return = [
        'ggr' => 0,
        'total_wins' => 0,
        'total_bets' => 0,
        'total_players' => 0,
        'players_per_hour' => 0,
      ];

      $SQL_PLAYERS = "SELECT
                        COUNT( DISTINCT player_id ) as total_players
                      FROM `records.betrecord`
                      WHERE
                       timestamp > TIMESTAMP_ADD(CURRENT_TIMESTAMP(), INTERVAL -60 MINUTE)";

      if ($gameID) {
        $SQL_PLAYERS .= " AND `game_id` = '" . $gameID . "'";
      }

      $resultPlayers = $this->execQuery($SQL_PLAYERS);

      if (isset($resultPlayers[0])) {
        $return['players_per_hour'] = $resultPlayers[0]['total_players'];
      }

      if (count($result)) {
        foreach ($result as &$row) {
          $row['ggr'] = $this->convertCurrency($row['ggr'], $row['currency'], $this->currencies);
          $row['total_wins'] = $this->convertCurrency($row['total_wins'], $row['currency'], $this->currencies);

          $return['ggr'] += (float)$row['ggr'];
          $return['total_bets'] += (float)$row['total_bets'];
          $return['total_wins'] += (float)$row['total_wins'];
          $return['total_players'] += $row['total_players'];
        }
      }

      $return['sql'] = $resultPlayers;

      return $return;
    }

    public function getAvgPlayersPerDay(Request $request)
    {
      $days = $request->get('days');
      $gameID = (int)$request->get('game_id');

      if (!$days) {
        $days = 7;
      }
      $SQL_PLAYERS = "SELECT
                        COUNT( DISTINCT player_id ) as total_players
                      FROM `records.betrecord`
                      WHERE
                       `timestamp` > TIMESTAMP_ADD(CURRENT_TIMESTAMP(), INTERVAL -" . $days . " DAY)
                       ";

      if ($gameID) {
        $SQL_PLAYERS .= " AND `game_id` = '" . $gameID . "'";
      }
//      $SQL_PLAYERS .= " GROUP BY DATE(`timestamp`)";

      $resultPlayers = $this->execQuery($SQL_PLAYERS);
      $totalPlayers = 0;
      if (isset($resultPlayers[0])) {
        $totalPlayers = $resultPlayers[0]['total_players'];
      }

      return [
        'players' => $resultPlayers,
        'totalPlayers' => $totalPlayers,
        'SQL' => $SQL_PLAYERS
      ];
    }

    public function top10Games()
    {
      $SQL = "SELECT
                SUM(stake) AS total_bets,
                COUNT(returns) as total_wins,
                SUM(stake - returns) as ggr,
                COUNT(*) as spins,
                currency,
                game_id
                FROM `records.betrecord`
                WHERE    `timestamp` > TIMESTAMP_ADD(CURRENT_TIMESTAMP(), INTERVAL -30 DAY)
                GROUP BY game_id, currency
                LIMIT 10
              ";
      $result = $this->execQuery($SQL);
      $return = [];

      if (count($result)) {
        foreach ($result as &$row) {
          $row['ggr'] = $this->convertCurrency($row['ggr'], $row['currency'], $this->currencies);
          $row['total_wins'] = $this->convertCurrency($row['total_wins'], $row['currency'], $this->currencies);
          $row['total_bets'] = $this->convertCurrency($row['total_bets'], $row['currency'], $this->currencies);

          if (!isset($return[$row['game_id']])) {
            $return[$row['game_id']]['game_id'] = $row['game_id'];
            $return[$row['game_id']]['ggr'] = $row['ggr'];
            $return[$row['game_id']]['total_wins'] = $row['total_wins'];
            $return[$row['game_id']]['total_bets'] = $row['total_bets'];
            $return[$row['game_id']]['spins'] = $row['spins'];
          } else {
            $return[$row['game_id']]['ggr'] += $row['ggr'];
            $return[$row['game_id']]['total_wins'] += $row['total_wins'];
            $return[$row['game_id']]['total_bets'] += $row['total_bets'];
            $return[$row['game_id']]['spins'] += (int)$row['spins'];
          }
        }
      }

      return array_values($return);
    }

    public function getSummaryByStudios(Request $request): array
    {

      switch ($request->get('report')) {
        case "brands":
          $FIELDS = "brand_id, COUNT( DISTINCT player_id) as total_players";
          break;
        case "games":
          $FIELDS = "game_id,
                    COUNT(DISTINCT brand_id) AS total_brands,
                    COUNT( DISTINCT player_id) as total_players,
                    '' as game_name,
                    '' as studio";
          break;
        case "players":
          $FIELDS = "player_id,
                    '' as client_name,
                    '' as brand,
                    '' as game_name,
                    0 as ltv,
                    COUNT(DISTINCT site_id) as total_studios,
                    COUNT(DISTINCT game_id) as total_games";
          break;
        case "session":
          $FIELDS = "session_id,
                    player_id,
                    '-' as client_name,
                    '-' as game_name,
                    '-' as player_country,
                    '-' as brand,
                    '00:00:00' as time_open,
                    '00:00:00' as time_closed,
                    COUNT(CASE WHEN round_complete = false THEN 1 ELSE NULL END) as total_refunds_count
                    ";
          break;
        case "invoices":
          $FIELDS = "site_id,
             SUM(stake - returns) - ( SUM(stake - returns) * 0.25) as ngr,
             0 as bonus_deduction,
             0 as total_due,
             0 as rev_share,
             0 as other_promo_discount,
             0 as rev_share_amount,
             '%' as tax
          ";
          break;
        default:
          $FIELDS = "site_id,
                      COUNT(DISTINCT brand_id) AS total_brands,
                      COUNT( DISTINCT player_id) as total_players";
      }

      $SQL = "SELECT
                currency,
                " . $FIELDS . ",
                SUM(stake) AS total_bets,
                SUM(returns) as total_wins_amount,
                COUNT(CASE WHEN returns > 0 THEN 1 ELSE NULL END) as total_wins,
                SUM(CASE WHEN round_complete = false THEN stake ELSE 0 END) as total_refunds,
                SUM(stake - returns) as ggr,
                0 as bonus_bets,
                0 as bonus_wins,
                0 as bonus_ggr,
                (SUM(returns)/SUM(stake)) * 100 as rtp,
                AVG(stake) as avg_bets,
                COUNT( DISTINCT  session_id) as total_sessions,
                COUNT( DISTINCT game_id) as total_games,
                COUNT(*) as total_spins
                FROM `records.betrecord`
                WHERE 1 = 1";

      if ($request->has('site_id') && (int)$request->get('site_id')) {
        $SQL .= " AND `site_id` = '" . (int)$request->get('site_id') . "'";
      }

      if ($request->has('game_id') && (int)$request->get('game_id')) {
        $SQL .= " AND `game_id` = '" . (int)$request->get('game_id') . "'";
      }

      if ($request->has('brand_id') && (int)$request->get('brand_id')) {
        $SQL .= " AND `brand_id` = '" . (int)$request->get('brand_id') . "'";
      }

      if ($request->has('toDate') && $request->has('fromDate')) {
        $SQL .= " AND `timestamp` >= '{$request->get('fromDate')} 00:00:00'
                  AND `timestamp` <= '{$request->get('toDate')} 23:59:59'";
      }

      if ($request->has('game_search') && $request->get('game_search') != "") {
        $SQL .= " AND ( game_id LIKE '%" . $request->get('game_search') . "%'
                  OR  player_id LIKE '%" . $request->get('game_search') . "%'
                  OR round_id LIKE '%" . $request->get('game_search') . "%'
                  )";
      }

      if ($request->has('currency') && $request->get('currency') != "") {
        $SQL .= " AND currency = '" . $request->get('currency') . "'";
      }

      if ($request->has('player_id') && $request->get('player_id') != "") {
        $SQL .= " AND player_id LIKE '%" . $request->get('player_id') . "%'";
      }

      $localGroup = "site_id";
      switch ($request->get('report')) {
        case 'brands':
          $SQL .= " group by brand_id, currency";
          $localGroup = "brand_id";
          break;
        case 'games':
          $SQL .= " group by game_id, currency";
          $localGroup = "game_id";
          break;
        case 'players':
          $SQL .= " group by player_id, currency";
          $localGroup = "player_id";
          break;
        case 'session':
          $SQL .= " group by session_id, player_id, currency";
          $localGroup = "session_id";
          break;
        default:
          $SQL .= " group by site_id, currency";
          $localGroup = "site_id";
      }

      $result = $this->execQuery($SQL);
      $return = [];
//      return ['result' => $result, 'sql' => $SQL];
      if (count($result)) {
        foreach ($result as &$row) {
          $row['total_bets'] = $this->convertCurrency($row['total_bets'], $row['currency'], $this->currencies);
          $row['total_refunds_native'] = $this->numberFormat($row['total_refunds']);
          $row['total_refunds'] = $this->convertCurrency($row['total_refunds'], $row['currency'], $this->currencies);
          $row['ggr'] = $this->convertCurrency($row['ggr'], $row['currency'], $this->currencies);
          $row['total_wins_amount'] = $this->convertCurrency($row['total_wins_amount'], $row['currency'], $this->currencies);

          if (isset($row['ngr'])) {
            $row['ngr'] = $this->convertCurrency($row['ngr'], $row['currency'], $this->currencies);
          }

          if (!isset($return[$row[$localGroup]])) {
            $return[$row[$localGroup]] = [...$row];
          } else {
            $return[$row[$localGroup]]['total_bets'] += $row['total_bets'];
            $return[$row[$localGroup]]['total_refunds'] += $row['total_refunds'];
            $return[$row[$localGroup]]['total_wins_amount'] += $row['total_wins_amount'];
            $return[$row[$localGroup]]['ggr'] += $row['ggr'];
            $return[$row[$localGroup]]['total_wins'] += (int)$row['total_wins'];
            $return[$row[$localGroup]]['total_players'] += (int)$row['total_players'];
            $return[$row[$localGroup]]['total_sessions'] += (int)$row['total_sessions'];
            $return[$row[$localGroup]]['total_games'] += (int)$row['total_games'];
            $return[$row[$localGroup]]['total_spins'] += (int)$row['total_spins'];

            if (isset($row['ngr'])) {
              $return[$row[$localGroup]]['ngr'] += (int)$row['ngr'];
            }
          }
        }
      }

      //calculate SUM & AVG
      $return = array_values($return);

      foreach ($return as &$row) {
        $row['rtp'] = $this->numberFormat(($row['total_wins_amount'] / $row['total_bets']) * 100);
        $row['avg_bets'] = $this->numberFormat($row['total_bets'] / $row['total_spins']);
      }

      return $return;
    }

    public function getCurrencies()
    {

      $allowedCurrencies = [
        'AOA', 'ARS', 'AUD', 'BND', 'BRL', 'BZD', 'CAD', 'CHF', 'CLP', 'COP', 'CRC', 'CZK',
        'DJF', 'DKK', 'DOP', 'EUR', 'FJD', 'FKP', 'GBP', 'GEL', 'GTQ', 'HKD', 'HNL', 'HUF',
        'IDR', 'ILS', 'INR', 'ISK', 'JPY', 'KES', 'KGS', 'KMF', 'KRW', 'KZT', 'MDL', 'MGA',
        'MRU', 'MWK', 'MXN', 'MYR', 'NOK', 'NZD', 'OMR', 'PEN', 'PGK', 'PHP', 'PLN', 'PYG',
        'RON', 'RWF', 'SBD', 'SCR', 'SEK', 'SGD', 'SRD', 'STN', 'SZL', 'TJS', 'TMT', 'TOP',
        'TRY', 'USD', 'UYU', 'VND', 'XCD', 'ZAR'
      ];

      $Exchanges = Exchange::query()->whereIn('currency', $allowedCurrencies)->get();
      $UniqueExchanges = [];
      foreach ($Exchanges as $exchange) {
        $UniqueExchanges[] = [
          'label' => 'EUR-' . $exchange->currency,
          'value' => $exchange->rate,
        ];

        $UniqueCurrencies[] = [
          'label' => $exchange->currency,
          'value' => $exchange->currency
        ];
      }

      return [
        'currencies' => $UniqueCurrencies,
        'exchange' => $UniqueExchanges
      ];
    }
  }
