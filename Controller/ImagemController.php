<?php

if (file_exists("../DAL/ImagemDAO.php")) {
    require_once ("../DAL/ImagemDAO.php");
} else if (file_exists("DAL/ImagemDAO.php")) {
    require_once ("DAL/ImagemDAO.php");
}

class ImagemController {

    private $imagemDAO;

    public function __construct() {
        $this->imagemDAO = new ImagemDAO();
    }

    public function CadastrarImagens(array $imagem) {
        if ($imagem != null) {
            return $this->imagemDAO->CadastrarImagens($imagem);
        } else {
            return false;
        }
    }

    public function CarregarImagensDenuncia(int $iddenuncia) {
        if ($iddenuncia > 0) {
            return $this->imagemDAO->CarregarImagensDenuncia($iddenuncia);
        } else {
            return null;
        }
    }

    public function VerificarArquivoExiste(int $iddenuncia, int $idimagem) {
        if ($iddenuncia > 0 && $idimagem > 0) {
            return $this->imagemDAO->VerificarArquivoExiste($iddenuncia, $idimagem);
        } else {
            return null;
        }
    }

    public function RemoverImagem(int $iddenuncia, int $idimagem) {
        if ($iddenuncia > 0 && $idimagem > 0) {
            return $this->imagemDAO->RemoverImagem($iddenuncia, $idimagem);
        } else {
            return false;
        }
    }
    
    public function RetornarImagemDenuncia(int $iddenuncia, int $idusuario) {
        if ($iddenuncia > 0 && $idusuario > 0) {
            return $this->imagemDAO->RetornarImagemDenuncia($iddenuncia, $idusuario);
        } else {
            return null;
        }
    }
    
    public function RetornarImagemDenunciaResumida(int $iddenuncia) {
        if ($iddenuncia > 0) {
            return $this->imagemDAO->RetornarImagemDenunciaResumida($iddenuncia);
        } else {
            return null;
        }
    }

}
