## Routes

| User story | Méthode | URL | Contrôleur |
|---|---|---|---|
| En tant que visiteur, j'ai besoin d'une page d'accueil afin de connaître les fonctionnalités du site | `GET` | `/` | `MainController#home`
| En tant que visiteur, j'ai besoin d'une liste de quiz afin de choisir à quel quiz jouer | `GET` | `/quiz` | `QuizController#list`
| En tant que visiteur, j'ai besoin d'une page détaillant les informations du quiz afin de lancer le quiz | `GET` | `/quiz/:id` | `QuizController#single`
| En tant que visiteur, j'ai besoin d'une page détaillant mes résultats au quiz afin de connaître mon score | `GET` | `/quiz/:id/result` | `QuizController#result`
| En tant que visiteur, j'ai besoin d'une page affichant une question afin d'y répondre | `GET` | `/question/:id` | `QuestionController#single`
| En tant que visiteur, j'ai besoin d'une route spécifique afin de déterminer si ma réponse était bonne, et de me rediriger vers la question suivante | `POST` | `/question/:id/give-answer` | `QuestionController#processAnswer`
| En tant que membre inscrit, j'ai besoin d'une page me présentant la liste des quiz que j'ai créés afin d'avoir accès aux fonctionnalités de création et de modification | `GET` | `/create` | `MainController#create` |
| En tant que membre inscrit, j'ai besoin d'un formulaire afin de créer un nouveau quiz | `GET|POST` | `/quiz/new` | `QuizController#create` |
| En tant que membre inscrit, j'ai besoin d'un formulaire afin de modifier un quiz existant | `GET|POST` | `/quiz/:id/update` | `QuizController#update` |
| En tant que membre inscrit, j'ai besoin d'un bouton "Supprimer" adin de supprimer un quiz existant | `POST` | `/quiz/:id/delete` | `QuizController#delete` |
| En tant que membre inscrit, j'ai besoin d'un formulaire afin de créer une nouvelle question | `POST` | `/question/new` | `QuestionController#create` |
| En tant que membre inscrit, j'ai besoin d'un formulaire afin de modifier une question existante | `POST` | `/question/:id/update` | `QuestionController#update` |
| En tant que membre inscrit, j'ai besoin d'un bouton "Supprimer" afin de supprimer une question existante | `POST` | `/question/:id/delete` | `QuestionController#delete` |
| En tant que membre inscrit, j'ai besoin d'un formulaire afin de créer une nouvelle réponse | `POST` | `/answer/new` | `AnswerController#create` |
| En tant que membre inscrit, j'ai besoin d'un formulaire afin de modifier une réponse existante | `POST` | `/answer/:id/update` | `AnswerController#update` |
| En tant que membre inscrit, j'ai besoin d'un bouton "Supprimer" afin de supprimer une réponse existante | `POST` | `/answer/:id/delete` | `AnswerController#delete` |