<?php
session_start();

require_once ("../Controller/UsuarioController.php");
require_once ("../Model/Usuario.php");

$retorno = "&nbsp;";

if (isset($_SESSION["entrar"])) {
    header("Location: painel.php");
}

if (filter_input(INPUT_GET, "msg", FILTER_SANITIZE_NUMBER_INT)) {
    if (filter_input(INPUT_GET, "msg", FILTER_SANITIZE_NUMBER_INT) == 1) {
        $retorno = "<div class=\"alert alert-danger\" role=\"alert\">Acesso negado.</div>";
    } else {
        $retorno = "<div class=\"alert alert-warning\" role=\"alert\">Você fez logout.</div>";
    }
}

if (filter_input(INPUT_POST, "btnEntrar", FILTER_SANITIZE_STRING)) {
    $usuarioController = new UsuarioController();

    $usu = filter_input(INPUT_POST, "txtUsuario", FILTER_SANITIZE_STRING);
    $senha = filter_input(INPUT_POST, "txtSenha", FILTER_SANITIZE_STRING);
    $permissao = 1;

    $resultado = $usuarioController->AutenticarUsuario($usu, $senha, $permissao);

    if ($resultado != null) {
        
        if (filter_input(INPUT_POST, "ckManterLogado", FILTER_SANITIZE_STRING)) {
            $_SESSION["entrar"] = true;
        }
        
        $_SESSION["idusuario"] = $resultado->getIdusuario();
        $_SESSION["nome"] = $resultado->getNome();
        $_SESSION["logado"] = true;

        header("Location: painel.php");
    } else {
        $retorno = "<div class=\"alert alert-danger\" role=\"alert\">Email ou senha inválido.</div>";
    }
} else {
    
}
?>

<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <title>Projeto COVID</title>
        <meta charset="UTF-8">
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="../js/jquery-3.1.1.min.js" type="text/javascript"></script>
        <script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" href="../img/logoCovid.png" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    </head>

    <body>
        <div id="dvLogin">
            <form method="post">
                <div class="row">
                    <div class="col-lg-12 alignCenter">
                        <img src="../img/logoPrincipal2.png" alt="logo Saúde e Segurança"/>
                    </div>
                    <div class="clear"></div>

                    <div class="borderBottom"></div>

                    <br>

                    <div class="col-lg-12">

                        <br>

                        <div class="form-group">
                            <label for="txtUsuario">Email:</label>
                            <input type="email" class="form-control" name="txtUsuario" id="txtUsuario" placeholder="Seu email">
                        </div>
                        <div class="form-group">
                            <label for="txtSenha">Senha:</label>
                            <input type="password" class="form-control" name="txtSenha" id="txtSenha" placeholder="*****">
                        </div>
                        <div class="form-group">
                            <div class="col-lg-7">
                                <input class="btn btn-success" type="submit" name="btnEntrar" value="Entrar">
                            <a href="" data-toggle="modal" data-target="#exampleModal">Recuperar senha</a>
                            </div class="col-lg-5">
                            <div>
                                <label><input type="checkbox" value="s" name="ckManterLogado"> Manter-se logado</label></label>
                            </div>
                        </div>
                    </div>

                    <p>&nbsp;</p>

                    <div class="col-lg-12"><?= $retorno; ?></div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Recuperar senha</h5>
                    </div>
                    <div class="modal-body">
                        <p>Para recuperar a senha, entre em contato com o administrador.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Sair</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $('#myModal').on('shown.bs.modal', function () {
                $('#myInput').trigger('focus');
            })
        </script>

    </body>
</html>