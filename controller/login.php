<?php
  require_once("../modules/DataBase.php");

  use modules\DataBase;

  $email = $_POST['email'];
  $senha = $_POST['senha'];

  $required_campo = '';
  $tipo_erro = '';
  $mensagem = '';

  if($email == ''){
    $required_campo .= 'Email, ';
  }
  if($senha == ''){
    $required_campo .= 'Senha, ';
  }

  if($required_campo != ''){
    $tipo_erro = "Campos obrigatórios!";
    $mensagem = " Preencha os campos ".$required_campo;
  }

  if($tipo_erro == '' && $mensagem == ''){

    $db = new DataBase();
    $conexao = $db->abrirConexao();

    $sql = "SELECT *, CURDATE() AS Data FROM usuarios WHERE email = '{$email}' AND senha = '{$senha}';";

    $consulta = $db->select( $conexao, $sql);

    $resultado = mysqli_fetch_array($consulta);

    if($resultado == NULL){
      echo json_encode(array('Campo' => 'Conta não Encontrada!', 'Menssagem' => '', 'Redirect' => '/ponto/login.php'));
      exit;
    } else {
      if($resultado['Data'] <= $resultado['validade']){
        @session_start();
        $_SESSION['id_usuarios_ponto'] = $resultado['id_usuarios'];
        $_SESSION['nome_ponto'] = $resultado['nome'];
        $_SESSION['email_ponto'] = $resultado['email'];
        $_SESSION['senha_ponto'] = $resultado['senha'];
        $_SESSION['data_cadastro_ponto'] = $resultado['data_cadastro'];
        $_SESSION['validade_ponto'] = $resultado['validade'];
      } else {
        echo json_encode(array('Campo' => 'Conta inválida!', 'Menssagem' => 'Sua conta passou da validade!', 'Redirect' => '/ponto/login.php'));
        exit;
      }

    }

  } else {
    $consulta = false;
  }

  if($consulta){
      $json = json_encode(array('Sucesso' => 'Login feito com Sucesso!', 'Redirect' => '/ponto'));
  } else {
      $json = json_encode(array('Campo' => $tipo_erro, 'Menssagem' => $mensagem, 'Redirect' => '/ponto/login.php'));
  }

  echo $json;

?>
