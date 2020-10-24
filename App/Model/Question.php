<?php

namespace App\Model;

use App\Model\Quiz;
use App\Model\Answer;
use App\Core\AbstractModel;

final class Question extends AbstractModel
{
    /**
     * @var string $description Question description
     * @var string $rank Question number in quiz
     * @var int $rightAnswerId Related right answer ID
     * @var int $rightAnswerId Related quiz ID
     */
    protected $description, $rank, $rightAnswerId, $quizId;

    /**
     * Create new question
     * 
     * @param int $id Database ID
     * @param string $description Question description
     * @param int $rank Question number in quiz
     * @param int $rightAnswerId Related right answer ID
     * @param int $quizId Related quiz ID
     */
    public function __construct(?int $id = null, $description = '', int $rank = 0, ?int $rightAnswerId = null, ?int $quizId = null)
    {
        parent::__construct($id);

        $this
            ->setDescription($description)
            ->setRank($rank)
        ;

        $this->rightAnswerId = $rightAnswerId;
        $this->quizId = $quizId;
    }

    /**
     * Find all questions in database
     * 
     * @return array
     */
    static public function findAll(): array
    {
        return parent::findAllInTable('questions');
    }

    /**
     * Find a single question by ID
     * 
     * @param int $id Database ID
     * @return Question|null
     */
    static public function findById(int $id): ?Question
    {
        return parent::findByIdInTable('questions', $id);
    }

    /**
     * Find questions matching condition (property equals value)
     * 
     * @param string $propName Property name
     * @param string $value Value to look for in property
     * @return array
     */
    static public function findWherePropEqual(string $propName, string $value): array
    {
        return parent::findWherePropEqualInTable('questions', $propName, $value);
    }

    /**
     * Create new record in database based on this object's properties
     */
    protected function insert(): void
    {
        $this->insertInTable(
            'questions',
            [
                'description' => 'description',
                'rank' => 'rank',
                'rightAnswerId' => 'right_answer_id',
                'quizId' => 'quiz_id',
            ]
        );
    }

    /**
     * Update matching existing record in database based on this object's properties
     */
    protected function update(): void
    {
        $this->updateInTable(
            'questions',
            [
                'description' => 'description',
                'rank' => 'rank',
                'rightAnswerId' => 'right_answer_id',
                'quizId' => 'quiz_id',
            ]
        );
    }

    /**
     * Remove matching recod from database
     */
    public function delete(): void
    {
        $this->deleteInTable('questions');
    }

    /**
     * Get the value of description
     * 
     * @return string
     */ 
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of rank
     */ 
    public function getRank(): int
    {
        return $this->rank;
    }

    /**
     * Set the value of rank
     *
     * @return  self
     */ 
    public function setRank(int $rank): self
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get related quiz
     * 
     * @return Quiz|null
     */
    public function getQuiz(): ?Quiz
    {
        return $this->getManyToOne(Quiz::class, 'quizId');
    }

    /**
     * Set related quiz
     * 
     * @param Quiz $quiz Quiz to associate
     * @return self
     */
    public function setQuiz(Quiz $quiz): self
    {
        return $this->setManyToOne($quiz, 'quizId');
    }

    /**
     * Get related right answer
     * 
     * @return Answer|null
     */
    public function getRightAnswer(): ?Answer
    {
        return $this->getManyToOne(Answer::class, 'rightAnswerId');
    }

    /**
     * Set related right answer
     * 
     * @param Answer $answer Answer to associate
     * @return self
     */
    public function setRightAnswer(Answer $answer): self
    {
        return $this->setManyToOne($Answer, 'rightAnswerId');
    }

    /**
     * Get related answers
     * 
     * @return array
     */
    public function getAnswers(): array
    {
        return $this->getOneToMany(Answer::class, 'question_id');
    }
}