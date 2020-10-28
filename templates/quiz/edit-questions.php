<!-- quiz/edit-questions -->
<ul class="mb-4" style="padding-left: 0">

    <?php foreach ($quiz->getQuestions() as $question): ?>
    <li style="list-style: none">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Question n°<?= $question->getRank() ?></h3>
                <p class="card-text"><?= $question->getDescription() ?></p>

                <ul class="list-group">
                    <?php foreach ($question->getAnswers() as $answer): ?>
                    <li class="list-group-item">
                        <strong>Réponse <?= $answer->getRank() ?>:</strong> <?= $answer->getDescription() ?>
                    </li>
                    <?php endforeach; ?>
                </ul>

            </div>
        </div>
    </li>
    <?php endforeach; ?>

</ul>

<form method="post" action="/question/new">
    <div class="form-group">
        <input name="rank" type="hidden" value="<?= count($quiz->getQuestions()) + 1 ?>" />
        <input name="quiz-id" type="hidden" value="<?= $quiz->getId() ?>" />
        <input name="description" type="text" class="form-control" placeholder="Entrez votre nouvelle question ici">
        <button type="submit" class="btn btn-primary">
            Ajouter une question
        </button>
    </div>
</form>
