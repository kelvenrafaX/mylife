<?php
  session_start();
  $id = json_decode($_POST['id']);

  require_once "../../modules/DataBase.php";

  use modules\DataBase;

  $db = new DataBase();
  $conexao = $db->abrirConexao();
  $sql = "DELETE FROM funcionarios WHERE id_funcionarios = {$id} AND id_usuarios = {$_SESSION['id_usuarios_ponto']}";

  $consulta = $db->select( $conexao, $sql);

  if($consulta){
      $json = json_encode(array('Sucesso' => 'Funcionário deletado com Sucesso!'));
  } else {
      $json = json_encode(array('Error' => "Error"));
  }

  echo $json;


?>
