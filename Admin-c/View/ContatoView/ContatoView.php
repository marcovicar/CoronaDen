<?php
require_once ("../Controller/ContatoController.php");
require_once ("../Model/Contato.php");

$contatoController = new ContatoController();

$listaContato = $contatoController->RetornaContatoCompleto();

$del = filter_input(INPUT_GET, "del", FILTER_SANITIZE_NUMBER_INT);

if ($del) {
    if ($contatoController->Remover($del)) {
        echo "<span class='spSucesso'>Contato apagado com sucesso</span>";
    } else {
        echo "<span class='spSucesso'>Erro ao apagar o contato</span>";
    }
}
?>

<div id="dvLocalizacaoView">
    <h1>Contato/Mensagens</h1>

    <br>

    <?php
    if ($listaContato != null) {
        foreach ($listaContato as $contato) {
            if ($contato->getStatus() == 1) {
                ?>
                <div class="panel panel-info maxPainelWidth">
                    <div class="panel-heading"><?= $contato->getUsuario()->getNome(); ?></div>
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <table class="table table-responsive-lg table-hover table-striped">
                                <tr>
                                    <th>Email</th>
                                    <td><?= $contato->getUsuario()->getEmail() ?></td>
                                </tr>
                                <tr>
                                    <th>Assunto</th>
                                    <td><?= $contato->getAssunto(); ?></td>
                                </tr>
                                <tr>
                                    <th>Mensagem</th>
                                    <td><?= $contato->getMensagem(); ?></td>
                                </tr>
                            </table>
                            <div class="textAlign">
                                <a id="delContato" href="?pagina=contato&del=<?= $contato->getIdcontato() ?>" class="btnacao red"><img src="img/icones/remover.png" alt="Imagem Remover"></a>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }
        }
    }
    ?>
</div>

<script>
    $(function() {
      $('a#delContato').click(function() {
        if (confirm('Você tem certeza que deseja apagar a mensagem?')) {
          return true;
        }

        return false;
      });
    });
</script>