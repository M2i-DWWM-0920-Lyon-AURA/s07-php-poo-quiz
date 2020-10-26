<?php

namespace App\Controller;

use App\Model\Quiz;
use App\View\StandardView;

class QuizController
{
    /**
     * Display all quizzes
     */
    public function list()
    {
        $view = new StandardView(
            [ 'head/meta' ],
            [ 'quiz/list' ],
            [ 'quizzes' => Quiz::findAll() ]
        );
        $view->render();
    }

    /**
     * Display a single quiz
     * 
     * @param int $id Quiz id
     */
    public function single(int $id)
    {
        $view = new StandardView(
            [ 'head/meta' ],
            [ 'quiz/single' ],
            [ 'quiz' => Quiz::findById($id) ]
        );
        $view->render();
    }
}
