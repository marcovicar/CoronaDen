<?php

$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_STRING);

$arrayPaginas = array(
    "home" => "View/home.php", //Página inicial
    "usuario" => "View/UsuarioView/UsuarioView.php",
    "alterarsenha" => "View/UsuarioView/AlterarSenhaView.php",
    "comentario" => "View/ComentarioView/ComentarioView.php",
    "localizacao" => "View/LocalizacaoView/LocalizacaoView.php",
    "localizacaoimagem" => "View/LocalizacaoView/AlterarImagem.php",
    "denuncia" => "View/DenunciaView/DenunciaView.php",
    "gerenciarimagemdenuncia" => "View/DenunciaView/ImagensDenunciaView.php",
    "visualizardenuncia" => "View/DenunciaView/VisualizarDenunciaView.php",
    "contato" => "View/ContatoView/ContatoView.php",
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
        require_once("View/home.php");
    }
} else {
    require_once("View/home.php");
}