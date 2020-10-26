<?php

namespace App\Controller;

use App\Model\Quiz;

class QuizController
{
    /**
     * Display all quizzes
     */
    public function list()
    {
        $quizzes = Quiz::findAll();

        include './templates/quiz-list.php';
    }

    /**
     * Display a single quiz
     * 
     * @param int $id Quiz id
     */
    public function single(int $id)
    {
        $quiz = Quiz::findById($id);

        include './templates/quiz-single.php';
    }
}
