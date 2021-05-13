<?php

require_once("Localizacao.php");
require_once("Usuario.php");

class Denuncia {

    private $iddenuncia;
    private $titulo;
    private $descricao;
    private $status;
    private $localizacao;
    private $usuario;
    private $imagem;

    public function __construct() {
        $this->localizacao = new Localizacao();
        $this->usuario = new Usuario();
    }

    function getIddenuncia() {
        return $this->iddenuncia;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getStatus() {
        return $this->status;
    }

    function getLocalizacao() {
        return $this->localizacao;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getImagem() {
        return $this->imagem;
    }

    function setIddenuncia($iddenuncia): void {
        $this->iddenuncia = $iddenuncia;
    }

    function setTitulo($titulo): void {
        $this->titulo = $titulo;
    }

    function setDescricao($descricao): void {
        $this->descricao = $descricao;
    }

    function setStatus($status): void {
        $this->status = $status;
    }

    function setLocalizacao($localizacao): void {
        $this->localizacao = $localizacao;
    }

    function setUsuario($usuario): void {
        $this->usuario = $usuario;
    }

    function setImagem($imagem): void {
        $this->usuario = $imagem;
    }

}
