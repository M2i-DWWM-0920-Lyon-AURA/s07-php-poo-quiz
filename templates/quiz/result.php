<!-- quiz/result -->
<h1>Votre résultat</h1>
<p>Vous venez de finir le quiz: <?= $quiz->getTitle() ?></p>
<p>Vous avez obtenu le score extraordinaire de: <?= $_SESSION['score'] ?>.</p>
<?php unset($_SESSION['score']) ?>