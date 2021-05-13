<?php

class DenunciaConsulta
{

    private $iddenuncia;
    private $titulo;
    private $descricao;
    private $status;
    private $name;
    private $address;
    private $imagem;

    function getIddenuncia()
    {
        return $this->iddenuncia;
    }

    function getTitulo()
    {
        return $this->titulo;
    }

    function getDescricao()
    {
        return $this->descricao;
    }

    function getStatus()
    {
        return $this->status;
    }

    function getName()
    {
        return $this->name;
    }

    function getAddress()
    {
        return $this->address;
    }

    function getImagem()
    {
        return $this->imagem;
    }

    function setIddenuncia($iddenuncia): void
    {
        $this->iddenuncia = $iddenuncia;
    }

    function setTitulo($titulo): void
    {
        $this->titulo = $titulo;
    }

    function setDescricao($descricao): void
    {
        $this->descricao = $descricao;
    }

    function setStatus($status): void
    {
        $this->status = $status;
    }

    function setName($name): void
    {
        $this->name = $name;
    }

    function setAddress($address): void
    {
        $this->address = $address;
    }

    function setImagem($imagem): void
    {
        $this->imagem = $imagem;
    }
}
