  <?php
    session_start();
    require_once "../../modules/DataBase.php";

    use modules\DataBase;

    $descricao = $_POST['descricao'];

    $required_campo = '';
    $tipo_erro = '';
    $mensagem = '';

    if($descricao == ''){
      $required_campo .= 'Descrição';
    }

    if($required_campo != ''){
      $tipo_erro = "Campos obrigatórios!";
      $mensagem = " Preencha os campos ".$required_campo;
    }

    if($tipo_erro == '' && $mensagem == ''){

      $db = new DataBase();
      $conexao = $db->abrirConexao();
      $sql = "INSERT INTO cargos (descricao, id_usuarios) VALUES ('".$descricao."', {$_SESSION['id_usuarios_ponto']})";

      $consulta = $db->insert( $conexao, $sql);

    } else {
      $consulta = false;
    }

    if($consulta){
        $json = json_encode(array('Sucesso' => 'Cargo cadastrado com Sucesso!'));
    } else {
        $json = json_encode(array('Campo' => $tipo_erro, 'Menssagem' => $mensagem));
    }

    echo $json;

?>
