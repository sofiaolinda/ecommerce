<?php

namespace Hcode\Model;

use \Hcode\Model;
use \Hcode\DB\Sql;

class User extends Model
{
    const SESSION = "User";

    protected $fields = [
        "iduser", "idperson", "deslogin", "despassword", "inadmin", "dtergister"
    ];

    public static function login($login, $password): User
    {
        $sql = new sql();

        $results = $sql->select("SELECT * from tb_users where deslogin = :LOGIN", array(
            ":LOGIN" => $login
        ));

        if (count($results) === 0) {
            throw new \Exception("Ususário não encontrado ou senha inválida");
        }

        $data = $results[0];

        if (password_verify($password, $data["despassword"]) === true) {
            $user = new User();

            $user->setData($data);

            $_SESSION[User::SESSION] = $user->setValues();

            return $user;
        } else {
            throw new \Exception("Ususário não encontrado ou senha inválida");
        }

    }

    public static function logout()
    {
        $_SESSION[User::SESSION] = NULL;
    }

    public static function verifyLogin($inadmin = true)
    {
        if (
            !isset($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
            ||
            !(int)$_SESSION[User::SESSION]["iduser"] > 0
            ||
            (bool)$_SESSION[User::SESSION]["iduser"] !== $inadmin

        ) {
            header("Location: /admin/login");
            exit;

        }
    }
}