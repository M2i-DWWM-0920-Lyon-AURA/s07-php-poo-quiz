<?php

namespace App\Controller;

use App\Model\Answer;
use App\Model\Question;

class AnswerController
{
    /**
     * Process create answer form
     */
    public function create()
    {
        $answer = new Answer;

        $question = Question::findById($_POST['question-id']);

        $count = count($question->getAnswers());

        $answer
            ->setDescription($_POST['description'])
            ->setRank($count + 1)
            ->setQuestion($question)
        ;

        $answer->save();

        // Renvoie sur le formulaire de modification de quiz
        header('Location: /quiz/' . $question->getQuiz()->getId() . '/update');
    }
}
