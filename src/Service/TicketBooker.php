<?php

namespace App\Service;

use App\Entity\Ticket;
use DateTime;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TicketBooker
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function book (
        int $event_id,
        DateTime $event_date,
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

        return $ticket;
    }
}
