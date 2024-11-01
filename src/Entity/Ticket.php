<?php

namespace App\Entity;

use DateTime;

class Ticket
{
    public int $id;
    public int $event_id;
    public DateTime $event_date;
    public int $ticket_adult_price;
    public int $ticket_adult_quantity;
    public int $ticket_kid_price;
    public int $ticket_kid_quantity;
    public string $barcode;
    public int $equal_price;
    public DateTime $created;

    public function __construct (
        int $event_id,
        DateTime $event_date,
        int $ticket_adult_price,
        int $ticket_adult_quantity,
        int $ticket_kid_price,
        int $ticket_kid_quantity,
    )
    {
        $this->$event_id = $event_id;
        $this->event_date = $event_date;
        $this->ticket_adult_price = $ticket_adult_price;
        $this->ticket_adult_quantity = $ticket_adult_quantity;
        $this->ticket_kid_price = $ticket_kid_price;
        $this->ticket_kid_quantity = $ticket_kid_quantity;

        $this->equal_price =
            $ticket_adult_quantity * $ticket_adult_price + 
            $ticket_kid_quantity   * $ticket_kid_price;

        $this->created = new DateTime();
    }
}

