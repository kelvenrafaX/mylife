<?php
/* Insira aqui a pasta que deseja salvar o arquivo. Ex: imagens */
     session_start();
     require_once "../../modules/DataBase.php";

     use modules\DataBase;

     $uploaddir = '../../assets/img/funcionarios/';

     $uploadfile = $uploaddir . $_FILES['arquivo']['name'];

     if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploadfile)){

       $db = new DataBase();
       $conexao = $db->abrirConexao();
       $sql = "UPDATE funcionarios SET foto = '{$_FILES['arquivo']['name']}' WHERE id_funcionarios = {$_POST['id']}
       AND id_usuarios = {$_SESSION['id_usuarios_ponto']}";

       $consulta = $db->insert( $conexao, $sql);

       if($consulta){

         $json = json_encode(array('Sucesso' => 'Imagem cadastrada com Sucesso!'));
         $redirect = '/ponto/funcionarios';

       } else {
         $json = json_encode(array('Campo' => '', 'Mensagem' => 'Falha no UPDATE!'));
         $redirect = '/ponto/funcionarios';
       }

     }

     else {

       $json = json_encode(array('Campo' => '', 'Mensagem' => "Falha ao mover arquivo!"));
       $redirect = '/ponto/funcionarios';

     }

     echo $json;

     header('Location:'.$redirect);
?>
