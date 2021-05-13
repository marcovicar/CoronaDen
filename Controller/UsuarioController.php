<?php

if (file_exists("../DAL/UsuarioDAO.php")) {
    require_once("../DAL/UsuarioDAO.php");
} else if (file_exists("DAL/UsuarioDAO.php")) {
    require_once("DAL/UsuarioDAO.php");
}

class UsuarioController
{

    private $usuarioDAO;

    public function __construct()
    {
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function Cadastrar(Usuario $usuario)
    {

        if (
            strlen($usuario->getNome()) >= 5 &&
            strpos($usuario->getEmail(), "@") && strpos($usuario->getEmail(), ".") &&
            strlen($usuario->getSenha()) >= 7 &&
            $usuario->getSexo() != "" &&
            $usuario->getStatus() >= 1 && $usuario->getStatus() <= 2 &&
            $usuario->getPermissao() >= 1 && $usuario->getPermissao() <= 2
        ) {

            return $this->usuarioDAO->Cadastrar($usuario);
        } else {
            return false;
        }
    }

    public function Alterar(Usuario $usuario)
    {
        if (
            strlen($usuario->getNome()) >= 5 &&
            strpos($usuario->getEmail(), "@") && strpos($usuario->getEmail(), ".") &&
            $usuario->getSexo() != "" &&
            $usuario->getStatus() >= 1 && $usuario->getStatus() <= 2 &&
            $usuario->getPermissao() >= 1 && $usuario->getPermissao() <= 2
        ) {

            return $this->usuarioDAO->Alterar($usuario);
        } else {
            return false;
        }
    }

    public function RetornarUsuarioResumido()
    {
        return $this->usuarioDAO->RetornarUsuarioResumido();
    }

    public function RetornarUsuario(string $termo)
    {
        if ($termo != "") {
            return $this->usuarioDAO->RetornarUsuarios($termo);
        } else {
            return null;
        }
    }

    public function RetornarTodos()
    {
        return $this->usuarioDAO->RetornarTodos();
    }

    public function RetornaIdusuario(int $usuarioIdusuario)
    {
        if ($usuarioIdusuario > 0) {
            return $this->usuarioDAO->RetornaIdusuario($usuarioIdusuario);
        } else {
            return null;
        }
    }

    public function AutenticarUsuario(string $usu, string $senha, int $permissao)
    {
        if (($usu) != "" && strlen($senha) >= 7 && $permissao > 0) {
            $senha = md5($senha);

            return $this->usuarioDAO->AutenticarUsuario($usu, $senha, $permissao);
        } else {
            return null;
        }
    }

    public function AlterarSenha(string $senha, int $idusuario)
    {
        if (strlen($senha) >= 7 && $idusuario > 0) {
            return $this->usuarioDAO->AlterarSenha($senha, $idusuario);
        } else {
            return false;
        }
    }

    public function VerificarEmailExiste(string $email)
    {
        if (strpos($email, "@") > 0 && strpos($email, ".") > 0) {
            return $this->usuarioDAO->VerificarEmailExiste($email);
        } else {
            -10;
        }
    }
}
