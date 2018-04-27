<?php if(isset($_GET['logout'])){
  @session_start();
  session_destroy();
} ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Sistema de Ponto</title>
  <link rel="shortcut icon" type="image/png" href="assets/img/logo_cinza.png"/>
  <!-- Bootstrap core CSS-->
  <link href="/ponto/assets/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="/ponto/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="/ponto/assets/css/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="/ponto/assets/css/sb-admin.css" rel="stylesheet">
  <script src="/ponto/assets/js/jquery-3.3.1.min"></script>
</head>

<body class="bg-dark">
  <!-- <div class="container">
    <img width="100%" src="assets/img/logo_branco.png" alt="">
  </div> -->
  <div class="container">
    <div style="background-color: #343a40; border: 0px; margin-top: -70px" class="card card-login mx-auto">
      <img width="100%" src="assets/img/logo_branco.png" alt="">
    </div>
    <div style="margin-top: -130px" class="card card-login mx-auto">
      <div class="card-body">
        <form id="form_login">
          <div class="form-group">
            <div style="display: none;" class="alert" id="div_response_login" ></div>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input class="form-control" name="email" id="email" type="email" aria-describedby="emailHelp" placeholder="Informe seu Email">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Senha</label>
            <input class="form-control" name="senha" id="senha" type="password" placeholder="Informe sua Senha">
          </div>
          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox"> Lembrar Senha</label>
            </div>
          </div>
          <button onclick="logar()" class="btn btn-primary btn-block">Logar</button>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="register.php">Criar sua conta</a>
          <a class="d-block small" href="forgot-password.html">Esqueci minha senha?</a>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    function logar(){
      var envio = $("#form_login").serialize();
      console.log(envio);
      $("#form_login").submit(function(e) {
        $.ajax({
               type: "POST",
               url: "/ponto/controller/login.php",
               data: $("#form_login").serialize(), // serializes the form's elements.
               dataType: 'json',
               success: function(data)
               {
                   console.log(data);

                   alertResponse(data, "div_response_login", data.Redirect);

               },
               error: function (data) {
                    console.log('Ocorreu um Erro!');
                    console.log(data);
                }
             });
         e.preventDefault(); // avoid to execute the actual submit of the form.
       });
    }
  </script>

  <!-- Bootstrap core JavaScript-->
  <script src="/ponto/assets/js/jquery.min.js"></script>
  <script src="/ponto/assets/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="/ponto/assets/js/jquery.easing.min.js"></script>
  <!-- Page level plugin JavaScript-->
  <script src="/ponto/assets/js/Chart.min.js"></script>
  <script src="/ponto/assets/js/jquery.dataTables.js"></script>
  <script src="/ponto/assets/js/dataTables.bootstrap4.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="/ponto/assets/js/sb-admin.min.js"></script>
  <!-- Custom scripts for this page-->
  <script src="/ponto/assets/js/sb-admin-datatables.min.js"></script>
  <script src="/ponto/assets/js/sb-admin-charts.min.js"></script>
  <script src="/ponto/functions/js/modal.js"></script>
  <script src="/ponto/functions/js/response.js"></script>
</body>

</html>
