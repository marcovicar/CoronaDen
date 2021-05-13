<?php

require_once("Denuncia.php");

class Imagem {
    
    private $idimagem;
    private $imagem;
    private $denuncia;
    
    public function __construct() {
        $this->denuncia = new Denuncia();
    }
    
    function getIdimagem() {
        return $this->idimagem;
    }

    function getImagem() {
        return $this->imagem;
    }

    function getDenuncia() {
        return $this->denuncia;
    }

    function setIdimagem($idimagem): void {
        $this->idimagem = $idimagem;
    }

    function setImagem($imagem): void {
        $this->imagem = $imagem;
    }

    function setDenuncia($denuncia): void {
        $this->denuncia = $denuncia;
    }

}