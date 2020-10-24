<?php
// ================================================================
// Espace de nommage (namespace)
// ----------------------------------------------------------------
// ~ 
// ================================================================

namespace App\Core;

// ================================================================
// 
// ----------------------------------------------------------------
// ~ 
// ================================================================

use App\Core\DatabaseHandler;

// ================================================================
// 
// ----------------------------------------------------------------
// ~ 
// ================================================================

abstract class AbstractModel
{
    // ================================================================
    // PROPRIETES
    // ----------------------------------------------------------------
    // - Propriétés des instances de cette classe
    // ================================================================

    /**
     * @var int $id Database ID
     */
    protected $id;

    // ================================================================
    // CONSTRUCTEUR
    // ----------------------------------------------------------------
    // - Permet de créer une nouvelle instance de cette clase
    // ================================================================

    /**
     * Create new model
     * 
     * @param int $id Database ID
     */
    public function __construct(?int $id = null)
    {
        $this->id = $id;
    }

    // ================================================================
    // GETTERS & SETTERS
    // ----------------------------------------------------------------
    // - Permettent d'accéder aux propriétés des instances de cette
    // classe
    // ================================================================

    /**
     * Get the value of id
     * 
     * @return int|null
     */ 
    public function getId(): ?int
    {
        return $this->id;
    }

    // ================================================================
    // 
    // ----------------------------------------------------------------
    // ~ 
    // ================================================================
    
    /**
     * Get related entity in a Many-To-One relaiton
     * 
     * @param string $otherClass Related entity's class name
     * @param string $propName Name of this object's property holding the related object's id
     * @return AbstractModel|null
     */
    protected function getManyToOne(string $otherClass, string $propName): ?AbstractModel
    {
        return $otherClass::findById($this->$propName);
    }

    /**
     * Set related entity in a Many-To-One relaiton
     * 
     * @param AbstractModel $otherClass Related entity instance
     * @param string $propName Name of this object's property holding the related object's id
     * @return self
     */
    protected function setManyToOne(AbstractModel $instance, string $propName): self
    {
        $this->$propName = $instance->getId();

        return $this;
    }

    /**
     * Get related entities in a One-To-Many relaiton
     * 
     * @param string $otherClass Related entity's class name
     * @param string $propName Name of related object's property holding this object's id
     * @return array
     */
    protected function getOneToMany(string $otherClass, string $propName): array
    {
        return $otherClass::findWherePropEqual($propName, $this->getId());
    }

    // ================================================================
    // 
    // ----------------------------------------------------------------
    // ~ 
    // ================================================================

    /**
     * Fetch all results from a database query
     * 
     * @static
     * @param \PDOStatement $statement PDO statement from which to retrieve results
     * @return array
     */
    static protected function fetchAllFromStatement(\PDOStatement $statement): array
    {
        $className = \get_called_class();

        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $className);
        return $statement->fetchAll(\PDO::FETCH_FUNC, [$className, 'createInstance']);
    }

    /**
     * Fetch first result from a database query and returns null if no record was found
     * 
     * @static
     * @param \PDOStatement $statement PDO statement from which to retrieve results
     * @return AbstractModel|null
     */
    static protected function fetchOneOrNull(\PDOStatement $statement): ?AbstractModel
    {
        $result = static::fetchAllFromStatement($statement);

        if (empty($result)) {
            return null;
        }

        return $result[0];
    }
    
    /**
     * Find all records in given database table
     * 
     * @static
     * @param string $tableName Database table name to query
     * @return array
     */
    static protected function findAllInTable(string $tableName): array
    {
        $statement = DatabaseHandler::query("SELECT * FROM `$tableName`");
        return static::fetchAllFromStatement($statement);
    }

    /**
     * Find a single record in given database table by ID
     * 
     * @static
     * @param string $tableName Database table name to query
     * @param int $id Database ID
     * @return AbstractModel|null
     */
    static protected function findByIdInTable(string $tableName, int $id): ?AbstractModel
    {
        $statement = DatabaseHandler::prepare("SELECT * FROM `$tableName` WHERE `id` = :id");
        $statement->execute([ ':id' => $id ]);
        return static::fetchOneOrNull($statement);
    }

    /**
     * Find records matching condition (property equals value) in given database
     * 
     * @static
     * @param string $tableName Database table name to query
     * @param string $propName Property name
     * @param string $value Value to look for in property
     */
    static protected function findWherePropEqualInTable(string $tableName, string $propName, string $value): array
    {
        $statement = DatabaseHandler::prepare("SELECT * FROM `$tableName` WHERE `$propName` = :val");
        $statement->execute([ ':val' => $value ]);
        return static::fetchAllFromStatement($statement);
    }

    /**
     * Save current object state in database
     */
    public function save(): void
    {
        if (is_null($this->getId())) {
            $this->insert();
        } else {
            $this->update();
        }
    }

    /**
     * Create new record in given database table based on this object's properties
     * 
     * @param string $tableName Database table name to query
     * @param array $properties Associative array matching each model's property with matching database table column
     */
    protected function insertInTable(string $tableName, array $properties): void
    {
        $params = [];
        foreach ($properties as $propName => $dbName) {
            $propNames []= "`$dbName`";
            $valueNames []= ":$propName";
            $params[":$propName"] = $this->$propName;
        }

        $propNames = join(', ', $propNames);
        $valueNames = join(', ', $valueNames);

        $queryArray = [
            "INSERT INTO `$tableName`",
            '( ' . $propNames . ' )',
            'VALUES (' . $valueNames . ')',
        ];
        $query = join("\n", $queryArray);

        $statement = DatabaseHandler::prepare($query);
        $statement->execute($params);

        $this->id = DatabaseHandler::lastInsertId();
    }

    /**
     * Update matching existing record in given database table based on this object's properties
     * 
     * @param string $tableName Database table name to query
     * @param array $properties Associative array matching each model's property with matching database table column
     */
    protected function updateInTable(string $tableName, array $properties): void
    {
        $params = [ ':id' => 'id' ];
        foreach ($properties as $propName => $dbName) {
            $values []= "`$dbName` = :$propName";
            $params[":$propName"] = $this->$propName;
        }

        $values = join(",\n", $values);

        $queryArray = [
            "UPDATE `$tableName`",
            'SET',
            $values,
            "WHERE `id` = :id"
        ];
        $query = join("\n", $queryArray);

        $statement = DatabaseHandler::prepare($query);
        $statement->execute($params);
    }

    /**
     * Remove matching recod from given database table
     * 
     * @param string $tableName Database table name to query
     */
    protected function deleteInTable(string $tableName): void
    {
        $statement = DatabaseHandler::prepare("DELETE FROM `$tableName` WHERE `id` = :id");
        $statement->execute([ ':id' => $this->id ]);

        $this->id = null;
    }

    /**
     * Create a new model from a collection of values returned from database
     */
    public function createInstance(...$params): AbstractModel
    {
        $className = \get_called_class();
        return new $className(...$params);
    }

    // ================================================================
    // 
    // ----------------------------------------------------------------
    // ~ 
    // ================================================================

    /**
     * Find all records in database
     * 
     * @abstract
     * @static
     * @return array
     */
    abstract static public function findAll(): array;

    /**
     * Find a single record by ID
     * 
     * @abstract
     * @static
     * @param int $id Database ID
     * @return AbstractModel|null
     */
    abstract static public function findById(int $id): ?AbstractModel;

    /**
     * Find records matching condition (property equals value)
     * 
     * @abstract
     * @static
     * @param string $propName Property name
     * @param string $value Value to look for in property
     * @return array
     */
    abstract static public function findWherePropEqual(string $propName, string $value): array;

    /**
     * Create new record in database based on this object's properties
     * 
     * @abstract
     */
    abstract protected function insert(): void;

    /**
     * Update matching existing record in database based on this object's properties
     * 
     * @abstract
     */
    abstract protected function update(): void;

    /**
     * Remove matching recod from database
     * 
     * @abstract
     */
    abstract public function delete(): void;
}
