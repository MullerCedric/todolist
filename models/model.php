<?php
namespace Models;

class Model
{
    public $pdo = null;
    protected function connectDB(): ?\PDO
    {
        $dbConfig = @parse_ini_file(DB_INI_FILE);
        $dsn = sprintf(
            'mysql:dbname=%s;host=%s',
            $dbConfig['DB_NAME'],
            $dbConfig['DB_HOST']
        );
        try {
            return new \PDO(
                $dsn,
                $dbConfig['DB_USER'],
                $dbConfig['DB_PASS'],
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ
                ]
            );
        } catch (\PDOException $e) {
            return null;
        }
    }
}