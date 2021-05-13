<?php

require_once("Usuario.php");

class Localizacao {

    private $idlocalizacao;
    private $name;
    private $address;
    private $type;
    private $status;
    private $thumb;
    private $usuario;

    public function __construct() {
        $this->usuario = new Usuario();
    }

    function getIdlocalizacao() {
        return $this->idlocalizacao;
    }

    function getName() {
        return $this->name;
    }

    function getAddress() {
        return $this->address;
    }

    function getType() {
        return $this->type;
    }

    function getStatus() {
        return $this->status;
    }

    function getThumb() {
        return $this->thumb;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function setIdlocalizacao($idlocalizacao): void {
        $this->idlocalizacao = $idlocalizacao;
    }

    function setName($name): void {
        $this->name = $name;
    }

    function setAddress($address): void {
        $this->address = $address;
    }

    function setType($type): void {
        $this->type = $type;
    }

    function setStatus($status): void {
        $this->status = $status;
    }

    function setThumb($thumb): void {
        $this->thumb = $thumb;
    }

    function setUsuario($usuario): void {
        $this->usuario = $usuario;
    }

}
