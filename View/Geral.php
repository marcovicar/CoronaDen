<?php

$listaConsulta = [];

if (filter_input(INPUT_GET, "termo", FILTER_SANITIZE_STRING)) {

    require_once("Controller/DenunciaController.php");
    require_once("Model/ViewModel/DenunciaConsulta.php");

    $denunciaController = new DenunciaController();

    $totalRegistros = $denunciaController->RetornarQuantidadeRegistros(filter_input(INPUT_GET, "termo", FILTER_SANITIZE_STRING));

    $totalDenunciasPagina = 2;
    $paginaAtual = 1;

    if (filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT)) {
        $paginaAtual = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT);
    }

    $fim = ($paginaAtual * $totalDenunciasPagina);
    $inicio = ($fim - $totalDenunciasPagina);

    $listaConsulta = $denunciaController->RetornarPesquisa(filter_input(INPUT_GET, "termo", FILTER_SANITIZE_STRING), $inicio, $totalDenunciasPagina);
}
?>


<?php
if (count($listaConsulta) > 0) {
?>

    <div id="dvDenunciaItens">
        <section id="info" class="info">
            <div class="container">

                <div class="section-title">
                    <h2>Resultado</h2>
                    <h3>Resultados encontrados para <span>pesquisa</span></h3>
                </div>

                <?php
                foreach ($listaConsulta as $denunciaConsulta) {
                ?>
                    <main id="main">
                        <section id="blog" class="blog">
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
                                                            <li class="d-flex align-items-center"><i class="icofont-location-pin"></i> <a><?= $denunciaConsulta->getName(); ?></a></li>
                                                        </ul>
                                                    </div>

                                                    <div class="entry-content">
                                                        <p>
                                                            <?= $denunciaConsulta->getDescricao(); ?>
                                                        </p>
                                                    </div>
                                                </article><!-- End blog entry -->
                                            </div>
                                            <br />
                                        </div>
                                    </div>
                                </div>
                        </section>
                    </main>

                    <!-- fim teste -->


                    <p>&nbsp;</p>

                    <div class="clear"></div>
                    <br>

                <?php
                }
                ?>
            </div>
    </div>
    </section>



    <div class="paginacao">
        <ul>

            <?php
            $totalNumeracao = ceil($totalRegistros / $totalDenunciasPagina);
            $currentPage = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT);
            $termo = filter_input(INPUT_GET, "termo", FILTER_SANITIZE_STRING);

            for ($i = 0; $i < $totalNumeracao; $i++) {
            ?>

                <li><a href="?pagina=geral&termo=<?= $termo ?>&pag=<?= ($i + 1) ?>"><?= ($i + 1) ?></a></li>

            <?php
            }
            ?>
        </ul>
    </div>

<?php
} else {
?>
    <div class="section-title">
        <br />
        <br />
        <h2>Erro</h2>
        <h3>Desculpe, <span>não encontramos</span> nenhuma denúncia com o termo especificado</h3>
        <br />
        <br />
        <br />
        <br />
        <br />
    </div>
<?php
}
?>

<br>

</div>