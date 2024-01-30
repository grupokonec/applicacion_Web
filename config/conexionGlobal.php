<?php

class ConnectionOne
{
    private $host;
    private $db;
    private $user;
    private $password;
    private $pdo;

    public function __construct($db)
    {
        $this->host = '35.226.0.51';
        $this->db = $db;
        $this->user = 'root';
        $this->password = 'kon.dat00,55+';

        // Inicializa la conexión de manera asíncrona
        $this->initAsyncConnection();
    }

    private function initAsyncConnection()
    {
        $this->pdo = new PDO(
            "mysql:host=" . $this->host . ";dbname=" . $this->db,
            $this->user,
            $this->password
        );

        $this->pdo->exec('set names utf8');
    }

    public function queryExeAsync($query, $params = [])
    {
        return new Promise(function ($resolve, $reject) use ($query, $params) {
            // Ejecuta la consulta en un hilo separado
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $this->pdo->prepare($query);
            
            try {
                $stmt->execute($params);
                $result = $stmt->fetchAll(PDO::FETCH_CLASS);
                $resolve($result);
            } catch (PDOException $e) {
                $reject($e);
            }
        });
    }
}


?>