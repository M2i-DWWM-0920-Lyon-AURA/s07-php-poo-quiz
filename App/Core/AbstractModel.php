<?php
// ================================================================
// Espace de nommage (namespace)
// ----------------------------------------------------------------
// ~ Les espaces de nommage permettent d'encapsuler des classes et
// des méthodes afin d'éviter les collisions de nom. Par exemple,
// je peux créer une nouvelle classe DateTime dans l'espace de
// nommage App\Core, ce qui me permettra de la distinguer de la
// clase native \DateTime.
// ~ La norme PSR-4 prévoit que chaque classe doit être écrite dans
// un fichir portant son nom, et que l'espace de nommage doit
// correspondre à la hiérarchie de dossiers dans lequel ce fichier
// se trouve. Par exemple, dans le fichier App\Core\DateTime.php,
// je dois trouver la classe DateTime à l'intérieur de l'espace
// de nommage App\Core.
// ~ Composer permet de mettre en place un chargement automatique
// (autoload) des fichiers s'ils sont organisés selon la norme
// PSR-4.
// ================================================================

namespace App\Core;

// ================================================================
// Dépendances
// ----------------------------------------------------------------
// ~ Le mot clé "use" permet de spécifier un nom de classe avec
// son espace de nommage, afin qu'il soit chargé automatiquement
// par Composer.
// ~ Chaque classe doit déclarer avec "use" l'ensemble des classes
// qu'elle utilise dans son propre code.
// ================================================================

use App\Core\DatabaseHandler;

// ================================================================
// Classe
// ----------------------------------------------------------------
// ~ Une classe est un plan de construction permettant de générer
// des objets (ou instances) conformes à un schéma. Ainsi, on sait
// que tous les objets d'une même classe partagent un même ensemble
// de propriétés et de comportements.
// ~ Une classe est distincte des objets qu'elle génère. Les
// propriétés et méthodes qu'elle définit appartient à ses
// instances. Les propriétés et méthodes statiques appartiennent
// à la classe.
// ~ Une classe abstraite ne peut pas générer d'objets directement.
// C'est une classe "incomplète" qui permet de factoriser des
// éléments communs entre plusieurs classes, mais elle doit
// obligatoirement être "complétée" par une classe-enfant pour
// être fonctionnelle. En l'occurrence, la classe AbstractModel
// contient toute la logique permettant de gérer l'accès à la base
// de données, les modèles concrets (qui correspondent à une table
// dans la base de données) n'ont plus qu'à la réutiliser.
// ================================================================

abstract class AbstractModel
{
    // ================================================================
    // Propriétés
    // ----------------------------------------------------------------
    // ~ Chaque classe définit un ensemble de propriétés pour toutes
    // ses instances sous la forme de variables.
    // ~ Chaque propriété peut être:
    //  *publique (public): tous les processus peuvent librement
    //   accéder au contenu de la propriété et le modifier.
    //  *privée (private): seuls les processus affiliés à cette classe
    //   peuvent accéder au contenu de la propriété et le modifier.
    //  *protégée (protected): seuls les processus affiliés à cette
    //   classe, ou à ses parents, ou à ses enfants, peuvent accéder
    //   au contenu de la propriété et la modifier.
    // ~ On préfère mettre toutes les propriétés en mode "protected"
    // (ou "private") afin de prévenir les mauvaises utilisations de
    // notre code.
    // ================================================================

    /**
     * @var int $id Database ID
     */
    protected $id;

    // ================================================================
    // Méthodes
    // ----------------------------------------------------------------
    // ~ Une méthode est une fonction définie dans une classe, qui
    // définira donc un comportement partagé par toutes ses instances.
    // Par exemple, la classe \DateTime contient une méthode format(),
    // qui permet à chaque date de s'afficher d'une manière précise.
    // ~ Depuis PHP 7, on peut rajouter un "type-hint" (indication de
    // type) aux paramètres et à la valeur de retour de chaque méthode.
    // Si on passe une valeur n'ayant pas le type spécifié, PHP tentera
    // d'abord de convertir la valeur donnée dans le type spécifié,
    // puis générera une erreur s'il échoue.
    // ================================================================

    // ================================================================
    // Constructeur
    // ----------------------------------------------------------------
    // ~ Méthode "magique" (c'est-à-dire dont le nom est réservé par
    // le langage) qui s'exécute automatiquement lorsqu'une instance
    // de la classe est créée. Elle permet classiquement de passer
    // un ensemble de valeurs permettant d'initialiser les propriétés
    // de l'instance.
    // ~ Comme les propriétés, les méthodes peuvent être publiques,
    // privées ou protégées.
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
    // Getters & Setters
    // ----------------------------------------------------------------
    // ~ Méthodes permettant de contrôler l'accès aux propriétés des
    // instances de la classe. On met toutes les propriétés en
    // "protected" (ou "private") afin d'empêcher l'accès libre, et
    // de forcer l'utilisation de "gettere" (de "get" = obtenir) pour
    // lire les propriétés et de "setters" (de "set" = définir) pour
    // les modifier.
    // ~ On peut donc inclure la logique que l'on souhaite, comme par
    // exemple une étape de validation avant d'enregistrer la nouvelle
    // valeur souhaitée, ou encore avoir des propriétés en lecture
    // seule (avec seulement un "getter" et pas de "setter"). 
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
    // Relations
    // ----------------------------------------------------------------
    // ~ Ces méthodes permettent de gérer les relations entre des
    // couples de modèles. Par exemple, si un article peut appartenir
    // à une et une seule catégorie (Many-To-One), et qu'une catégorie
    // peut contenir n'importe quel nombre d'articles (One-To-Many),
    // la méthode getManyToOne(Category::class, 'category_id')
    // permettra à un Article d'accéder à sa catégorie, alors que la
    // méthode getOneToMany(Article::class, 'category_id') permettra à
    // une Category de récupérer la liste de ses articles.
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
    // Accès à la base de données
    // ----------------------------------------------------------------
    // ~ Ces méthodes permettent aux modèles d'interagir avec la base
    // de données, aussi bien pour des requêtes (find*) que pour des
    // mutations (insert, update, delete). Ces méthodes sont destinées
    // à être appelées par les modèles concrets, qui devront donc leur
    // passer le nom de la table concernée (ainsi que la liste des
    // colonnes, le cas échéant).
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
        // Récupère le nom de la classe depuis laquelle cette méthode a été appelée
        $className = \get_called_class();
        // Demande à l'interface de base de données de récupérer l'ensemble
        // des résultats de la requête, en passant chaque résultat à travers
        // la fonction createInstance() de la classe appelante
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
        // Récupère tous les résultats de la requête sous forme d'objets
        $result = static::fetchAllFromStatement($statement);

        // Si la liste des résultats est vide, renvoyer null
        if (empty($result)) {
            return null;
        }

        // Sinon, renvoyer le premier résultat de la liste
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
        // Si l'objet n'existe pas encore en base de données
        if (is_null($this->getId())) {
            // Crée un nouvel enregistrement en base de données correspondant à cet objet
            $this->insert();
        // Sinon
        } else {
            // Met à jour les propriétés de l'enregistrement existant correspondant à cet objet
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
        // Pour chaque paramètre passé par le modèle concret
        foreach ($properties as $propName => $dbName) {
            // Construit un tableau avec les noms des paramètres entre bacticks (`)
            // Ce sera la liste des propriétés à définir dans la table
            $propNames []= "`$dbName`";
            // Construit un autre tableau avec les noms des paramètres précédés par un :
            // Ce sera la liste des champs variables dans lesquels on injectera les valeurs
            $valueNames []= ":$propName";
            // Construit un autre tableau faisant correspondre à chaque nom de champ variable
            // la valeur de l'objet qu'il faudra injecter
            $params[":$propName"] = $this->$propName;
        }

        // Fusionne la liste des propriétés à définir en joignant chaque élément avec une virgule
        $propNames = join(', ', $propNames);
        // Fusionne la liste des champs variables en joignant chaque élément avec une virgule
        $valueNames = join(', ', $valueNames);

        // Construit un tableau qui contient les différentes lignes de la requête
        $queryArray = [
            // Ajoute la commande et le nom de la table concernée
            "INSERT INTO `$tableName`",
            // Ajoute les propriétés à définir
            '( ' . $propNames . ' )',
            // Ajoute des champs variables correspondants aux propriétés
            'VALUES (' . $valueNames . ')',
        ];
        // Fusionne le tableau en joignant chaque élément avec un saut de ligne (\n)
        $query = join("\n", $queryArray);

        // Prépare la requête et l'exécute en injectant les valeurs de l'objet actuel
        $statement = DatabaseHandler::prepare($query);
        $statement->execute($params);

        // Récupère le dernier ID inséré en base de données et l'affecte à cet objet
        // Cela évite que l'objet continue à se comporter comme s'il n'existait pas
        // encore en base de données
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
        // Ajoute l'ID aux paramètres passés par le modèle concret
        $params = [ ':id' => 'id' ];
        // Pour chaque paramètre passé par le modèle concret
        foreach ($properties as $propName => $dbName) {
            // Construit un tableau avec le nom de propriété entre backticks (`) égal à un champ variable
            // précédé d'un :
            $values []= "`$dbName` = :$propName";
            // Construit un autre tableau faisant correspondre à chaque nom de champ variable
            // la valeur de l'objet qu'il faudra injecter
            $params[":$propName"] = $this->$propName;
        }

        // Fusionne la liste des propriétés à définir en joignant chaque élément avec une virgule
        // et un saut de ligne (\n)
        $values = join(",\n", $values);

        // Construit un tableau qui contient les différentes lignes de la requête
        $queryArray = [
            // Ajoute la commande et le nom de la table concernée
            "UPDATE `$tableName`",
            'SET',
            // Ajoute la liste des propriétés 
            $values,
            // Ajoute la condition permettant d'identifier l'enregistrement à modifier
            "WHERE `id` = :id"
        ];
        // Fusionne le tableau en joignant chaque élément avec un saut de ligne (\n)
        $query = join("\n", $queryArray);

        // Prépare la requête et l'exécute en injectant les valeurs de l'objet actuel
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
        // Récupère le nom de la classe depuis laquelle cette méthode a été appelée
        $className = \get_called_class();
        // Crée une nouvelle instance de la classe demandée, et passe à son constructeur
        // l'ensemble des arguments passés à cette fonction
        return new $className(...$params);
    }

    // ================================================================
    // Méthodes abstraites
    // ----------------------------------------------------------------
    // ~ Une méthode abstraite est une simple déclaration de méthode
    // (visibilité, nom, paramètres, type de retour), sans contenu.
    // Cela oblige les classes dérivant de celle-ci à implémenter
    // l'ensemble de ces méthodes, car l'on sait qu'elles sont
    // indispensables à leur bon fonctionnement. Mais comme ces
    // méthodes n'ont pas de sens en-dehors d'un modèle concret
    // (associé à une table en base de données), on ne les définit pas
    // dans la classe abstraite; on se contente d'exiger sa présence
    // dans chaque classe dérivée.
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
