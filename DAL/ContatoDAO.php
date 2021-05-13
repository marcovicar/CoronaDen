<?php

require_once ("Banco.php");

class ContatoDAO {

    private $pdo;
    private $debug;

    public function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }
    
    public function Cadastrar(Contato $contato) {
        try {
          $sql = "INSERT INTO contato (assunto, mensagem, status, usuario_idusuario) VALUES (:assunto, :mensagem, :status, :idusuario)";
          
          $param = array(
              ":assunto" => $contato->getAssunto(),
              ":mensagem" => $contato->getMensagem(),
              ":status" => $contato->getStatus(),
              ":idusuario" => $contato->getUsuario()->getIdusuario(),
          );
          
          return $this->pdo->ExecuteNonQuery($sql, $param);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return false;
            }
        }
    }
    
    public function Remover(int $idcontato) {
        try {
          $sql = "UPDATE contato SET status = 2 WHERE idcontato = :idcontato";
          
          $param = array(
              ":idcontato" => $idcontato,
          );
          
          return $this->pdo->ExecuteNonQuery($sql, $param);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return false;
            }
        }
    }
    
    public function RetornaContatoCompleto() {
        try {
            $sql = "SELECT c.idcontato, c.assunto, c.mensagem, c.status, u.nome, u.email FROM contato AS c INNER JOIN usuario AS u ON c.usuario_idusuario = u.idusuario ORDER BY idcontato DESC";
            
            $dt = $this->pdo->ExecuteQuery($sql);
            $listaContato = [];

            foreach ($dt as $dr) {
                $contato = new Contato();
                
                $contato->setIdcontato($dr["idcontato"]);
                $contato->setAssunto($dr["assunto"]);
                $contato->setMensagem($dr["mensagem"]);
                $contato->setStatus($dr["status"]);
                $contato->getUsuario()->setNome($dr["nome"]);
                $contato->getUsuario()->setEmail($dr["email"]);

                $listaContato[] = $contato;
            }
            
            return $listaContato;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return null;
            }
        }
    }
    
}