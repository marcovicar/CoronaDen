<?php
require_once("Model/Localizacao.php");
require_once("Controller/LocalizacaoController.php");

$localizacaoController = new LocalizacaoController();

$resultado = "";
$spResultadoBusca = "";
$listaBuscaResumo = [];

$listaTodos = $localizacaoController->ListarTodos();

$termo = $termo = filter_input(INPUT_POST, "txtTermo", FILTER_SANITIZE_STRING);

if (filter_input(INPUT_POST, "btnBuscar", FILTER_SANITIZE_STRING)) {

    $listaBuscaResumo = $localizacaoController->RetornarTodosFiltro($termo);

    if ($listaBuscaResumo != null) {
        $spResultadoBusca = "Exibindo dados";
    } else {
        $spResultadoBusca = "Dados não encontrados";
    }
}
?>

<br />
<br />
<br />
<br />
<br />
<br />


<!-- ======= Localização Section ======= -->
<div id="location">
    <section id="contact" class="contact">
        <div class="container">

            <div class="section-title">
                <h2>Localização</h2>
                <h3>Endereços que já foram <span>denúnciados</span></h3>
                <p>Logo abaixo mostra os locais cadastrados por usuários</p>
            </div>


            <div class="panel panel-default maxPainelWidth">
                <div class="panel-heading"><b>Consultar</b></div>
                <div class="panel-body">
                    <form method="post" name="frmBuscarLocalizacao" id="frmBuscarLocalizacao">
                        <div class="row">
                            <div class="col-lg-12 col-xs-12">
                                <div class="form-group">
                                    <label for="txtTermo">Busque por uma localização cadastrada:</label>
                                    <input type="text" class="form-control" id="txtTermo" name="txtTermo">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-xs-12">
                                <p id="pResultado"><?= $resultado; ?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <input class="btn btn-buscaLocalizacao" type="submit" name="btnBuscar" value="Buscar">
                                <span><?= $spResultadoBusca ?></span>
                            </div>
                        </div>
                    </form>

                    <br>
                    <hr>
                    <br>

                    <?php
                    if ($termo) {

                        //LISTAR RESUMIDO
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
                                <div class="row">
                                    <div class="col-lg-4 col-xs-12">
                                        <img src="img/Localizacoes/<?= $localizacao->getThumb(); ?>" alt="" class="img-responsive img-thumbnail">
                                        <br>
                                    </div>
                                    <div class="col-lg-8 col-xs-12">
                                        <table class="table table-hover table-striped" style="width: 100%;">
                                            <tr>
                                                <th id="lineSite">Usuário</th>
                                                <td id="lineSite">Anônimo #<?= $localizacao->getUsuario()->getIdusuario(); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Nome da rua</th>
                                                <td><?= $localizacao->getName(); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Endereço</th>
                                                <td><?= $localizacao->getAddress(); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Tipo</th>
                                                <td><?= $type; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="clear borderBottom"></div>
                                    <br>
                                </div>

                                <br>

                            <?php
                            }
                        }
                        //                  FIM LISTAR RESUMIDO
                    } else {

                        if ($listaTodos != null) {
                            foreach ($listaTodos as $localizacao) {

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
                                <div class="row">
                                    <div class="col-lg-4 col-xs-12">
                                        <img src="img/Localizacoes/<?= $localizacao->getThumb(); ?>" alt="" class="img-responsive img-thumbnail">
                                        <br>
                                    </div>
                                    <div class="col-lg-8 col-xs-12">

                                        <table class="table table-hover table-striped" style="width: 100%;">
                                            <tr>
                                                <th id="lineSite">Usuário</th>
                                                <td id="lineSite">Anônimo #<?= $localizacao->getUsuario()->getIdusuario(); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Cidade</th>
                                                <td><?= $localizacao->getName(); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Endereço</th>
                                                <td><?= $localizacao->getAddress(); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Tipo</th>
                                                <td><?= $type; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="clear borderBottom"></div>
                                    <br>
                                </div>

                                <br>

                    <?php
                            }
                        } else {
                            echo "<p>Dados não encontrados</p>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

</div>
</section><!-- End Localização Section -->
</div>