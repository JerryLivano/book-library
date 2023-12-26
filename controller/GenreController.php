<?php

namespace controller;

use dao\GenreDao;
use entity\Genre;

class GenreController
{
    private GenreDao $genreDao;

    public function __construct()
    {
        $this->genreDao = new GenreDao();
    }

    public function index(): void
    {
        $deleteCommand = filter_input(INPUT_GET, 'cmd');
        if (isset($deleteCommand) && $deleteCommand == 'del') {
            $genreId = filter_input(INPUT_GET, 'gid');
            $result = $this->genreDao->deleteGenreFromDb($genreId);
            if ($result) {
                echo '<div class="d-flex justify-content-center">Data succesfully removed</div>';
            } else {
                echo '<div class="d-flex justify-content-center">Failed to remove data</div>';
            }
        }

        // Input Data
        $submitPressed = filter_input(INPUT_POST, 'btnSave');
        if (isset($submitPressed)) {
            $name = filter_input(INPUT_POST, 'txtName');
            if (trim($name) == ' '){
                echo '<div class="d-flex justify-content-center">Please provide with a valid name</div>';
            } else {
                $genre = new \entity\Genre();
                $genre->setName($name);
                $results = $this->genreDao->addNewGenre($genre);
                if ($results) {
                    echo '<div class="d-flex justify-content-center">Data Succesfully Loaded</div>';
                } else {
                    echo '<div class="d-flex justify-content-center">Failed to add data</div>';
                }
            }
        }
        $results = $this->genreDao->fetchGenreFromDb();
        include_once 'pages\genre.php';
    }

    public function edit(): void
    {
        $editedId = filter_input(INPUT_GET, 'gid');
        if (isset($editedId)) {
            $genre = $this->genreDao->fetchOneGenre($editedId);
        }

        /** @var $genre \entity\Genre */
        $updatePressed = filter_input(INPUT_POST, 'btnUpdate');
        if (isset($updatePressed)) {
            $name = filter_input(INPUT_POST, 'txtName');
            if (trim($name) == ' ') {
                echo '<div>Please fill updated genre name</div>';
            } else {
                $genreUpdate = new \entity\Genre();
                $genreUpdate->setId($genre->getId());
                $genreUpdate->setName($name);
                $results = $this->genreDao->updateGenreToDb($genreUpdate);
                if ($results) {
                    header('location:index.php?menu=genre');
                } else {
                    echo '<div>Failed to update data</div>';
                }
            }
        }
        include_once 'pages\genre_edit.php';
    }
}