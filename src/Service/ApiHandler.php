<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiHandler
{
    private HttpClientInterface $client;
    private string $baseUrl;

    public function __construct(HttpClientInterface $client, string $baseUrl)
    {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
    }

    public function request(string $method, string $path, array $options = []): ?array
    {
        $rng = random_int(0, PHP_INT_MAX) % 2 === 0;
        $rng2 = random_int(0, 3);

        if ($path === '/book')
        {
            if ($rng)
            {
                return [
                    'message' => 'order successfully booked'
                ];
            }
            else
            {
                return [
                    'error' => 'barcode already exists'
                ];
            }
        }

        if ($path === '/approve')
        {
            if ($rng)
            {
                return [
                    'message' => 'order successfully aproved'
                ];
            }
            else
            {
                $str = '';
                switch ($rng2)
                {
                case 0:
                    $str = 'event cancelled';
                    break;
                case 1:
                    $str = 'no tickets';
                    break;
                case 2:
                    $str = 'no seats';
                    break;
                case 3:
                    $str = 'fan removed';
                    break;
                }
                return [
                    'error' => $str
                ];
            }
        }
        return null;

        // Actual code to run request
        // $response = $this->client->request($method, $this->baseUrl . $path, $options);
        //return $response->toArray();
    }
}
