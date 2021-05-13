<?php
require_once("COntroller/DenunciaController.php");
require_once("Controller/LocalizacaoController.php");
require_once("Model/Denuncia.php");
require_once("Model/Localizacao.php");

$localizacaoController = new LocalizacaoController();
$denunciaController = new DenunciaController();

$edit = false;
$resultado = "";


$titulo = "";
$descricao = "";
$localizacao = "";
$name = "";

$idusuario = 0;

if (isset($_SESSION["idusuario"])) {
    $idusuario = $_SESSION["idusuario"];
}

$listaResumida = $localizacaoController->RetornarLocalizacaoResumido();

$iddenuncia = filter_input(INPUT_GET, "iddenuncia", FILTER_SANITIZE_NUMBER_INT);

if (filter_input(INPUT_POST, "btnSubmit", FILTER_SANITIZE_STRING)) {
    $denuncia = new Denuncia();

    $denuncia->setIddenuncia($iddenuncia);
    $denuncia->setTitulo(filter_input(INPUT_POST, "txtTitulo", FILTER_SANITIZE_STRING));
    $denuncia->setDescricao(filter_input(INPUT_POST, "txtDescricao", FILTER_SANITIZE_STRING));
    $denuncia->setStatus(1);
    $denuncia->getLocalizacao()->setIdlocalizacao(filter_input(INPUT_POST, "slLocalizacao", FILTER_SANITIZE_NUMBER_INT));
    $denuncia->getUsuario()->setIdusuario($_SESSION["idusuario"]);


    if (!$iddenuncia) {

        //Cadastrar
        if ($denunciaController->Cadastrar($denuncia)) {
            $resultado = "<span class='spSucesso'>Denúncia cadastrado com sucesso</span>";
        } else {
            $resultado = "<span class='spErro'>Houve um erro ao tentar cadastrar a denúncia</span>";
        }
    } else {
        //Edição
        if ($denunciaController->AlterarResumido($denuncia)) {
            $resultado = "<span class='spSucesso'>Denúncia alterada com sucesso!</span>";
        } else {
            $resultado = "<span class='spErro'>Houve um erro ao tentar alterar a denúncia!</span>";
        }
    }
}

if ($iddenuncia) {

    $denuncia = $denunciaController->RetornaIddenuncia($iddenuncia);

    if (!empty($denuncia)) {
        $iddenuncia = $denuncia->getIddenuncia();
        $titulo = $denuncia->getTitulo();
        $descricao = $denuncia->getDescricao();
        $idlocalizacao = $denuncia->getLocalizacao()->getIdlocalizacao();
        $edit = true;
    }
}
?>

<br />
<br />
<br />
<br />
<br />
<br />

<div id="dvDenunciar">
    <?php
    if ($idusuario != 0) {
    ?>
        <!-- MELHORIAS MV -->
        <div id="dvDenunciar">
            <section id="denunciar" class="denunciar">
                <div class="container">
                    <div class="section-title">
                        <h2>Denunciar</h2>
                        <h3>Quero fazer uma <span>denúncia</span></h3>
                        <p>Aqui você realiza denúncias de aglomerações, mas não se preocupe pois as denúncias são feitas de forma anônima.</p>
                        <br />
                        <h2><span>**Lembre-se, antes de realizar uma denúncia, você deve cadastrar um endereço no painel**</span></h2>
                    </div>

                    <div id="dvFrmDenunciar" class="dvFrmDenunciar">
                        <form method="post" class="dvFrmDenunciar" name="frmDenunciar" id="frmDenunciar" role="form">
                            <div class="linha">
                                <div class="form-group">
                                    <input type="text" class="form-control" value="<?= $titulo ?>" id="txtTitulo" name="txtTitulo" placeholder="Digite um titulo aqui" />
                                    <div class="validate"></div>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="linha">
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" id="txtDescricao" name="txtDescricao" placeholder="Digite aqui a descrição de sua denúncia"><?= $descricao ?></textarea>
                                    <div class="validate"></div>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="linha">
                                <select id="slLocalizacao" name="slLocalizacao" <?= ($edit == true ? "disabled='disabled'" : "") ?>>
                                    <option value="0">Selecione uma localização</option>
                                    <?php
                                    foreach ($listaResumida as $loc) {
                                    ?>
                                        <option value="<?= $loc->getIdlocalizacao() ?>" <?= ($loc->getIdLocalizacao() ? "selected='selected'" : "") ?>><?= $loc->getName() ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="linha">
                                <div class="grid-100 coluna right">
                                    <div class="text-center"><input type="submit" name="btnSubmit" id="btnSubmit" value="<?= (!$edit ? "Denúnciar" : "Alterar Denúncia") ?>" /></div>
                                    <br />
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="linha">
                                <div class="text-center">
                                    <div class="grid-100 coluna">
                                        <span id="spResultado"><?= $resultado; ?></span>
                                    </div>
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
            </section>
        </div>
    <?php

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

<script>
    $(document).ready(function() {

        $("#frmDenunciar").submit(function(e) {
            if (!Validar()) {
                e.preventDefault();
            }
        });
    });

    function Validar() {
        var erros = 0;
        var ulErros = document.getElementById("ulErros");
        ulErros.innerHTML = "";
        ulErros.style.color = "red";

        if (document.getElementById("txtTitulo").value.length == 0) {
            var li = document.createElement("li");
            li.innerHTML = "- Informe um Título válido";
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

        if (erros === 0) {
            return true;
        } else {
            return false;
        }
    }
</script>