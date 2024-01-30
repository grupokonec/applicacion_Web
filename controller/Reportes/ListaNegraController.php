<?php
class ListaNegraController
{

    public static function getDatos()
    {
        $conn = new ConnectionOne("bdcl22"); // Instanciamos la conexion.

        // Preparamos la query 
        $query = "SELECT telefono FROM lista_negra WHERE status = 'AVO'";

        // Obtenemos los resultados
        $resultados = $conn->queryExe($query);

        $telefonos = [];

        // Los agregamos en un arreglo.
        foreach ($resultados as $telefono) {
            $telefonos[] = $telefono->telefono;
        }

        // Retornamos el arreglo.
        return $telefonos;
    }
}

?>
