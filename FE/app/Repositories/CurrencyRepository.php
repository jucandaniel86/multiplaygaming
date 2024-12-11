<?php

  namespace App\Repositories;

  use App\Models\Exchange;
  use GuzzleHttp\Exception\GuzzleException;
  use GuzzleHttp\Client;
  use Illuminate\Support\Facades\Log;

  class CurrencyRepository
  {
    private $apiEndpoint = "https://api.exchangeratesapi.io/v1/latest";
    private $apiKey = "28bc92d6db5ab44776ee0e543e4526c5";
    private $lastHours = 4;

    public function getCurrencies()
    {
      try {
        $client = new Client();
        $Exchange = Exchange::query()
          ->whereRaw("update_time > DATE_ADD(NOW(), INTERVAL -" . $this->lastHours . " HOUR)")
          ->get();

        if (!count($Exchange)) {
          $response = $client->request('GET', $this->apiEndpoint, ['query' => [
            'access_key' => $this->apiKey
          ]]);

          $content = json_decode($response->getBody(), true);

          if (isset($content['rates'])) {
            foreach ($content['rates'] as $key => $rate) {
              Exchange::updateOrCreate(
                ['currency' => $key],
                [
                  'api_timestamp' => $content['timestamp'],
                  'currency' => $key,
                  'rate' => (float)$rate,
                  'update_time' => now()
                ]
              );
            }
            Log::channel('currency')->info(json_encode([
              'time' => now(),
              'success' => true,
              'currencies_updated' => count($Exchange)
            ]));
          }

          $Exchange = Exchange::where('currency', '!=', "")->get();
        }

        return [
          'success' => true,
          'exchange' => $Exchange->pluck('rate', 'currency')->toArray(),
        ];
      } catch (GuzzleException $exception) {
        Log::channel('currency')->info(json_encode([
          'time' => now(),
          'success' => false,
          'error' => [
            'message' => $exception->getMessage(),
            'line' => $exception->getLine(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile()
          ],
        ]));
        return [
          'success' => false,
          'message' => $exception->getMessage(),
          'code' => $exception->getCode()
        ];
      }
    }
  }
