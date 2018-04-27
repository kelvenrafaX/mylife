<?php
    session_start();
    require_once "../../modules/DataBase.php";

    use modules\DataBase;

    $db = new DataBase();
    $conexao = $db->abrirConexao();
    $sql = "SELECT * FROM funcionarios AS f INNER JOIN cargos AS c ON f.id_cargo = c.id_cargos
            WHERE f.id_usuarios = {$_SESSION['id_usuarios_ponto']}";

    $consulta = $db->select( $conexao, $sql);

    $json_str = array();

    while( $row = mysqli_fetch_array($consulta, MYSQLI_ASSOC)){
        // Origem
        $id_funcionarios = $row['id_funcionarios'];
        $nome = $row['nome'];
        $id_cargo = $row['id_cargo'];
        $id_permissoes = $row['id_permissoes'];
        $codigo_ponto = $row['codigo_ponto'];
        $descricao = $row['descricao'];
        $foto = $row['foto'];

        $array = array(
            'id_funcionarios' => $id_funcionarios,
            'nome' => $nome,
            'id_cargo' => $id_cargo,
            'id_permissoes' => $id_permissoes,
            'codigo_ponto' => $codigo_ponto,
            'descricao' => $descricao,
            'foto' => $foto
        );
        array_push($json_str, $array);
    }

    $json = json_encode($json_str);

    echo $json;

?>
