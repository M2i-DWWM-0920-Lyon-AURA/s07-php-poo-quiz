<?php

namespace App\Controller;

use App\Model\Quiz;
use App\Core\AbstractView;
use App\View\StandardView;
use App\Exception\RecordNotFoundException;

class QuizController
{
    // ================================================================
    // Méthodes internes
    // ----------------------------------------------------------------
    // ~ Ces méthodes correspondent à des traitements internes
    // réalisés uniquement à l'intérieur de la classe. Elles sont
    // donc protégées afin d'empêcher d'autres processus de les
    // appeler.
    // ================================================================

    /**
     * Get quiz by id and throws error if quiz is null
     * 
     * @param int $id Quiz database ID
     */
    protected function findQuizByIdOrException(int $id): Quiz
    {
        // Récupère le quiz demandé dans la base de données
        $quiz = Quiz::findById($id);

        // Si le quiz n'existe pas
        if (is_null($quiz)) {
            // Envoie une erreur
            throw new RecordNotFoundException("Quiz #$id could not be found.");
        }
        
        // Sinon, renvoie le quiz normalement
        return $quiz;
    }

    // ================================================================
    // Méthodes corespondant à des routes
    // ----------------------------------------------------------------
    // ~ Ces méthodes correspondent chacune à une route définie dans
    // le routeur. Elles sont donc publiques afin de pouvoir être
    // appelée par le Front controller.
    // ================================================================

    /**
     * Display all quizzes
     */
    public function list(): AbstractView
    {
        // Renvoie une nouvelle vue...
        return new StandardView(
            // ...contenant la page affichant la liste des quiz auxquels on peut jouer...
            [ 'quiz/list' ],
            // ...ainsi que la liste de tous les quiz
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
        // Récupère le quiz demandé en vérifiant qu'il existe
        $quiz = $this->findQuizByIdOrException($id);

        // Renvoie une nouvelle vue...
        return new StandardView(
            // ...contenant la page affichant les détails d'un quiz...
            [ 'quiz/single', ],
            // ...ainsi que les données du quiz
            [ 'quiz' => $quiz ]
        );
    }

    /**
     * Display result to taken quiz
     */
    public function result(int $id): AbstractView
    {
        \session_start();

        // Récupère le quiz demandé en vérifiant qu'il existe
        $quiz = $this->findQuizByIdOrException($id);

        // Renvoie une nouvelle vue...
        return new StandardView(
            // ...contenant l'alerte à afficher, la page de résultat...
            [ 'common/alert', 'quiz/result' ],
            // ...ainsi que les données du quiz
            [ 'quiz' => $quiz ]
        );
    }

    /**
     * Display quiz creation form
     */
    public function createForm(): AbstractView
    {
        // Crée un nouveau quiz
        $quiz = new Quiz;

        // Renvoie une nouvelle vue...
        return new StandardView(
            // ...contenant le formulaire de modification d'un quiz...
            [ 'quiz/edit' ],
            // ...ainsi que les donneés du quiz
            [ 'quiz' => $quiz ]
        );
    }

    /**
     * Process quiz creation form
     */
    public function create()
    {
        // Crée un nouveau quiz
        $quiz = new Quiz;

        // Assigne le contenu du formulaire aux propriétés de l'objet
        $quiz
            ->setTitle($_POST['title'])
            ->setDescription($_POST['description'])
        ;

        // Sauvegarde le quiz en base de données
        $quiz->save();

        // Redirige vers la page "Création"
        header('Location: /create');
    }

    /**
     * Display quiz update form
     * 
     * @param int $id Quiz database ID
     */
    public function updateForm(int $id): AbstractView
    {
        // Récupère le quiz demandé en vérifiant qu'il existe
        $quiz = $this->findQuizByIdOrException($id);
        
        // Renvoie une nouvelle vue...
        return new StandardView(
            // ...contenant le formulaire de modification d'un quiz...
            [ 'quiz/edit' ],
            // ...ainsi que les donneés du quiz
            [ 'quiz' => $quiz ]
        );
    }

    /**
     * Process quiz update form
     * 
     * @param int $id Quiz database ID
     */
    public function update(int $id)
    {
        // Récupère le quiz demandé en vérifiant qu'il existe
        $quiz = $this->findQuizByIdOrException($id);

        // Assigne le contenu du formulaire aux propriétés de l'objet
        $quiz
            ->setTitle($_POST['title'])
            ->setDescription($_POST['description'])
        ;

        // Sauvegarde le quiz en base de données
        $quiz->save();

        // Redirige vers la page "Création"
        header('Location: /create');
    }

    /**
     * Delete quiz
     * 
     * @param int $id Quiz database ID
     */
    public function delete(int $id)
    {
        // Récupère le quiz demandé en vérifiant qu'il existe
        $quiz = $this->findQuizByIdOrException($id);

        // Supprime le quiz en base de données
        $quiz->delete();

        // Redirige vers la page "Création"
        header('Location: /create');
    }
}
