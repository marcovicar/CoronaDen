<?php

session_start();

require_once ("../Controller/UsuarioController.php");
require_once ("../Model/Usuario.php");

$usuarioController = new UsuarioController();

$req = filter_input(INPUT_GET, "req", FILTER_SANITIZE_NUMBER_INT);

switch ($req) {
    case 1:
        $email = filter_input(INPUT_POST, "txtEmail", FILTER_SANITIZE_STRING);
        echo $usuarioController->VerificarEmailExiste($email);
        break;
    case 2:
        $usu = filter_input(INPUT_POST, "txtEmail", FILTER_SANITIZE_STRING);
        $senha = filter_input(INPUT_POST, "txtSenha", FILTER_SANITIZE_STRING);
        $permissao = 2;
        
        $usuario = $usuarioController->AutenticarUsuario($usu, $senha, $permissao);
        
        if (!empty($usuario)) {
            $_SESSION["idusuario"] = $usuario->getIdusuario();

            $ex = explode(" ", $usuario->getNome());
            $_SESSION["nome"] = $ex[0];
            echo "ok";
        } else {
            echo "invalid";
        }
        break;
}