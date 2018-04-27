<?php
    session_start();
    $lista = $_POST['lista'];
    $lista_decode = json_decode($lista);
    $funcionario = $lista_decode[0]->funcionario;
    $periodo = $lista_decode[0]->periodo;
    $explode = explode('-',$periodo);
    $ano = $explode[0];
    $mes = $explode[1];

    require_once "../../modules/DataBase.php";

    use modules\DataBase;

    $db = new DataBase();
    $conexao = $db->abrirConexao();
    $sql = "SELECT *,
    ADDTIME
    (
           TIMEDIFF
           (
                    IF(rp.saida < f.saida_prevista, rp.saida, f.saida_prevista),
                    IF(rp.entrada < f.entrada_prevista, f.entrada_prevista, rp.entrada)
           ),
           TIMEDIFF
           (
                    IF(rp.saida_2 < f.saida_2_prevista, rp.saida_2, f.saida_2_prevista),
                    IF(rp.entrada_2 < f.entrada_2_prevista, f.entrada_2_prevista, rp.entrada_2)
           )
    ) AS total,
    ADDTIME
    (
      ADDTIME
      (
        TIMEDIFF
        (
          IF(rp.entrada < f.entrada_prevista, f.entrada_prevista, rp.entrada), f.entrada_prevista
        ),
        TIMEDIFF
        (
          IF(rp.saida > f.saida_prevista, f.saida_prevista, rp.saida) , f.saida_prevista
        )
      ),
      ADDTIME
      (
        TIMEDIFF
        (
          IF(rp.entrada_2 < f.entrada_2_prevista, f.entrada_2_prevista, rp.entrada_2), f.entrada_2_prevista
        ),
        TIMEDIFF
        (
          IF(rp.saida_2 > f.saida_2_prevista, f.saida_2_prevista, rp.saida_2) , f.saida_2_prevista
        )
      )
    ) AS atraso
            FROM registro_de_ponto AS rp
            INNER JOIN funcionarios AS f ON rp.id_funcionarios = f.id_funcionarios
            INNER JOIN cargos AS c ON f.id_cargo = c.id_cargos
            WHERE rp.id_funcionarios = {$funcionario}
            AND  YEAR(rp.data) = '{$ano}' AND MONTH(rp.data) = '{$mes}'
            AND rp.entrada IS NOT NULL
            AND rp.saida IS NOT NULL
            AND rp.entrada_2 IS NOT NULL
            AND rp.saida_2 IS NOT NULL
            AND rp.id_usuarios = {$_SESSION['id_usuarios_ponto']}";

    // echo $sql;

    $sql_total = "SELECT SUM(ADDTIME(TIMEDIFF(rp.saida , rp.entrada) , TIMEDIFF(rp.saida_2 , rp.entrada_2))) as total,
                         SUM(ADDTIME(ADDTIME(TIMEDIFF(rp.entrada , f.entrada_prevista) , TIMEDIFF(rp.saida , f.saida_prevista)) ,
                         ADDTIME(TIMEDIFF(rp.entrada_2 , f.entrada_2_prevista) , TIMEDIFF(rp.saida_2 , f.saida_2_prevista)))) as atraso
                         FROM registro_de_ponto AS rp
                         INNER JOIN funcionarios AS f ON rp.id_funcionarios = f.id_funcionarios
                         INNER JOIN cargos AS c ON f.id_cargo = c.id_cargos
                         WHERE rp.id_funcionarios = {$funcionario}
                         AND  YEAR(rp.data) = '{$ano}' AND MONTH(rp.data) = '{$mes}'
                         AND rp.entrada IS NOT NULL
                         AND rp.saida IS NOT NULL
                         AND rp.entrada_2 IS NOT NULL
                         AND rp.saida_2 IS NOT NULL
                         AND rp.id_usuarios = {$_SESSION['id_usuarios_ponto']}";

                        // echo $sql_total ;

    $consulta = $db->select( $conexao, $sql);
    $consulta_total = $db->select( $conexao, $sql_total);

    $json_str = array();

    $salario = '';

    while( $row = mysqli_fetch_array($consulta, MYSQLI_ASSOC)){
        $row_total = mysqli_fetch_array($consulta_total, MYSQLI_ASSOC);

        $salario = $row['salario'];
        $id_funcionarios = $row['id_funcionarios'];
        $nome = $row['nome'];
        $data = $row['data'];
        $data_explode = explode('-', $data);
        $data = $data_explode[2] . '/' . $data_explode[1] . '/' . $data_explode[0];
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

        // $diferenca = $entrada - $saida;
        $total = $row['total'];
        $atraso = $row['atraso'];
        $atraso_total = $row_total['atraso'];
        $total_total = $row_total['total'];

        $atraso_total_concatenado = $atraso_total . '/';
        $pos_atraso_total = strpos($atraso_total_concatenado, '/');

        if($pos_atraso_total == 6){
          $hora_atraso = substr($atraso_total, 0 , 2);
          $minuto_atraso = substr($atraso_total, 2 , 2);
          $segundo_atraso = substr($atraso_total, 4 , 4);
        } else {
          $hora_atraso = substr($atraso_total, 0 , 1);
          $minuto_atraso = substr($atraso_total, 1 , 2);
          $segundo_atraso = substr($atraso_total, 3 , 3);
        }

        $valor_atraso = ($salario / 220) * (intval($hora_atraso) + (intval($minuto_atraso) / 60) + (intval($segundo_atraso) / 3600));
        $liquido = $salario - $valor_atraso;

        if($pos_atraso_total == 6){
          $atraso_total = $hora_atraso . ':' . $minuto_atraso . ':' . $segundo_atraso;
        } else {
          $atraso_total = '0' . $hora_atraso . ':' . $minuto_atraso . ':' . $segundo_atraso;
        }

        $total_total_concatenado = $total_total . '/';
        $pos_total_total = strpos($total_total_concatenado, '/');

        if($pos_total_total == 6){
          $hora_total = substr($total_total, 0 , 2);
          $minuto_totalo = substr($total_total, 2 , 2);
          $segundo_total = substr($total_total, 4 , 4);
        } else {
          $hora_total = substr($total_total, 0 , 1);
          $minuto_total = substr($total_total, 1 , 2);
          $segundo_total = substr($total_total, 3 , 3);
        }

        if($pos_total_total == 6){
          $total_total = $hora_total . ':' . $minuto_total . ':' . $segundo_total;
        } else {
          $total_total = '0' . $hora_total . ':' . $minuto_total . ':' . $segundo_total;
        }


        // $atraso_total_concatenado = $atraso_total . '/';
        // $total_total_concatenado = $total_total . '/';
        //
        // $pos_atraso_total = strpos($atraso_total_concatenado, '/');
        // $hora_atraso = substr($atraso_total, 0 , $pos_atraso_total);
        // $minuto_atraso = substr($atraso_total, 0 , $pos_atraso_total);
        // $segundos_atraso =


        // $total = $hora;


        if($entrada != '--:--'){
          if($entrada <= $entradaPrevista){
            $entrada = '<text style="color:green;"> '.$entrada.' </text>';
          } else {
            // $atraso += $entrada - $entradaPrevista;
            $entrada = '<text style="color:red;"> '.$entrada.' </text>';
          }
        }

        if($saida != '--:--'){
          if($saida >= $saidaPrevista){
            $saida = '<text style="color:green;"> '.$saida.' </text>';
          } else {
            // $atraso += $saida - $saidaPrevista;
            $saida = '<text style="color:red;"> '.$saida.' </text>';
          }
        }

        if($entrada2 != '--:--'){
          if($entrada2 <= $entrada2Prevista){
            $entrada2 = '<text style="color:green;"> '.$entrada2.' </text>';
          } else {
            // $atraso += $entrada2 - $entrada2Prevista;
            $entrada2 = '<text style="color:red;"> '.$entrada2.' </text>';
          }
        }

        if($saida2 != '--:--'){
          if($saida2 >= $saida2Prevista){
            $saida2 = '<text style="color:green;"> '.$saida2.' </text>';
          } else {
            // $atraso += $saida2 - $saida2Prevista;
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
            'saida2' => $saida2,
            'data' => $data,
            'total' => $total,
            'atraso' => $atraso,
            'salario' => str_replace('.',',',substr($salario, 0 , ((strpos($salario, '.') === false ? 100 : strpos($salario, '.')) + 3))),
            'ano' => $ano,
            'mes' => $mes,
            'atraso_total' => $atraso_total,
            'total_total' => $total_total,
            'valor_atraso' => str_replace('.',',',substr($valor_atraso, 0 , ((strpos($valor_atraso, '.') === false ? 100 : strpos($valor_atraso, '.')) + 3))),
            'liquido' => str_replace('.',',',substr($liquido, 0 , ((strpos($liquido, '.') === false ? 100 : strpos($liquido, '.')) + 3)))
        );
        array_push($json_str, $array);
    }

    $json = json_encode($json_str);

    echo $json;

?>
