<!-- quiz/list -->
<h1>Liste des quizz</h1>
<ul>

    <?php foreach ($quizzes as $quiz): ?>
    <li>
        <?= $quiz->getTitle() ?>
    </li>
    <?php endforeach; ?>

</ul>
