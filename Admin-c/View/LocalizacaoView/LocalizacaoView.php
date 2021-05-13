<?php
require_once("../Util/UploadFile.php");
require_once("../Model/Localizacao.php");
require_once("../Controller/LocalizacaoController.php");

$localizacaoController = new LocalizacaoController();

$resultado = "";
$spResultadoBusca = "";
$listaBuscaResumo = [];

$listaTodos = $localizacaoController->ListarTodosAdm();

$idlocalizacao = "";
$name = "";
$address = "";
$type = "";
$status = "";
$thumb = "";

if (filter_input(INPUT_POST, "btnGravar", FILTER_SANITIZE_STRING)) {
    $localizacao = new Localizacao();

    $localizacao->setIdlocalizacao(filter_input(INPUT_POST, "txtIdlocalizacao", FILTER_SANITIZE_STRING));
    $localizacao->setName(filter_input(INPUT_POST, "txtName", FILTER_SANITIZE_STRING));
    $localizacao->setAddress(filter_input(INPUT_POST, "txtAddress", FILTER_SANITIZE_STRING));
    $localizacao->setType(filter_input(INPUT_POST, "slType", FILTER_SANITIZE_NUMBER_INT));
    $localizacao->setStatus(filter_input(INPUT_POST, "slStatus", FILTER_SANITIZE_NUMBER_INT));
    $localizacao->getUsuario()->setIdusuario($_SESSION["idusuario"]);

    if (!filter_input(INPUT_GET, "idlocalizacao", FILTER_SANITIZE_NUMBER_INT)) {
        //      CADASTRAR
        $upload = new Upload();

        $nomeImagem = $upload->LoadFile("../img/Localizacoes", "img", $_FILES["flImagem"]);

        $localizacao->setThumb($nomeImagem);

        if ($nomeImagem != "" && $nomeImagem != "invalid") {

            if ($localizacaoController->Cadastrar($localizacao)) {
                $resultado = "<div class=\"alert alert-success\" role=\"alert\">Localização cadastrada com sucesso</div>";
            } else {
                $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Houve um erro ao tentar cadastrar a localização</div>";
            }
        } else if ($nomeImagem == "invalid") {
            $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Formato de imagem inválido</div>";
        } else {
            $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Houve um erro ao tentar carregar a imagem</div>";
        }
    } else {
        //      EDITAR
        if ($localizacaoController->Alterar($localizacao)) {
            $resultado = "<div class=\"alert alert-success\" role=\"alert\">Localização cadastrada com sucesso</div>";
        } else {
            $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Houve um erro ao tentar alterar a localização</div>";
        }
    }
}

if (filter_input(INPUT_GET, "idlocalizacao", FILTER_SANITIZE_NUMBER_INT)) {
    $localizacao = $localizacaoController->RetornarIdlocalizacao(filter_input(INPUT_GET, "idlocalizacao", FILTER_SANITIZE_NUMBER_INT));

    if ($localizacao != null) {

        $idlocalizacao = filter_input(INPUT_GET, "idlocalizacao", FILTER_SANITIZE_NUMBER_INT);
        $name = $localizacao->getName();
        $address = $localizacao->getAddress();
        $type = $localizacao->getType();
        $status = $localizacao->getStatus();
        $thumb = "img";
    }
}

if (filter_input(INPUT_POST, "btnBuscar", FILTER_SANITIZE_STRING)) {
    $termo = filter_input(INPUT_POST, "txtTermo", FILTER_SANITIZE_STRING);

    $listaBuscaResumo = $localizacaoController->RetornarTodosFiltro($termo);

    if ($listaBuscaResumo != null) {
        $spResultadoBusca = "Exibindo dados";
    } else {
        $spResultadoBusca = "Dados não encontrados";
    }
}
?>

<div id="dvLocalizacaoView">
    <h1>Localização</h1>

    <br>

    <div class="controlePaginas">
        <a href="?pagina=localizacao"><img src="img/icones/editar.png" alt="" /></a>
        <a href="?pagina=localizacao&consulta=s"><img src="img/icones/buscar.png" alt="" /></a>
    </div>

    <br>

    <?php
    if (!filter_input(INPUT_GET, "consulta", FILTER_SANITIZE_STRING)) {
    ?>

        <div class="panel panel-default maxPainelWidth">
            <div class="panel-heading">Cadastrar e editar localização</div>
            <div class="panel-body">
                <form method="post" id="frmGerenciarLocalizacao" name="frmGerenciarLocalizacao" novalidate enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            <div class="form-group">
                                <input type="hidden" value="<?= $idlocalizacao ?>" name="txtIdlocalizacao" id="txtIdlocalizacao">

                                <label for="txtName">Cidade:</label>
                                <input type="text" class="form-control" value="<?= $name; ?>" id="txtName" name="txtName" placeholder="Cidade">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="txtAddress">Endereço:</label>
                                <input type="text" class="form-control" value="<?= $address; ?>" id="txtAddress" name="txtAddress" placeholder="Endereço">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-12">
                            <div class="form-group">
                                <label for="slType">Tipo:</label>
                                <select class="form-control" value="<?= $type; ?>" id="slType" name="slType">
                                    <option value="0">Selecione um tipo</option>
                                    <option value="1" <?= ($type) == "1" ? "selected='selected'" : ""; ?>>Casa</option>
                                    <option value="2" <?= ($type) == "2" ? "selected='selected'" : ""; ?>>Apartamento</option>
                                    <option value="3" <?= ($type) == "3" ? "selected='selected'" : ""; ?>>Comercio</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-12">
                            <div class="form-group">
                                <label for="slStatus">Status:</label>
                                <select class="form-control" value="<?= $status; ?>" id="slStatus" name="slStatus">
                                    <option value="0">Selecione um status</option>
                                    <option value="1" <?= ($status) == "1" ? "selected='selected'" : ""; ?>>Ativo</option>
                                    <option value="2" <?= ($status) == "2" ? "selected='selected'" : ""; ?>>Inativo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            <div class="form-group">
                                <label for="flImagem">Selecione uma imagem:</label>
                                <input type="file" class="form-control" id="flImagem" accept="image/*" name="flImagem" <?= ($thumb) == "" ? "" : "disabled='disabled'"; ?>>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            <p id="pResultado"><?= $resultado; ?></p>
                        </div>
                    </div>

                    <input class="btn btn-success" type="submit" name="btnGravar" value="Gravar">
                    <a onclick="location.href = document.referrer; return false;" class="btn btn-danger">Cancelar</a>

                    <br>
                    <br>

                    <div class="row">
                        <div class="col-lg-12">
                            <ul id="ulErros">

                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <?PHP
    } else {
    ?>

        <div class="panel panel-default maxPainelWidth">
            <div class="panel-heading">Consultar</div>
            <div class="panel-body">
                <form method="post" name="frmBuscarLocalizacao" id="frmBuscarLocalizacao">
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            <div class="form-group">
                                <label for="txtTermo">Termo:</label>
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
                            <input class="btn btn-success" type="submit" name="btnBuscar" value="Buscar">
                            <span><?= $spResultadoBusca ?></span>
                        </div>
                    </div>
                </form>

                <br>
                <hr>
                <br>



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
                        <div class="row">
                            <div class="col-lg-6 col-xs-12">
                                <img src="../img/Localizacoes/<?= $localizacao->getThumb(); ?>" alt="" class="img-responsive img-thumbnail">
                                <br><br>
                                <div class="spaceAround">
                                    <a href="?pagina=localizacao&idlocalizacao=<?= $localizacao->getIdlocalizacao(); ?>" class="btn btn-warning">Editar</a>
                                    <a href="?pagina=localizacaoimagem&idlocalizacao=<?= $localizacao->getIdlocalizacao(); ?>&img=<?= $localizacao->getThumb(); ?>" class="btn btn-info">Alterar imagem</a>
                                </div>
                                <br>
                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <p><span class="bold">Usuario: </span><?= $localizacao->getUsuario()->getNome(); ?></p>
                                <p>&nbsp;</p>
                                <p><span class="bold">Nome: </span><?= $localizacao->getName(); ?></p>
                                <p><span class="bold">Endereço: </span><?= $localizacao->getAddress(); ?></p>
                                <p><span class="bold">Tipo: </span><?= $type; ?></p>
                                <p><span class="bold">Status: </span><?= $status; ?></p>
                            </div>
                            <div class="clear borderBottom"></div>
                            <br>
                        </div>

                        <br>

                        <?php
                    }
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
                                <div class="col-lg-6 col-xs-12">
                                    <img src="../img/Localizacoes/<?= $localizacao->getThumb(); ?>" alt="" class="img-responsive img-thumbnail">
                                    <br><br>
                                    <div class="spaceAround">
                                        <a href="?pagina=localizacao&idlocalizacao=<?= $localizacao->getIdlocalizacao(); ?>" class="btn btn-warning">Editar</a>
                                        <a href="?pagina=localizacaoimagem&idlocalizacao=<?= $localizacao->getIdlocalizacao(); ?>&img=<?= $localizacao->getThumb(); ?>" class="btn btn-info">Alterar imagem</a>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-lg-6 col-xs-12">
                                    <p><span class="bold">Usuario: </span><?= $localizacao->getUsuario()->getNome(); ?></p>
                                    <p>&nbsp;</p>
                                    <p><span class="bold">Nome: </span><?= $localizacao->getName(); ?></p>
                                    <p><span class="bold">Endereço: </span><?= $localizacao->getAddress(); ?></p>
                                    <p><span class="bold">Tipo: </span><?= $type; ?></p>
                                    <p><span class="bold">Status: </span><?= $status; ?></p>
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

    <?php
    }
    ?>

</div>

<script>
    $(document).ready(function() {

        $("#frmGerenciarLocalizacao").submit(function(e) {
            if (!ValidarFormulario()) {
                e.preventDefault();
            }
        });

        $("#frmBuscarLocalizacao").submit(function(e) {
            if ($("#txtNameBusca").val() == "" && $("#txtAddressBusca").val() == "") {
                document.getElementById("pResultado").innerHTML = "<div class=\"alert alert-danger\" role=\"alert\">Formulario vazio</div>";
                e.preventDefault();
            }
        });

        function ValidarFormulario() {
            var erros = 0;

            var ulErros = document.getElementById("ulErros");
            ulErros.style.color = "red";
            ulErros.innerHTML = "";

            //        JavaScript nativo
            if (document.getElementById("txtName").value.length < 5) {
                var li = document.createElement("li");
                li.innerHTML = "- Informe um Nome válido";
                ulErros.appendChild(li);
                erros++;
            }

            if (document.getElementById("txtAddress").value.length < 5) {
                var li = document.createElement("li");
                li.innerHTML = "- Informe um Endereço válido";
                ulErros.appendChild(li);
                erros++;
            }

            if (document.getElementById("slType").value < "1" || document.getElementById("slType").value > "3") {
                var li = document.createElement("li");
                li.innerHTML = "- Informe um Tipo válido";
                ulErros.appendChild(li);
                erros++;
            }

            if (document.getElementById("slStatus").value < "1" || document.getElementById("slStatus").value > "2") {
                var li = document.createElement("li");
                li.innerHTML = "- Informe um Status válido";
                ulErros.appendChild(li);
                erros++;
            }

            //          Jquery
            if ($("#txtIdlocalizacao").val() == "") {
                if (document.getElementById("flImagem").value == "") {
                    var li = document.createElement("li");
                    li.innerHTML = "- Selecione uma Imagem válida";
                    $("#ulErros").append(li);
                    erros++;
                }
            }

            if (erros === 0) {
                return true;
            } else {
                return false;
            }
        }

    });
</script>