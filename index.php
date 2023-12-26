<?php
use controller\BookController;
use controller\GenreController;
use controller\UserController;

session_start();
if (!isset($_SESSION['registered_user'])) {
    $_SESSION['registered_user'] = false;
}
include_once 'entity/User.php';
include_once 'entity/Genre.php';
include_once 'entity/Book.php';
include_once 'dao/PDOUtil.php';
include_once 'dao/UserDao.php';
include_once 'dao/GenreDao.php';
include_once 'dao/BookDao.php';
include_once 'controller/UserController.php';
include_once 'controller/GenreController.php';
include_once 'controller/BookController.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JerPipedia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php
    if ($_SESSION['registered_user']) {
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="padding-left: 30px;">
        <img src="asset/jerpip.png" width="50" alt="">
        <a class="navbar-brand ms-2">Jer<span style="color: #F9004D;">Pipedia</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="?menu=home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?menu=book">Book</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?menu=genre">Genre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?menu=logout">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-3">

    </div>
    <main>
        <?php
            $navigation = filter_input(INPUT_GET, 'menu');
            switch ($navigation) {
                case 'home':
                    include_once 'pages/home.php';
                    break;
                case 'genre':
                    $genreController = new GenreController();
                    $genreController->index();
                    break;
                case 'book':
                    $bookController = new BookController();
                    $bookController->index();
                    break;
                case 'genre_update':
                    $genreController = new GenreController();
                    $genreController->edit();
                    break;
                case 'book_update':
                    $bookController = new BookController();
                    $bookController->edit();
                    break;
                case 'image':
                    $bookController = new BookController();
                    $bookController->cover();
                    break;
                case 'logout':
                    session_unset();
                    session_destroy();
                    header('location:index.php');
                    break;
                default:
                    include_once 'pages/home.php';
                    break;
            }
        ?>
    </main>
    <?php
    } else {
        $userController = new UserController();
        $userController->index();
    }
    ?>
</body>
</html>
