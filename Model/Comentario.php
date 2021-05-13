<?php

require_once("Usuario.php");
require_once("Denuncia.php");

class Comentario {

    private $idcomentario;
    private $mensagem;
    private $data;
    private $status;
    private $usuario;
    private $denuncia;
    private $subcomentario;

    public function __construct() {
        $this->usuario = new Usuario();
        $this->denuncia = new Denuncia();
    }

    function getIdcomentario() {
        return $this->idcomentario;
    }

    function getMensagem() {
        return $this->mensagem;
    }

    function getData() {
        return $this->data;
    }

    function getStatus() {
        return $this->status;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getDenuncia() {
        return $this->denuncia;
    }

    function getSubcomentario() {
        return $this->subcomentario;
    }

    function setIdcomentario($idcomentario): void {
        $this->idcomentario = $idcomentario;
    }

    function setMensagem($mensagem): void {
        $this->mensagem = $mensagem;
    }

    function setData($data): void {
        $this->data = $data;
    }

    function setStatus($status): void {
        $this->status = $status;
    }

    function setUsuario_idusuario($usuario): void {
        $this->usuario = $usuario;
    }

    function setDenuncia_idanuncio($denuncia): void {
        $this->denuncia = $denuncia;
    }

    function setSubcomentario($subcomentario): void {
        $this->subcomentario = $subcomentario;
    }

}
