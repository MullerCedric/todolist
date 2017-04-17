<?php
namespace Models;

class Auth extends Model
{
    public function checkUser(string $email, string $password)
    {
        $pdo = $this->connectDB();
        if ($pdo) {
            try {
                $pdoSt =
                    $pdo->prepare(
                        'SELECT * FROM todochecker.users WHERE email = :email AND password = :password'
                    );
                $pdoSt->execute([
                    ':email' => $email,
                    ':password' => $password
                ]);
                return $pdoSt->fetch();
            } catch (\PDOException $exception) {
                return null;
            }
        }
    }
}