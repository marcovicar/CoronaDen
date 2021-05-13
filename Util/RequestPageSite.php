<?php

$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_STRING);

$arrayPaginas = array(
    "home" => "index.php", //Página inicial
    "conteudo" => "View/conteudoPrincipal.php",
    "entrar" => "View/Entrar.php",
    "usuario" => "View/Usuario.php",
    "localizacao" => "View/Localizacao.php",
    "geral" => "View/Geral.php",
    "denuncia" => "View/Denuncia.php",
    "contato" => "View/Contato.php",
    "termodeuso" => "View/TermoDeUso.php",
    "politicas" => "View/Privacidade.php",
    "api" => "View/API.php",
//  Painel
    "painel" => "View/Painel.php",
    "denunciar" => "View/Painel/Denunciar.php",
    "localizar" => "View/Painel/Localizar.php",
    "anexarimagem" => "View/Painel/GerenciarImagem.php",
    "visualizardenuncia" => "View/Painel/VisualizarDenuncia.php",
    "alterarimagem" => "View/Painel/AlterarImagem.php",
    "alterarsenha" => "View/Painel/AlterarSenha.php",
);

if ($pagina) {
    $encontrou = false;

    foreach ($arrayPaginas as $page => $key) {
        if ($pagina == $page) {
            $encontrou = true;
            require_once($key);
        }
    }

    if (!$encontrou) {
        require_once("index.php");
        header('Location: index.php?pagina=conteudo');
    }
} else {
    require_once("index.php");
    header('Location: index.php?pagina=conteudo');
}