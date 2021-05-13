<?php
require_once ("../Model/localizacao.php");
require_once ("../Model/usuario.php");
require_once ("../Model/denuncia.php");
require_once ("../Model/imagem.php");
require_once ("../Controller/DenunciaController.php");
require_once ("../Controller/ImagemController.php");

$denunciaController = new DenunciaController();
$imagemController = new ImagemController();

$iddenuncia = filter_input(INPUT_GET, "iddenuncia", FILTER_SANITIZE_NUMBER_INT);
$denuncia = $denunciaController->RetornarCompletoIddenuncia($iddenuncia);
$imagens = $imagemController->CarregarImagensDenuncia($iddenuncia);
?>

<div id="dvVisualizarDenunciaView">
    <h1>Visualizar denuncia</h1>

    <br>

    <?php
    if ($denuncia->getTitulo() != null) {
        ?>
        <div class="panel panel-info maxPainelWidth">
            <div class="panel-heading bold"><?= $denuncia->getTitulo() ?></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 col-xs-12">
                        <?php
                        if ($imagens != null) {
                            ?>
                            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                <!-- Indicators -->
                                <ol class="carousel-indicators">
                                    <?php
                                    for ($i = 0; $i < count($imagens); $i++) {
                                        ?>
                                        <li data-target="#myCarousel" data-slide-to="<?= $i; ?>" <?= ($i == 0 ? "class='active'" : ""); ?>></li>
                                        <?php
                                    }
                                    ?>
                                </ol>

                                <!-- Wrapper for slides -->
                                <div class="carousel-inner" role="listbox">

                                    <?php
                                    $cont = 0;
                                    foreach ($imagens as $ima) {
                                        ?>
                                        <div <?= ($cont == 0 ? "class='item active'" : "class='item'") ?>>
                                            <img src = "../img/Denuncias/<?= $ima->getImagem(); ?>" alt = "<?= $denuncia->getTitulo(); ?>">
                                        </div>
                                        <?php
                                        $cont++;
                                    }
                                    ?>

                                </div>

                                <!-- Left and right controls -->
                                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                    <span class="sr-only">Anterior</span>
                                </a>
                                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                    <span class="sr-only">Próximo</span>
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            <table class="table table-responsive-lg table-responsive-xs table-hover table-striped">
                                <tr>
                                    <th>Titulo</th>
                                    <td><?= $denuncia->getTitulo(); ?></td>
                                </tr>
                                <tr>
                                    <th>Descrição</th>
                                    <td><?= $denuncia->getDescricao(); ?></td>
                                </tr>
                                <tr>
                                    <th>Localização</th>
                                    <td><?= $denuncia->getLocalizacao()->getName(); ?></td>
                                </tr>
                                <tr>
                                    <th>Usuario</th>
                                    <td><?= $denuncia->getUsuario()->getNome(); ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><?= $denuncia->getStatus() == 1 ? "<span class='glyphicon glyphicon-ok' style='color: green;'></span> <span style='color: green;'>Ativo</span>" : "<span class='glyphicon glyphicon-remove' style='color: red;'></span> <span style='color: red;'>Inativo</span>" ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="textAlign">
                        <a href="?pagina=denuncia&iddenuncia=<?= $iddenuncia; ?>" class="btn btn-warning">Editar</a>
                        <a href="?pagina=gerenciarimagemdenuncia&iddenuncia=<?= $iddenuncia; ?>" class="btn btn-info">Gerenciar imagens</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="panel panel-info maxPainelWidth">
            <div class="panel-heading">Nada encontrado</div>
            <div class="panel-body">
                <p>Nenhuma informação encontrada</p>
            </div>
        </div>
        <?php
    }
    ?>
</div>