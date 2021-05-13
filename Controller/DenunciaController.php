<?php

if (file_exists("../DAL/DenunciaDAO.php")) {
    require_once("../DAL/DenunciaDAO.php");
} else if (file_exists("DAL/DenunciaDAO.php")) {
    require_once("DAL/DenunciaDAO.php");
}


class DenunciaController
{

    private $denunciaDAO;

    public function __construct()
    {
        $this->denunciaDAO = new DenunciaDAO();
    }

    public function Cadastrar(Denuncia $denuncia)
    {
        if (
            strlen($denuncia->getTitulo()) > 0 &&
            strlen($denuncia->getDescricao()) >= 10 &&
            $denuncia->getStatus() >= 1 && $denuncia->getStatus() <= 2 &&
            $denuncia->getLocalizacao()->getIdlocalizacao() > 0 &&
            $denuncia->getUsuario()->getIdusuario() > 0
        ) {
            return $this->denunciaDAO->Cadastrar($denuncia);
        } else {
            return false;
        }
    }

    public function Alterar(Denuncia $denuncia)
    {
        if (
            $denuncia->getIddenuncia() > 0 &&
            trim(strlen($denuncia->getTitulo())) > 0 &&
            trim(strlen($denuncia->getDescricao())) >= 10 &&
            $denuncia->getStatus() >= 1 && $denuncia->getStatus() <= 2 &&
            $denuncia->getLocalizacao()->getIdlocalizacao() > 0
        ) {
            return $this->denunciaDAO->Alterar($denuncia);
        } else {
            return false;
        }
    }

    public function Remover(int $iddenuncia)
    {
        if ($iddenuncia > 0) {
            return $this->denunciaDAO->Remover($iddenuncia);
        } else {
            return false;
        }
    }

    public function AlterarResumido(Denuncia $denuncia)
    {
        if (
            $denuncia->getIddenuncia() > 0 &&
            trim(strlen($denuncia->getTitulo())) > 0 &&
            trim(strlen($denuncia->getDescricao())) >= 10 &&
            $denuncia->getUsuario()->getIdusuario() > 0
        ) {
            return $this->denunciaDAO->AlterarResumido($denuncia);
        } else {
            return false;
        }
    }

    public function RetornarTodosFiltro(string $termo)
    {
        if ($termo != "") {
            return $this->denunciaDAO->RetornarTodosFiltro($termo);
        } else {
            return null;
        }
    }

    public function RetornarTodos()
    {
        return $this->denunciaDAO->RetornarTodos();
    }

    public function RetornaIddenuncia(int $iddenuncia)
    {
        if ($iddenuncia > 0) {
            return $this->denunciaDAO->RetornaIddenuncia($iddenuncia);
        } else {
            return null;
        }
    }

    public function RetornaUsuarioIddenuncia(int $idusuario)
    {
        if ($idusuario > 0) {
            return $this->denunciaDAO->RetornaUsuarioIddenuncia($idusuario);
        } else {
            return null;
        }
    }

    public function RetornarDenunciaIdusuario(int $idusuario)
    {
        if ($idusuario > 0) {
            return $this->denunciaDAO->RetornarDenunciaIdusuario($idusuario);
        } else {
            return null;
        }
    }

    public function RetornarCompletoIddenuncia(int $iddenuncia)
    {
        if ($iddenuncia > 0) {
            return $this->denunciaDAO->RetornarCompletoIddenuncia($iddenuncia);
        } else {
            return null;
        }
    }

    public function RetornarQuantidadeRegistros(string $termo)
    {
        if (strlen($termo) >= 3) {
            return $this->denunciaDAO->RetornarQuantidadeRegistros($termo);
        } else {
            return null;
        }
    }

    public function RetornarPesquisa(string $termo, int $inicio, int $fim)
    {
        if (strlen($termo) >= 3) {
            return $this->denunciaDAO->RetornarPesquisa($termo, $inicio, $fim);
        } else {
            return null;
        }
    }

    public function RetornarTotalPesquisa()
    {
        return $this->denunciaDAO->RetornarTotalPesquisa();
    }

    public function RetornarUltimasDenuncias(int $qnt)
    {
        if ($qnt > 0) {
            return $this->denunciaDAO->RetornarUltimasDenuncias($qnt);
        } else {
            return null;
        }
    }
}
