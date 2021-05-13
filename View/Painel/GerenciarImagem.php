<?php
require_once("Util/UploadMultipleFile.php");
require_once("Controller/ImagemController.php");
require_once("Model/Imagem.php");

$uploadMultipleFile = new Upload();
$imagemController = new ImagemController();

$resultado = "";

$iddenuncia = filter_input(INPUT_GET, "iddenuncia", FILTER_SANITIZE_NUMBER_INT);
$listaImagem = $imagemController->CarregarImagensDenuncia($iddenuncia);

$idusuario = 0;

if (isset($_SESSION["idusuario"])) {
    $idusuario = $_SESSION["idusuario"];
}

if (filter_input(INPUT_POST, "btnCarregar", FILTER_SANITIZE_STRING)) {

    if ($uploadMultipleFile->ValidaImagens($_FILES["flImagem"], "img", 1, 6)) {
        $arquivos = $uploadMultipleFile->LoadFile("img/Denuncias", $_FILES["flImagem"]);

        $idImagemDenuncia = filter_input(INPUT_GET, "iddenuncia", FILTER_SANITIZE_NUMBER_INT);

        $listaImagem = [];

        foreach ($arquivos as $nome) {
            $imagem = new Imagem();

            $imagem->getDenuncia()->setIddenuncia($iddenuncia);
            $imagem->setImagem($nome);

            $listaImagem[] = $imagem;
        }

        if ($imagemController->CadastrarImagens($listaImagem)) {
            $resultado = "<div class='alert alert-success' role='alert'>Imagens cadastradas com sucesso</div>";
        } else {
            foreach ($arquivos as $nome) {
                unlink("img/Denuncias/{$nome}");
            }

            $resultado = "<div class='alert alert-danger' role='alert'>Houve um erro ao tentar cadastrar as imagens</div>";
        }
    } else {
        $resultado = "<div class='alert alert-danger' role='alert'>Houve um erro ao tentar carregar as imagens</div>";
    }
}

if (filter_input(INPUT_GET, "del", FILTER_SANITIZE_NUMBER_INT)) {
    $nomeImagem = $imagemController->VerificarArquivoExiste(filter_input(INPUT_GET, "iddenuncia", FILTER_SANITIZE_NUMBER_INT), filter_input(INPUT_GET, "del", FILTER_SANITIZE_NUMBER_INT));

    if ($nomeImagem != "" || $nomeImagem != null) {
        if ($imagemController->RemoverImagem(filter_input(INPUT_GET, "iddenuncia", FILTER_SANITIZE_NUMBER_INT), filter_input(INPUT_GET, "del", FILTER_SANITIZE_NUMBER_INT))) {
            unlink("img/Denuncias/{$nomeImagem}");

            $resultado = "<div class=\"alert alert-success\" role=\"alert\">Imagem removida com sucesso</div>";
        } else {
            $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Houve um erro ao tentar remover a imagem</div>";
        }
    } else {
        $resultado = "<div class=\"alert alert-danger\" role=\"alert\">O arquivo infromado não pode ser localizado</div>";
    }
}
?>

<br />
<br />
<br />
<br />
<br />
<br />

<div id="dvGrmImagem">
    <section id="grmImagem" class="grmImagem">
        <div class="container">
            <div class="section-title">
                <h2>Gerenciar Imagens</h2>
                <h3>Anexe imagens a sua <span>denúncia</span></h3>
                <p>Aqui você realiza o cadastro de um endereço para poder utilizar em uma denúncia.</p>
            </div>

            <?php
            if ($idusuario != 0) {

            ?>
                <div class="col-lg-8">
                    <div id="dvFrmAnexarImagem" class="dvFrmAnexarImagem">
                        <form method="post" id="frmAnexarImagem" name="frmAnexarImagem" novalidate enctype="multipart/form-data">
                            <div class="linha">
                                <div class="grid-100 coluna">
                                    <label for="flImagem">Selecione as imagens (Máximo 6 imagens)</label>
                                    <input type="file" id="flImagem" name="flImagem[]" accept="image/*" multiple="multitple" />
                                </div>
                            </div>
                            <div class="linha">
                                <div class="grid-100 coluna">
                                    <p class="bold">Imagens selecionadas</p>
                                    <ul id="ulImagensSelecionadas"></ul>
                                </div>
                            </div>
                            <div class="linha">
                                <div class="grid-100 coluna right">
                                    <input type="submit" name="btnCarregar" id="btnCarregar" value="Carregar" class="btn-padrao" />
                                </div>
                            </div>
                            <div class="linha">
                                <div class="grid-100 coluna">
                                    <br />
                                    <br />
                                    <span id="spResultado"><?= $resultado; ?></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </section>
</div>

<br>

<?php
                if ($listaImagem != null) {
                    foreach ($listaImagem as $imagem) {
?>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xs-12">
                    <img src="img/Denuncias/<?= $imagem->getImagem(); ?>" alt="Imagem denuncia" class="img-responsive img-thumbnail">
                    <br><br>
                    <div>
                        <a id="removerImg" href="?pagina=anexarimagem&iddenuncia=<?= $iddenuncia; ?>&del=<?= $imagem->getIdimagem(); ?>" class="btn btn-danger">Remover</a>
                    </div>
                    <br>
                </div>
                <div class="clear borderBottom"></div>
                <br>
            </div>
        </div>
    <?php
                    }
    ?>
    </ul>
    </div>

<?php
                }
            } else {
?>
<div style="text-align: center;" class="container">
    <p class="bold">Você precisa estar autenticado para acessar este conteúdo, clique <a href="?pagina=entrar&#dvEntrar">aqui</a> para fazer o login.</p>
</div>
<?php
            }
?>

</div>
<div id="dvModal">
    <div>
        <img src="" alt="Imagem Denuncia" id="imgModal">
        <br>
        <br>
        <button onclick="CloseModal();">Fechar</button>
    </div>
</div>

<script>
    function OpenModal(image) {
        $("#dvModal").show("normal");
        document.getElementById("imgModal").src = "img/Denuncias/" + image;
    }

    function CloseModal() {
        $("#dvModal").hide("normal");
    }

    $(function() {
        $('a#removerImg').click(function() {
            if (confirm('Você tem certeza que deseja apagar esta imagem?')) {
                return true;
            }

            return false;
        });
    });

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

        $("#frmAnexarImagem").submit(function(e) {
            var inp = document.getElementById("flImagem");

            if (inp.files.length >= 1 && inp.files.length <= 6) {

            } else {
                document.getElementById("spResultado").style.color = "red";
                document.getElementById("spResultado").innerText = "Selecione no minimo 1 e no maximo 6(seis) imagens";
                e.preventDefault();
            }
        });

    });
</script>