<!-- question/single -->
<h2 class="mt-4">Question n°<span id="question-id"><?= $question->getRank() ?></span></h2>
<form method="post" action="/question/<?= $question->getId() ?>/give-answer">
    <p id="current-question-text" class="question-text"><?= $question->getDescription() ?></p>
    <div id="answers" class="d-flex flex-column">

        <?php foreach ($question->getAnswers() as $answer): ?>
        <div class="custom-control custom-radio mb-2">
            <input class="custom-control-input" type="radio" name="answer" id="answer<?= $answer->getId() ?>" value="<?= $answer->getId() ?>">
            <label class="custom-control-label" for="answer<?= $answer->getId() ?>"><?= $answer->getDescription() ?></label>
        </div>
        <?php endforeach; ?>

    </div>
    <button type="submit" class="btn btn-primary">Valider</button>
</form>