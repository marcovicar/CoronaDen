<?php
require_once("../Util/UploadMultipleFile.php");
require_once("../Controller/ImagemController.php");
require_once("../Model/Imagem.php");

$uploadMultipleFile = new Upload();
$imagemController = new ImagemController();

$resultado = "";

$iddenuncia = filter_input(INPUT_GET, "iddenuncia", FILTER_SANITIZE_NUMBER_INT);

if (filter_input(INPUT_POST, "btnGravar", FILTER_SANITIZE_STRING)) {

    $arquivos = $uploadMultipleFile->LoadFile("../img/Denuncias", $_FILES["flImagem"]);

    $idImagemDenuncia = filter_input(INPUT_GET, "iddenuncia", FILTER_SANITIZE_NUMBER_INT);

    $listaImagem = [];

    foreach ($arquivos as $nome) {
        $imagem = new Imagem();

        $imagem->getDenuncia()->setIddenuncia($idImagemDenuncia);
        $imagem->setImagem($nome);

        $listaImagem[] = $imagem;
    }

    if ($imagemController->CadastrarImagens($listaImagem)) {
        $resultado = "<div class=\"alert alert-success\" role=\"alert\">Imagens cadastradas com sucesso</div>";
    } else {
        foreach ($arquivos as $nome) {
            unlink("../img/Denuncias/{$nome}");
        }

        $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Houve um erro ao tentar cadastrar as imagens</div>";
    }

    if ($uploadMultipleFile->ValidaImagens($_FILES["flImagem"], "img", 2, 10)) {
    } else {
        $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Houve um erro ao tentar carregar as imagens</div>";
    }
}

if (filter_input(INPUT_GET, "del", FILTER_SANITIZE_NUMBER_INT)) {
    $nomeImagem = $imagemController->VerificarArquivoExiste(filter_input(INPUT_GET, "iddenuncia", FILTER_SANITIZE_NUMBER_INT), filter_input(INPUT_GET, "del", FILTER_SANITIZE_NUMBER_INT));

    if ($nomeImagem != "" || $nomeImagem != null) {
        if ($imagemController->RemoverImagem(filter_input(INPUT_GET, "iddenuncia", FILTER_SANITIZE_NUMBER_INT), filter_input(INPUT_GET, "del", FILTER_SANITIZE_NUMBER_INT))) {
            unlink("../img/Denuncias/{$nomeImagem}");
            $resultado = "<div class=\"alert alert-success\" role=\"alert\">Imagem removida com sucesso</div>";
        } else {
            $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Houve um erro ao tentar remover a imagem</div>";
        }
    } else {
        $resultado = "<div class=\"alert alert-danger\" role=\"alert\">O arquivo infromado não pode ser localizado</div>";
    }
} else {
}

$listaImagem = $imagemController->CarregarImagensDenuncia(filter_input(INPUT_GET, "iddenuncia", FILTER_SANITIZE_NUMBER_INT));
?>

<div id="dvImagemDenunciaView">
    <h1>Gerenciar Imagens de denuncia</h1>

    <br>

    <div class="panel panel-default maxPainelWidth">
        <div class="panel-heading">Carregar imagens</div>
        <div class="panel-body">
            <form method="post" id="frmGerenciarImagemDenuncia" name="frmGerenciarImagemDenuncia" novalidate enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-12 col-xs-12">
                        <div class="form-group">
                            <label for="flImagem">Selecione as imagens: (Max: 10)</label>
                            <input type="file" class="form-control" accept="image/*" id="flImagem" name="flImagem[]" multiple="multiple">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-xs-12">
                        <p style="font-weight: 700;">Imagens selecionadas</p>
                        <ul id="ulImagensSelecionadas"></ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-xs-12">
                        <p id="pResultado"><?= $resultado; ?></p>
                    </div>
                </div>

                <input class="btn btn-success" type="submit" name="btnGravar" value="Carregar Imagem">
            </form>
        </div>
    </div>

    <br>

    <div class="panel panel-default maxPainelWidth">
        <div class="panel-heading">Imagens</div>
        <div class="panel-body">
            <?php
            if ($listaImagem != null) {
                foreach ($listaImagem as $imagem) {
            ?>
                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <img src="../img/Denuncias/<?= $imagem->getImagem(); ?>" alt="Imagem denuncia" class="img-responsive img-thumbnail">
                            <br><br>
                            <div>
                                <a href="?pagina=gerenciarimagemdenuncia&iddenuncia=<?= $iddenuncia; ?>&del=<?= $imagem->getIdimagem(); ?>" class="btn btn-danger">Remover</a>
                            </div>
                            <br>
                        </div>
                        <div class="clear borderBottom"></div>
                        <br>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $("#flImagem").change(function() {
            var inp = document.getElementById("flImagem");
            var ulImagensSelecionadas = document.getElementById("ulImagensSelecionadas");

            ulImagensSelecionadas.innerHTML = "";

            for (var i = 0; i < inp.files.length; ++i) {
                var name = inp.files.item(i).name;
                var li = document.createElement("li");
                li.innerText = "- " + name;
                ulImagensSelecionadas.appendChild(li);
            }
        });

        $("#frmGerenciarImagemDenuncia").submit(function(e) {
            var inp = document.getElementById("flImagem");

            if (inp.files.length >= 1 && inp.files.length <= 10) {

            } else {
                document.getElementById("spResultado").style.color = "red";
                document.getElementById("spResultado").innerText = "Selecione no minimo 1 e no maximo 10(dez) imagens";
                e.preventDefault();
            }
        });
    });
</script>