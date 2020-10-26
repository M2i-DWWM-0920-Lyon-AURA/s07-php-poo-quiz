<?php

namespace App\Controller;

use App\Model\Quiz;
use App\View\StandardView;
use App\Exception\RecordNotFoundException;

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
        // Récupère le quiz correspondant à l'ID demandé
        $quiz = Quiz::findById($id);

        // Si le quiz n'existe pas
        if (is_null($quiz)) {
            throw new RecordNotFoundException("Quiz #$id could not be found.");
        }

        // Renvoie une vue permettant d'afficher les données d'un seul quiz
        $view = new StandardView(
            [ 'head/meta' ],
            [ 'quiz/single' ],
            [ 'quiz' => $quiz ]
        );
        $view->render();
    }
}
