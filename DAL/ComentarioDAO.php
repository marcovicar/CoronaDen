<?php

require_once ("Banco.php");

class ComentarioDAO {

    private $pdo;
    private $debug;

    public function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }
    
    public function Cadastrar(Comentario $comentario) {
        try {
          $sql = "INSERT INTO comentario (mensagem, data, status, denuncia_iddenuncia, usuario_idusuario, comentario_idcomentario) VALUES (:mensagem, :data, :status, :iddenuncia, :idusuario, :idcomentario)";
          
          $param = array(
              ":mensagem" => $comentario->getMensagem(),
              ":data" => date("Y-m-d H-i-s"),
              ":status" => 1,
              ":iddenuncia" => $comentario->getDenuncia()->getIddenuncia(),
              ":idusuario" => $comentario->getUsuario()->getIdusuario(),
              ":idcomentario" => $comentario->getSubcomentario(),
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
    
    public function Remover(int $idcomentario) {
        try {
          $sql = "UPDATE comentario SET status = 2 WHERE idcomentario = :idcomentario";
          
          $param = array(
              ":idcomentario" => $idcomentario,
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
    
    public function RemoverAdm(int $idcomentario) {
        try {
          $sql = "UPDATE comentario SET status = 3 WHERE idcomentario = :idcomentario";
          
          $param = array(
              ":idcomentario" => $idcomentario,
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
    
    public function RetornarUltimasDenuncias(int $iddenuncia) {
        try {
            $sql = "SELECT c.idcomentario, c.mensagem, c.data, c.comentario_idcomentario, c.usuario_idusuario, u.nome FROM comentario c INNER JOIN usuario u ON u.idusuario = c.usuario_idusuario WHERE c.denuncia_iddenuncia = :iddenuncia AND c.status = 1 ORDER BY c.data DESC LIMIT 15";
            $param = array(
                ":iddenuncia" => $iddenuncia,
            );

            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaComentario = array();

            foreach ($dt as $dr) {
                $comentario = new Comentario();
                
                $comentario->setIdcomentario($dr["idcomentario"]);
                $comentario->setMensagem($dr["mensagem"]);
                $comentario->setData($dr["data"]);
                $comentario->getUsuario()->setIdusuario($dr["usuario_idusuario"]);
                $comentario->getUsuario()->setNome($dr["nome"]);
                $comentario->setSubcomentario($dr["comentario_idcomentario"]);

                $listaComentario[] = $comentario;
            }

            return $listaComentario;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }
    
    public function RetornarTodasDenuncias(int $iddenuncia) {
        try {
            $sql = "SELECT c.idcomentario, c.mensagem, c.data, c.status, c.comentario_idcomentario, u.idusuario, u.nome FROM comentario c INNER JOIN usuario u ON u.idusuario = c.usuario_idusuario WHERE c.denuncia_iddenuncia = :iddenuncia ORDER BY c.data DESC";
            $param = array(
                ":iddenuncia" => $iddenuncia,
            );

            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaComentario = array();

            foreach ($dt as $dr) {
                $comentario = new Comentario();
                
                $comentario->setIdcomentario($dr["idcomentario"]);
                $comentario->setMensagem($dr["mensagem"]);
                $comentario->setData($dr["data"]);
                $comentario->setStatus($dr["status"]);
                $comentario->getUsuario()->setNome($dr["nome"]);
                $comentario->getUsuario()->setIdusuario($dr["idusuario"]);
                $comentario->setSubcomentario($dr["comentario_idcomentario"]);

                $listaComentario[] = $comentario;
            }

            return $listaComentario;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }
    
    public function RetornarTodosComentarios() {
        try {
            $sql = "SELECT c.idcomentario, c.mensagem, c.data, c.status, c.comentario_idcomentario, u.nome FROM comentario c INNER JOIN usuario u ON u.idusuario = c.usuario_idusuario ORDER BY c.data DESC";

            $dt = $this->pdo->ExecuteQuery($sql);
            $listaComentario = array();

            foreach ($dt as $dr) {
                $comentario = new Comentario();
                
                $comentario->setIdcomentario($dr["idcomentario"]);
                $comentario->setMensagem($dr["mensagem"]);
                $comentario->setData($dr["data"]);
                $comentario->setStatus($dr["status"]);
                $comentario->getUsuario()->setNome($dr["nome"]);
                $comentario->setSubcomentario($dr["comentario_idcomentario"]);

                $listaComentario[] = $comentario;
            }

            return $listaComentario;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }
    
    public function RetornarTodosFiltro(string $termo) {
        try {
            $sql = "SELECT c.idcomentario, c.mensagem, c.data, c.status, c.comentario_idcomentario, u.nome FROM comentario c INNER JOIN usuario u ON u.idusuario = c.usuario_idusuario WHERE c.mensagem LIKE :termo ORDER BY c.data DESC";

            $param = array(
                ":termo" => "%{$termo}%",
            );

            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaComentario = array();

            foreach ($dt as $dr) {
                $comentario = new Comentario();
                
                $comentario->setIdcomentario($dr["idcomentario"]);
                $comentario->setMensagem($dr["mensagem"]);
                $comentario->setData($dr["data"]);
                $comentario->setStatus($dr["status"]);
                $comentario->getUsuario()->setNome($dr["nome"]);
                $comentario->setSubcomentario($dr["comentario_idcomentario"]);

                $listaComentario[] = $comentario;
            }

            return $listaComentario;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return null;
            }
        }
    }
    
}