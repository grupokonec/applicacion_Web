<?php


class ConexionBD {
  private $servername="35.226.0.51";
  private $username;
  private $password="kon.dat00,55+";
  private $database;
  private $conn;

  // Constructor que recibe los parámetros de la conexión
  public function __construct( $username, $database) {
     
      $this->username = $username;
      $this->database = $database;
  }

  // Método para establecer la conexión
  public function conectar() {
      // Establecer la conexión
      $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);

      // Verificar la conexión
      if ($this->conn->connect_error) {
          die("Error de conexión: " . $this->conn->connect_error);
      }

      return $this->conn;
  }

  // Método para cerrar la conexión
  public function cerrarConexion() {
      if ($this->conn) {
          $this->conn->close();
      }
  }
}

?>