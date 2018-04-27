<section class="p-3 p-lg-5" id="about">
  <div class="row">
    <div class="col-md-12">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" href="#first-tab" data-toggle="tab">Disciplinas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#second-tab" data-toggle="tab">Tarefas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Calendário</a>
        </li>
      </ul>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tab-content">
      	<div class="tab-pane active in" id="first-tab">
      		<div class="col-md-12 mt-3">
            <button id="ativarCadastro" onclick="ativarCadastro()" type="button" class="btn btn-success btn-sm pull-right" name="button"><i class="fa fa-plus fa-fw"></i> Nova disciplina</button>
            <button style="display:none" id="desativarCadastro" onclick="ativarCadastro('desativar')" type="button" class="btn btn-danger btn-sm pull-right" name="button"> Cancelar </button>
            <div id="cadastro-disciplinas" style="display: none">
              <div id="loading" style="top: 100px; left: 300px; position: absolute; display:none;">
                <?php include "component/loading-heart.php"; ?>
              </div>
              <label for="nome-disciplina"> Nome
                <input class="form-control" type="text" name="nome-disciplina" id="nome-disciplina" value="">
              </label>
              <label for="nome-disciplina"> Quant. Dias semanais
                <input onchange="addSelectDias(this)" min="1" max="7" class="form-control" type="number" name="quantDias-disciplina" id="quantDias-disciplina" value="1">
              </label>
              <div id="dias-disciplina">
                <label for="dias-select-disciplina-1"> Dia 1
                  <select class="form-control" name="dias-select-disciplina-1" id="dias-select-disciplina-1">
                    <option value="1"> Domingo </option>
                    <option value="2"> Segunda </option>
                    <option value="3"> Terça </option>
                    <option value="4"> Quarta </option>
                    <option value="5"> Quinta </option>
                    <option value="6"> Sexta </option>
                    <option value="7"> Sábado </option>
                  </select>
                </label>
              </div>
              <div id="horarios-disciplina">
                <label for="nome-disciplina"> Horário
                  <input class="form-control" type="time" name="horario-disciplina" id="horario-disciplina-1">
                </label>
              </div>
              <label for="nome-disciplina"> Semestre
                <input class="form-control" min="1" max="10" type="number" name="semestre-disciplina" id="semestre-disciplina" value="1">
              </label>
              <label for="nome-disciplina"> Professor
                <input class="form-control" type="text" name="nome-disciplina" id="professor-disciplina" value="">
              </label>
              <button onclick="cadastrarDisciplina()" class="btn btn-success" type="button" name="button"><i class="fa fa-plus fa-fw"></i></button>
            </div>
          </div>
          <div class="col-md-12 mt-5">
            <!-- <hr>
              <div class="alert alert-info">
                <h4>Filtros</h4>
                <label for="[object Object]"> Semestre
                  <select class="form-control">
                    <option value="0">Todos</option>
                    <option value="1">1° semestre</option>
                    <option value="2">2° semestre</option>
                    <option value="3">3° semestre</option>
                    <option value="4">4° semestre</option>
                    <option value="5">5° semestre</option>
                    <option value="6">6° semestre</option>
                    <option value="7">7° semestre</option>
                    <option value="8">8° semestre</option>
                    <option value="9">9° semestre</option>
                    <option value="10">10° semestre</option>
                  </select>
                </label>
              </div> -->
            <hr>
            <h2>Minhas disciplinas</h2>
            <hr>
            <div id="dias">

            </div>
          </div>
      	</div>
      	<div class="tab-pane" id="second-tab">
      		<p>Aqui vai o conteúdo da segunda aba.</p>
      	</div>
      </div>
    </div>
  </div>


</section>

<script type="text/javascript">
  $(function() {
    getDisciplinas();
  });

  function ativarCadastro(action = "ativar"){
    if(action === "ativar"){
      $("#ativarCadastro").fadeOut("fast");
      $("#cadastro-disciplinas, #desativarCadastro").fadeIn("fast");
    } else {
      $("#cadastro-disciplinas, #desativarCadastro").fadeOut("fast");
      $("#ativarCadastro").fadeIn("fast");
    }

  }

  function addSelectDias(input){
    var str = "";
    var str_horarios = "";
    if(input.value > 7){
      $("#dias-disciplina").html('<div class="alert alert-danger"> Quantidade de dias maior do que o máximo possível! </div>');
      $("#horarios-disciplina").html('Por favor, coloque um valor entre 1 e 7');
    } else {
      for (var i = 1; i <= input.value; i++) {
        str+=    '<label class="mr-1" for="dias-select-disciplina-'+i+'"> Dia ' + i;
        str+=      '<select class="form-control" name="dias-select-disciplina-'+i+'" id="dias-select-disciplina-'+i+'">';
        str+=        '<option value="1"> Domingo </option>';
        str+=        '<option value="2"> Segunda </option>';
        str+=        '<option value="3"> Terça </option>';
        str+=        '<option value="4"> Quarta </option>';
        str+=        '<option value="5"> Quinta </option>';
        str+=        '<option value="6"> Sexta </option>';
        str+=        '<option value="7"> Sábado </option>';
        str+=      '</select>';
        str+=    '</label>';

        str_horarios += '<label class="mr-1" for="nome-disciplina"> Horário/Dia ' + i +
                          '<input class="form-control" type="time" name="horario-disciplina" id="horario-disciplina-'+i+'">' +
                        '</label>';
      }

      $("#dias-disciplina").html(str);
      $("#horarios-disciplina").html(str_horarios);

    }

  }

  function ativarModoCadastro(action = "ativar"){
    if(action === "ativar"){
      $("#cadastro-disciplinas").css("opacity","0.5");
      $("#loading").fadeIn("slow");
    } else {
      $("#cadastro-disciplinas").css("opacity","1.0");
      $("#loading").fadeOut("slow");
    }
  }

  function cadastrarDisciplina(){

    ativarModoCadastro();

    var nomeDisciplina = $("#nome-disciplina").val();
    var qtdeDiasDisciplina = $("#quantDias-disciplina").val();
    var semestre = $("#semestre-disciplina").val();
    var professor = $("#professor-disciplina").val();
    var diasDisciplina = [];
    var horariosDisciplina = [];

    for (var i = 1; i <= qtdeDiasDisciplina; i++) {
      diasDisciplina.push({ i : $("#dias-select-disciplina-"+i).val()});
    }
    for (var i = 1; i <= qtdeDiasDisciplina; i++) {
      horariosDisciplina.push({ i : $("#horario-disciplina-"+i).val()});
    }

    var list = [];
    var item = new Object();

    item.nomeDisciplina = nomeDisciplina;
    item.qtdeDiasDisciplina = qtdeDiasDisciplina;
    item.semestre = semestre;
    item.professor = professor;
    item.diasDisciplina = diasDisciplina;
    item.horariosDisciplina = horariosDisciplina;

    list.push(item);

    console.log(list);

    $.ajax({
        method: "post",
        dataType: "json",
        url: "/mylife/controller/Faculdade/insert.php",
        data: { list: JSON.stringify(list) },
        success: function(success){
          console.log(success);
          ativarModoCadastro("desativar");
          ativarCadastro("desativar");
          getDisciplinas();
        },
        error: function(error){
          console.log(error);
        }
    });
    // $("#cadastro-disciplinas").fadeOut('slow');
  }

  function getDisciplinas(){
    $.ajax({
        method: "get",
        dataType: "json",
        url: "/mylife/controller/Faculdade/getDisciplinas.php",
        success: function(success){
          console.log(success);
          if(success.length === 0){
              $("#dias").html("<div class='alert alert-info'> Nenhuma disciplina foi cadastrada! </div>");
          } else {
            var diaDaSemanaAtual = 0;
            $("#dias").html("");
            $.each(success, function(idx, obj){
              // console.log("Dia do json: " +obj.dia_semanal);
              // console.log("Dia do Laço: " +diaDaSemanaAtual);

              var str = "";
              if(obj.dia_semanal == diaDaSemanaAtual){
                // console.log("Acrescentando");
        str +=  '    <tr>' +
                '      <td> '+obj.descricao+' </td>' +
                '      <td> '+obj.semestre+' </td>' +
                '      <td> '+obj.horario_semanal+' </td>' +
                '      <td> '+obj.professor+' </td>' +
                '    </tr>';
                $("#table-body-"+obj.dia_semanal).append(str);
              } else {
                // console.log("Criando novo dia");
                str +=  '<h4>';
                if(obj.dia_semanal == '1'){
                  str += "Domingo";
                } else if (obj.dia_semanal == '2') {
                  str += "Segunda-Feira";
                } else if (obj.dia_semanal == '3') {
                  str += "Terça-Feira";
                } else if (obj.dia_semanal == '4') {
                  str += "Quarta-Feira";
                } else if (obj.dia_semanal == '5') {
                  str += "Quinta-Feira";
                } else if (obj.dia_semanal == '6') {
                  str += "Sexta-Feira";
                } else if (obj.dia_semanal == '7') {
                  str += "Sábado";
                }
                str+=   '</h4>' +
                '<table class="table table-striped">' +
                '  <thead>' +
                '    <tr>' +
                '      <th> Nome </th>' +
                '      <th> Semestre </th>' +
                '      <th> Horário </th>' +
                '      <th> Professor </th>' +
                '    </tr>' +
                '  </thead>' +
                '  <tbody id="table-body-'+obj.dia_semanal+'">' +
                '    <tr>' +
                '      <td> '+obj.descricao+' </td>' +
                '      <td> '+obj.semestre+' </td>' +
                '      <td> '+obj.horario_semanal+' </td>' +
                '      <td> '+obj.professor+' </td>' +
                '    </tr>' +
                '  </tbody>' +
                '</table>';

                diaDaSemanaAtual = obj.dia_semanal;
                $("#dias").append(str);
              }
            });
          }
        },
        error: function(error){
          console.log(error);
        }
    });
  }


</script>
