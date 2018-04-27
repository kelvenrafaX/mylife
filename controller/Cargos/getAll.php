<?php
    session_start();
    require_once "../../modules/DataBase.php";

    use modules\DataBase;

    $db = new DataBase();
    $conexao = $db->abrirConexao();
    $sql = "SELECT * FROM cargos WHERE id_usuarios = {$_SESSION['id_usuarios_ponto']}";

    $consulta = $db->select( $conexao, $sql);

    $json_str = array();

    while( $row = mysqli_fetch_array($consulta, MYSQLI_ASSOC)){
        // Origem
        $id_cargos = $row['id_cargos'];
        $descricao = $row['descricao'];

        $array = array(
            'id_cargos' => $id_cargos,
            'descricao' => $descricao
        );
        array_push($json_str, $array);
    }

    $json = json_encode($json_str);

    echo $json;

?>
