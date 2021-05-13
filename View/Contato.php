<?php
$resultado = "";

$idusuario = 0;

if (isset($_SESSION["idusuario"])) {
    $idusuario = $_SESSION["idusuario"];
}

if ($idusuario > 0) {
    require_once("Controller/UsuarioController.php");

    require_once("Controller/ContatoController.php");
    require_once("Model/Contato.php");

    $contatoController = new ContatoController();
    $usuarioController = new UsuarioController();

    if (filter_input(INPUT_POST, "btnComentarioContato", FILTER_SANITIZE_STRING)) {
        $contato = new Contato();

        $contato->setAssunto(filter_input(INPUT_POST, "txtAssunto", FILTER_SANITIZE_STRING));
        $contato->setMensagem(filter_input(INPUT_POST, "txtMensagem", FILTER_SANITIZE_STRING));
        $contato->setStatus(1);
        $contato->getUsuario()->setIdusuario($_SESSION["idusuario"]);

        if ($contatoController->Cadastrar($contato)) {
            $resultado = "<span class='spSucesso'>Informações enviadas!</span>";
        } else {
            $resultado = "<span class='spErro'>Houve um erro ao tentar enviar as informações!</span>";
        }
    }

    $listaUsuario = $usuarioController->RetornaIdusuario($idusuario);
}
?>

<br />
<br />
<br />
<br />
<br />

<div id="dvContato">
    <section id="info" class="info">
        <div class="container">

            <div class="section-title">
                <h2>Contato/Suporte</h2>
                <h3>Entre em <span>contato</span> conosco</h3>
                <p>Você pode entrar em contato com a nossa equipe através das nossas redes sociais fornecidas no final da página (rodapé), ou se preferir, utilize o formulário de contato.</p>
            </div>

            <br>

            <?php
            if ($idusuario > 0) {
            ?>

                <div id="dvContato" class="dvFrmContato">
                    <form method="post" class="dvFrmContato" name="frmContato" id="frmContato" role="form">
                        <div class="linha">
                            <div class="form-group">
                                <h4><i class="icofont-user"></i> Nome:</h4>
                                <input type="text" class="form-control" id="txtNome" name="txtNome" placeholder="<?= $listaUsuario->getNome(); ?>" disabled>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="linha">
                            <div class="form-group">
                                <h4><i class="icofont-envelope"></i> Email:</h4>
                                <input type="text" class="form-control" id="txtEmail" name="txtEmail" placeholder="<?= $listaUsuario->getEmail(); ?>" disabled>
                            </div>
                        </div>

                        <div class="linha">
                            <div class="form-group">
                                <h4>Assunto: <span class="red-color">*</span></label></h4>
                                <input id="inputContato" type="text" class="form-control" id="txtAssunto" name="txtAssunto" placeholder="Suporte, Denuncia...">
                            </div>
                        </div>

                        <div class="clear"></div>
                        <div class="linha">
                            <label id="font-Contato" for="txtMensagem"><b>Mensagem: </b><span class="bold" id="contadorMensagem">500 caracteres |</span><span class="red-color"> *</span></label><br>
                            <textarea class="form-control" rows="5" id="txtMensagem" name="txtMensagem" placeholder="Digite aqui a sua mensagem para nossa equipe de desenvolvedores"></textarea>
                        </div>

                        <div class="linha">
                            <div class="grid-100 coluna right">
                                <input type="submit" name="btnComentarioContato" id="btnComentarioContato" value="Enviar" class="dvComentarioContato" />
                                <br />
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="linha">
                            <div class="text-center">
                                <div class="grid-100 coluna">
                                    <p id="pResultado"><?= $resultado; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="linha">
                            <div class="text-center">
                                <div class="grid-100 coluna">
                                    <br />
                                    <ul id="ulErros"></ul>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            <?php
            } else {
                echo "<p class='bold'>Para comentar você precisa estar autenticado</p>";
            }
            ?>

            <br>
        </div>
    </section>

</div>



<script>
    $("#dvFrmContato").submit(function(e) {
        if (!Validar()) {
            e.preventDefault();
        }
    });

    function Validar() {
        var ulErros = document.getElementById("ulErros");
        ulErros.style.color = "red";
        ulErros.innerHTML = "";
        var erros = 0;

        if (document.getElementById("txtAssunto").value.length < 5) {
            erros++;
            ulErros.innerHTML += "<li>- <b>Assunto inválido.</b> (Min. 5 caracteres)</li>";
        }

        if (document.getElementById("txtMensagem").value.length < 10 || document.getElementById("txtMensagem").value.length > 500) {
            erros++;
            ulErros.innerHTML += "<li>- <b>Mensagem inválida.</b> (min 10 e max. 500 caracteres)</li>";
        }

        if (erros == 0) {
            return true;
        } else {
            return false;
        }

    }

    $("#txtMensagem").keyup(function() {
        var txtMensagem = $("#txtMensagem").val().length;
        var maximo = 500;
        var total = (parseInt(maximo) - parseInt(txtMensagem));

        $("#contadorMensagem").text(total + " caracteres");

        if (txtMensagem <= maximo) {
            $("#contadorMensagem").css("color", "green");
        } else {
            $("#contadorMensagem").css("color", "red");
        }

    });

    function validateEmail(email) {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }
</script>