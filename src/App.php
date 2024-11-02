<?php

namespace App;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\ConfigurationArray;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Dotenv\Dotenv;

class App
{
    public EntityManager $em;
    public DependencyFactory $depFactory;

    private $dotenv;

    public function __construct(string $dir)
    {
        $this->dotenv = new Dotenv();
        $this->dotenv->populate(['APP_DEBUG' => 1]);
        $this->dotenv->loadEnv("$dir/.env", null, 'prod');

        $mconf = require($dir . '/config/migrations.php');
        foreach ($mconf['migrations_paths'] as $key => $value)
        {
            $mconf['migrations_paths'][$key] = $dir . $value;
        }

        $migration_conf = new ConfigurationArray($mconf);

        $dsnParser = new DsnParser(['mysql' => 'pdo_mysql', 'postgres' => 'pdo_pgsql']);
        $ORMconfig = ORMSetup::createAttributeMetadataConfiguration(
            paths: [$dir . '/src/Entity'],
            isDevMode: true,
        );
        $connectionParams = $dsnParser->parse($_ENV['DATABASE_URL']);
        $connection = DriverManager::getConnection($connectionParams);
        $this->em = new EntityManager($connection, $ORMconfig);
        $this->depFactory = DependencyFactory::fromEntityManager($migration_conf, new ExistingEntityManager($this->em));
    }
}

