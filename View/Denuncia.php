<?php
require_once("Controller/DenunciaController.php");
require_once("Model/Denuncia.php");

require_once("Controller/LocalizacaoController.php");

$denunciaController = new DenunciaController();
$localizacaoController = new LocalizacaoController();

$listaUltimasDenuncias = $denunciaController->RetornarUltimasDenuncias(5);
$listaUltimasLocalizacoes = $localizacaoController->RetornarUltimasLocalizacoes(5);
$listaConsulta = $denunciaController->RetornarTotalPesquisa();

$resultado = "";

$iddenuncia = filter_input(INPUT_GET, "iddenuncia", FILTER_SANITIZE_NUMBER_INT);
$denuncia = null;

if ($iddenuncia > 0) {

    require_once("Controller/ImagemController.php");
    require_once("Model/Imagem.php");

    require_once("Controller/ComentarioController.php");
    require_once("Model/Comentario.php");

    $comentarioController = new ComentarioController();
    $imagemController = new ImagemController();
    $comentario = new Comentario();

    $imagens = $imagemController->CarregarImagensDenuncia($iddenuncia);
    $denuncia = $denunciaController->RetornarCompletoIddenuncia($iddenuncia);

    if (filter_input(INPUT_POST, "btnComentar", FILTER_SANITIZE_STRING)) {

        $comentario->getUsuario()->setIdusuario($_SESSION["idusuario"]);
        $comentario->getDenuncia()->setIddenuncia(filter_input(INPUT_POST, "txtIddenuncia", FILTER_SANITIZE_NUMBER_INT));
        $comentario->setMensagem(strip_tags(filter_input(INPUT_POST, "txtComentario", FILTER_SANITIZE_STRING)));

        if ($comentarioController->Cadastrar($comentario)) {
            $resultado = "<span class='spSucesso'>Comentário enviado!</span>";
        } else {
            $resultado = "<span class='spErro'>Houve um erro ao tentar enviar o comentário!</span>";
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

<div id="dvDenuncia">

    <div class="section-title">
        <br />
        <h2>Denúncias</h2>
    </div>

    <?php
    if (filter_input(INPUT_GET, "termo", FILTER_SANITIZE_STRING) || filter_input(INPUT_GET, "iddenuncia", FILTER_SANITIZE_NUMBER_INT)) {
        if ($denuncia->getIddenuncia() > 0) {
            $listaImagem = $imagemController->RetornarImagemDenunciaResumida($iddenuncia);
    ?>
            <br>

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
                                ?>
                                    <br />
                                    <p style="color: red; text-align:center"><b>**Não há imagens cadastradas!**</b></p>
                                    <br />
                                    <br />
                                <?php
                                }
                                ?>
                                <br>



                                <h2 class="entry-title">
                                    <a href="#"><?= $denuncia->getTitulo(); ?></a>
                                </h2>

                                <div class="entry-meta">
                                    <ul>
                                        <li class="d-flex align-items-center"><i class="icofont-user"></i> <a href="#">Anônimo #<?= $denuncia->getUsuario()->getIdusuario(); ?></a></li>
                                        <li class="d-flex align-items-center"><i class="icofont-location-pin"></i> <a href="?pagina=localizacao&#location"><?= $denuncia->getLocalizacao()->getName(); ?></a></li>
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


                            <?php
                            if (isset($_SESSION["idusuario"])) {
                            ?>

                                <div id="dvComentario" class="formcontroles">
                                    <form method="post" name="frmComentario" id="frmComentario" action="#dvComentario">
                                        <!--1º row-->
                                        <div class="linha">
                                            <div class="grid-100 coluna">
                                                <label for="txtNome">Comentar - <span id="spCaracteresRestantes" class="bold">500</span> caracteres restantes.</label>
                                            </div>
                                            <div class="grid-100 coluna">
                                                <textarea rows="7" id="txtComentario" name="txtComentario"></textarea>
                                                <input type="hidden" id="txtIddenuncia" name="txtIddenuncia" value="<?= $denuncia->getIddenuncia(); ?>" />
                                            </div>
                                        </div>

                                        <div class="clear"></div>

                                        <div class="linha">
                                            <div class="grid-100 coluna">
                                                <p id="pResultado"><?= $resultado; ?></p>
                                            </div>
                                        </div>

                                        <div class="clear"></div>

                                        <div class="linha">
                                            <div class="grid-100 coluna">
                                                <input type="submit" name="btnComentar" id="btnComentar" value="Comentar" class="btn-padrao" />
                                            </div>
                                        </div>
                                    </form>
                                    <br>

                                    <!--Os últimos 10 comentários-->
                                    <p></p>

                                </div>
                            <?php
                            } else {
                                echo "<p class='bold'>**Para comentar você precisa estar autenticado</p>";
                            }
                            ?>




                            <br><br>
                            <div id="dvComentariosUsuarios">
                                <div class="blog-comments">
                                    <h4 class="comments-count">Comentários:</h4>
                                    <br />
                                    <?php
                                    $comentarioController = new ComentarioController();
                                    $listaComentario = $comentarioController->RetornarUltimasDenuncias($iddenuncia);


                                    if (!empty($listaComentario)) {
                                        $comentarioPrincipal = array();
                                        $comentarioSecundario = array();

                                        foreach ($listaComentario as $comentario) {
                                            if ($comentario->getSubcomentario() == null) {
                                                $comentarioPrincipal[] = $comentario;
                                            } else {
                                                $comentarioSecundario[] = $comentario;
                                            }
                                        }

                                        foreach ($comentarioPrincipal as $comentario) {
                                    ?>
                                            <div class="dvComent">
                                                <p><span class="bold">Publicado em: </span><?= date("d/m/Y H:i", strtotime($comentario->getData())) ?> | <span class="bold">Por: Anônimo #<?= $comentario->getUsuario()->getIdusuario() ?></span></p>
                                                <p style="margin-top: 5px;"><?= $comentario->getMensagem(); ?></p>


                                                <div class="textAlign">
                                                    <?php
                                                    foreach ($comentarioSecundario as $subcomentario) {
                                                        if ($subcomentario->getSubcomentario() == $comentario->getIdcomentario()) {
                                                    ?>
                                                            <div class="comentarioDenunciante">
                                                                <p><span class="bold">Resposta do Denunciante em:</span> <?= date("d/m/Y H:i", strtotime($subcomentario->getData())) ?> </p>
                                                                <div style="color: white">
                                                                    <?= $subcomentario->getMensagem(); ?>
                                                                </div>
                                                            </div>
                                                    <?php
                                                        }
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
                                <br />
                            <?php
                        }
                    } else {
                            ?>
                            <div id="dvDenunciaItens">

                                <?php
                                foreach ($listaConsulta as $denunciaConsulta) {
                                ?>

                                    <main id="main">
                                        <section id="blog" class="blog">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-lg-8 entries">
                                                        <div class="row">
                                                            <div class="col-md-6 d-flex align-items-stretch" id="deLado">
                                                                <article class="entry">

                                                                    <div class="entry-img">
                                                                        <img src="img/Denuncias/<?= $denunciaConsulta->getImagem(); ?>" alt="<?= $denunciaConsulta->getTitulo(); ?>" class="img-fluid">
                                                                    </div>

                                                                    <h2 class="entry-title">
                                                                        <a href="?pagina=denuncia&iddenuncia=<?= $denunciaConsulta->getIddenuncia(); ?>"><?= $denunciaConsulta->getTitulo(); ?></a>
                                                                    </h2>

                                                                    <div class="entry-meta">
                                                                        <ul>
                                                                            <li class="d-flex align-items-center"><i class="icofont-location-pin"></i> <a><?= $denunciaConsulta->getAddress(); ?></a></li>
                                                                        </ul>
                                                                    </div>

                                                                    <div class="entry-content">
                                                                        <p>
                                                                            <?= $denunciaConsulta->getDescricao(); ?>
                                                                        </p>
                                                                        <br />
                                                                    </div>
                                                                </article><!-- End blog entry -->
                                                            </div>
                                                            <br />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </main>
                                    <br>
                                <?php
                                }
                                ?>
                            </div>
                        <?php
                    }
                        ?>
                            </div>
                        </div>


                        <div class="col-lg-4">

                            <div class="sidebar">

                                <h3 class="sidebar-title">Denúncias recentes</h3>

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

                                <h3 class="sidebar-title">Localizações recentes</h3>
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
</div>
<br />
<br />

<script>
    $(document).ready(function() {

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
</script>