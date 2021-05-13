<?php

require_once("Banco.php");

if (file_exists("../Model/Localizacao.php")) {
    require_once("../Model/Localizacao.php");
} else if (file_exists("Model/Localizacao.php")) {
    require_once("Model/Localizacao.php");
}

class LocalizacaoDAO
{

    private $pdo;
    private $debug;

    public function __construct()
    {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(Localizacao $localizacao)
    {
        try {
            $sql = "INSERT INTO localizacao (name, address, type, status, thumb, usuario_idusuario) VALUES (:name, :address, :type, :status, :thumb, :idusuario)";

            $param = array(
                ":name" => $localizacao->getName(),
                ":address" => $localizacao->getAddress(),
                ":type" => $localizacao->getType(),
                ":status" => $localizacao->getStatus(),
                ":thumb" => $localizacao->getThumb(),
                ":idusuario" => $localizacao->getUsuario()->getIdusuario(),
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

    public function Alterar(Localizacao $localizacao)
    {
        try {
            $sql = "UPDATE localizacao SET name = :name, address = :address, type = :type, status = :status WHERE idlocalizacao = :idlocalizacao";

            $param = array(
                ":idlocalizacao" => $localizacao->getIdlocalizacao(),
                ":name" => $localizacao->getName(),
                ":address" => $localizacao->getAddress(),
                ":type" => $localizacao->getType(),
                ":status" => $localizacao->getStatus(),
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

    public function Remover(int $idlocalizacao)
    {
        try {
            $sql = "UPDATE localizacao SET status = 2 WHERE idlocalizacao = :idlocalizacao";

            $param = array(
                ":idlocalizacao" => $idlocalizacao,
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

    public function AlterarImagem(string $thumb, int $idlocalizacao)
    {
        try {
            $sql = "UPDATE localizacao SET thumb = :thumb WHERE idlocalizacao = :idlocalizacao";

            $param = array(
                ":thumb" => $thumb,
                ":idlocalizacao" => $idlocalizacao,
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

    public function RetornarLocalizacaoResumido()
    {
        try {
            $sql = "SELECT idlocalizacao, name FROM localizacao WHERE usuario_idusuario = '" . $_SESSION['idusuario'] . "' AND status = 1 ORDER BY idlocalizacao DESC";

            $dt = $this->pdo->ExecuteQuery($sql);
            $listaLocalizacao = [];

            foreach ($dt as $loc) {
                $localizacao = new Localizacao();

                $localizacao->setIdlocalizacao($loc["idlocalizacao"]);
                $localizacao->setName($loc["name"]);

                $listaLocalizacao[] = $localizacao;
            }

            return $listaLocalizacao;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarLocalizacaoResumidoAdm()
    {
        try {
            $sql = "SELECT idlocalizacao, name FROM localizacao WHERE status = 1 ORDER BY idlocalizacao DESC";

            $dt = $this->pdo->ExecuteQuery($sql);
            $listaLocalizacao = [];

            foreach ($dt as $loc) {
                $localizacao = new Localizacao();

                $localizacao->setIdlocalizacao($loc["idlocalizacao"]);
                $localizacao->setName($loc["name"]);

                $listaLocalizacao[] = $localizacao;
            }

            return $listaLocalizacao;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarTodosFiltro(string $termo)
    {
        try {
            $sql = "SELECT l.idlocalizacao, l.name, l.address, l.type, l.status, l.thumb, u.idusuario, u.nome FROM localizacao as l INNER JOIN usuario as u ON l.usuario_idusuario = u.idusuario WHERE (name LIKE :termo OR address LIKE :termo1) AND l.status = 1 ORDER BY idlocalizacao DESC";

            $param = array(
                ":termo" => "%{$termo}%",
                ":termo1" => "%{$termo}%",
            );

            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaLocalizacaoResumido = [];

            foreach ($dt as $dr) {
                $localizacao = new Localizacao();

                $localizacao->setIdlocalizacao($dr["idlocalizacao"]);
                $localizacao->getUsuario()->setIdusuario($dr["idusuario"]);
                $localizacao->getUsuario()->setNome($dr["nome"]);
                $localizacao->setName($dr["name"]);
                $localizacao->setAddress($dr["address"]);
                $localizacao->setType($dr["type"]);
                $localizacao->setStatus($dr["status"]);
                $localizacao->setThumb($dr["thumb"]);

                $listaLocalizacaoResumido[] = $localizacao;
            }

            return $listaLocalizacaoResumido;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return null;
            }
        }
    }

    public function RetornarTodos()
    {
        try {
            $sql = "SELECT idlocalizacao, name, address, type, status, thumb FROM localizacao WHERE usuario_idusuario = '" . $_SESSION['idusuario'] . "' AND status = 1 ORDER BY idlocalizacao DESC";

            $dt = $this->pdo->ExecuteQuery($sql);
            $listaLocalizacaoResumido = [];

            foreach ($dt as $dr) {
                $localizacao = new Localizacao();

                $localizacao->setIdlocalizacao($dr["idlocalizacao"]);
                $localizacao->setName($dr["name"]);
                $localizacao->setAddress($dr["address"]);
                $localizacao->setType($dr["type"]);
                $localizacao->setStatus($dr["status"]);
                $localizacao->setThumb($dr["thumb"]);

                $listaLocalizacaoResumido[] = $localizacao;
            }

            return $listaLocalizacaoResumido;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return null;
            }
        }
    }

    public function ListarTodos()
    {
        try {
            $sql = "SELECT l.idlocalizacao, l.name, l.address, l.type, l.status, l.thumb, u.idusuario, u.nome FROM localizacao AS l INNER JOIN usuario AS u ON l.usuario_idusuario = u.idusuario ORDER BY idlocalizacao DESC";

            $dt = $this->pdo->ExecuteQuery($sql);
            $listaLocalizacaoResumido = [];

            foreach ($dt as $dr) {
                $localizacao = new Localizacao();

                $localizacao->setIdlocalizacao($dr["idlocalizacao"]);
                $localizacao->setName($dr["name"]);
                $localizacao->setAddress($dr["address"]);
                $localizacao->setType($dr["type"]);
                $localizacao->setStatus($dr["status"]);
                $localizacao->setThumb($dr["thumb"]);
                $localizacao->getUsuario()->setIdusuario($dr["idusuario"]);
                $localizacao->getUsuario()->setNome($dr["nome"]);

                $listaLocalizacaoResumido[] = $localizacao;
            }

            return $listaLocalizacaoResumido;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return null;
            }
        }
    }

    public function ListarTodosAdm()
    {
        try {
            $sql = "SELECT l.idlocalizacao, l.name, l.address, l.type, l.status, l.thumb, u.nome FROM localizacao as l INNER JOIN usuario as u ON l.usuario_idusuario = u.idusuario WHERE l.status = 1 ORDER BY idlocalizacao DESC";

            $dt = $this->pdo->ExecuteQuery($sql);
            $listaLocalizacaoResumido = [];

            foreach ($dt as $dr) {
                $localizacao = new Localizacao();

                $localizacao->setIdlocalizacao($dr["idlocalizacao"]);
                $localizacao->setName($dr["name"]);
                $localizacao->setAddress($dr["address"]);
                $localizacao->setType($dr["type"]);
                $localizacao->setStatus($dr["status"]);
                $localizacao->setThumb($dr["thumb"]);
                $localizacao->getUsuario()->setNome($dr["nome"]);

                $listaLocalizacaoResumido[] = $localizacao;
            }

            return $listaLocalizacaoResumido;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return null;
            }
        }
    }

    public function RetornarIdlocalizacao(int $idlocalizacao)
    {
        try {
            $sql = "SELECT name, address, type, status FROM localizacao WHERE idlocalizacao = :idlocalizacao";

            $param = array(
                ":idlocalizacao" => $idlocalizacao,
            );

            $dt = $this->pdo->ExecuteQueryOneRow($sql, $param);

            $localizacao = new Localizacao();

            $localizacao->setName($dt["name"]);
            $localizacao->setAddress($dt["address"]);
            $localizacao->setType($dt["type"]);
            $localizacao->setStatus($dt["status"]);

            return $localizacao;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return false;
            }
        }
    }

    public function RetornarUltimasLocalizacoes(int $qnt)
    {
        try {
            $sql = "SELECT idlocalizacao, name, thumb FROM localizacao WHERE status = 1 ORDER BY idlocalizacao DESC LIMIT :limit";

            $param = array(
                ":limit" => $qnt,
            );

            $dt = $this->pdo->ExecuteQuery($sql, $param);

            $listaLocalizacaoResumido = [];

            foreach ($dt as $dr) {
                $localizacao = new Localizacao();

                $localizacao->setIdlocalizacao($dr["idlocalizacao"]);
                $localizacao->setName($dr["name"]);
                $localizacao->setThumb($dr["thumb"]);

                $listaLocalizacaoResumido[] = $localizacao;
            }

            return $listaLocalizacaoResumido;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return null;
            }
        }
    }
}
