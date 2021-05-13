<?php

if (file_exists("../DAL/ComentarioDAO.php")) {
    require_once ("../DAL/ComentarioDAO.php");
} else if (file_exists("DAL/ComentarioDAO.php")) {
    require_once ("DAL/ComentarioDAO.php");
}

class ComentarioController {

    private $comentarioDAO;

    public function __construct() {
        $this->comentarioDAO = new ComentarioDAO();
    }

    public function Cadastrar(Comentario $comentario) {
        if (strlen($comentario->getMensagem()) <= 500 &&
                $comentario->getDenuncia()->getIddenuncia() > 0 &&
                $comentario->getUsuario()->getIdusuario() > 0) {
            return $this->comentarioDAO->Cadastrar($comentario);
        } else {
            return false;
        }
    }

    public function Remover(int $idcomentario) {
        if ($idcomentario > 0) {
            return $this->comentarioDAO->Remover($idcomentario);
        } else {
            return false;
        }
    }
    
    public function RemoverAdm(int $idcomentario) {
        if ($idcomentario > 0) {
            return $this->comentarioDAO->RemoverAdm($idcomentario);
        } else {
            return false;
        }
    }

    public function RetornarUltimasDenuncias(int $iddenuncia) {
        if ($iddenuncia > 0) {
            return $this->comentarioDAO->RetornarUltimasDenuncias($iddenuncia);
        } else {
            return null;
        }
    }

    public function RetornarTodasDenuncias(int $iddenuncia) {
        if ($iddenuncia > 0) {
            return $this->comentarioDAO->RetornarTodasDenuncias($iddenuncia);
        } else {
            return null;
        }
    }
    
    public function RetornarTodosComentarios() {
        return $this->comentarioDAO->RetornarTodosComentarios();
    }
    
    public function RetornarTodosFiltro(string $termo) {
        if ($termo != "") {
            return $this->comentarioDAO->RetornarTodosFiltro($termo);
        } else {
            return null;
        }
    }

}
