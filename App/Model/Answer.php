<?php

namespace App\Model;

use App\Model\Question;
use App\Core\AbstractModel;

final class Answer extends AbstractModel
{
    /**
     * @var string $description Answer description
     * @var int $questionId Related question ID
     */
    protected $description, $questionId;

    /**
     * Create new answer
     * 
     * @param int $id Database ID
     * @param string $description Answer description
     * @param int $questionId Related question ID
     */
    public function __construct(?int $id = null, string $description = '', ?int $questionId = null)
    {
        parent::__construct($id);

        $this
            ->setDescription($description)
        ;

        $this->questionId = $questionId;
    }

    /**
     * Find all answers in database
     * 
     * @return array
     */
    static public function findAll(): array
    {
        return parent::findAllInTable('answers');
    }

    /**
     * Find a single answer by ID
     * 
     * @param int $id Database ID
     * @return Answer|null
     */
    static public function findById(int $id): ?Answer
    {
        return parent::findByIdInTable('answers', $id);
    }

    /**
     * Find answers matching condition (property equals value)
     * 
     * @param string $propName Property name
     * @param string $value Value to look for in property
     * @return array
     */
    static public function findWherePropEqual(string $propName, string $value): array
    {
        return parent::findWherePropEqualInTable('answers', $propName, $value);
    }

    /**
     * Create new record in database based on this object's properties
     */
    protected function insert(): void
    {
        $this->insertInTable(
            'answers',
            [
                'description' => 'description',
                'questionId' => 'question_id',
            ]
        );
    }

    /**
     * Update matching existing record in database based on this object's properties
     */
    protected function update(): void
    {
        $this->updateInTable(
            'answers',
            [
                'description' => 'description',
                'questionId' => 'question_id',
            ]
        );
    }

    /**
     * Remove matching recod from database
     */
    public function delete(): void
    {
        $this->deleteInTable('answers');
    }    

    /**
     * Get $questionId Related question ID
     *
     * @return  string
     */ 
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set $questionId Related question ID
     *
     * @param  string  $description  $questionId Related question ID
     *
     * @return  self
     */ 
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get related question
     * 
     * @return Question|null
     */
    public function getQuestion(): ?Question
    {
        return $this->getManyToOne(Question::class, 'questionId');
    }

    /**
     * Set related Question
     * 
     * @param Question $Question Question to associate
     * @return self
     */
    public function setQuestion(Question $question): self
    {
        return $this->setManyToOne($question, 'questionId');
    }
}
