#!/usr/bin/env php
<?php

use App\App;
use App\Service\ApiHandler;
use App\Service\TicketBooker;
use Symfony\Component\HttpClient\HttpClient;

require_once __DIR__ . "/vendor/autoload.php";

$app = new App(__DIR__);

if ($argc != 7)
{
    echo "Usage:\n";
    echo "main.php <event_id> <event_date> <adult_price> <adult_quantity> <kid_price> <kid_quantity>\n";
    echo "<event_date> format: YYYY-MM-DD\n";
    return 0;
}

(ctype_digit($argv[1]) and $argv[1] >= 0) or die("Invalid event id\n");
DateTime::createFromFormat("Y-m-d", $argv[2]) or die("Invalid event date\n");
(ctype_digit($argv[3]) and $argv[3] >= 0) or die("Invalid adult price\n");
(ctype_digit($argv[4]) and $argv[4] >= 0) or die("Invalid adult quantity\n");
(ctype_digit($argv[5]) and $argv[5] >= 0) or die("Invalid kid price\n");
(ctype_digit($argv[6]) and $argv[6] >= 0) or die("Invalid kid quantity\n");

$client = HttpClient::create();

// For reproducible responses from mocked API
srand(50);

$api = new ApiHandler($client, $_ENV['API_URL']);
$booker = new TicketBooker($api);

$ticket = $booker->book($argv[1], $argv[2], $argv[3], $argv[4], $argv[5], $argv[6]);

if (!is_null($ticket))
{
    $app->em->persist($ticket);
    $app->em->flush();
}

