<?php
  require_once "../modules/DataBase.php";

  use modules\DataBase;

  $nome = $_POST['nome'];
  $senha = $_POST['senha'];
  $confirmar_senha = $_POST['confirmar_senha'];
  $email = $_POST['email'];

  $required_campo = '';
  $tipo_erro = '';
  $mensagem = '';

  if($nome == ''){
    $required_campo .= 'Nome, ';
  }
  if($senha == ''){
    $required_campo .= 'Senha, ';
  }
  if($confirmar_senha == ''){
    $required_campo .= 'Confirmar Senha, ';
  }
  if($email == ''){
    $required_campo .= 'Email, ';
  }

  if($required_campo != ''){
    $tipo_erro = "Campos obrigatórios!";
    $mensagem = " Preencha os campos ".$required_campo;
  }

  if($senha != $confirmar_senha){
    $tipo_erro = "Senhas diferentes!";
    $mensagem = " Preencha as senhas iguais! ";
  }

  if($tipo_erro == '' && $mensagem == ''){

    $db = new DataBase();
    $conexao = $db->abrirConexao();

    $sql = "SELECT * FROM usuarios WHERE email = '{$email}';";

    $consulta2 = $db->select( $conexao, $sql);

    $resultado = mysqli_fetch_array($consulta2);

    if($resultado != NULL){
      echo json_encode(array('Campo' => 'Email', 'Menssagem' => 'Email já cadastrado!', 'Redirect' => '/ponto/register.php'));
      exit;
    } else {

    $sql = "INSERT INTO usuarios (nome, email, senha, data_cadastro, validade)
                                    VALUES (
                                      '".$nome."',
                                      '".$email."',
                                      '".$senha."',
                                      CURDATE(),
                                      CURDATE() + 10
                                      )";

    $consulta = $db->insert( $conexao, $sql);

    }

  } else {
    $consulta = false;
  }

  if($consulta){
      $json = json_encode(array('Sucesso' => 'Conta cadastrada com Sucesso!', 'Redirect' => '/ponto/login.php'));
  } else {
      $json = json_encode(array('Campo' => $tipo_erro, 'Menssagem' => $mensagem, 'Redirect' => '/ponto/register.php'));
  }

  echo $json;

?>
