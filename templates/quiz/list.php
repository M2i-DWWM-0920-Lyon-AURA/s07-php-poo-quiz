<!-- quiz/list -->
<h1>Liste des quizz</h1>
<ul>

    <?php foreach ($quizzes as $quiz): ?>
    <li>
        <a href="/quiz/<?= $quiz->getId() ?>">
        <?= $quiz->getTitle() ?>
        </a>
    </li>
    <?php endforeach; ?>

</ul>
