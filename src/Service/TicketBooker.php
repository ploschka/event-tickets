<?php

namespace App\Service;

use App\Entity\Ticket;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TicketBooker
{
    private ApiHandler $api;

    public function __construct(ApiHandler $api)
    {
        $this->api = $api;
    }

    private function genBarcode(): string
    {
        $len = 120;
        $bytes = random_bytes($len);

        for ($i = 0; $i < $len; ++$i)
        {
            $bytes[$i] = ord($bytes[$i]) % 10;
        }
        return $bytes;
    }

    public function book (
        int $event_id,
        string $event_date,
        int $ticket_adult_price,
        int $ticket_adult_quantity,
        int $ticket_kid_price,
        int $ticket_kid_quantity,
    ) : ?Ticket
    {
        $ticket = new Ticket(
            $event_id,
            $event_date,
            $ticket_adult_price,
            $ticket_adult_quantity,
            $ticket_kid_price,
            $ticket_kid_quantity
        );

        $barcode = null;
        $booked = false;
        while(!$booked)
        {
            $barcode = $this->genBarcode();

            $a = [
                'event_id' => $event_id,
                'event_date' => $event_date,
                'ticket_adult_price' => $ticket_adult_price,
                'ticket_adult_quantity' => $ticket_adult_quantity,
                'ticket_kid_price' => $ticket_kid_price,
                'ticket_kid_quantity' => $ticket_kid_quantity,
                'barcode' => $barcode,
            ];

            $j = json_encode($a);
            $resp = $this->api->request('POST', '/book', [
                'body' => $j,
            ]);

            if (!is_null($resp))
            {
                if (array_key_exists('message', $resp))
                {
                    if ($resp['message'] === 'order successfully booked')
                    {
                        $booked = true;
                    }
                }
            }
        }

        $a = [
            'barcode' => $barcode,
        ];
        $j = json_encode($a);

        $resp = $this->api->request('POST', '/approve', [
            'body' => $j,
        ]);

        if (!is_null($resp))
        {
            if (array_key_exists('error', $resp))
            {
                return null;
            }
        }
        $ticket->barcode = $barcode;

        return $ticket;
    }
}
