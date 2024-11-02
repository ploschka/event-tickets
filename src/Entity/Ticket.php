<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column]
    public ?int $event_id = null;

    #[ORM\Column(type: "string", length: 10)]
    public ?string $event_date = null;

    #[ORM\Column]
    public ?int $ticket_adult_price = null;

    #[ORM\Column]
    public ?int $ticket_adult_quantity = null;

    #[ORM\Column]
    public ?int $ticket_kid_price = null;

    #[ORM\Column]
    public ?int $ticket_kid_quantity = null;

    #[ORM\Column(type: "string", length: 120, unique: true)]
    public ?string $barcode = null;

    #[ORM\Column]
    public ?int $equal_price = null;

    #[ORM\Column]
    public ?DateTime $created = null;

    public function __construct (
        int $event_id,
        string $event_date,
        int $ticket_adult_price,
        int $ticket_adult_quantity,
        int $ticket_kid_price,
        int $ticket_kid_quantity,
    )
    {
        $this->event_id = $event_id;
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

