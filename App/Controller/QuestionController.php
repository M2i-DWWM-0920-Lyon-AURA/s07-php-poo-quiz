<?php

namespace App\Controller;

use App\Model\Question;
use App\View\StandardView;
use App\Exception\RecordNotFoundException;

class QuestionController
{
    /**
     * Display single question
     * 
     * @param int $id Question database ID
     */
    public function single(int $id)
    {
        $question = Question::findById($id);

        if (is_null($question)) {
            throw new RecordNotFoundException("Question #$id could not be found.");
        }

        return new StandardView(
            [ 'question/single' ],
            [ 'question' => $question ]
        );
    }
}
