<?php

namespace dao;

use entity\Genre;
use PDO;
use dao\PDOUtil;
use entity\Book;

class BookDao
{
    public function fetchBookFromDb(): bool|array
    {
        $link = PDOUtil::createMySQLConnection();
        $query = 'SELECT book.isbn, book.title, book.author, book.publisher, book.publish_year, book.short_description, book.cover, genre.name 
                FROM genre INNER JOIN book ON genre.id = book.genre_id';
        $stmt = $link -> prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE,Book::class);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $link = null;
        return $results;
    }

    public function addNewBook(Book $book): int
    {
        $results = 0;
        $link = PDOUtil::createMySQLConnection();
        $link -> beginTransaction();
        $query = 'INSERT INTO book(isbn, title, author, publisher, publish_year, short_description, genre_id) VALUES (?, ?, ?, ?, ?, ?, ?)';
        $stmt = $link -> prepare($query);
        $stmt -> bindValue(1, $book->getIsbn());
        $stmt -> bindValue(2, $book->getTitle());
        $stmt -> bindValue(3, $book->getAuthor());
        $stmt -> bindValue(4, $book->getPublisher());
        $stmt -> bindValue(5, $book->getYear());
        $stmt -> bindValue(6, $book->getDescription());
        $stmt -> bindValue(7, $book->getGenre()->getId());
        if ($stmt -> execute()) {
            $link -> commit();
            $results = 1;
        } else {
            $link -> rollBack();
        }
        $link = null;
        return $results;
    }

    public function fetchOneBook($isbn)
    {
        $link = PDOUtil::createMySQLConnection();
        $query = 'SELECT * FROM book WHERE isbn = ?';
        $stmt = $link -> prepare($query);
        $stmt -> bindParam(1, $isbn);
        $stmt -> setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();
        $book = $stmt->fetchObject(Book::class);
        $link = null;
        return $book;
    }

    public function fetchOneGenreName($isbn)
    {
        $link = PDOUtil::createMySQLConnection();
        $query = 'SELECT genre.name FROM book INNER JOIN genre ON book.genre_id = genre.id
                WHERE isbn = ?';
        $stmt = $link -> prepare($query);
        $stmt -> bindParam(1, $isbn);
        $stmt -> setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();
        $results = $stmt->fetchObject(Book::class);
        $link = null;
        return $results;
    }

    public function updateBookToDb(Book $book): int
    {
        $result = 0;
        $link = PDOUtil::createMySQLConnection();
        $query = 'UPDATE book SET title = ?, author = ?, publisher = ?, publish_year = ?, short_description = ?, genre_id = ? WHERE isbn = ?';
        $stmt = $link -> prepare($query);
        $stmt -> bindValue(1, $book->getTitle());
        $stmt -> bindValue(2, $book->getAuthor());
        $stmt -> bindValue(3, $book->getPublisher());
        $stmt -> bindValue(4, $book->getYear());
        $stmt -> bindValue(5, $book->getDescription());
        $stmt -> bindValue(6, $book->getGenre()->getId());
        $stmt -> bindValue(7, $book->getIsbn());
        if ($stmt -> execute()) {
            $link -> commit();
            $result = 1;
        } else {
            $link -> rollBack();
        }
        $link = null;
        return $result;
    }

    public function deleteBookFromDb($isbn): int
    {
        $result = 0;
        $link = PDOUtil::createMySQLConnection();
        $link -> beginTransaction();
        $query = 'DELETE FROM book WHERE isbn = ?';
        $stmt = $link -> prepare($query);
        $stmt -> bindParam(1, $isbn);
        if ($stmt -> execute()) {
            $link -> commit();
            $result = 1;
        } else {
            $link -> rollBack();
        }
        $link = null;
        return $result;
    }

    public function uploadCover(Book $book)
    {
        $result = 0;
        $link = PDOUtil::createMySQLConnection();
        $query = 'UPDATE book SET cover = ? WHERE isbn = ?';
        $stmt = $link -> prepare($query);
        $stmt -> bindValue(1, $book->getCover());
        $stmt -> bindValue(2, $book->getIsbn());
        if ($stmt -> execute()) {
            $link -> commit();
            $result = 1;
        } else {
            $link -> rollBack();
        }
        $link = null;
        return $result;
    }
}