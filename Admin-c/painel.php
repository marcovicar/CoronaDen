<?php
session_start();

if (isset($_SESSION["logado"])) {
    if (!$_SESSION["logado"]) {
        header("Location: index.php?msg=1");
    }
} else {
    header("Location: index.php?msg=1");
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
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
        <script src="js/script.js" type="text/javascript"></script>
    </head>

    <body>
        <div class="dvConteudoPrincipal">
            <div class="row" id="dvTopo">
                <div class="col-xs-12 hidden-lg text-center">
                    <div class="dvLogoTopo">
                        <span class="glyphicon glyphicon-menu-hamburger btn btn-default btn-lg" aria-hidden="true" id="btnMenuResponsive"></span>
                        <a href="painel.php"><img src="../img/logoPrincipal2.png" alt="logo Saúde e Segurança"/></a>
                    </div>
                </div>
                <div class="col-xs-12 hidden-xs">
                    <div class="dvLogoTopo">
                        <a href="painel.php"><img src="../img/logoPrincipal2.png" alt="logo Saúde e Segurança"/></a>
                    </div>
                </div>
            </div>

            <div class="row" id="dvMenuResponsive" style="display: none;">
                <div class="col-xs-12">
                    <ul id="ulMenuResponsive">
                        <li><a href="painel.php">Início</a></li>
                        <li><a href="?pagina=usuario">Usuário</a></li>
                        <li><a href="?pagina=comentario">Comentário</a></li>
                        <li><a href="?pagina=localizacao">Localização</a></li>
                        <li><a href="?pagina=denuncia">Denúncia</a></li>
                        <li><a href="?pagina=contato">Contato</a></li>
                        <li><a href="logout.php">Sair</a></li>
                    </ul>
                </div>
            </div>

            <div class="row no-gutter">
                <div class="col-lg-2 gridLeft hidden-xs" id="dvLateral">
                    <div id="dvMenuLateral">
                        <ul id="ulMenu">
                            <li><a href="painel.php">Início</a></li>
                            <li><a href="?pagina=usuario">Usuário</a></li>
                            <li><a href="?pagina=comentario">Comentário</a></li>
                            <li><a href="?pagina=localizacao">Localização</a></li>
                            <li><a href="?pagina=denuncia">Denúncia</a></li>
                            <li><a href="?pagina=contato">Contato</a></li>
                            <li><a href="logout.php">Sair</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8 col-xs-12" id="dvCentro">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            require_once("../Util/RequestPage.php");
                            ?>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="row" id="dvRodape">
                        <div class="col-lg-6 col-xs-12 alignCenter">
                            <br /><br />
                            <p>&copy; Copyright <strong><span>CoronaDen</span></strong>. Todos os direitos reservados</p>
                        </div>
                    </div>

                    <br>
                    <br>
                    <br>
                    <br>

                </div>
                <div class="col-lg-2 gridLeft hidden-xs" id="dvLateral">
                    <div id="dvMenuLateral">
                        <ul id="ulMenu">

                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                $("#btnMenuResponsive").click(function () {
                    $("#dvMenuResponsive").slideToggle("slow");
                });
            });
        </script>

    </body>
</html>