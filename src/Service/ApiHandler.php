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
        $rng = rand(0, PHP_INT_MAX) % 2 === 0;
        $rng2 = rand(0, 3);

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
            return [
                'message' => 'order successfully aproved'
            ];
        }
        return null;

        // Actual code to run request
        // $response = $this->client->request($method, $this->baseUrl . $path, $options);
        //return $response->toArray();
    }
}
