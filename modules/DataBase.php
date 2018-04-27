<?php

namespace modules;

class DataBase {

    public function abrirConexao(){
        // $servername = "mysql.hostinger.com.br";
        // $username = "u268183283_user";
        // $password = "jOhVoAdmpK9U";
        // $database = "u268183283_raiss";

        $servername = "localhost";
        // 3306
        $username = "root";
        $password = "1234";
        $database = "raissa";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $database);

        return $conn;
    }

    public function select($conexao, $sql){
        $consulta = mysqli_query($conexao, $sql);
        return $consulta;
    }

    public function fetch($consulta){
        $row = mysqli_fetch_array($consulta, MYSQLI_ASSOC);
        return $row;
    }

    public function insert($conexao, $sql){
        $consulta = mysqli_query($conexao, $sql);
        return $consulta;
    }

    public function update(){

    }

    public function close($conn){
        mysqli_close($conn);
    }
}





?>
