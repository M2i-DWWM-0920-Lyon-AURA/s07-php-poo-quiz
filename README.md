## Routes

| User story | Méthode | URL | Contrôleur |
|---|---|---|---|
| En tant que visiteur, j'ai besoin d'une page d'accueil afin de connaître les fonctionnalités du site | `GET` | `/` | `MainController#home`
| En tant que visiteur, j'ai besoin d'une liste de quiz afin de choisir à quel quiz jouer | `GET` | `/quiz` | `QuizController#list`
| En tant que visiteur, j'ai besoin d'une page détaillant les informations du quiz afin de lancer le quiz | `GET` | `/quiz/:id` | `QuizController#single`
| En tant que visiteur, j'ai besoin d'une page détaillant mes résultats au quiz afin de connaître mon score | `GET` | `/quiz/:id/result` | `QuizController#result`
| En tant que visiteur, j'ai besoin d'une page affichant une question afin d'y répondre | `GET` | `/question/:id` | `QuestionController#single`
| En tant que visiteur, j'ai besoin d'une route spécifique afin de déterminer si ma réponse était bonne, et de me rediriger vers la question suivante | `POST` | `/question/:id/give-answer` | `QuestionController#processAnswer`
