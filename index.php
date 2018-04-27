<?php
    // Carregando Rota Atual
    include 'include/loadRouter.php';

    // Carregando Configurações

    include 'config.php';

    //  -- Startando HTML -- \\
    // @session_start();
    // if(isset($_SESSION['email_ponto'])
    // && isset($_SESSION['senha_ponto'])
    // && isset($_SESSION['data_cadastro_ponto'])
    // && isset($_SESSION['validade_ponto'])){

    // Cuspindo o Header
    include 'include/header.php';

    // Cuspingo o Head do Body
    include 'include/headBody.php';

    // Cuspindo Div inicial do Corpo
    include 'include/divInicial.php';

    // Cuspingo a View de acordo com a URL
    include 'include/loadView.php';

    // Logout Modal
    include "include/logoutModal.php";

    // Arquivo onde acontece os imports do JavaScript
    include "include/loadJs.php";

    // Fechando a Div Inicial do Corpo
    include 'include/divFinal.php';
  //
  // } else {
  //   header('Location: login.php');
  //   // echo $_SESSION['email_ponto'];
  // }

?>

  </body>
</html>
