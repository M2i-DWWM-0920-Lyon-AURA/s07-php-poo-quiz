<!-- quiz/single -->
<h1><?= $quiz->getTitle() ?></h1>
<p><?= $quiz->getDescription() ?></p>
<a href="/question/<?= $quiz->getQuestions()[0]->getId() ?>" class="btn btn-primary">Lancer le quiz</a>
