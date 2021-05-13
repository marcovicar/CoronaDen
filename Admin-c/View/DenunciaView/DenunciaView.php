<?php
require_once("../Model/Denuncia.php");
require_once("../Model/Localizacao.php");
require_once("../Model/Usuario.php");

require_once("../Controller/LocalizacaoController.php");
require_once("../Controller/DenunciaController.php");
require_once("../Controller/UsuarioController.php");

$denunciaController = new DenunciaController();
$localizacaoController = new LocalizacaoController();
$usuarioController = new UsuarioController();

$listaResumidaLocalizacao = $localizacaoController->RetornarLocalizacaoResumidoAdm();
$listaResumidaUsuario = $usuarioController->RetornarUsuarioResumido();

$resultado = "";
$spResultadoBusca = "";
$listaBuscaResumo = [];

$lista = $denunciaController->RetornarTodos();

$iddenuncia = 0;
$titulo = "";
$idlocalizacao = 0;
$descricao = "";

$status = 0;

if (filter_input(INPUT_POST, "btnGravar", FILTER_SANITIZE_STRING)) {
    $denuncia = new Denuncia();

    $denuncia->setIddenuncia(filter_input(INPUT_GET, "iddenuncia", FILTER_SANITIZE_NUMBER_INT));
    $denuncia->setTitulo(filter_input(INPUT_POST, "txtTitulo", FILTER_SANITIZE_STRING));
    $denuncia->setDescricao(filter_input(INPUT_POST, "txtDescricao", FILTER_SANITIZE_STRING));
    $denuncia->setStatus(filter_input(INPUT_POST, "slStatus", FILTER_SANITIZE_NUMBER_INT));
    $denuncia->getLocalizacao()->setIdlocalizacao(filter_input(INPUT_POST, "slLocalizacao", FILTER_SANITIZE_NUMBER_INT));
    $denuncia->getUsuario()->setIdusuario($_SESSION["idusuario"]);

    if (!filter_input(INPUT_GET, "iddenuncia", FILTER_SANITIZE_NUMBER_INT)) {
        //CADASTRAR
        if ($denunciaController->Cadastrar($denuncia)) {
            $resultado = "<div class=\"alert alert-success\" role=\"alert\">Denuncia realizado com sucesso</div>";
        } else {
            $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Houve um erro ao tentar cadastrar a denuncia</div>";
        }
    } else {
        //EDITAR
        if ($denunciaController->Alterar($denuncia)) {
            $resultado = "<div class=\"alert alert-success\" role=\"alert\">Denuncia alterada com sucesso</div>";
        } else {
            $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Houve um erro ao tentar alterar a denuncia</div>";
        }
    }
}

if (filter_input(INPUT_POST, "btnBuscar", FILTER_SANITIZE_STRING)) {
    $termo = filter_input(INPUT_POST, "txtTermo", FILTER_SANITIZE_STRING);

    $listaBuscaResumo = $denunciaController->RetornarTodosFiltro($termo);

    if ($listaBuscaResumo != null) {
        $spResultadoBusca = "Exibindo dados";
    } else {
        $spResultadoBusca = "Dados não encontrados";
    }
}

if (filter_input(INPUT_GET, "iddenuncia", FILTER_SANITIZE_NUMBER_INT)) {
    $denuncia = $denunciaController->RetornaIddenuncia(filter_input(INPUT_GET, "iddenuncia", FILTER_SANITIZE_NUMBER_INT));

    $titulo = $denuncia->getTitulo();
    $descricao = $denuncia->getDescricao();
    $idlocalizacao = $denuncia->getLocalizacao()->getIdlocalizacao();
    $name = $denuncia->getLocalizacao()->getName();
    $status = $denuncia->getStatus();
}
?>

<div id="dvDenunciaView">
    <h1>Gerenciar Denúncia</h1>

    <br>

    <div class="controlePaginas">
        <a href="?pagina=denuncia"><img src="img/icones/editar.png" alt="" /></a>
        <a href="?pagina=denuncia&consulta=s"><img src="img/icones/buscar.png" alt="" /></a>
    </div>

    <br>

    <?php
    if (!filter_input(INPUT_GET, "consulta", FILTER_SANITIZE_STRING)) {
    ?>

        <div class="panel panel-default maxPainelWidth">
            <div class="panel-heading">Cadastrar e editar denuncia</div>
            <div class="panel-body">
                <form method="post" id="frmGerenciarDenuncia" name="frmGerenciarDenuncia" novalidate="">
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            <div class="form-group">
                                <input type="hidden" name="txtIddenuncia" id="txtIddenuncia">

                                <label for="txtTitulo">Titulo:</label>
                                <input type="text" class="form-control" value="<?= $titulo ?>" id="txtTitulo" name="txtTitulo" placeholder="Titulo da denuncia">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            <div class="form-group">
                                <p style="font-weight: 700;">Descrição:</p>
                                <textarea rows="5" cols="33" class="form-control" id="txtDescricao" name="txtDescricao"><?= $descricao ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-xs-12">
                            <div class="form-group">
                                <label for="slSubcategoria">Localização:</label>
                                <select class="form-control" id="slLocalizacao" name="slLocalizacao" value="<?= $idlocalizacao ?>">
                                    <option value="0">Selecione uma localização</option>
                                    <?php
                                    foreach ($listaResumidaLocalizacao as $loc) {
                                    ?>
                                        <option value="<?= $loc->getIdlocalizacao() ?>" <?= ($loc->getIdLocalizacao() == $idlocalizacao ? "selected='selected'" : "") ?>><?= $loc->getName() ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12">
                            <div class="form-group">
                                <label for="slStatus">Status:</label>
                                <select class="form-control" id="slStatus" name="slStatus">
                                    <option value="0">Selecione um status</option>
                                    <option value="1" <?= ($status) == 1 ? "selected='selected'" : ""; ?>>Ativo</option>
                                    <option value="2" <?= ($status) == 2 ? "selected='selected'" : ""; ?>>Inativo</option>
                                </select>
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
                            <ul id="ulErros"></ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <?php
    } else {
    ?>

        <br>

        <div class="panel panel-default maxPainelWidth">
            <div class="panel-heading">Buscar denuncia</div>
            <div class="panel-body">
                <form method="post" name="frmBuscarDenuncia" id="frmBuscarDenuncia" action="#tbBusca">
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

                <div id="dvTbBusca">
                    <table class="table table-hover table-responsive table-striped" id="tbBusca">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Titulo</th>
                                <th>Descrição</th>
                                <th>Localização</th>
                                <th>Usuario</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($listaBuscaResumo != null) {
                                foreach ($listaBuscaResumo as $denuncia) {
                            ?>
                                    <tr>
                                        <td>#<?= $denuncia->getIddenuncia() ?></td>
                                        <td><?= $denuncia->getTitulo() ?></td>
                                        <td><?= $denuncia->getDescricao() ?></td>
                                        <td><?= $denuncia->getLocalizacao()->getName() ?></td>
                                        <td><?= $denuncia->getUsuario()->getNome() ?></td>
                                        <td><?= $denuncia->getStatus() == 1 ? "<span class='glyphicon glyphicon-ok' style='color: green;'></span> <span style='color: green;'>Ativo</span>" : "<span class='glyphicon glyphicon-remove' style='color: red;'></span> <span style='color: red;'>Inativo</span>" ?></td>
                                        <td>
                                            <button class="button button1"><a class="dropdown-item" href="?pagina=denuncia&iddenuncia=<?= $denuncia->getIddenuncia(); ?>">Editar</a></button>
                                            <button class="button button1"><a class="dropdown-item" href="?pagina=gerenciarimagemdenuncia&iddenuncia=<?= $denuncia->getIddenuncia(); ?>">Gerenciar Imagens</a></button>
                                            <button class="button button1"><a class="dropdown-item" href="?pagina=visualizardenuncia&iddenuncia=<?= $denuncia->getIddenuncia(); ?>">Visualizar Denuncia</a></button>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                foreach ($lista as $denuncia) {
                                ?>
                                    <tr>
                                        <td>#<?= $denuncia->getIddenuncia() ?></td>
                                        <td><?= $denuncia->getTitulo() ?></td>
                                        <td><?= $denuncia->getDescricao() ?></td>
                                        <td><?= $denuncia->getLocalizacao()->getName() ?></td>
                                        <td><?= $denuncia->getUsuario()->getNome() ?></td>
                                        <td><?= $denuncia->getStatus() == 1 ? "<span class='glyphicon glyphicon-ok' style='color: green;'></span> <span style='color: green;'>Ativo</span>" : "<span class='glyphicon glyphicon-remove' style='color: red;'></span> <span style='color: red;'>Inativo</span>" ?></td>
                                        <td>
                                            <button class="button button1"><a class="dropdown-item" href="?pagina=denuncia&iddenuncia=<?= $denuncia->getIddenuncia(); ?>">Editar</a></button>
                                            <button class="button button1"><a class="dropdown-item" href="?pagina=gerenciarimagemdenuncia&iddenuncia=<?= $denuncia->getIddenuncia(); ?>">Gerenciar Imagens</a></button>
                                            <button class="button button1"><a class="dropdown-item" href="?pagina=visualizardenuncia&iddenuncia=<?= $denuncia->getIddenuncia(); ?>">Visualizar Denuncia</a></button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

</div>

<script>
    $(document).ready(function() {

        $("#frmGerenciarDenuncia").submit(function(e) {
            if (!ValidarFormulario()) {
                e.preventDefault();
            }
        });

        $("#frmBuscarDenuncia").submit(function(e) {
            if ($("#txtTituloBusca").val() == "" && $("#txtDescricaoBusca").val() == "" && $("#txtLocalizacaoBusca").val() == "") {
                document.getElementById("pResultado").innerHTML = "<div class=\"alert alert-danger\" role=\"alert\">Formulario vazio</div>";
                e.preventDefault();
            }
        });

    });

    function ValidarFormulario() {
        var erros = 0;

        var ulErros = document.getElementById("ulErros");
        ulErros.style.color = "red";
        ulErros.innerHTML = "";

        //      JavaScript nativo
        if (document.getElementById("txtTitulo").value.length <= 0) {
            var li = document.createElement("li");
            li.innerHTML = "- Informe um Titulo válido";
            ulErros.appendChild(li);
            erros++;
        }

        if (document.getElementById("txtDescricao").value.length < 10) {
            var li = document.createElement("li");
            li.innerHTML = "- Informe uma Descrição válida";
            ulErros.appendChild(li);
            erros++;
        }

        if (document.getElementById("slLocalizacao").value <= 0) {
            var li = document.createElement("li");
            li.innerHTML = "- Informe uma Localização válida";
            ulErros.appendChild(li);
            erros++;
        }

        if (document.getElementById("slStatus").value != "1" && document.getElementById("slStatus").value != "2") {
            var li = document.createElement("li");
            li.innerHTML = "- Informe um Status válido";
            ulErros.appendChild(li);
            erros++;
        }

        if (erros === 0) {
            return true;
        } else {
            return false;
        }
    }
</script>