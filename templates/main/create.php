<!-- main/create -->
<div class="jumbotron">
  <h1 class="display-4">Création</h1>
  <p class="lead">Sur cette page, vous retrouvez l'ensemble des quiz que vous avez créés. Vous pouvez modifier ou supprimer des quiz déjà existants, et même en créer de nouveaux!</p>
</div>

<ul class="list-group mb-4">

    <?php foreach ($quizzes as $quiz): ?>
    <a href="/quiz/<?= $quiz->getId() ?>/update">
        <li class="list-group-item list-group-item-action">
            <?= $quiz->getTitle() ?>
        </li>
    </a>
    <?php endforeach; ?>

</ul>

<a href="/quiz/new" class="btn btn-primary">
    Créer un nouveau quiz
</a>