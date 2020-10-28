<?php

namespace App\Controller;

use App\Model\Quiz;
use App\Model\Answer;
use App\Model\Question;
use App\Core\AbstractView;
use App\View\StandardView;
use App\Exception\RecordNotFoundException;

class QuestionController
{
    /**
     * Display single question
     * 
     * @param int $id Question database ID
     */
    public function single(int $id): AbstractView
    {
        \session_start();

        if (!isset($_SESSION['score'])) {
            $_SESSION['score'] = 0;
        }

        $question = Question::findById($id);

        if (is_null($question)) {
            throw new RecordNotFoundException("Question #$id could not be found.");
        }

        return new StandardView(
            [ 'common/alert', 'question/single' ],
            [ 'question' => $question ]
        );
    }

    /**
     * Process answer given by user
     * 
     * @param int $id Queston database ID
     */
    public function processAnswer(int $id): void
    {
        // Autorise l'accès à la super-globale $_SESSION
        \session_start();

        $question = Question::findById($id);

        if (is_null($question)) {
            throw new RecordNotFoundException("Question #$id could not be found.");
        }

        // Si l'utilisateur n'a pas donné de réponse à la question
        if (!isset($_POST['answer'])) {
            $_SESSION['message'] = 'Vous devez sélectionner une réponse!';
            // Retourne sur la page de la question actuelle
            header('Location: /question/' . $question->getId());
            die();
        }

        $userAnswer = \intval($_POST['answer']);

        // Si la réponse donnée par l'utilisateur correspond à la bonne réponse à la question concernée
        if ($question->getRightAnswer()->getId() === $userAnswer) {
            $_SESSION['score'] += 1;
            $_SESSION['message'] = 'Bonne réponse';
        } else {
            $_SESSION['message'] = 'Mauvaise réponse';
        }

        $nextQuestion = $question->getNextQuestionInQuiz();
        // S'il n'y a plus de questions dans le quiz
        if (is_null($nextQuestion)) {
            header('Location: /quiz/' . $question->getQuiz()->getId() . '/result');
            die();
        }
        // Redirige sur la page de la question suivante
        header('Location: /question/' . $nextQuestion->getId());
    }

    /**
     * Process create question form
     */
    public function create()
    {
        // Crée une nouvelle question
        $question = new Question;

        // Récupère le quiz à associer à la question
        $quiz = Quiz::findById($_POST['quiz-id']);

        // Assigne les valeurs envoyées par l'utilisateur aux propriétés de la question
        $question
            ->setDescription($_POST['description'])
            ->setRank($_POST['rank'])
            ->setQuiz($quiz)
        ;

        // Sauvegarde la question en base de données
        $question->save();

        // Crée une nouvelle réponse
        $answer = new Answer;

        // Associe la réponse à la question créée précédemment
        $answer
            ->setQuestion($question)
            ->setDescription('Réponse 1')
            ->setRank(1)
        ;

        // Sauvegarde la réponse en base de données
        $answer->save();

        // Définit la bonne réponse à la question créée comme étant la réponse créée
        $question->setRightAnswer($answer);

        $question->save();

        // Renvoie sur le formulaire de modification de quiz
        header('Location: /quiz/' . $quiz->getId() . '/update');
    }
}
