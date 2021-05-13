<?php

require_once("Banco.php");

class DenunciaDAO
{

    private $pdo;
    private $debug;

    public function __construct()
    {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(Denuncia $denuncia)
    {
        try {
            $sql = "INSERT denuncia (titulo, descricao, status, localizacao_idlocalizacao, usuario_idusuario) VALUES (:titulo, :descricao, :status, :idlocalizacao, :idusuario)";

            $param = array(
                ":titulo" => $denuncia->getTitulo(),
                ":descricao" => $denuncia->getDescricao(),
                ":status" => $denuncia->getStatus(),
                ":idlocalizacao" => $denuncia->getLocalizacao()->getIdlocalizacao(),
                ":idusuario" => $denuncia->getUsuario()->getIdusuario(),
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

    public function Alterar(Denuncia $denuncia)
    {
        try {
            $sql = "UPDATE denuncia SET titulo = :titulo, descricao = :descricao, status = :status, localizacao_idlocalizacao = :idlocalizacao WHERE iddenuncia = :iddenuncia";

            $param = array(
                ":iddenuncia" => $denuncia->getIddenuncia(),
                ":titulo" => $denuncia->getTitulo(),
                ":descricao" => $denuncia->getDescricao(),
                ":status" => $denuncia->getStatus(),
                ":idlocalizacao" => $denuncia->getLocalizacao()->getIdlocalizacao()
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

    public function Remover(int $iddenuncia)
    {
        try {
            $sql = "UPDATE denuncia SET status = 2 WHERE iddenuncia = :iddenuncia";

            $param = array(
                ":iddenuncia" => $iddenuncia,
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

    public function AlterarResumido(Denuncia $denuncia)
    {
        try {
            $sql = "UPDATE denuncia SET titulo = :titulo, descricao = :descricao WHERE iddenuncia = :iddenuncia AND usuario_idusuario = :idusuario";

            $param = array(
                ":iddenuncia" => $denuncia->getIddenuncia(),
                ":titulo" => $denuncia->getTitulo(),
                ":descricao" => $denuncia->getDescricao(),
                ":idusuario" => $denuncia->getUsuario()->getIdusuario(),
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

    public function RetornarTodosFiltro(string $termo)
    {
        try {
            $sql = "SELECT d.iddenuncia, d.titulo, d.descricao, l.name, u.nome, d.status FROM usuario as u INNER JOIN denuncia as d ON u.idusuario = d.usuario_idusuario INNER JOIN localizacao as l ON d.localizacao_idlocalizacao = l.idlocalizacao WHERE d.titulo LIKE :termo OR d.descricao LIKE :termo1 OR l.name LIKE :termo2 ORDER BY d.iddenuncia DESC";

            $param = array(
                ":termo" => "%{$termo}%",
                ":termo1" => "%{$termo}%",
                ":termo2" => "%{$termo}%",
            );

            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaDenunciaResumido = [];

            foreach ($dt as $dr) {
                $denuncia = new Denuncia();

                $denuncia->setIddenuncia($dr["iddenuncia"]);
                $denuncia->setTitulo($dr["titulo"]);
                $denuncia->setDescricao($dr["descricao"]);
                $denuncia->getLocalizacao()->setName($dr["name"]);
                $denuncia->getUsuario()->setNome($dr["nome"]);
                $denuncia->setStatus($dr["status"]);

                $listaDenunciaResumido[] = $denuncia;
            }

            return $listaDenunciaResumido;
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
            $sql = "SELECT d.iddenuncia, d.titulo, d.descricao, l.name, u.nome, d.status FROM usuario as u INNER JOIN denuncia as d ON u.idusuario = d.usuario_idusuario INNER JOIN localizacao as l ON d.localizacao_idlocalizacao = l.idlocalizacao ORDER BY d.iddenuncia DESC";

            $dt = $this->pdo->ExecuteQuery($sql);
            $listaDenunciaResumido = [];

            foreach ($dt as $dr) {
                $denuncia = new Denuncia();

                $denuncia->setIddenuncia($dr["iddenuncia"]);
                $denuncia->setTitulo($dr["titulo"]);
                $denuncia->setDescricao($dr["descricao"]);
                $denuncia->getLocalizacao()->setName($dr["name"]);
                $denuncia->getUsuario()->setNome($dr["nome"]);
                $denuncia->setStatus($dr["status"]);

                $listaDenunciaResumido[] = $denuncia;
            }

            return $listaDenunciaResumido;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return null;
            }
        }
    }

    public function RetornaIddenuncia(int $iddenuncia)
    {
        try {
            $sql = "SELECT d.iddenuncia, d.titulo, d.descricao, d.status, l.idlocalizacao, l.name FROM denuncia as d INNER JOIN localizacao as l ON d.localizacao_idlocalizacao = l.idlocalizacao WHERE d.iddenuncia = :iddenuncia";

            $param = array(
                ":iddenuncia" => $iddenuncia,
            );

            $dt = $this->pdo->ExecuteQueryOneRow($sql, $param);

            $denuncia = new Denuncia();

            $denuncia->setIddenuncia($dt["iddenuncia"]);
            $denuncia->setTitulo($dt["titulo"]);
            $denuncia->setDescricao($dt["descricao"]);
            $denuncia->getLocalizacao()->setIdlocalizacao($dt["idlocalizacao"]);
            $denuncia->getLocalizacao()->setName($dt["name"]);
            $denuncia->setStatus($dt["status"]);

            return $denuncia;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return null;
            }
        }
    }

    public function RetornarDenunciaIdusuario(int $idusuario)
    {
        try {
            $sql = "SELECT d.iddenuncia, d.titulo, d.descricao, d.status, l.name, l.address, ( SELECT imagem FROM imagem WHERE denuncia_iddenuncia = d.iddenuncia ORDER BY idimagem ASC LIMIT 1 ) as imagem FROM denuncia d INNER JOIN localizacao l ON d.localizacao_idlocalizacao = l.idlocalizacao INNER JOIN usuario u ON u.idusuario = d.usuario_idusuario WHERE d.usuario_idusuario = :idusuario AND d.status = 1 ORDER BY d.iddenuncia DESC";

            $param = array(
                ":idusuario" => $idusuario,
            );

            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaDenuncia = [];

            foreach ($dt as $dr) {
                $denunciaConsulta = new DenunciaConsulta();

                $denunciaConsulta->setIddenuncia($dr["iddenuncia"]);
                $denunciaConsulta->setTitulo($dr["titulo"]);
                $denunciaConsulta->setDescricao($dr["descricao"]);
                $denunciaConsulta->setStatus($dr["status"]);
                $denunciaConsulta->setName($dr["name"]);
                $denunciaConsulta->setAddress($dr["address"]);
                $denunciaConsulta->setImagem($dr["imagem"]);

                $listaDenuncia[] = $denunciaConsulta;
            }

            return $listaDenuncia;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return null;
            }
        }
    }

    public function RetornarCompletoIddenuncia(int $iddenuncia)
    {
        try {
            $sql = "SELECT d.iddenuncia, d.titulo, d.descricao, d.status, l.name, l.address, u.idusuario, u.nome "
                . "FROM localizacao as l "
                . "INNER JOIN denuncia as d "
                . "ON d.localizacao_idlocalizacao = l.idlocalizacao "
                . "INNER JOIN usuario as u "
                . "ON d.usuario_idusuario = u.idusuario "
                . "WHERE d.iddenuncia = :iddenuncia";

            $param = array(
                ":iddenuncia" => $iddenuncia,
            );

            $dr = $this->pdo->ExecuteQueryOneRow($sql, $param);

            $denuncia = new Denuncia();

            $denuncia->setIddenuncia($dr["iddenuncia"]);
            $denuncia->setTitulo($dr["titulo"]);
            $denuncia->setDescricao($dr["descricao"]);
            $denuncia->setStatus($dr["status"]);
            $denuncia->getLocalizacao()->setName($dr["name"]);
            $denuncia->getLocalizacao()->setAddress($dr["address"]);
            $denuncia->getUsuario()->setNome($dr["nome"]);
            $denuncia->getUsuario()->setIdusuario($dr["idusuario"]);

            return $denuncia;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return null;
            }
        }
    }

    public function RetornarQuantidadeRegistros(string $termo)
    {
        try {
            $sql = "SELECT count(d.iddenuncia) as total FROM denuncia d INNER JOIN localizacao l ON d.localizacao_idlocalizacao = l.idlocalizacao WHERE (titulo LIKE :termo OR descricao LIKE :termo1  OR l.name LIKE :termo2 OR l.address LIKE :termo3) AND d.status = 1";

            $param = array(
                ":termo" => "%{$termo}%",
                ":termo1" => "%{$termo}%",
                ":termo2" => "%{$termo}%",
                ":termo3" => "%{$termo}%",
            );

            $dr = $this->pdo->ExecuteQueryOneRow($sql, $param);

            if ($dr["total"] != null) {
                return $dr["total"];
            } else {
                return 0;
            }
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return null;
            }
        }
    }

    public function RetornarPesquisa(string $termo, int $inicio, int $fim)
    {
        try {
            $sql = "SELECT d.iddenuncia, d.titulo, d.descricao, l.name, l.address, ( SELECT imagem FROM imagem WHERE denuncia_iddenuncia = d.iddenuncia ORDER BY idimagem ASC LIMIT 1 ) as imagem FROM denuncia d INNER JOIN localizacao l ON d.localizacao_idlocalizacao = l.idlocalizacao WHERE (d.titulo LIKE :termo OR d.descricao LIKE :termo1 OR l.name LIKE :termo2 OR l.address LIKE :termo3) AND d.status = 1 LIMIT :inicio, :fim";

            $param = array(
                ":termo" => "%{$termo}%",
                ":termo1" => "%{$termo}%",
                ":termo2" => "%{$termo}%",
                ":termo3" => "%{$termo}%",
                ":inicio" => $inicio,
                ":fim" => $fim,
            );

            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaDenuncia = [];

            foreach ($dt as $dr) {
                $denunciaConsulta = new DenunciaConsulta();

                $denunciaConsulta->setIddenuncia($dr["iddenuncia"]);
                $denunciaConsulta->setTitulo($dr["titulo"]);
                $denunciaConsulta->setDescricao($dr["descricao"]);
                $denunciaConsulta->setName($dr["name"]);
                $denunciaConsulta->setAddress($dr["address"]);
                $denunciaConsulta->setImagem($dr["imagem"]);

                $listaDenuncia[] = $denunciaConsulta;
            }

            return $listaDenuncia;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return null;
            }
        }
    }

    public function RetornarTotalPesquisa()
    {
        try {
            $sql = "SELECT d.iddenuncia, d.titulo, d.descricao, l.name, l.address, ( SELECT imagem FROM imagem WHERE denuncia_iddenuncia = d.iddenuncia ORDER BY idimagem ASC LIMIT 1 ) as imagem FROM denuncia d INNER JOIN localizacao l ON d.localizacao_idlocalizacao = l.idlocalizacao WHERE d.status = 1 ORDER BY d.iddenuncia DESC";

            $dt = $this->pdo->ExecuteQuery($sql);
            $listaDenuncia = [];

            foreach ($dt as $dr) {
                $denunciaConsulta = new DenunciaConsulta();

                $denunciaConsulta->setIddenuncia($dr["iddenuncia"]);
                $denunciaConsulta->setTitulo($dr["titulo"]);
                $denunciaConsulta->setDescricao($dr["descricao"]);
                $denunciaConsulta->setName($dr["name"]);
                $denunciaConsulta->setAddress($dr["address"]);
                $denunciaConsulta->setImagem($dr["imagem"]);

                $listaDenuncia[] = $denunciaConsulta;
            }

            return $listaDenuncia;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return null;
            }
        }
    }

    public function RetornarUltimasDenuncias(int $qnt)
    {
        try {
            $sql = "SELECT d.iddenuncia, d.titulo, i.imagem FROM denuncia d INNER JOIN imagem i ON d.iddenuncia = i.denuncia_iddenuncia WHERE d.status = 1 GROUP BY d.iddenuncia ORDER BY d.iddenuncia DESC LIMIT :limit";

            $param = array(
                ":limit" => $qnt,
            );

            $dt = $this->pdo->ExecuteQuery($sql, $param);

            $listaDenuncia = [];

            foreach ($dt as $dr) {
                $denunciaConsulta = new DenunciaConsulta();

                $denunciaConsulta->setIddenuncia($dr["iddenuncia"]);
                $denunciaConsulta->setTitulo($dr["titulo"]);
                $denunciaConsulta->setImagem($dr["imagem"]);

                $listaDenuncia[] = $denunciaConsulta;
            }

            return $listaDenuncia;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return null;
            }
        }
    }
}
