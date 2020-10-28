<!-- quiz/edit-questions -->
<ul class="mb-4" style="padding-left: 0">

    <?php foreach ($quiz->getQuestions() as $question): ?>
    <li style="list-style: none">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Question n°<?= $question->getRank() ?></h3>
                <p class="card-text"><?= $question->getDescription() ?></p>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#questionModal<?= $question->getId() ?>">
                    Modifier
                </button>

                <!-- Modal -->
                <div class="modal fade" id="questionModal<?= $question->getId() ?>" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modifier la question</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="/question/<?= $question->getId() ?>/update">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Description</label>
                                        <input name="description" type="text" class="form-control" value="<?= $question->getDescription() ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="list-group">
                    <?php foreach ($question->getAnswers() as $answer): ?>
                    <li class="list-group-item">
                        <strong>Réponse <?= $answer->getRank() ?>:</strong> <?= $answer->getDescription() ?>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <form method="post" action="/answer/new">
                    <div class="form-group">
                        <input name="question-id" type="hidden" value="<?= $question->getId() ?>" />
                        <input name="description" type="text" class="form-control" placeholder="Entrez une nouvelle réponse ici" />
                        <button type="submit" class="btn btn-primary">
                            Ajouter une nouvelle réponse
                        </button>
                    <div>
                </form>

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