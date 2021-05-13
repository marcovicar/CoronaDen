<?php
require_once("Util/UploadFile.php");
require_once("Controller/LocalizacaoController.php");

$localizacaoController = new LocalizacaoController();

$resultado = "";

if (filter_input(INPUT_POST, "btnAlterarImagem", FILTER_SANITIZE_STRING)) {
    $upload = new Upload();

    $nomeImagem = $upload->LoadFile("img/Localizacoes/", "img", $_FILES["flImagem"]);

    if ($nomeImagem != "" && $nomeImagem != "invalid") {
        if ($localizacaoController->AlterarImagem($nomeImagem, filter_input(INPUT_GET, "idlocalizacao", FILTER_SANITIZE_NUMBER_INT))) {
            unlink("img/Localizacoes/" . filter_input(INPUT_GET, "img", FILTER_SANITIZE_STRING));

            $resultado = "<div class=\"alert alert-success\" role=\"alert\">Imagem alterado com sucesso</div>";
        } else {
            $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Houve um erro ao tentar alterar a imagem.</div>";
            unlink("img/Localizacoes/{$nomeImagem}");
        }
    } else if ($nomeImagem == "invalid") {
        $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Formato de imagem inválido.</div>";
    } else {
        $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Houve um erro ao tentar carregar a imagem.</div>";
    }
}
?>

<br />
<br />
<br />
<br />
<br />
<br />

<div id="dvImagemLocalizacaoView">
    <div class="section-title">
        <br />
        <br />
        <h2>Localização</h2>
        <h3>Alterar imagem da <span>localização</span></h3>
    </div>
    <br />

    <div class="panel-body">
        <div class="panel panel-default maxPainelWidth">
            <div class="panel-heading">&nbsp;</div>
            <div class="panel-body">
                <form method="post" id="frmAlterarImagemLocalizacao" name="frmAlterarImagemLocalizacao" novalidate enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <img src="img/Localizacoes/<?= filter_input(INPUT_GET, "img", FILTER_SANITIZE_STRING); ?>" alt="" title="" class="img-responsive img-thumbnail">

                            <br /> <br />

                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <p>Selecione uma nova imagem para a alterção.</p>

                            <br />

                            <div class="form-group">
                                <label for="flImagem">Selecione uma imagem</label>
                                <input type="file" id="flImagem" name="flImagem" accept="image/*" />
                            </div>
                            <input class="btn btn-success" type="submit" name="btnAlterarImagem" value="Alterar imagem">
                            <span id="spResultado" class="bold"><?= $resultado; ?></span>
                        </div>
                        <div class="clear"></div>

                        <br />

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $("#frmAlterarImagemCategoria").submit(function(e) {
            if ($("#flImagem").val() === "") {
                $("#spResultado").text("Selecione uma imagem.");
                $("#spResultado").css("color", "red");

                e.preventDefault();
            }
        });
    });
</script>