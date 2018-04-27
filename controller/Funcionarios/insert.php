  <?php
    session_start();
    require_once "../../modules/DataBase.php";

    use modules\DataBase;

    $nome = $_POST['nome'];
    $cargo = $_POST['cargo'];
    $codigo_ponto = $_POST['codigo_ponto'];
    $salario = $_POST['salario'];
    $entrada = $_POST['entrada'];
    $entrada2 = $_POST['entrada2'];
    $saida = $_POST['saida'];
    $saida2 = $_POST['saida2'];

    $required_campo = '';
    $tipo_erro = '';
    $mensagem = '';

    if($entrada == ''){
      $required_campo .= 'Entrada, ';
    }
    if($entrada2 == ''){
      $required_campo .= 'Entrada 2, ';
    }
    if($saida == ''){
      $required_campo .= 'Saída, ';
    }
    if($saida2 == ''){
      $required_campo .= 'Saída 2, ';
    }
    if($nome == ''){
      $required_campo .= 'Nome, ';
    }
    if($cargo < 0){
      $required_campo .= 'Cargo, ';
    }
    if($codigo_ponto == ''){
      $required_campo .= 'Código de Ponto, ';
    }
    if($salario == ''){
      $required_campo .= 'Salário, ';
    }

    if($required_campo != ''){
      $tipo_erro = "Campos obrigatórios!";
      $mensagem = " Preencha os campos ".$required_campo;
    }

    if($tipo_erro == '' && $mensagem == ''){

      $db = new DataBase();
      $conexao = $db->abrirConexao();
      $sql = "INSERT INTO funcionarios (nome, id_cargo, codigo_ponto, entrada_prevista, saida_prevista, entrada_2_prevista, saida_2_prevista, id_usuarios, salario)
                                      VALUES (
                                        '".$nome."',
                                        ".$cargo.",
                                        ".$codigo_ponto.",
                                        '".$entrada."',
                                        '".$saida."',
                                        '".$entrada2."',
                                        '".$saida2."',
                                        {$_SESSION['id_usuarios_ponto']},
                                        ".$salario."
                                        )";
      // echo $sql;

      $consulta = $db->insert( $conexao, $sql);

    } else {
      $consulta = false;
    }

    if($consulta){
        $json = json_encode(array('Sucesso' => 'Funcionário cadastrado com Sucesso!'));
    } else {
        $json = json_encode(array('Campo' => $tipo_erro, 'Menssagem' => $mensagem));
    }

    echo $json;

?>
