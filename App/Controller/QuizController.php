<?php

namespace App\Controller;

use App\Model\Quiz;
use App\Core\AbstractView;
use App\View\StandardView;
use App\Exception\RecordNotFoundException;

class QuizController
{
    /**
     * Display all quizzes
     */
    public function list(): AbstractView
    {
        return new StandardView(
            [ 'quiz/list' ],
            [ 'quizzes' => Quiz::findAll() ]
        );
    }

    /**
     * Display a single quiz
     * 
     * @param int $id Quiz id
     */
    public function single(int $id): AbstractView
    {
        // Récupère le quiz correspondant à l'ID demandé
        $quiz = Quiz::findById($id);

        // Si le quiz n'existe pas
        if (is_null($quiz)) {
            throw new RecordNotFoundException("Quiz #$id could not be found.");
        }

        // Renvoie une vue permettant d'afficher les données d'un seul quiz
        return new StandardView(
            [ 'quiz/single', ],
            [ 'quiz' => $quiz ]
        );
    }

    /**
     * Display result to taken quiz
     */
    public function result(int $id): AbstractView
    {
        \session_start();

        // Récupère le quiz correspondant à l'ID demandé
        $quiz = Quiz::findById($id);

        // Si le quiz n'existe pas
        if (is_null($quiz)) {
            throw new RecordNotFoundException("Quiz #$id could not be found.");
        }

        // Renvoie une vue permettant d'afficher les données d'un seul quiz
        return new StandardView(
            [ 'common/alert', 'quiz/result' ],
            [ 'quiz' => $quiz ]
        );
    }

    /**
     * Display quiz creation form
     */
    public function createForm(): AbstractView
    {
        return new StandardView(
            [ 'quiz/edit' ],
        );
    }
}
