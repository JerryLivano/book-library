<?php

namespace dao;

use PDO;
use entity\User;

class UserDao
{
    public function login($email, $password)
    {
        $link = PDOUtil::createMySQLConnection();
        $query = 'SELECT id, name, email FROM user WHERE email = ? AND password = MD5(?)';
        $stmt = $link->prepare($query);
        $stmt -> bindParam(1, $email);
        $stmt -> bindParam(2, $password);
        $stmt -> setFetchMode(\PDO::FETCH_OBJ);
        $stmt -> execute();
        $user = $stmt->fetchObject(User::class);
        $link = null;
        return $user;
    }

    public function addNewUser(User $user): int
    {
        $result = 0;
        $link = PDOUtil::createMySQLConnection();
        $link -> beginTransaction();
        $query = 'INSERT INTO user(name, email, password) VALUES (?, ?, MD5(?))';
        $stmt = $link -> prepare($query);
        $stmt -> bindValue(1, $user->getName());
        $stmt -> bindValue(2, $user->getEmail());
        $stmt -> bindValue(3, $user->getPassword());
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