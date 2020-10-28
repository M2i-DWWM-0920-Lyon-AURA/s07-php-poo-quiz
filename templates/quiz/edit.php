<!-- quiz/edit -->
<form method="post">
    <div class="form-group">
        <label for="quizTitle">Titre</label>
        <input name="title" type="text" class="form-control" id="quizTitle" placeholder="Entrez le titre de votre quiz" value="<?= $quiz->getTitle() ?>">
    </div>
    <div class="form-group">
        <label for="quizDescription">Description</label>
        <input name="description" type="text" class="form-control" id="quizDescription"
            placeholder="Entrez une description pour votre quiz" value="<?= $quiz->getDescription() ?>">
    </div>
    <button type="submit" class="btn btn-primary">Valider les modifications</button>
</form>