<?php

namespace App\Core;

// ================================================================
// Singleton
// ----------------------------------------------------------------
// https://refactoring.guru/fr/design-patterns/singleton
// ----------------------------------------------------------------
// ~ Le Singleton est un design pattern (schéma de conception) qui
// permet de s'assurer qu'il ne pourra jamais exister qu'une et
// une seule instance d'une classe.
// ~ En l'occurrence, on souhaite avoir une et une seule interface
// à la base de données pour gérer toutes nos requêtes, et
// s'assurer qu'il soit impossible d'en créer une autre par
// mégarde.
// ================================================================

final class DatabaseHandler
{
    // La propriété statique $instance contient la seule et unique
    // instance de cette classe
    // Elle est privée pour éviter que d'autres processus puissent
    // venir modifier son contenu

    /**
     * @static
     * @var \PDO $instance Current instance of PDO
     */
    static private $instance;

    // Le constructeur est privé afin d'interdire l'écriture de
    // new DatabaseHandler

    private function __construct() { }

    // Le getter de $instance permet d'avoir accès à l'interface
    // de base de données, mais l'absence de setter interdit de
    // la remplacer par autre chose
    // L'instance est créée lorsque le getter est appelé pour la
    // première fois

    /**
     * Get current instance of PDO
     * 
     * @static
     */
    static private function getInstance(): \PDO
    {
        if (is_null(static::$instance)) {
            $pdo = new \PDO("mysql:host=localhost;dbname=php-quiz-plus", 'root', 'root');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);

            static::$instance = $pdo;
        }

        return static::$instance;
    }

    // Ces méthodes sont les points d'accès du Singleton, elles
    // permettent d'appeler les méthodes de l'interface de
    // base de données correspondante de manière statique
    // (par exemple: DatabaseHandler::query(...)), et donc de
    // n'importe où dans le code

    /**
     * Send SQL request to database
     * 
     * @static
     * @param string $sqlQuery SQL query to be sent
     * @return \PDOStatement
     */
    static public function query(string $sqlQuery): \PDOStatement
    {
        return static::getInstance()->query($sqlQuery);
    }

    /**
     * Create prepared request before sending it to database
     * 
     * @static
     * @param string $sqlQuery SQL query to be sent
     * @return \PDOStatement
     */
    static public function prepare(string $sqlQuery): \PDOStatement
    {
        return static::getInstance()->prepare($sqlQuery);
    }

    /**
     * Get last inserted ID in database
     * 
     * @static
     * @return int
     */
    static public function lastInsertId(): int
    {
        return static::getInstance()->lastInsertId();
    }
}
