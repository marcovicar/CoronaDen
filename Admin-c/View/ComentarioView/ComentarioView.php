<?php
require_once ("../Controller/ComentarioController.php");
require_once ("../Model/Comentario.php");

$resultado = "";
$spResultadoBusca = "";
$termo = "";

$comentarioController = new ComentarioController();

$listaComentario = $comentarioController->RetornarTodosComentarios();

if (filter_input(INPUT_POST, "btnBuscar", FILTER_SANITIZE_STRING)) {
    $termo = filter_input(INPUT_POST, "txtTermo", FILTER_SANITIZE_STRING);

    $listaBuscaResumo = $comentarioController->RetornarTodosFiltro($termo);

    if ($listaBuscaResumo != null) {
        $spResultadoBusca = "Exibindo dados";
    } else {
        $spResultadoBusca = "Dados não encontrados";
    }
}

$del = filter_input(INPUT_GET, "del", FILTER_SANITIZE_NUMBER_INT);

if ($del) {
    if ($comentarioController->RemoverAdm($del)) {
        $resultado = "<span class='spSucesso'>Comentário apagado com sucesso</span>";
    } else {
        $resultado = "<span class='spSucesso'>Erro ao apagar o comentario</span>";
    }
}
?>

<div id="dvComentarioView">
    <br>
    <div class="row">
        <div class="col-lg-12">
            <p id="pResultado"><?= $resultado; ?></p>
        </div>
    </div>

    <br>

    <h1>Gerenciar Comentário</h1>

    <br>

    <div class="panel panel-default maxPainelWidth">
        <div class="panel-heading">Buscar denuncia</div>
        <div class="panel-body">
            <form method="post" name="frmBuscarDenuncia" id="frmBuscarDenuncia">
                <div class="row">
                    <div class="col-lg-12 col-xs-12">
                        <div class="form-group">
                            <label for="txtTermo">Termo:</label>
                            <input type="text" class="form-control" id="txtTermo" name="txtTermo">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <input class="btn btn-success" type="submit" name="btnBuscar" value="Buscar">
                        <span><?= $spResultadoBusca ?></span>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="clear"></div>

    <?php
    if ($termo == "") {
        ?>
        <br>

        <div id="dvTodosComentarioUsuario">
            <?php
            if (!empty($listaComentario)) {
                $listaComentarioPrincipal = [];
                $listaComentarioSecundario = [];

                foreach ($listaComentario as $comentario) {
                    if (empty($comentario->getSubcomentario())) {
                        $listaComentarioPrincipal[] = $comentario;
                    } else {
                        $listaComentarioSecundario[] = $comentario;
                    }
                }

                foreach ($listaComentarioPrincipal as $comentario) {
                    ?>
                    <div class="dvComment">
                        <p><span class="bold">Publicado em: </span><?= date("d/m/Y H:i", strtotime($comentario->getData())) ?> | <span class="bold">Por: </span><?= $comentario->getUsuario()->getNome() ?></p>
                        <p><?= $comentario->getMensagem() ?></p>

                        <br>

                        <div class="textAlign">
                            <?php
                            if ($comentario->getStatus() == 1) {
                                $mostraComentario = true;

                                foreach ($listaComentarioSecundario as $subcomentario) {
                                    if ($subcomentario->getSubcomentario() == $comentario->getIdcomentario()) {
                                        $mostraComentario = false;
                                    }
                                }
                                ?>
                                <a href="?pagina=comentario&del=<?= $comentario->getIdcomentario() ?>" class="btnacao red"><img src="img/icones/remover.png" alt="Imagem Remover"></a>

                                <?php
                            } else if ($comentario->getStatus() == 2) {
                                echo '<p style="color: red;">Comentario removido</p>';
                            } else if ($comentario->getStatus() == 3) {
                                echo '<p style="color: blue;">Comentario removido pelo Adm</p>';
                            }
                            ?>
                        </div>

                        <br>

                    </div>
                    <?php
                    foreach ($listaComentarioSecundario as $subcomentario) {
                        if ($subcomentario->getSubcomentario() == $comentario->getIdcomentario()) {
                            ?>
                            <div class="comentarioDenunciante">
                                <p><span class="bold">Resposta: </span><?= date("d/m/Y H:i", strtotime($subcomentario->getData())) ?> | <span class="bold">Por: </span><?= $subcomentario->getUsuario()->getNome() ?></p>
                                <?= $subcomentario->getMensagem() ?>
                                <div class="textAlign">
                                    <?php
                                    if ($subcomentario->getStatus() == 1) {
                                        ?>
                                        <a href="?pagina=comentario&del=<?= $subcomentario->getIdcomentario() ?>" class="btnacao red"><img src="img/icones/remover.png" alt="Imagem Remover"></a>

                                        <?php
                                    } else if ($subcomentario->getStatus() == 2) {
                                        echo '<p style="color: red;">Comentario removido</p>';
                                    } else if ($subcomentario->getStatus() == 3) {
                                        echo '<p style="color: blue;">Comentario removido pelo Adm</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <br>
                            <?php
                        }
                    }
                    ?>


                    <br>

                    <?php
                }
            } else {
                $resultado = "<span class='spErro'>Nenhum comentario a ser exibido!</span>";
            }
            ?>

        </div>
        <?php
        
    } else {
        ?>
        
        <br>

        <div id="dvComentarioUsuarioResumo">
            <?php
            if (!empty($listaBuscaResumo)) {
                $listaComentarioPrincipal = [];
                $listaComentarioSecundario = [];

                foreach ($listaBuscaResumo as $comentario) {
                    if (empty($comentario->getSubcomentario())) {
                        $listaComentarioPrincipal[] = $comentario;
                    } else {
                        $listaComentarioSecundario[] = $comentario;
                    }
                }

                foreach ($listaComentarioPrincipal as $comentario) {
                    ?>
                    <div class="dvComment">
                        <p><span class="bold">Publicado em: </span><?= date("d/m/Y H:i", strtotime($comentario->getData())) ?> | <span class="bold">Por: </span><?= $comentario->getUsuario()->getNome() ?></p>
                        <p><?= $comentario->getMensagem() ?></p>

                        <br>

                        <div class="textAlign">
                            <?php
                            if ($comentario->getStatus() == 1) {
                                $mostraComentario = true;

                                foreach ($listaComentarioSecundario as $subcomentario) {
                                    if ($subcomentario->getSubcomentario() == $comentario->getIdcomentario()) {
                                        $mostraComentario = false;
                                    }
                                }
                                ?>
                                <a href="?pagina=comentario&del=<?= $comentario->getIdcomentario() ?>" class="btnacao red"><img src="img/icones/remover.png" alt="Imagem Remover"></a>

                                <?php
                            } else if ($comentario->getStatus() == 2) {
                                echo '<p style="color: red;">Comentario removido</p>';
                            } else if ($comentario->getStatus() == 3) {
                                echo '<p style="color: blue;">Comentario removido pelo Adm</p>';
                            }
                            ?>
                        </div>

                        <br>

                    </div>
                    <?php
                    foreach ($listaComentarioSecundario as $subcomentario) {
                        if ($subcomentario->getSubcomentario() == $comentario->getIdcomentario()) {
                            ?>
                            <div class="comentarioDenunciante">
                                <p><span class="bold">Resposta: </span><?= date("d/m/Y H:i", strtotime($subcomentario->getData())) ?> | <span class="bold">Por: </span><?= $subcomentario->getUsuario()->getNome() ?></p>
                                <?= $subcomentario->getMensagem() ?>
                                <div class="textAlign">
                                    <?php
                                    if ($subcomentario->getStatus() == 1) {
                                        ?>
                                        <a id="delComentAdm" href="?pagina=comentario&del=<?= $subcomentario->getIdcomentario() ?>" class="btnacao red"><img src="img/icones/remover.png" alt="Imagem Remover"></a>

                                        <?php
                                    } else if ($subcomentario->getStatus() == 2) {
                                        echo '<p style="color: red;">Comentario removido</p>';
                                    } else if ($subcomentario->getStatus() == 3) {
                                        echo '<p style="color: blue;">Comentario removido pelo Adm</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <br>
                            <?php
                        }
                    }
                    ?>


                    <br>

                    <?php
                }
            } else {
                $resultado = "<span class='spErro'>Nenhum comentario a ser exibido!</span>";
            }
            ?>

        </div>
        <?php
    }
    ?>
</div>
