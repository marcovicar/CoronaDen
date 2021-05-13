<?php
require_once("Controller/UsuarioController.php");

$usuarioController = new UsuarioController();

$resultado = "";

if (filter_input(INPUT_POST, "btnGravar", FILTER_SANITIZE_STRING)) {
    if (filter_input(INPUT_GET, "idusuario", FILTER_SANITIZE_NUMBER_INT)) {
        if ($usuarioController->AlterarSenha(
            filter_input(INPUT_POST, "txtSenha", FILTER_SANITIZE_STRING),
            filter_input(INPUT_GET, "idusuario", FILTER_SANITIZE_NUMBER_INT)
        )) {
            $resultado = "<div class=\"alert alert-success\" role=\"alert\">senha alterada com sucesso</div>";
        } else {
            $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Houve um erro ao tentar alterar a senha</div>";
        }
    }
}
?>

<br />
<br />
<br />
<br />
<br />
<br />

<div id="dvAlterarSenhaView">
    <div class="container">
        <div class="section-title">
            <br />
            <br />
            <h2>Conta</h2>
            <h3>Alterar <span>Senha</span></h3>
            <p>Aqui você poderá redefinir a senha de sua conta.</p>
        </div>

        <br>

        <div class="col-lg-8">
            <div id="frmAlterarSenha" class="frmAlterarSenha" style="text-align: center;">
                <form method="post" id="frmAlterarSenha" class="frmAlterarSenha" name="frmAlterarSenha" novalidate>
                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <label for="txtSenha"><span class="vlSenha"></span></label>
                            <input type="password" class="form-control" id="txtSenha" name="txtSenha" placeholder="Digite uma nova senha">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="txtConfSenha"><span class="vlSenha"></span></label>
                            <input type="password" class="form-control" id="txtConfSenha" name="txtConfSenha" placeholder="Digite novamente a nova senha">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <p id="pResultado"><?= $resultado; ?></p>
                        </div>
                    </div>

                    <input class="btn btn-padrao" type="submit" name="btnGravar" value="Alterar">
                    <a onclick="location.href = document.referrer; return false;" class="btn btn-cancelar">Cancelar</a>

                    <br>
                    <br>

                    <div class="row">
                        <div class="col-lg-12">
                            <ul id="ulErros">
                                <br />
                                <br />
                                <br />
                                <br />
                                <br />
                                <br />
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $("#frmAlterarSenha").submit(function(e) {
            if (!ValidarFormulario()) {
                e.preventDefault();
            }
        });

        var vlSenhas = document.getElementsByClassName('vlSenha');

        $('#txtSenha').keyup(function() {

            if (ValidarSenha()) {
                for (var i = 0; i < vlSenhas.length; i++) {
                    vlSenhas[i].style.color = 'green';
                    vlSenhas[i].innerHTML = 'válido';
                }
            } else {
                for (var i = 0; i < vlSenhas.length; i++) {
                    vlSenhas[i].style.color = 'red';
                    vlSenhas[i].innerHTML = 'inválido';
                }
            }
        });

        $('#txtConfSenha').keyup(function() {

            if (ValidarSenha()) {
                for (var i = 0; i < vlSenhas.length; i++) {
                    vlSenhas[i].style.color = 'green';
                    vlSenhas[i].innerHTML = 'válido';
                }
            } else {
                for (var i = 0; i < vlSenhas.length; i++) {
                    vlSenhas[i].style.color = 'red';
                    vlSenhas[i].innerHTML = 'inválido';
                }
            }
        });
    });

    function ValidarSenha() {
        var senha1 = $('#txtSenha').val();
        var senha2 = $('#txtConfSenha').val();

        if (senha1.length >= 7 && senha2.length >= 7) {
            if (senha1 == senha2) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function ValidarFormulario() {
        var erros = 0;

        var ulErros = document.getElementById("ulErros");
        ulErros.style.color = "red";
        ulErros.innerHTML = "";

        //                  JavaScript nativo
        if (!ValidarSenha()) {
            var li = document.createElement("li");
            li.innerHTML = "- Informe uma Senha válida";
            ulErros.append(li);
            erros++;
        }

        if (erros === 0) {
            return true;
        } else {
            return false;
        }
    }
</script>