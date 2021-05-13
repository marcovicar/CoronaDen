<?php
require_once("Model/Usuario.php");
require_once("Controller/UsuarioController.php");

$resultado = "";
$erros = [];

if (filter_input(INPUT_POST, "btnGravar", FILTER_SANITIZE_STRING)) {
    $usuarioController = new UsuarioController();

    $erros = Validar();

    if (empty($erros)) {
        $usuario = new Usuario();

        $usuario->setNome(filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING));
        $usuario->setEmail(filter_input(INPUT_POST, "txtEmail", FILTER_SANITIZE_STRING));
        $usuario->setSenha(filter_input(INPUT_POST, "txtSenha", FILTER_SANITIZE_STRING));
        $usuario->setNascimento(filter_input(INPUT_POST, "txtData", FILTER_SANITIZE_STRING));
        $usuario->setSexo(filter_input(INPUT_POST, "slSexo", FILTER_SANITIZE_STRING));
        $usuario->setStatus(1);
        $usuario->setPermissao(2);

        if ($usuarioController->Cadastrar($usuario)) {
            $resultado = "<span class='spSucesso'>Usuário cadastrado com sucesso!</span>";
        } else {
            $resultado = "<span class='spErro'>Houve um erro ao tentar cadastrar o usuário!</span>";
        }
    }
}

function Validar()
{
    $usuarioController = new UsuarioController();

    $listaErros = [];

    if (strlen(filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING)) < 5) {
        $listaErros[] = "NOME INVÁLIDO (min 5 caracteres)";
    }

    if (filter_input(INPUT_POST, "txtEmail", FILTER_SANITIZE_STRING)) {
        if ($usuarioController->VerificarEmailExiste(filter_input(INPUT_POST, "txtEmail", FILTER_SANITIZE_STRING)) == 1) {
            $listaErros[] = "E-MAIL JÁ CADASTRADO";
        }
    } else {
        $listaErros[] = "E-MAIL INVÁLIDO";
    }

    if (filter_input(INPUT_POST, "txtSenha", FILTER_SANITIZE_STRING) != filter_input(INPUT_POST, "txtSenha2", FILTER_SANITIZE_STRING)) {
        $listaErros[] = "SENHAS INVÁLIDAS (min 7 caracteres)";
    }

    if (filter_input(INPUT_POST, "txtData", FILTER_SANITIZE_STRING) == "") {
        $listaErros[] = "DATA DE NASCIMENTO INVÁLIDA";
    }
    if (filter_input(INPUT_POST, "slSexo", FILTER_SANITIZE_STRING) != "m") {
        if (filter_input(INPUT_POST, "slSexo", FILTER_SANITIZE_STRING) != "f") {
            $listaErros[] = "SEXO INVÁLIDO";
        }
    }

    return $listaErros;
}
?>

<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />


<div id="dvUsuario">
    <div class="container">
        <div class="section-title">
            <br />
            <h2>Área de Cadastro</h2>
            <h3>Crie a sua <span> conta</span></h3>
        </div>


        <div class="col-lg-8">
            <div id="dvFrmUsuario" class="dvFrmUsuario" style="text-align: center;">
                <form method="post" id="frmCadastroUsuario" name="frmCadastroUsuario" role="form" class="dvFrmUsuario">
                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <input type="text" class="form-control" id="txtNome" name="txtNome" placeholder="Nome completo">
                        </div>
                        <div class="col-md-6 form-group">
                            <input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="Email">
                            <label for="txtEmail"><span id="spValidaEmail">&nbsp;</span></label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <input type="text" class="form-control" id="txtData" name="txtData" placeholder="Data de Nascimento">
                        </div>
                        <div class="col-md-6 form-group">
                            <select class="form-control" id="slSexo" name="slSexo">
                                <option value="0">Selecione um sexo</option>
                                <option value="m">Masculino</option>
                                <option value="f">Feminino</option>
                            </select>
                        </div>
                    </div>

                    <p>&nbsp;</p>

                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <input type="password" class="form-control" id="txtSenha" name="txtSenha" placeholder="Senha">
                            <label for="txtSenha"><span class="spValidaSenha"></span></label>
                        </div>
                        <div class="col-md-6 form-group">
                            <input type="password" class="form-control" id="txtSenha2" name="txtSenha2" placeholder="Confirmar senha">
                            <label for="txtSenha2"><span class="spValidaSenha"></span></label>
                        </div>
                    </div>
                    <div class="text-center"><input type="submit" name="btnGravar" value="Quero me cadastrar"></div>
                    <div class="linha">
                        <div class="grid-100 coluna">
                            <a href="?pagina=entrar">Já possuo uma conta</a>
                        </div>
                    </div>
                </form>

                <p>&nbsp;</p>


                <div class="linha">
                    <div class="grid-100 coluna">
                        <span id="spResultado"><?= $resultado; ?></span>
                    </div>
                </div>


                <div class="linha">
                    <div class="grid-100 coluna">
                        <ul id="ulErros" style="list-style: none; font-weight:bold;">
                                <?php
                                foreach ($erros as $e) {
                                ?>
                                    <li><?= $e; ?></li>
                                <?php
                                }
                                ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="js/jquery.mask.min.js" type="text/javascript"></script>

<script>
    $('#txtData').mask('00/00/0000');

    $("#txtSenha, #txtSenha2").keyup(function() {
        var resultadoValidacao = ValidarSenha(7);
        ExibeMensagens(resultadoValidacao);
    });

    $("#txtEmail").focusout(function() {
        ValidaEmail();
    });

    $("#frmCadastroUsuario").submit(function(e) {
        if (!Validar()) {
            e.preventDefault();
        }
    });

    function Validar() {
        var erros = 0;

        var ulErros = document.getElementById("ulErros");
        ulErros.innerHTML = "";
        ulErros.style.color = "red";
        ulErros.style.listStyle = "none";

        if ($("#txtNome").val().length < 5) {
            var li = document.createElement("li");
            li.innerText = "NOME INVÁLIDO (min. 5 caracteres)";
            ulErros.appendChild(li);
            erros++;
        }

        if ($("#txtEmail").val().indexOf("@") <= 0 || $("#txtEmail").val().indexOf(".") <= 0) {
            var li = document.createElement("li");
            li.innerText = "E-MAIL INVÁLIDO";
            ulErros.appendChild(li);
            erros++;
        }

        if (!ValidarSenha(7)) {
            var li = document.createElement("li");
            li.innerText = "SENHAS INVÁLIDAS (min 7 caracteres)";
            ulErros.appendChild(li);
            erros++;
        }

        if (!ValidarData($("#txtData").val())) {
            var li = document.createElement("li");
            li.innerText = "DATA DE NASCIMENTO INVÁLIDA";
            ulErros.appendChild(li);
            erros++;
        }

        if (document.getElementById("slSexo").value != "m" && document.getElementById("slSexo").value != "f") {
            var li = document.createElement("li");
            li.innerHTML = "SEXO INVÁLIDO";
            ulErros.appendChild(li);
            erros++;
        }

        if (erros == 0) {
            return true;
        } else {
            return false;
        }
    }

    function ValidarData(data) {
        var dt = new Date();

        var arrData = data.split("/");

        if (arrData[0] > 0 && arrData[0] <= 31) {
            if (arrData[1] > 0 && arrData[1] <= 12) {
                if (arrData[2] > (dt.getFullYear() - 80) && arrData[1] <= dt.getFullYear()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function ValidarSenha(minLenght) {
        var senha1 = document.getElementById("txtSenha").value;
        var senha2 = document.getElementById("txtSenha2").value;
        var valido = false;
        if (senha1.length >= minLenght && senha2.length >= minLenght) {
            if (senha1 === senha2) {
                valido = true;
            }
        }

        return valido;
    }

    function ExibeMensagens(valido) {
        var spValidaSenha = document.getElementsByClassName("spValidaSenha");
        if (valido) {
            for (var i = 0; i < spValidaSenha.length; i++) {
                spValidaSenha[i].style.color = "#39C462";
                spValidaSenha[i].innerText = "SENHAS COINCIDEM";
            }
        } else {
            for (var i = 0; i < spValidaSenha.length; i++) {
                spValidaSenha[i].style.color = "#FF3730";
                spValidaSenha[i].innerText = "SENHAS INVÁLIDAS";
            }
        }
    }

    function ValidaEmail() {

        var email = $("#txtEmail").val();
        if (email.indexOf("@") > 0 && email.indexOf(".") > 0) {
            $.ajax({
                url: "Action/UsuarioAction.php?req=1",
                data: {
                    txtEmail: $("#txtEmail").val()
                },
                type: "POST",
                dataType: "text",
                success: function(retorno) {
                    if (retorno == -1) {
                        $("#spValidaEmail").text("E-MAIL VÁLIDO");
                        $("#spValidaEmail").css("color", "#39C462");
                    } else if (retorno == 1) {
                        $("#spValidaEmail").text("E-MAIL JÁ CADASTRADO ");
                        $("#spValidaEmail").css("color", "#FF4500");
                    } else {
                        $("#spValidaEmail").text("ERRO AO VALIDAR");
                        $("#spValidaEmail").css("color", "#FF3730");
                    }
                },
                error: function(erro) {
                    console.log(erro);
                }
            });
        } else {
            return -10;
        }
    }
</script>