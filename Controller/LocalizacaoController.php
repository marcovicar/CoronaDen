<?php

if (file_exists("../DAL/LocalizacaoDAO.php")) {
    require_once("../DAL/LocalizacaoDAO.php");
} else if (file_exists("DAL/LocalizacaoDAO.php")) {
    require_once("DAL/LocalizacaoDAO.php");
}

class LocalizacaoController
{

    private $localizacaoDAO;

    public function __construct()
    {
        $this->localizacaoDAO = new LocalizacaoDAO();
    }

    public function Cadastrar(Localizacao $localizacao)
    {
        if (
            strlen($localizacao->getName()) > 5 &&
            strlen($localizacao->getAddress()) > 5 &&
            $localizacao->getType() >= 1 && $localizacao->getType() <= 3 &&
            $localizacao->getStatus() >= 1 && $localizacao->getStatus() <= 2 &&
            $localizacao->getThumb() != "" &&
            $localizacao->getUsuario()->getIdusuario() > 0
        ) {
            return $this->localizacaoDAO->Cadastrar($localizacao);
        } else {
            return false;
        }
    }

    public function Remover(int $idlocalizacao)
    {
        return $this->localizacaoDAO->Remover($idlocalizacao);
    }

    public function Alterar(Localizacao $localizacao)
    {
        if (
            $localizacao->getIdlocalizacao() > 0 &&
            strlen($localizacao->getName()) > 5 &&
            strlen($localizacao->getAddress()) > 5 &&
            $localizacao->getType() >= 1 && $localizacao->getType() <= 3
        ) {
            return $this->localizacaoDAO->Alterar($localizacao);
        } else {
            return false;
        }
    }

    public function AlterarImagem(string $thumb, int $idlocalizacao)
    {
        if (trim(strlen($thumb)) > 0 && $idlocalizacao > 0) {
            return $this->localizacaoDAO->AlterarImagem($thumb, $idlocalizacao);
        } else {
            return false;
        }
    }

    public function RetornarLocalizacaoResumido()
    {
        return $this->localizacaoDAO->RetornarLocalizacaoResumido();
    }

    public function RetornarLocalizacaoResumidoAdm()
    {
        return $this->localizacaoDAO->RetornarLocalizacaoResumidoAdm();
    }

    public function RetornarTodosFiltro(string $termo)
    {
        if ($termo != "") {
            return $this->localizacaoDAO->RetornarTodosFiltro($termo);
        } else {
            return null;
        }
    }

    public function RetornarTodos()
    {
        return $this->localizacaoDAO->RetornarTodos();
    }

    public function ListarTodos()
    {
        return $this->localizacaoDAO->ListarTodos();
    }

    public function ListarTodosAdm()
    {
        return $this->localizacaoDAO->ListarTodos();
    }

    public function RetornarIdlocalizacao(int $idlocalizacao)
    {
        if ($idlocalizacao > 0) {
            return $this->localizacaoDAO->RetornarIdlocalizacao($idlocalizacao);
        } else {
            return null;
        }
    }

    public function RetornarUltimasLocalizacoes(int $qnt)
    {
        if ($qnt > 0) {
            return $this->localizacaoDAO->RetornarUltimasLocalizacoes($qnt);
        } else {
            return null;
        }
    }
}
