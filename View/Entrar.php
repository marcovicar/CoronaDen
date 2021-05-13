<?php
$resultado = "";
?>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<div id="dvEntrar">
    <div class="container">
        <div class="section-title">
            <h2>Área de Login</h2>
            <h3>Faça login em <span>sua conta</span></h3>
        </div>


        <div class="col-lg-8">
            <div id="dvFrmEntrar" class="dvFrmEntrar" style="text-align: center;">
                <form id="frmEntrar" name="frmEntrar" method="post" role="form" class="dvFrmEntrar">
                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="Digite seu Email">
                        </div>
                        <div class="col-md-6 form-group">
                            <input type="password" class="form-control" id="txtSenha" name="txtSenha" placeholder="Digite sua senha">
                        </div>
                    </div>
                    <div class="text-center"><input type="submit" name="btnGravar" value="Entrar"></div>
                    <div class="linha">
                        <div class="grid-100 coluna">
                            <a id="esqueciMinhaSenha" href="">Esqueci minha senha</a> | <a href="?pagina=usuario">Cadastrar</a>
                        </div>
                    </div>
                </form>

                <div class="linha">
                    <div class="grid-100 coluna">
                        <span id="spResultado"><?= $resultado; ?></span>
                    </div>
                </div>

                <p>&nbsp;</p>

            </div>
        </div>
    </div>
</div>


<script>
    $("#frmEntrar").submit(function(e) {
        if (Validar()) {
            Autenticar();
        } else {
            e.preventDefault();
        }
    });

    function Validar() {
        var erros = 0;

        $("#spResultado").text("");
        $("#spResultado").css("color", "red");

        if ($("#txtEmail").val().indexOf("@") <= 0 || $("#txtEmail").val().indexOf(".") <= 0) {
            $("#spResultado").html("<span class='spErro'>E-MAIL INVÁLIDO</span>");
            erros++;
        } else if ($("#txtSenha").val().length < 7) {
            $("#spResultado").html("<span class='spErro'>SENHA INVÁLIDA. (min. 7 caracteres)</span>");
            erros++;
        }

        if (erros == 0) {
            return true;
        } else {
            return false;
        }
    }

    function Autenticar() {
        var obj = {
            txtEmail: $("#txtEmail").val(),
            txtSenha: $("#txtSenha").val(),
        };

        $.ajax({
            url: "Action/UsuarioAction.php?req=2",
            type: "POST",
            dataType: "text",
            data: obj,
            beforeSend: function() {
                $("#spResultado").text("Autenticando...");
                $("#spResultado").css("color", "blue");
            },
            success: function(retorno) {
                console.log(retorno);
                if (retorno == "ok") {
                    $("#spResultado").css("color", "green");
                    $("#spResultado").html("<span class='spSucesso'>Redirecionado...</span>");
                    location.href = "?pagina=conteudo";
                } else {
                    $("#spResultado").html("<span class='spErro'>Usuário ou senha inválido</span>");
                }
            },
            error: function(erro) {
                console.log(erro);
            }
        });
    }

    $(function() {
        $('a#esqueciMinhaSenha').click(function() {
            if (confirm('Você terá que entrar em contato com o Administrador para poder redefinir a sua senha através do e-mail covid192020projeto@gmail.com')) {
                return true;
            }

            return false;
        });
    });
</script>