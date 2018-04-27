<?php
    require_once "../../modules/DataBase.php";

    use modules\DataBase;

    $db = new DataBase();
    $conexao = $db->abrirConexao();
    $sql = "SELECT * FROM disciplinas AS d INNER JOIN disciplinas_horarios AS dh ON d.id_disciplinas = dh.id_disciplinas ORDER BY dia_semanal";

    $consulta = $db->select( $conexao, $sql);

    $json_str = array();

    while( $row = mysqli_fetch_array($consulta, MYSQLI_ASSOC)){
        // Origem
        $id_disciplinas = $row['id_disciplinas'];
        $descricao = $row['descricao'];
        $qtdeDias = $row['qtdeDias'];
        $semestre = $row['semestre'];
        $professor = $row['professor'];
        $id_disciplinas_horarios = $row['id_disciplinas_horarios'];
        $dia_semanal = $row['dia_semanal'];
        $horario_semanal = $row['horario_semanal'];

        $array = array(
            'id_disciplinas' => $id_disciplinas,
            'descricao' => $descricao,
            'qtdeDias' => $qtdeDias,
            'semestre' => $semestre,
            'professor' => $professor,
            'id_disciplinas_horarios' => $id_disciplinas_horarios,
            'dia_semanal' => $dia_semanal,
            'horario_semanal' => $horario_semanal
        );
        array_push($json_str, $array);
    }

    $json = json_encode($json_str);

    echo $json;

?>
