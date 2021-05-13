<?php

class Usuario {

    private $idusuario;
    private $nome;
    private $email;
    private $nascimento;
    private $sexo;
    private $senha;
    private $status;
    private $permissao;
    private $ip;

    function getIdusuario() {
        return $this->idusuario;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getNascimento() {
        return $this->nascimento;
    }

    function getSexo() {
        return $this->sexo;
    }

    function getSenha() {
        return $this->senha;
    }

    function getStatus() {
        return $this->status;
    }

    function getPermissao() {
        return $this->permissao;
    }

    function getIp() {
        return $this->ip;
    }

    function setIdusuario($idusuario): void {
        $this->idusuario = $idusuario;
    }

    function setNome($nome): void {
        $this->nome = $nome;
    }

    function setEmail($email): void {
        $this->email = strtolower($email);
    }

    function setNascimento($nascimento): void {
        $date = str_replace("/", "-", $nascimento);
        $this->nascimento = date("Y-m-d", strtotime($date));
    }

    function setSexo($sexo): void {
        $this->sexo = $sexo;
    }

    function setSenha($senha): void {
        $this->senha = md5($senha);
    }

    function setStatus($status): void {
        $this->status = $status;
    }

    function setPermissao($permissao): void {
        $this->permissao = $permissao;
    }

    function setIp($ip): void {
        $this->ip = $ip;
    }

}
