<?php
  require_once "../../modules/DataBase.php";

  use modules\DataBase;

  $list = $_POST['list'];

  $list_decode = json_decode($list);

  $nomeDisciplina = $list_decode[0]->nomeDisciplina;
  $qtdeDiasDisciplina = $list_decode[0]->qtdeDiasDisciplina;
  $semestre = $list_decode[0]->semestre;
  $professor = $list_decode[0]->professor;
  $diasDisciplina = $list_decode[0]->diasDisciplina;
  $horariosDisciplina = $list_decode[0]->horariosDisciplina;

  $db = new DataBase();
  $conexao = $db->abrirConexao();
  $sql = "INSERT INTO disciplinas (descricao, qtdeDias, semestre, professor) VALUES (
            '". $nomeDisciplina . "',
            ".$qtdeDiasDisciplina.",
            ".$semestre.",
            '".$professor."'
          )";

  $consulta = $db->insert( $conexao, $sql);

  if($consulta){
      $sqlQuery = "SELECT max(id_disciplinas) as id_disciplinas FROM disciplinas";

      $consultaQuery = $db->select($conexao, $sqlQuery);

      $rowQuery = mysqli_fetch_array($consultaQuery, MYSQLI_ASSOC);

      for ($i=0; $i < $qtdeDiasDisciplina ; $i++) {
        $sqlInsert = "INSERT INTO disciplinas_horarios (id_disciplinas, dia_semanal, horario_semanal) VALUES (
                  ". $rowQuery['id_disciplinas'] .",
                  ".$diasDisciplina[$i]->i.",
                  '".$horariosDisciplina[$i]->i."'
                )";
        // var_dump($sqlInsert);
        $consultaInsert = $db->insert( $conexao, $sqlInsert);
      }

      if ($consultaInsert) {
        $json = json_encode(array('Sucesso' => 'Disciplina cadastrada com Sucesso!'));
      } else {
        $json = json_encode(array('Error' => 'Falha no insert dos horários das disciplinas!'));
      }
  } else {
      $json = json_encode(array('Error' => 'Falha no insert da disciplina'));
  }

  echo $json;

?>
