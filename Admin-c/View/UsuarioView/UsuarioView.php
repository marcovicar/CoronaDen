<?php
require_once("../Controller/UsuarioController.php");
require_once("../Model/Usuario.php");

$usuarioController = new UsuarioController();

$listarTodos = $usuarioController->RetornarTodos();

$idusuario = 0;
$nome = "";
$email = "";
$nascimento = "";
$senha = "";
$sexo = "";
$status = 0;
$permissao = 0;

$resultado = "";
$spResultadoBusca = "";

$listaUsuariosBusca = [];

if (filter_input(INPUT_POST, "btnGravar", FILTER_SANITIZE_STRING)) {
    $usuario = new Usuario();

    $usuario->setNome(filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING));
    $usuario->setEmail(filter_input(INPUT_POST, "txtEmail", FILTER_SANITIZE_STRING));
    $usuario->setSenha(filter_input(INPUT_POST, "txtSenha", FILTER_SANITIZE_STRING));
    $usuario->setNascimento(filter_input(INPUT_POST, "txtData", FILTER_SANITIZE_STRING));
    $usuario->setSexo(filter_input(INPUT_POST, "slSexo", FILTER_SANITIZE_STRING));
    $usuario->setStatus(filter_input(INPUT_POST, "slStatus", FILTER_SANITIZE_NUMBER_INT));
    $usuario->setPermissao(filter_input(INPUT_POST, "slPermissao", FILTER_SANITIZE_NUMBER_INT));


    if (!filter_input(INPUT_GET, "idusuario", FILTER_SANITIZE_NUMBER_INT)) {
        //Cadastrar
        if ($usuarioController->Cadastrar($usuario)) {
            $resultado = "<div class=\"alert alert-success\" role=\"alert\">Usuario cadastrado com sucesso</div>";
        } else {
            $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Houve um erro ao tentar cadastrar o usuário</div>";
        }
    } else {
        //Editar
        $usuario->setIdusuario(filter_input(INPUT_GET, "idusuario", FILTER_SANITIZE_NUMBER_INT));

        if ($usuarioController->Alterar($usuario)) {
            $resultado = "<div class=\"alert alert-success\" role=\"alert\">Usuario alterado com sucesso</div>";
        } else {
            $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Houve um erro ao tentar alterar o usuário</div>";
        }
    }
}

// BUSCAR USUARIOS
if (filter_input(INPUT_POST, "btnBuscar", FILTER_SANITIZE_STRING)) {
    $termo = filter_input(INPUT_POST, "txtTermo", FILTER_SANITIZE_STRING);

    $listaUsuariosBusca = $usuarioController->RetornarUsuario($termo);

    if ($listaUsuariosBusca != null) {
        $spResultadoBusca = "Exibindo dados";
    } else {
        $spResultadoBusca = "Dados não encontrados";
    }
}

if (filter_input(INPUT_GET, "idusuario", FILTER_SANITIZE_NUMBER_INT)) {
    $retornoUsuario = $usuarioController->RetornaIdusuario(filter_input(INPUT_GET, "idusuario", FILTER_SANITIZE_NUMBER_INT));

    $idusuario = filter_input(INPUT_POST, "idusuario", FILTER_SANITIZE_NUMBER_INT);
    $nome = $retornoUsuario->getNome();
    $email = $retornoUsuario->getEmail();

    //  CONVERSÃO DE DATA
    $date = str_replace("-", "/", $retornoUsuario->getNascimento());
    $nascimento = date("d-m-Y", strtotime($date));

    $senha = "sim";
    $sexo = $retornoUsuario->getSexo();
    $status = $retornoUsuario->getStatus();
    $permissao = $retornoUsuario->getPermissao();
}
?>

<div id="dvUsuarioView">
    <h1>Gerenciar Usuário</h1>

    <br>

    <div class="controlePaginas">
        <a href="?pagina=usuario"><img src="img/icones/editar.png" alt="" /></a>
        <a href="?pagina=usuario&consulta=s"><img src="img/icones/buscar.png" alt="" /></a>
    </div>

    <br>

    <!--DIV CADASTRO-->
    <?php
    if (!filter_input(INPUT_GET, "consulta", FILTER_SANITIZE_STRING)) {
    ?>
        <div class="panel panel-default maxPainelWidth">
            <div class="panel-heading">Cadastrar e editar usuários</div>
            <div class="panel-body">
                <form method="post" id="frmGerenciarUsuario" name="frmGerenciarUsuario" novalidate="">
                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <input type="hidden" value="<?= $idusuario ?>" name="txtIdusuario" id="txtIdusuario">
                                <label for="txtNome">Nome:</label>
                                <input type="text" class="form-control" value="<?= $nome; ?>" id="txtNome" name="txtNome" placeholder="Nome completo">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="txtEmail">Email:</label>
                                <input type="email" class="form-control" value="<?= $email; ?>" id="txtEmail" name="txtEmail" placeholder="Digite seu Email">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="txtSenha">Senha: <span class="vlSenha"></span></label>
                                <input type="password" class="form-control" id="txtSenha" name="txtSenha" placeholder="*****" <?= ($senha) == "" ? "" : "disabled='disabled'"; ?>>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="txtConfSenha">Confirmar senha: <span class="vlSenha"></span></label>
                                <input type="password" class="form-control" id="txtConfSenha" name="txtConfSenha" placeholder="*****" <?= ($senha) == "" ? "" : "disabled='disabled'"; ?>>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="txtData">Data de nascimento:</label>
                                <input type="text" class="form-control" value="<?= $nascimento; ?>" id="txtData" name="txtData" placeholder="01/01/1970">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="slSexo">Sexo:</label>
                                <select class="form-control" id="slSexo" name="slSexo">
                                    <option value="0">Selecione um sexo</option>
                                    <option value="m" <?= ($sexo) == "m" ? "selected='selected'" : ""; ?>>Masculino</option>
                                    <option value="f" <?= ($sexo) == "f" ? "selected='selected'" : ""; ?>>Feminino</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="slStatus">Status:</label>
                                <select class="form-control" value="<?= $status; ?>" id="slStatus" name="slStatus">
                                    <option value="0">Selecione um status</option>
                                    <option value="1" <?= ($status) == "1" ? "selected='selected'" : ""; ?>>Ativo</option>
                                    <option value="2" <?= ($status) == "2" ? "selected='selected'" : ""; ?>>Inativo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="slPermissao">Permissão:</label>
                                <select class="form-control" value="<?= $permissao; ?>" id="slPermissao" name="slPermissao">
                                    <option value="0">Selecione uma permissão</option>
                                    <option value="1" <?= ($permissao) == "1" ? "selected='selected'" : ""; ?>>Administrador</option>
                                    <option value="2" <?= ($permissao) == "2" ? "selected='selected'" : ""; ?>>Comum</option>
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
                            <ul id="ulErros">

                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php
    } else {
    ?>

        <br>

        <!--DIV CONSULTA-->
        <div class="panel panel-default maxPainelWidth">
            <div class="panel-heading">Cadastrar e editar usuários</div>

            <br>

            <div class="panel-body">
                <form method="post" name="frmBuscarUsuario" id="frmBuscarUsuario">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="txtTermo">Termo de busca:</label>
                                <input type="text" class="form-control" id="txtTermo" name="txtTermo" placeholder="Fulano de Tal">
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
                            <input class="btn btn-info" type="submit" name="btnBuscar" value="Buscar">
                            <span><?= $spResultadoBusca ?></span>
                        </div>
                    </div>
                </form>

                <br>
                <hr>
                <br>

                <table class="table table-responsive-lg table-responsive-xs table-hover table-striped" style="overflow-x:auto; display: block;">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Data de nascimento</th>
                            <th>Sexo</th>
                            <th>Status</th>
                            <th>Permissão</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($listaUsuariosBusca != null) {
                            foreach ($listaUsuariosBusca as $user) {

                                $nascimento = date("d/m/Y", strtotime($user->getNascimento()));
                        ?>
                                <tr>
                                    <td><?= $user->getNome(); ?></td>
                                    <td><?= $user->getEmail(); ?></td>
                                    <td><?= $nascimento; ?></td>
                                    <td><?= $user->getSexo() == "m" ? "<span style='color: blue;'>Homem</span>" : "<span style='color: orange;'>Mulher</span>" ?></td>
                                    <td><?= $user->getStatus() == 1 ? "<span class='glyphicon glyphicon-ok' style='color: green;'></span> <span style='color: green;'>Ativo</span>" : "<span class='glyphicon glyphicon-remove' style='color: red;'></span> <span style='color: red;'>Inativo</span>" ?></td>
                                    <td><?= $user->getPermissao() == 1 ? "<span style='color: green;'>Administrador</span>" : "<span class='glyphicon glyphicon-user' style='color: red;'></span> <span style='color: red;'>Comum</span>" ?></td>
                                    <td>
                                        <button class="button button1"><a class="dropdown-item" href="?pagina=usuario&idusuario=<?= $user->getIdusuario(); ?>">Editar</a></button>
                                        <button class="button button1"><a class="dropdown-item" href="?pagina=alterarsenha&idusuario=<?= $user->getIdusuario(); ?>">Alterar senha</a></button>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            if ($listarTodos != null) {
                                foreach ($listarTodos as $user) {

                                    $nascimento = date("d/m/Y", strtotime($user->getNascimento()));
                                ?>
                                    <tr>
                                        <td><?= $user->getNome(); ?></td>
                                        <td><?= $user->getEmail(); ?></td>
                                        <td><?= $nascimento; ?></td>
                                        <td><?= $user->getSexo() == "m" ? "<span style='color: blue;'>Homem</span>" : "<span style='color: orange;'>Mulher</span>" ?></td>
                                        <td><?= $user->getStatus() == 1 ? "<span class='glyphicon glyphicon-ok' style='color: green;'></span> <span style='color: green;'>Ativo</span>" : "<span class='glyphicon glyphicon-remove' style='color: red;'></span> <span style='color: red;'>Inativo</span>" ?></td>
                                        <td><?= $user->getPermissao() == 1 ? "<span style='color: green;'>Administrador</span>" : "<span class='glyphicon glyphicon-user' style='color: red;'></span> <span style='color: red;'>Comum</span>" ?></td>
                                        <td>
                                            <button class="button button1"><a class="dropdown-item" href="?pagina=usuario&idusuario=<?= $user->getIdusuario(); ?>">Editar</a></button>
                                            <button class="button button1"><a class="dropdown-item" href="?pagina=alterarsenha&idusuario=<?= $user->getIdusuario(); ?>">Alterar senha</a></button>
                                        </td>
                                    </tr>
                        <?php
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
    }
    ?>
</div>

<script src="../js/jquery.mask.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {

        $('#txtData').mask('00/00/0000');

        $("#frmGerenciarUsuario").submit(function(e) {
            if (!ValidarFormulario()) {
                e.preventDefault();
            }
        });

        $("#frmBuscarUsuario").submit(function(e) {
            if ($("#txtTermo").val() == "" && $("#slTipoBusca").val() != 1 && $("#slTipoBusca").val() != 2) {
                document.getElementById("pResultado").innerHTML = "<div class=\"alert alert-danger\" role=\"alert\">Formulario vazio</div>";
                e.preventDefault();
            }
        });

        var vlSenhas = document.getElementsByClassName('vlSenha');

        $('#txtSenha').keyup(function() {

            if (ValidarSenha()) {
                for (var i = 0; i < vlSenhas.length; i++) {
                    vlSenhas[i].style.color = 'green';
                    vlSenhas[i].innerHTML = 'válido';
                }
            } else {
                for (var i = 0; i < vlSenhas.length; i++) {
                    vlSenhas[i].style.color = 'red';
                    vlSenhas[i].innerHTML = 'inválido';
                }
            }
        });

        $('#txtConfSenha').keyup(function() {

            if (ValidarSenha()) {
                for (var i = 0; i < vlSenhas.length; i++) {
                    vlSenhas[i].style.color = 'green';
                    vlSenhas[i].innerHTML = 'válido';
                }
            } else {
                for (var i = 0; i < vlSenhas.length; i++) {
                    vlSenhas[i].style.color = 'red';
                    vlSenhas[i].innerHTML = 'inválido';
                }
            }
        });
    });

    function ValidarSenha() {
        var senha1 = $('#txtSenha').val();
        var senha2 = $('#txtConfSenha').val();

        if (senha1.length >= 7 && senha2.length >= 7) {
            if (senha1 == senha2) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function ValidarFormulario() {
        var erros = 0;

        var ulErros = document.getElementById("ulErros");
        ulErros.style.color = "red";
        ulErros.innerHTML = "";

        //                             JavaScript nativo
        if (document.getElementById("txtNome").value.length < 5) {
            var li = document.createElement("li");
            li.innerHTML = "- Informe um Nome válido";
            ulErros.appendChild(li);
            erros++;
        }

        if (document.getElementById("txtEmail").value.indexOf("@") < 0 || document.getElementById("txtEmail").value.indexOf(".") < 0) {
            var li = document.createElement("li");
            li.innerHTML = "- Informe um Email válido";
            ulErros.appendChild(li);
            erros++;
        }

        if (!ValidarSenha() && $("#txtIdusuario").val() == "0") {
            var li = document.createElement("li");
            li.innerHTML = "- Informe uma Senha válida";
            ulErros.append(li);
            erros++;
        }

        if (!ValidarData(document.getElementById("txtData").value)) {
            var li = document.createElement("li");
            li.innerHTML = "- Informe uma Data de nascimento válida";
            ulErros.appendChild(li);
            erros++;
        }

        if (document.getElementById("slSexo").value != "m" && document.getElementById("slSexo").value != "f") {
            var li = document.createElement("li");
            li.innerHTML = "- Informe um Sexo válido";
            ulErros.appendChild(li);
            erros++;
        }

        if (document.getElementById("slStatus").value != "1" && document.getElementById("slStatus").value != "2") {
            var li = document.createElement("li");
            li.innerHTML = "- Informe um Status válido";
            ulErros.appendChild(li);
            erros++;
        }

        if (document.getElementById("slPermissao").value != "1" && document.getElementById("slPermissao").value != "2") {
            var li = document.createElement("li");
            li.innerHTML = "- Informe uma Permissão válida";
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