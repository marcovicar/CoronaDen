<?php
require_once("Controller/DenunciaController.php");
require_once("Model/Denuncia.php");

require_once("Controller/LocalizacaoController.php");

$idusuario = 0;

if (isset($_SESSION["idusuario"])) {
    $idusuario = $_SESSION["idusuario"];
}

$denunciaController = new DenunciaController();
$localizacaoController = new LocalizacaoController();

$listaDenuncia = $denunciaController->RetornarDenunciaIdusuario($idusuario);
$listaBuscaResumo = $localizacaoController->RetornarTodos();

$del = filter_input(INPUT_GET, "del", FILTER_SANITIZE_NUMBER_INT);
$delden = filter_input(INPUT_GET, "delden", FILTER_SANITIZE_NUMBER_INT);

if ($del) {
    if ($localizacaoController->Remover($del)) {
        echo "<span class='spSucesso'>Localização apagado com sucesso</span>";
    } else {
        echo "<span class='spSucesso'>Erro ao apagar a localização</span>";
    }
}

if ($delden) {
    if ($denunciaController->Remover($delden)) {
        echo "<span class='spSucesso'>Denuncia apagado com sucesso</span>";
    } else {
        echo "<span class='spSucesso'>Erro ao apagar o denuncia</span>";
    }
}
?>

<br />
<br />
<br />
<br />
<br />

<!-- ======= Painel Section ======= -->
<?php
if ($idusuario != 0) {
?>
    <div id="dvPainel">
        <section id="services" class="services">
            <div class="container">

                <div class="section-title">
                    <h2>Painel</h2>
                    <h3>Gerencie a <span>sua conta</span></h3>
                </div>

                <div class="row">
                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box">
                            <div class="icon"><i class="bx bx-map-pin"></i></div>
                            <h4 class="title"><a href="?pagina=localizar&#dvLocalizacaoView">Endereço</a></h4>
                            <p class="description">Cadastre uma localização antes de fazer uma denúncia</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box">
                            <div class="icon"><i class="bx bxs-megaphone"></i></div>
                            <h4 class="title"><a href="?pagina=denunciar&#dvDenunciar"><b></b> Denunciar</a></h4>
                            <p class="description">Realize uma denúncia anônimamente</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box">
                            <div class="icon"><i class="bx bx-lock"></i></div>
                            <h4 class="title"><a href="?pagina=alterarsenha&idusuario=<?= $_SESSION['idusuario'] ?>&#dvAlterarSenhaView">Senha</a></h4>
                            <p class="description">Aqui você pode alterar a sua senha de acesso</p>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Painel Section -->

        <!-- Denuncias -->
        <div class="section-title">
            <h3>Minhas <span>denúncias</span></h3>
        </div>
        <?php
        if ($listaDenuncia != null) {
            foreach ($listaDenuncia as $denuncia) {
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
                                                    <img src="img/Denuncias/<?= $denuncia->getImagem(); ?>" alt="<?= $denuncia->getTitulo() ?>" class="img-fluid">
                                                </div>

                                                <h2 class="entry-title">
                                                    <a href="?pagina=visualizardenuncia&iddenuncia=<?= $denuncia->getIddenuncia(); ?>"><?= $denuncia->getTitulo(); ?></a>
                                                </h2>

                                                <div class="entry-meta">
                                                    <ul>
                                                        <li class="d-flex align-items-center"><i class="icofont-user"></i> <a href="?pagina=visualizardenuncia&iddenuncia=<?= $denuncia->getIddenuncia(); ?>">Status: <?= $denuncia->getStatus() == 1 ? "<span class='glyphicon glyphicon-ok' style='color: green;'></span> <span style='color: green;'>Ativo</span>" : "<span class='glyphicon glyphicon-remove' style='color: red;'></span> <span style='color: red;'>Inativo</span>" ?></a></li>
                                                        <li class="d-flex align-items-center"><i class="icofont-location-pin"></i> <a><?= $denuncia->getName(); ?></a></li>
                                                    </ul>
                                                </div>

                                                <div class="entry-content">
                                                    <p>
                                                        <?= $denuncia->getDescricao(); ?>
                                                    </p>
                                                    <div class="read-more">
                                                        <a href="?pagina=denunciar&iddenuncia=<?= $denuncia->getIddenuncia(); ?>&#dvDenunciar">Editar</i></a>
                                                        <a href="?pagina=visualizardenuncia&iddenuncia=<?= $denuncia->getIddenuncia(); ?>&#dvVisualizarDenuncia">Visualizar</a>
                                                        <a href="?pagina=anexarimagem&iddenuncia=<?= $denuncia->getIddenuncia(); ?>&#dvGrmImagem">+Imagens</i></a>
                                                    </div>
                                                    <br />
                                                    <div class="read-more">
                                                        <a id="delete" style="background: red;" href="?pagina=painel&delden=<?= $denuncia->getIddenuncia(); ?>">Excluir</i></a>
                                                    </div>
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
        <?php
            }
        } else {
            echo "<div class='text-center'><p>Você não possui denúncias cadastradas!</p></div>";
        }
        ?>
        <div class="panel-body">
            <div class="section-title">
                <br />
                <h3>Minhas <span>localizações</span></h3>
            </div>

            <?php
            if ($listaBuscaResumo != null) {
                foreach ($listaBuscaResumo as $localizacao) {

                    $type = "";
                    $status = "";

                    if ($localizacao->getType() == 1) {
                        $type = "Casa";
                    } else if ($localizacao->getType() == 2) {
                        $type = "Apartamento";
                    } else if ($localizacao->getType() == 3) {
                        $type = "Comercio";
                    }

                    if ($localizacao->getStatus() == 1) {
                        $status = "Ativo";
                    } else if ($localizacao->getStatus() == 2) {
                        $status = "Inativo";
                    }
            ?>
                    <div id="Mylocations">
                        <section id="contact" class="contact">
                            <div class="container">

                                <div class="row">
                                    <div class="col-lg-4 col-xs-12">
                                        <img src="img/Localizacoes/<?= $localizacao->getThumb(); ?>" alt="" class="img-responsive img-thumbnail">
                                        <br>
                                    </div>
                                    <div class="col-lg-8 col-xs-12">
                                        <table class="table table-hover table-striped" style="width: 100%;">
                                            <tr>
                                                <th style="background: #e43c5c; color: white;"><b>Nome da rua</b></th>
                                                <td style="background: #e43c5c; color: white;"><b><?= $localizacao->getName(); ?></b></td>
                                            </tr>
                                            <tr>
                                                <th>Endereço</th>
                                                <td><?= $localizacao->getAddress(); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Tipo</th>
                                                <td><?= $type; ?></td>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <td class="textAlign">
                                                    <div class="btn-group">
                                                        <button type="button" style="background: #d07586" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Opção
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <li><a href="?pagina=localizar&idlocalizacao=<?= $localizacao->getIdlocalizacao(); ?>">Editar</a></li>
                                                            <li role="separator" class="divider"></li>
                                                            <li><a href="?pagina=alterarimagem&idlocalizacao=<?= $localizacao->getIdlocalizacao(); ?>&img=<?= $localizacao->getThumb(); ?>">Alterar imagem</a></li>
                                                            <li><a id="delLocalizacao" href="?pagina=painel&del=<?= $localizacao->getIdlocalizacao() ?>">Remover</a></li>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="clear borderBottom"></div>
                                    <br>
                                </div>
                            </div>
                    </div>
        </div>
    </div>

<?php
                }
            } else {
?>
<div style="text-align: center;" class="container">
    <p>Você não possui localizações cadastradas!</p>
</div>";
<?php
            }
        } else {
?>
<br />
<br />
<div style="text-align: center;" class="container">
    <p class="bold">Você precisa estar autenticado para acessar este conteúdo, clique <a href="?pagina=entrar&#dvEntrar">aqui</a> para fazer o login.</p>
</div>
<?php
        }
?>
</div>
<!-- End Denuncias -->

<br />
<br />
<br />
<br />

<script>
    $(function() {
        $('a#delete').click(function() {
            if (confirm('Você tem certeza que deseja apagar esta denúncia?')) {
                return true;
            }

            return false;
        });
    });

    $(function() {
        $('a#delLocalizacao').click(function() {
            if (confirm('Você tem certeza que deseja apagar esta localização?')) {
                return true;
            }

            return false;
        });
    });
</script>