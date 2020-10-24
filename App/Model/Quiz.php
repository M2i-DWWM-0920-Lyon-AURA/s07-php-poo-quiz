<?php

namespace App\Model;

use App\Model\Question;
use App\Core\AbstractModel;

final class Quiz extends AbstractModel
{
    /**
     * @var string $title Quiz title
     * @var string $description Quiz description
     */
    protected $title, $description;

    /**
     * Create new quiz
     * 
     * @param int $id Database ID
     * @param string $title Quiz title
     * @param string $description Quiz description
     */
    public function __construct(?int $id = null, string $title = '', string $description = '')
    {
        parent::__construct($id);

        $this
            ->setTitle($title)
            ->setDescription($description)
        ;
    }

    /**
     * Find all quizzes in database
     * 
     * @return array
     */
    static public function findAll(): array
    {
        return parent::findAllInTable('quizzes');
    }

    /**
     * Find a single quiz by ID
     * 
     * @param int $id Database ID
     * @return Quiz|null
     */
    static public function findById(int $id): ?Quiz
    {
        return parent::findByIdInTable('quizzes', $id);
    }

    /**
     * Find quizzes matching condition (property equals value)
     * 
     * @param string $propName Property name
     * @param string $value Value to look for in property
     * @return array
     */
    static public function findWherePropEqual(string $propName, string $value): array
    {
        return parent::findWherePropEqualInTable('quizzes', $propName, $value);
    }

    /**
     * Create new record in database based on this object's properties
     */
    protected function insert(): void
    {
        $this->insertInTable(
            'quizzes',
            [
                'title' => 'title',
                'description' => 'description',
            ]
        );
    }

    /**
     * Update matching existing record in database based on this object's properties
     */
    protected function update(): void
    {
        $this->updateInTable(
            'quizzes',
            [
                'title' => 'title',
                'description' => 'description',
            ]
        );
    }

    /**
     * Remove matching recod from database
     */
    public function delete(): void
    {
        $this->deleteInTable('quizzes');
    }


    /**
     * Get $description Quiz description
     *
     * @return  string
     */ 
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set $description Quiz description
     *
     * @param  string  $title  $description Quiz description
     *
     * @return  self
     */ 
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get $description Quiz description
     *
     * @return  string
     */ 
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set $description Quiz description
     *
     * @param  string  $description  $description Quiz description
     *
     * @return  self
     */ 
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get related questions
     * 
     * @return array
     */
    public function getQuestions(): array
    {
        return $this->getOneToMany(Question::class, 'quiz_id');
    }
}
