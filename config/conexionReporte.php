<?php


class ConnectionOne{
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

        try {
            $this->pdo = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db,
                $this->user,
                $this->password
            );

            $this->pdo->exec('set names utf8');
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function queryExe($query, $params = [])
    {
        set_time_limit(600);
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $e) {
            die("Error en la consulta: " . $e->getMessage());
        }
    }
}
?>