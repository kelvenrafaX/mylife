<?php
  session_start();
  $codigo_ponto = json_decode($_POST['codigo']);

  require_once "../../modules/DataBase.php";

  use modules\DataBase;

  $db = new DataBase();
  $conexao = $db->abrirConexao();

  $sql_time = "SET @@session.time_zone='-03:00';";
  $consulta_time = $db->select( $conexao, $sql_time);

  $sql = "SELECT *, DATE_FORMAT(NOW(),'%H:%i:%s') AS hora, DATE_FORMAT(NOW(),'%m-%d-%Y') AS data FROM  funcionarios
          INNER JOIN cargos ON cargos.id_cargos = funcionarios.id_cargo
          WHERE codigo_ponto = {$codigo_ponto}
          AND funcionarios.id_usuarios = {$_SESSION['id_usuarios_ponto']};";

  $consulta = $db->select( $conexao, $sql);

  while( $row = mysqli_fetch_array($consulta, MYSQLI_ASSOC)){

      $id_funcionarios = $row['id_funcionarios'];

      $sql2 = "SELECT *
               FROM  registro_de_ponto
               WHERE id_funcionarios = {$id_funcionarios}
               AND data = CURDATE()
               AND id_usuarios = {$_SESSION['id_usuarios_ponto']}";

      $consulta2 = $db->select( $conexao, $sql2);

      $row2 = mysqli_fetch_array($consulta2);
      $qtderow = mysqli_fetch_row($consulta2);

      // var_dump($qtderow);
      // var_dump($row2);
      // exit;

      $nome = $row['nome'];
      $data = $row['data'];
      $data_array = explode('-', $data);
      $data = $data_array[1]."/".$data_array[0]."/".$data_array[2];
      $hora = $row['hora'];
      $descricao = $row['descricao'];
      $foto = $row['foto'];

      $status = "Success";

      if($row2 != NULL){
        if($row2['saida'] == NULL){
          $ponto = "Primeira saída registrada com sucesso!";
          $sql_insert = "UPDATE registro_de_ponto
                         SET saida = DATE_FORMAT(NOW(),'%H:%i:%s')
                         WHERE id_registro_de_ponto = {$row2['id_registro_de_ponto']}
                         AND id_usuarios = {$_SESSION['id_usuarios_ponto']};";
        } else if ($row2['entrada_2'] == NULL){
          $ponto = "Segunda entrada registrada com sucesso!";
          $sql_insert = "UPDATE registro_de_ponto
                         SET entrada_2 = DATE_FORMAT(NOW(),'%H:%i:%s')
                         WHERE id_registro_de_ponto = {$row2['id_registro_de_ponto']}
                         AND id_usuarios = {$_SESSION['id_usuarios_ponto']};";
        } else if ($row2['saida_2'] == NULL){
          $ponto = "Segunda saída registrada com sucesso!";
          $sql_insert = "UPDATE registro_de_ponto
                         SET saida_2 = DATE_FORMAT(NOW(),'%H:%i:%s')
                         WHERE id_registro_de_ponto = {$row2['id_registro_de_ponto']}
                         AND id_usuarios = {$_SESSION['id_usuarios_ponto']};";
        } else {
          // echo json_encode(array('Error' => 'Funcionário já registrou o ponto 4 vezes!'));
          // exit;

          $ponto = "Funcionário já registrou o ponto 4 vezes!";
          $status = "Error";
        }
      } else {
        $ponto = "Primeira entrada registrada com sucesso!";
        $sql_insert = "INSERT INTO registro_de_ponto
                       (id_funcionarios, data, entrada, id_usuarios)
                       VALUES
                       ({$id_funcionarios}, CURDATE(), DATE_FORMAT(NOW(),'%H:%i:%s'), {$_SESSION['id_usuarios_ponto']});";
      }

  }

  if($status == "Success"){
    $consulta3 = $db->insert( $conexao, $sql_insert);
  }



  if($consulta){
      $json = json_encode(array('Status' => $status,
                                'Nome' => $nome,
                                'Data' => $data,
                                'Hora' => $hora,
                                'Tipo' => $descricao,
                                'Foto' => $foto,
                                'Ponto' => $ponto
                                ));
  } else {
      $json = json_encode(array('Error' => "Error"));
  }

  echo $json;


?>
