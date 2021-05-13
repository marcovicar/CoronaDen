<?php
require_once("Controller/DenunciaController.php");
require_once("Controller/ImagemController.php");
require_once("Controller/LocalizacaoController.php");
require_once("Model/Denuncia.php");
require_once("Model/Imagem.php");
require_once("Controller/ComentarioController.php");
require_once("Model/Comentario.php");
$iddenuncia = filter_input(INPUT_GET, "iddenuncia", FILTER_SANITIZE_NUMBER_INT);
$del = filter_input(INPUT_GET, "del", FILTER_SANITIZE_NUMBER_INT);

$comentarioController = new ComentarioController();
$denunciaController = new DenunciaController();
$imagemController = new ImagemController();
$localizacaoController = new LocalizacaoController();
$denuncia = $denunciaController->RetornarCompletoIddenuncia($iddenuncia);

$listaUltimasDenuncias = $denunciaController->RetornarUltimasDenuncias(5);
$listaUltimasLocalizacoes = $localizacaoController->RetornarUltimasLocalizacoes(5);

$imagens = $imagemController->CarregarImagensDenuncia($iddenuncia);
$listaImagem = $imagemController->RetornarImagemDenunciaResumida($iddenuncia);

$resultado = "";
$idusuario = 0;

if ($del) {
    if ($comentarioController->Remover($del)) {
?>
        <script>
            setCookie("result", "1", 1);
        </script>
    <?php
    } else {
    ?>
        <script>
            setCookie("result", "-1", 1);
        </script>
    <?php
    }
}

if (isset($_SESSION["idusuario"])) {
    $idusuario = $_SESSION["idusuario"];
}

if (filter_input(INPUT_POST, "btnResponder", FILTER_SANITIZE_STRING)) {
    $comentario = new Comentario();

    $comentario->setMensagem(filter_input(INPUT_POST, "txtComentarioDenunciante", FILTER_SANITIZE_SPECIAL_CHARS));
    $comentario->setSubcomentario(filter_input(INPUT_POST, "txtIdcomentario", FILTER_SANITIZE_NUMBER_INT));
    $comentario->getDenuncia()->setIddenuncia($iddenuncia);
    $comentario->getUsuario()->setIdusuario($_SESSION["idusuario"]);

    if ($comentarioController->Cadastrar($comentario)) {
    ?>
        <script>
            setCookie("result", "2", 1);
        </script>
    <?php
    } else {
    ?>
        <script>
            setCookie("result", "-2", 1);
        </script>
<?php
    }
}
?>

<br />
<br />
<br />
<br />
<br />
<br />

<div id="dvVisualizarDenuncia">

    <?php

    if ($denuncia->getTitulo() != null) {

        $imagemController = new ImagemController();

        $listaImagem = $imagemController->CarregarImagensDenuncia($iddenuncia);

    ?>
        <main id="main">

            <!-- ======= Blog Section ======= -->
            <section id="blog" class="blog">
                <div class="container">

                    <div class="row">

                        <div class="col-lg-8 entries">
                            <article class="entry entry-single">
                                <?php
                                if ($listaImagem != null) {
                                ?>
                                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            <?php
                                            for ($i = 0; $i < count($listaImagem); $i++) {
                                            ?>
                                                <li data-target="#carouselExampleIndicators" data-slide-to="<?= $i; ?>" <?= ($i == 0 ? "class='active'" : ""); ?>></li>
                                            <?php
                                            }
                                            ?>
                                        </ol>

                                        <div class="carousel-inner">
                                            <?php
                                            $cont = 0;
                                            foreach ($imagens as $ima) {
                                            ?>
                                                <div <?= ($cont == 0 ? "class='carousel-item active'" : "class='carousel-item'") ?>>
                                                    <img class="d-block w-100" src="img/Denuncias/<?= $ima->getImagem(); ?>" alt="<?= $denuncia->getTitulo(); ?>">
                                                </div>
                                            <?php
                                                $cont++;
                                            }
                                            ?>
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                <?php
                                } else {
                                    echo "Nenhuma imagem cadastrada!";
                                }
                                ?>

                                <h2 class="entry-title">
                                    <a href="#"><?= $denuncia->getTitulo(); ?></a>
                                </h2>

                                <div class="entry-meta">
                                    <ul>
                                        <li class="d-flex align-items-center"><i class="icofont-user"></i> <a href="#">Anônimo #<?= $denuncia->getUsuario()->getIdusuario(); ?></a></li>
                                        <li class="d-flex align-items-center"><i class="icofont-location-pin"></i> <a href="#"><?= $denuncia->getLocalizacao()->getName(); ?></a></li>
                                        <li class="d-flex align-items-center"><i class="icofont-map"></i> <a><?= $denuncia->getLocalizacao()->getAddress(); ?></a></li>
                                        <li class="d-flex align-items-center"><i class="icofont-user"></i> <a href="#">Status: <?= $denuncia->getStatus() == 1 ? "<span class='glyphicon glyphicon-ok' style='color: green;'></span> <span style='color: green;'>Ativo</span>" : "<span class='glyphicon glyphicon-remove' style='color: red;'></span> <span style='color: red;'>Inativo</span>" ?></a></li>
                                    </ul>
                                </div>

                                <div class="entry-content">
                                    <p>
                                        <?= $denuncia->getDescricao(); ?>
                                    </p>
                                </div>

                            </article>
                            <!-- End blog entry -->



                            <div class="blog-comments">

                                <br />
                                <h4 class="comments-count">Comentários:</h4>

                                <div id="comment-2" class="comment clearfix">
                                    <!-- Comentários -->
                                    <div id="dvResponderComentario" style="display: none;">
                                        <p><span class="bold">Responder para: </span><span id="spNomeUsuario"></span></p>
                                        <br />
                                        <form method="post" id="frmResponder">
                                            <span>Resposta: </span><br><br>
                                            <input type="hidden" id="txtIdcomentario" name="txtIdcomentario" />
                                            <textarea rows="6" class="form-control" id="txtComentarioDenunciante" name="txtComentarioDenunciante"></textarea>
                                            <br>
                                            <input type="submit" name="btnResponder" id="btnResponder" class="btn-padrao" />
                                        </form>
                                        <div class="clear"></div>
                                    </div>
                                    <br>
                                    <div id="dvComentariosUsuarios">
                                        <?php
                                        $comentarioController = new ComentarioController();
                                        $listaComentario = $comentarioController->RetornarTodasDenuncias($iddenuncia);

                                        if (!empty($listaComentario)) {


                                            $listaComentarioPrincipal = [];
                                            $listaComentarioSecundario = [];

                                            foreach ($listaComentario as $comentario) {
                                                if (empty($comentario->getSubcomentario())) {
                                                    $listaComentarioPrincipal[] = $comentario;
                                                } else {
                                                    $listaComentarioSecundario[] = $comentario;
                                                }
                                            }

                                            foreach ($listaComentarioPrincipal as $comentario) {
                                        ?>
                                                <div class="dvComent">
                                                    <p><span class="bold">Publicado em: </span><?= date("d/m/Y H:i", strtotime($comentario->getData())) ?> | <span class="bold">Por: Anônimo #<?= $comentario->getUsuario()->getIdusuario() ?></span></p>
                                                    <p style="margin-top: 5px;"><?= $comentario->getMensagem(); ?></p>
                                                    <br />
                                                    <div class="textAlign">
                                                        <?php
                                                        if ($idusuario != 0) {
                                                            if ($comentario->getStatus() == 1) {
                                                        ?>
                                                                <a href="#dvResponderComentario" class="btnacao blue" onclick="ResponderComentario('Anônimo #<?= $comentario->getUsuario()->getIdusuario() ?>',' <?= $comentario->getIdcomentario() ?>')"><img src="img/Icone/comentario.png" alt="Imagem Responder"></a>
                                                                <a id="delComent" href="?pagina=visualizardenuncia&iddenuncia=<?= $iddenuncia ?>&del=<?= $comentario->getIdcomentario() ?>" class="btnacao red"><img src="img/Icone/remover.png" alt="Imagem Remover"></a>

                                                            <?php
                                                            } else if ($comentario->getStatus() == 2) {
                                                            ?>
                                                                <p class="bold">Este comentário foi removido.</p>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <p class="bold">Este comentário foi removido pelo administrador.</p>
                                                        <?php
                                                            }
                                                        } else {
                                                            echo "******TESTE******";
                                                        }
                                                        ?>

                                                        <?php
                                                        foreach ($listaComentarioSecundario as $comentarioSecundario) {

                                                            if ($comentarioSecundario->getSubcomentario() == $comentario->getIdcomentario()) {
                                                        ?>
                                                                <br><br>
                                                                <div class="comentarioDenunciante">
                                                                    <p class="bold">Resposta do Denunciante em: <?= date("d/m/Y H:i", strtotime($comentarioSecundario->getData())) ?> </p>
                                                                    <?= $comentarioSecundario->getMensagem(); ?>
                                                                </div>
                                                            <?php
                                                            }
                                                            ?>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <br />
                                        <?php
                                            }
                                        } else {
                                            echo "Nenhum comentário para ser exibido!";
                                        }

                                        ?>
                                    </div>

                                <?php
                            } else {
                                ?>
                                    <br />
                                    <br />
                                    <div style="text-align: center;" class="container">
                                        <h1>Denúncia não encontrada!</h1>
                                        <p>Desculpe, a denúncia que você busca não foi encontrada em nosso banco de dados.</p>
                                    </div>
                                <?php
                            }
                                ?>

                                </div>
                                <!-- End comment #2-->

                            </div>
                            <!-- End blog comments -->

                        </div>
                        <!-- End blog entries list -->

                        <div class="col-lg-4">

                            <div class="sidebar">

                                <h3 class="sidebar-title">Últimas denúncias</h3>

                                <?php
                                foreach ($listaUltimasDenuncias as $denunciaConsulta) {
                                    $titulo = $denunciaConsulta->getTitulo();

                                    if (strlen($titulo) >= 20) {
                                        $titulo = substr($titulo, 0, 17);
                                        $titulo = "{$titulo}...";
                                    }
                                ?>
                                    <li>
                                        <a href="?pagina=denuncia&iddenuncia=<?= $denunciaConsulta->getIddenuncia() ?>">
                                            <img id="imgUltimasDenuncias" src="img/Denuncias/<?= $denunciaConsulta->getImagem() ?>" alt="<?= $denunciaConsulta->getTitulo() ?>">
                                            <span><?= $titulo ?></span>
                                        </a>
                                    </li>
                                <?php
                                }
                                ?>
                                <!-- End sidebar recent posts-->

                            </div><!-- End sidebar -->

                            <div class="sidebar">

                                <h3 class="sidebar-title">Últimas localizações</h3>
                                <?php
                                foreach ($listaUltimasLocalizacoes as $LocalizacaoConsulta) {
                                    $name = $LocalizacaoConsulta->getName();

                                    if (strlen($name) >= 20) {
                                        $name = substr($name, 0, 17);
                                        $name = "{$name}...";
                                    }
                                ?>
                                    <li>
                                        <a href="?pagina=localizacao">
                                            <img id="imgUltimasDenuncias" src="img/Localizacoes/<?= $LocalizacaoConsulta->getThumb() ?>" alt="<?= $LocalizacaoConsulta->getName() ?>">
                                            <span><?= $name ?></span>
                                        </a>
                                    </li>
                                <?php
                                }
                                ?>
                            </div>

                        </div><!-- End blog sidebar -->

                    </div>

                </div>
            </section>
            <!-- End Blog Section -->
        </main>

</div>

<script>
    $(function() {
        $('a#delComent').click(function() {
            if (confirm('Você tem certeza que deseja desativar este comentário?')) {
                return true;
            }

            return false;
        });
    });

    $(document).ready(function() {
        alert(var_dump(result));
        var result = getCookie("result");

        if (result == "1") {
            alert("Comentário removido.");
            DeleteCookie("result");
        } else if (result == "-1") {
            alert("Houve um erro ao tentar comentar.");
            DeleteCookie("result");
        }

        if (result == "2") {
            alert("Comentário respondido.");
            DeleteCookie("result");
        } else if (result == "-2") {
            alert("Houve um erro ao tentar responder o comentário.");
            DeleteCookie("result");
        }

        $("#frmResponder").submit(function(event) {
            if ($("#txtComentarioDenunciante").val().length < 5) {
                alert("Informe pelo menos 5 caracteres!");
                event.preventDefault();
            }
        });

        $("#txtComentario").keyup(function() {
            ContarCaracteres();
        });

        $("#frmComentario").submit(function(e) {
            if (ContarCaracteres() < 0) {
                e.preventDefault();
                $("#pResultado").text("Formulário inválido");
                $("#pResultado").css("color", "red");
            }
        });

        function ContarCaracteres() {
            var total = 500;
            var txtComentario = $("#txtComentario").val();

            var atual = (total - txtComentario.length);

            if (atual < 0) {
                $("#spCaracteresRestantes").css("color", "red");
                $("#txtComentario").css("border", "1px solid red");
            } else {
                $("#spCaracteresRestantes").css("color", "black");
                $("#txtComentario").css("border", "1px solid green");
            }

            $("#spCaracteresRestantes").text(atual);
            return atual;
        }
    });

    function ResponderComentario(nomeUsuario, idcomentario) {
        document.getElementById("txtIdcomentario").value = idcomentario;
        document.getElementById("spNomeUsuario").innerHTML = nomeUsuario;

        document.getElementById("dvResponderComentario").style.display = "inline";
    }
</script>