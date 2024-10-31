<?php

namespace App;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Dotenv\Dotenv;

class App
{
    public $em;

    private $dotenv;

    public function __construct(string $dir)
    {
        $this->dotenv = new Dotenv();
        $this->dotenv->loadEnv("$dir/.env");

        $dsnParser = new DsnParser(['mysql' => 'pdo_mysql', 'postgres' => 'pdo_pgsql']);
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [$dir . '/src/Entities'],
            isDevMode: true,
        );
        $connectionParams = $dsnParser->parse($_ENV['DATABASE_URL']);
        $connection = DriverManager::getConnection($connectionParams, $config);
        $this->em = new EntityManager($connection, $config);
    }
}

