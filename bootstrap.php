<?php
// bootstrap.php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once "vendor/autoload.php";

// Configuration de Doctrine pour les attributs
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/src/entities/CRUD'],
    isDevMode: true
);

// Configuration de la connexion à la base de données
$connection = DriverManager::getConnection([
    'driver'   => 'pdo_mysql',
    'dbname'   => 'my_database_epide',
    'user'     => 'root',
    'password' => '',
    'host'     => 'localhost',  // Host défini séparément
    'port'     => 3307,  // Port défini séparément
    'charset'  => 'utf8mb4'
], $config);

// Obtention du gestionnaire d'entités
$entityManager = new EntityManager($connection, $config);
