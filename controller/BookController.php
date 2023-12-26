<?php

namespace controller;

use dao\GenreDao;
use dao\BookDao;
use entity\Book;
use entity\Genre;

class BookController
{
    private BookDao $bookDao;
    private GenreDao $genreDao;

    public function __construct()
    {
        $this->bookDao = new BookDao();
        $this->genreDao = new GenreDao();
    }

    public function index(): void
    {
        $deleteCommand = filter_input(INPUT_GET, 'cmd');
        if (isset($deleteCommand) && $deleteCommand == 'del') {
            $bookIsbn = filter_input(INPUT_GET, 'isbn');
            $nama_cover = $this->bookDao->fetchOneBook($bookIsbn);
            $result = $this->bookDao->deleteBookFromDb($bookIsbn);
            if ($result) {
                if ($nama_cover->getCover() != null){
                    unlink("uploads/" . $nama_cover->getCover());
                }
                echo '<div class="d-flex justify-content-center">Data succesfully removed</div>';
                header('location:index.php?menu=book');
            } else {
                echo '<div class="d-flex justify-content-center">Failed to remove data</div>';
            }
        }

        $submitPressed = filter_input(INPUT_POST, 'btnSave');
        if (isset($submitPressed)) {
            $isbn = filter_input(INPUT_POST, 'isbn');
            $title = filter_input(INPUT_POST, 'judul');
            $author = filter_input(INPUT_POST, 'author');
            $pub = filter_input(INPUT_POST, 'publisher');
            $pubyear = filter_input(INPUT_POST, 'publish_year');
            $desc = filter_input(INPUT_POST, 'desc');
            $id = filter_input(INPUT_POST, 'genre_id');
            if ($_FILES["txtFiles"]["error"] != 4) {
                if ($_FILES["txtFiles"]['size'] > 1024 * 2048) {
                    echo '<div>Uploaded file exceed 2MB</div>';
                } else {
                    $targetDirectory = 'uploads/';
                    $fileExtension = pathinfo($_FILES["txtFiles"]['name'], PATHINFO_EXTENSION);
                    $newFileName = $isbn . '.' . $fileExtension;
                    $fileUploadPath = $targetDirectory . $newFileName;
                }
            }
            if ((trim($isbn) == '') || (trim($title) == '') || (trim($author) == '') || (trim($pub) == '') || (trim($pubyear) == '') || (trim($desc) == '') || (trim($id) == '')){
                echo '<div class="d-flex justify-content-center>Please provide with a valid name</div>';
            } else {
                $newBook = new \entity\Book();
                $newGenre = new \entity\Genre();
                $newBook->setIsbn($isbn);
                $newBook->setTitle($title);
                $newBook->setAuthor($author);
                $newBook->setPublisher($pub);
                $newBook->setYear($pubyear);
                $newBook->setDescription($desc);
                $newBook->setCover($newFileName);
                $newGenre->setId($id);
                $newBook->setGenre($newGenre);
                $results = $this->bookDao->addNewBook($newBook);
                if ($results) {
                    if ($_FILES["txtFiles"]["error"] != 4) {
                        move_uploaded_file($_FILES["txtFiles"]['tmp_name'], $fileUploadPath); #Parameter : nama file temporary, tempat diuploadnya
                    }
                    echo '<div class="d-flex justify-content-center">Data Succesfully Loaded</div>';
                } else {
                    echo '<div class="d-flex justify-content-center">Failed to add data</div>';
                }
            }
        }
        $resultsGenre = $this->genreDao->fetchGenreFromDb();
        $resultsBook = $this->bookDao->fetchBookFromDb();
        include_once 'pages\book.php';
    }

    public function edit(): void
    {
        $editedIsbn = filter_input(INPUT_GET, 'isbn');
        if (isset($editedIsbn)) {
            $book = $this->bookDao->fetchOneBook($editedIsbn);
            $genreName = $this->bookDao->fetchOneGenreName($editedIsbn);
        }

        $updatePressed = filter_input(INPUT_POST, 'btnUpdate');
        if (isset($updatePressed)) {
            $title = filter_input(INPUT_POST, 'judul');
            $author = filter_input(INPUT_POST, 'author');
            $pub = filter_input(INPUT_POST, 'publisher');
            $pubyear = filter_input(INPUT_POST, 'publish_year');
            $desc = filter_input(INPUT_POST, 'desc');
            $id = filter_input(INPUT_POST, 'genre_id');
            if ($_FILES['txtFile']["error"] != 4) {
                $targetDirectory = 'uploads/';
                $fileExtension = pathinfo($_FILES['txtFile']['name'], PATHINFO_EXTENSION);
                $cover = $book->getCover() . '.' . $fileExtension;
                $fileUploadPath = $targetDirectory . $cover;
            }
            if (trim($title) == ' ') {
                echo '<div class="d-flex justify-content-center">Please fill updated title name</div>';
            } else if (trim($author) == ' ') {
                echo '<div class="d-flex justify-content-center">Please fill updated author name</div>';
            } else if (trim($pub) == ' ') {
                echo '<div class="d-flex justify-content-center">Please fill updated publisher name</div>';
            } else if (trim($pubyear) == ' ') {
                echo '<div class="d-flex justify-content-center">Please fill updated publisher year date</div>';
            } else if (trim($desc) == ' ') {
                echo '<div class="d-flex justify-content-center">Please fill updated description name</div>';
            } else if (trim($cover) == ' ') {
                echo '<div class="d-flex justify-content-center">Please fill updated cover name</div>';
            } else if (trim($id) == ' ') {
                echo '<div class="d-flex justify-content-center">Please fill updated genre name</div>';
            } else {
                $bookUpdate = new \entity\Book();
                $genreUpdate = new \entity\Genre();
                $bookUpdate->setIsbn($book->getIsbn());
                $bookUpdate->setTitle($title);
                $bookUpdate->setAuthor($author);
                $bookUpdate->setPublisher($pub);
                $bookUpdate->setYear($pubyear);
                $bookUpdate->setDescription($desc);
                $bookUpdate->setCover($cover);
                $genreUpdate->setId($id);
                $bookUpdate->setGenre($genreUpdate);
                if ($_FILES['txtFile']['error'] != 4) {
                    if ($_FILES['txtFile']['size'] > 1024 * 2048) {
                        echo '<div>Uploaded file exceed 2MB</div>';
                    } else {
                        $result_cover = $this->bookDao->uploadCover($bookUpdate);
                        $results = $this->bookDao->updateBookToDb($bookUpdate);
                    }
                } else {
                    $results = $this->bookDao->updateBookToDb($bookUpdate);
                }
                if ($results) {
                    if ($result_cover) {
                        unlink($fileUploadPath);
                        move_uploaded_file($_FILES['txtFile']['tmp_name'], $fileUploadPath); #Parameter : nama file temporary, tempat diuploadnya
                    }
                    header('location:index.php?menu=book');
                } else {
                    echo '<div class="d-flex justify-content-center">Failed to update data</div>';
                }
            }
        }
        $results = $this->genreDao->fetchGenreFromDb();
        include_once 'pages\book_edit.php';
    }

    public function cover(): void
    {
        $isbnCover = filter_input(INPUT_GET, 'isbn');
        if (isset($isbnCover)) {
            $bookIsbn = $this->bookDao->fetchOneBook($isbnCover);
        }

        $uploadPressed = filter_input(INPUT_POST, 'btnUpload');
        if (isset($uploadPressed)) {
            $fileName = filter_input(INPUT_POST, 'txtFileName');
            $targetDirectory = 'uploads/';
            if ($_FILES['txtFile']['error'] != 4){
                $fileExtension = pathinfo($_FILES['txtFile']['name'], PATHINFO_EXTENSION);
                $newFileName = $fileName . '.' . $fileExtension;
                $fileUploadPath = $targetDirectory . $newFileName;
            } else {
                $newFileName = "default.jpg";
                unlink($targetDirectory . "/" . $bookIsbn->getCover());
                header('location:index.php?menu=book');
            }
            if ($_FILES['txtFile']['size'] > 1024 * 2048) {
                echo '<div>Uploaded file exceed 2MB</div>';
            } else {
                $coverUpdate = new \entity\Book();
                $coverUpdate->setCover($newFileName);
                $coverUpdate->setIsbn($isbnCover);
                $result = $this->bookDao->uploadCover($coverUpdate);
                if ($result) {
                    unlink($fileUploadPath);
                    move_uploaded_file($_FILES['txtFile']['tmp_name'], $fileUploadPath); #Parameter : nama file temporary, tempat diuploadnya
                    header('location:index.php?menu=book');
                } else {
                    echo '<div>Uploaded file error</div>';
                }
            }
        }
        include_once 'pages\image.php';
    }
}