<?php

if (file_exists("../DAL/ContatoDAO.php")) {
    require_once ("../DAL/ContatoDAO.php");
} else if (file_exists("DAL/ContatoDAO.php")) {
    require_once ("DAL/ContatoDAO.php");
}

Class ContatoController {

    private $contatoDAO;

    public function __construct() {
        $this->contatoDAO = new ContatoDAO();
    }

    public function Cadastrar(Contato $contato) {
        if (strlen($contato->getAssunto()) >= 5 &&
                strlen($contato->getMensagem()) >= 10 && strlen($contato->getMensagem()) <= 500 &&
                $contato->getStatus() >= 1 && $contato->getStatus() <= 2 &&
                $contato->getUsuario()->getIdusuario() > 0) {
            return $this->contatoDAO->Cadastrar($contato);
        } else {
            return false;
        }
    }
    
    public function Remover(int $idcontato) {
        if ($idcontato > 0) {
            return $this->contatoDAO->Remover($idcontato);
        } else {
            return false;
        }
    }
    
    public function RetornaContatoCompleto() {
        return $this->contatoDAO->RetornaContatoCompleto();
    }
}
