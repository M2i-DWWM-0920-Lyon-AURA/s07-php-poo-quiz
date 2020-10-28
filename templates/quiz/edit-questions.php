<!-- quiz/edit-questions -->
<ul class="mb-4" style="padding-left: 0">

    <?php foreach ($quiz->getQuestions() as $question): ?>
    <li style="list-style: none">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Question n°<?= $question->getRank() ?></h3>
                
                <div class="d-flex">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-sm mr-2" data-toggle="modal"
                        data-target="#questionModal<?= $question->getId() ?>">
                        Modifier
                    </button>

                    <p class="card-text"><?= $question->getDescription() ?></p>
                </div>

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

                <ul class="list-group mb-4">
                    <?php foreach ($question->getAnswers() as $answer): ?>
                    <li class="list-group-item">
                        <strong>Réponse <?= $answer->getRank() ?>:</strong>
                        <form method="post" action="/answer/<?= $answer->getId() ?>/update" class=" d-flex">
                            <input name="description" type="text" value="<?= $answer->getDescription() ?>" class="form-control" />
                            <button type="submit" class="btn btn-primary">
                                Modifier
                            </button>
                        </form>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <form method="post" action="/answer/new">
                    <input name="question-id" type="hidden" value="<?= $question->getId() ?>" />
                    <div class="d-flex">
                        <input name="description" type="text" class="form-control" placeholder="Entrez une nouvelle réponse ici" />
                        <button type="submit" class="btn btn-primary">
                            Ajouter
                        </button>
                    <div>
                </form>

            </div>
        </div>
    </li>
    <?php endforeach; ?>

</ul>

<form method="post" action="/question/new">
    <input name="rank" type="hidden" value="<?= count($quiz->getQuestions()) + 1 ?>" />
    <input name="quiz-id" type="hidden" value="<?= $quiz->getId() ?>" />
    <div class="d-flex">
        <input name="description" type="text" class="form-control" placeholder="Entrez votre nouvelle question ici">
        <button type="submit" class="btn btn-primary">
            Ajouter
        </button>
    </div>
</form>