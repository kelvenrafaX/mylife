<?php
    session_start();
    require_once "../../modules/DataBase.php";

    use modules\DataBase;

    $db = new DataBase();
    $conexao = $db->abrirConexao();
    $sql = "SELECT * FROM registro_de_ponto AS rp
            INNER JOIN funcionarios AS f ON rp.id_funcionarios = f.id_funcionarios
            INNER JOIN cargos AS c ON f.id_cargo = c.id_cargos
            WHERE rp.id_usuarios = {$_SESSION['id_usuarios_ponto']} ";

    $consulta = $db->select( $conexao, $sql);

    $json_str = array();

    while( $row = mysqli_fetch_array($consulta, MYSQLI_ASSOC)){
        // Origem
        $id_funcionarios = $row['id_funcionarios'];
        $nome = $row['nome'];
        $id_cargo = $row['id_cargo'];
        $descricao = $row['descricao'];
        $entradaPrevista = $row['entrada_prevista'];
        $saidaPrevista = $row['saida_prevista'];
        $entrada2Prevista = $row['entrada_2_prevista'];
        $saida2Prevista = $row['saida_2_prevista'];
        $entrada = ($row['entrada'] == null ? '--:--' : $row['entrada']);
        $saida = ($row['saida'] == null ? '--:--' : $row['saida']);
        $entrada2 = ($row['entrada_2'] == null ? '--:--' : $row['entrada_2']);
        $saida2 = ($row['saida_2'] == null ? '--:--' : $row['saida_2']);

        if($entrada != '--:--'){
          if($entrada <= $entradaPrevista){
            $entrada = '<text style="color:green;"> '.$entrada.' </text>';
          } else {
            $entrada = '<text style="color:red;"> '.$entrada.' </text>';
          }
        }

        if($saida != '--:--'){
          if($saida <= $saidaPrevista){
            $saida = '<text style="color:green;"> '.$saida.' </text>';
          } else {
            $saida = '<text style="color:red;"> '.$saida.' </text>';
          }
        }

        if($entrada2 != '--:--'){
          if($entrada2 <= $entrada2Prevista){
            $entrada2 = '<text style="color:green;"> '.$entrada2.' </text>';
          } else {
            $entrada2 = '<text style="color:red;"> '.$entrada2.' </text>';
          }
        }

        if($saida2 != '--:--'){
          if($saida2 <= $saida2Prevista){
            $saida2 = '<text style="color:green;"> '.$saida2.' </text>';
          } else {
            $saida2 = '<text style="color:red;"> '.$saida2.' </text>';
          }
        }

        $array = array(
            'id_funcionarios' => $id_funcionarios,
            'nome' => $nome,
            'id_cargo' => $id_cargo,
            'descricao' => $descricao,
            'entrada' => $entrada,
            'saida' => $saida,
            'entrada2' => $entrada2,
            'saida2' => $saida2
        );
        array_push($json_str, $array);
    }

    $json = json_encode($json_str);

    echo $json;

?>
