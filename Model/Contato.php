<?php

require_once("Usuario.php");

class Contato {

    private $idcontato;
    private $assunto;
    private $mensagem;
    private $status;
    private $usuario;

    public function __construct() {
        $this->usuario = new Usuario();
    }

    function getIdcontato() {
        return $this->idcontato;
    }

    function getAssunto() {
        return $this->assunto;
    }

    function getMensagem() {
        return $this->mensagem;
    }

    function getStatus() {
        return $this->status;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function setIdcontato($idcontato): void {
        $this->idcontato = $idcontato;
    }

    function setAssunto($assunto): void {
        $this->assunto = $assunto;
    }

    function setMensagem($mensagem): void {
        $this->mensagem = $mensagem;
    }
    
    function setStatus($status): void {
        $this->status = $status;
    }

    function setUsuario($usuario): void {
        $this->usuario = $usuario;
    }

}
