#!/usr/bin/env php
<?php

use App\App;
use App\Service\TicketBooker;
use Symfony\Component\HttpClient\HttpClient;

require_once __DIR__ . "/vendor/autoload.php";

$app = new App(__DIR__);

$client = HttpClient::createForBaseUri($_ENV['API_URL']);

$booker = new TicketBooker($client);

$ticket = $booker->book(0, new DateTime(), 0, 0, 0, 0);

$app->em->persist($ticket);
$app->em->flush();

