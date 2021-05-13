<?php

require_once ("Banco.php");

class ImagemDAO {

    private $pdo;
    private $debug;

    public function __construct() {
        $this->pdo = new Banco();
    }

    public function CadastrarImagens(array $imagem) {
        try {
            $erros = 0;
            
            $this->pdo->BeginTransaction();

            foreach ($imagem as $i) {
                $sql = "INSERT INTO imagem (imagem, denuncia_iddenuncia) VALUES (:imagem, :iddenuncia)";

                $param = array(
                    ":imagem" => $i->getImagem(),
                    ":iddenuncia" => $i->getDenuncia()->getIddenuncia(),
                );

                if (!$this->pdo->ExecuteNonQuery($sql, $param)) {
                    $erros++;
                }
            }
            
            if ($erros == 0) {
                $this->pdo->Commit();
                return true;
            } else {
                $this->pdo->Rollback();
                return false;
            }
            
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                $this->pdo->Rollback();
                return false;
            }
        }
    }
    
    public function CarregarImagensDenuncia(int $iddenuncia) {
        try {
            $sql = "SELECT idimagem, imagem FROM imagem WHERE denuncia_iddenuncia = :iddenuncia ORDER BY idimagem DESC";
            
            $param = array(
                ":iddenuncia" => $iddenuncia,
            );
            
            $dt = $this->pdo->ExecuteQuery($sql, $param);
            
            $listaImagens = [];
            
            foreach ($dt as $dr) {
                $imagem = new Imagem();
                
                $imagem->setIdimagem($dr["idimagem"]);
                $imagem->setImagem($dr["imagem"]);
                
                $listaImagens[] = $imagem;
            }
            
            return $listaImagens;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                $this->pdo->Rollback();
                return false;
            }
        }
    }
    
    public function VerificarArquivoExiste(int $iddenuncia, int $idimagem) {
        try {
            $sql = "SELECT imagem FROM imagem WHERE denuncia_iddenuncia = :iddenuncia AND idimagem = :idimagem";
            
            $param = array(
                ":iddenuncia" => $iddenuncia,
                ":idimagem" => $idimagem,
            );
            
            $dr = $this->pdo->ExecuteQueryOneRow($sql, $param);
            
            return $dr["imagem"];
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                $this->pdo->Rollback();
                return false;
            }
        }
    }
    
    public function RemoverImagem(int $iddenuncia, int $idimagem) {
        try {
            $sql = "DELETE FROM imagem WHERE denuncia_iddenuncia = :iddenuncia AND idimagem = :idimagem";
            
            $param = array(
                ":iddenuncia" => $iddenuncia,
                ":idimagem" => $idimagem,
            );
            
            return $this->pdo->ExecuteNonQuery($sql, $param);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                $this->pdo->Rollback();
                return false;
            }
        }
    }
    
    public function RetornarImagemDenuncia(int $iddenuncia, int $idusuario) {
        try {
            $sql = "SELECT i.imagem, d.titulo FROM imagem i INNER JOIN denuncia d ON d.iddenuncia = i.denuncia_iddenuncia WHERE d.iddenuncia = :iddenuncia AND d.usuario_idusuario = :idusuario";
            
            $param = array(
                ":iddenuncia" => $iddenuncia,
                ":idusuario" => $idusuario,
            );
            
            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaImagem = [];
            
            foreach ($dt as $dr) {
                $array = array($dr["imagem"], $dr["titulo"]);
                
                $listaImagem[] = $array;
            }
            
            return $listaImagem;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                $this->pdo->Rollback();
                return false;
            }
        }
    }
    
    public function RetornarImagemDenunciaResumida(int $iddenuncia) {
        try {
            $sql = "SELECT imagem FROM imagem WHERE denuncia_iddenuncia = :iddenuncia";
            $param = array(
                ":iddenuncia" => $iddenuncia
            );

            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaImagem = array();

            foreach ($dt as $dr) {
                $array = $dr["imagem"];

                $listaImagem[] = $array;
            }

            return $listaImagem;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

}
