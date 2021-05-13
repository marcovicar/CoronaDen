<?php
require_once("Util/UploadFile.php");
require_once("Model/Localizacao.php");
require_once("Controller/LocalizacaoController.php");

$localizacaoController = new LocalizacaoController();

$idlocalizacao = filter_input(INPUT_GET, "idlocalizacao", FILTER_SANITIZE_NUMBER_INT);
$resultado = "";

$name = "";
$address = "";
$type = "";
$status = "";
$thumb = "";
$editar = false;

if (filter_input(INPUT_POST, "btnGravar", FILTER_SANITIZE_STRING)) {
    $localizacao = new Localizacao();

    $localizacao->setIdlocalizacao(filter_input(INPUT_POST, "txtIdlocalizacao", FILTER_SANITIZE_STRING));
    $localizacao->setName(filter_input(INPUT_POST, "txtName", FILTER_SANITIZE_STRING));
    $localizacao->setAddress(filter_input(INPUT_POST, "txtAddress", FILTER_SANITIZE_STRING));
    $localizacao->setType(filter_input(INPUT_POST, "slType", FILTER_SANITIZE_NUMBER_INT));
    $localizacao->setStatus(filter_input(INPUT_POST, "slStatus", FILTER_SANITIZE_NUMBER_INT));
    $localizacao->getUsuario()->setIdusuario($_SESSION["idusuario"]);

    if (!$idlocalizacao) {
        $upload = new Upload();

        $nomeImagem = $upload->LoadFile("img/Localizacoes", "img", $_FILES["flImagem"]);

        $localizacao->setThumb($nomeImagem);

        if ($nomeImagem != "" && $nomeImagem != "invalid") {

            if ($localizacaoController->Cadastrar($localizacao)) {
                $resultado = "<div class=\"alert alert-success\" role=\"alert\">Localização cadastrada!</div>";
            } else {
                $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Houve um erro ao tentar cadastrar a localização</div>";
            }
        } else if ($nomeImagem == "invalid") {
            $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Formato de imagem inválido</div>";
        } else {
            $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Houve um erro ao tentar carregar a imagem</div>";
        }
    } else {
        //EDITAR
        if ($localizacaoController->Alterar($localizacao)) {
            $resultado = "<div class=\"alert alert-success\" role=\"alert\">Localização alterada com sucesso!</div>";
        } else {
            $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Erro ao tentar alterar a localização!</div>";
        }
    }
}

if ($idlocalizacao) {
    $localizacao = $localizacaoController->RetornarIdlocalizacao($idlocalizacao);

    if ($localizacao != null) {

        $idlocalizacao = filter_input(INPUT_GET, "idlocalizacao", FILTER_SANITIZE_NUMBER_INT);
        $name = $localizacao->getName();
        $address = $localizacao->getAddress();
        $type = $localizacao->getType();
        $status = $localizacao->getStatus();
        $thumb = "img";

        $editar = true;
    }
}
?>

<br />
<br />
<br />
<br />
<br />
<br />

<div id="dvLocalizacaoView">
    <section id="cadLocal" class="cadLocal">
        <div class="container">
            <div class="section-title">
                <h2>Localização</h2>
                <h3>Cadastre uma <span>Localização/Endereço</span></h3>
                <p>Aqui você realiza o cadastro de um endereço para poder utilizar em uma denúncia.</p>
            </div>

            <div class="col-lg-8">
                <div id="dvFrmcadLocal" class="dvFrmcadLocal">
                    <form method="post" class="dvFrmcadLocal" name="frmcadLocal" id="frmcadLocal" role="form" novalidate enctype="multipart/form-data">
                        <div class="linha">
                            <div class="form-group">
                                <input type="hidden" value="<?= $idlocalizacao ?>" name="txtIdlocalizacao" id="txtIdlocalizacao">

                                <input type="text" class="form-control" id="txtName" name="txtName" value="<?= $name; ?>" placeholder="Cidade">
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="linha">
                            <div class="form-group">
                                <input type="text" class="form-control" id="txtAddress" name="txtAddress" value="<?= $address; ?>" placeholder="Endereço">
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="linha">
                            <div class="form-group">
                                <select class="form-control" id="slType" name="slType" value="<?= $type; ?>">
                                    <option value="0">Selecione um tipo</option>
                                    <option value="1" <?= ($type) == "1" ? "selected='selected'" : ""; ?>>Casa</option>
                                    <option value="2" <?= ($type) == "2" ? "selected='selected'" : ""; ?>>Apartamento</option>
                                    <option value="3" <?= ($type) == "3" ? "selected='selected'" : ""; ?>>Comercio</option>
                                </select>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="linha">
                            <div class="form-group">
                                <select class="form-control" id="slStatus" name="slStatus" value="<?= $status; ?>">
                                    <option value="0">Selecione um status</option>
                                    <option value="1" <?= ($status) == "1" ? "selected='selected'" : ""; ?>>Ativo</option>
                                    <option value="2" <?= ($status) == "2" ? "selected='selected'" : ""; ?>>Inativo</option>
                                </select>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="linha">
                            <div class="form-group">
                                <input type="file" class="form-control" id="flImagem" accept="image/*" name="flImagem" <?= ($thumb) == "" ? "" : "disabled='disabled'"; ?>>
                            </div>
                        </div>
                        <div class="section-title">
                            <h2><span>**Necessário que anexe uma imagem do endereço a ser cadastrado**</span></h2>
                        </div>

                        <div class="linha">
                            <div class="grid-100 coluna right">
                                <div class="grid-60 mobile-grid-100 coluna">
                                    <p id="pResultado"><?= $resultado; ?></p>
                                </div>

                                <div class="text-center">
                                    <input type="submit" name="btnGravar" id="btnSubmit" value="<?= ($editar) ? "Alterar" : "Gravar" ?>" />
                                    <br />
                                    <div class="grid-100 coluna">
                                        <a href="?pagina=painel&#dvPainel">Cancelar</a>
                                    </div>
                                </div>
                                <br />
                            </div>

                        </div>
                        <div class="clear"></div>
                        <div class="linha">
                            <div class="text-center">
                                <div class="grid-100 coluna">
                                    <br />
                                    <ul id="ulErros"></ul>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</div>