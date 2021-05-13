<?php

require_once("Banco.php");

class UsuarioDAO
{

    private $pdo;
    private $debug;

    public function __construct()
    {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(Usuario $usuario)
    {
        try {
            $sql = "INSERT INTO usuario (idusuario, nome, email, nascimento, sexo, senha, status, permissao, ip) VALUES (idusuario, :nome, :email, :nascimento, :sexo, :senha, :status, :permissao, :ip)";

            $param = array(
                ":nome" => $usuario->getNome(),
                ":email" => $usuario->getEmail(),
                ":nascimento" => $usuario->getNascimento(),
                ":sexo" => $usuario->getSexo(),
                ":senha" => $usuario->getSenha(),
                ":status" => $usuario->getStatus(),
                ":permissao" => $usuario->getPermissao(),
                ":ip" => $_SERVER["REMOTE_ADDR"],
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

    public function Alterar(Usuario $usuario)
    {
        try {
            $sql = "UPDATE usuario SET nome = :nome, email = :email, nascimento = :nascimento, sexo = :sexo, status = :status, permissao = :permissao WHERE idusuario = :idusuario";

            $param = array(
                ":nome" => $usuario->getNome(),
                ":email" => $usuario->getEmail(),
                ":nascimento" => $usuario->getNascimento(),
                ":sexo" => $usuario->getSexo(),
                ":status" => $usuario->getStatus(),
                ":permissao" => $usuario->getPermissao(),
                ":idusuario" => $usuario->getIdusuario(),
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

    public function RetornarUsuarioResumido()
    {
        try {
            $sql = "SELECT idusuario, nome FROM usuario ORDER BY idusuario DESC";

            $dt = $this->pdo->ExecuteQuery($sql);
            $listaUsuario = [];

            foreach ($dt as $usu) {
                $usuario = new Usuario();

                $usuario->setIdusuario($usu["idusuario"]);
                $usuario->setNome($usu["nome"]);

                $listaUsuario[] = $usuario;
            }

            return $listaUsuario;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarUsuarios(string $termo)
    {
        try {
            $sql = "SELECT idusuario, nome, email, nascimento, sexo, status, permissao FROM usuario WHERE nome LIKE :termo OR email LIKE :termo1 ORDER BY nome ASC";

            $param = array(
                ":termo" => "%{$termo}%",
                ":termo1" => "%{$termo}%",
            );

            $dataTable = $this->pdo->ExecuteQuery($sql, $param);

            $listaUsuario = [];

            foreach ($dataTable as $resultado) {
                $usuario = new Usuario();

                $usuario->setIdusuario($resultado["idusuario"]);
                $usuario->setNome($resultado["nome"]);
                $usuario->setEmail($resultado["email"]);
                $usuario->setNascimento($resultado["nascimento"]);
                $usuario->setSexo($resultado["sexo"]);
                $usuario->setStatus($resultado["status"]);
                $usuario->setPermissao($resultado["permissao"]);

                $listaUsuario[] = $usuario;
            }

            return $listaUsuario;
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
            $sql = "SELECT idusuario, nome, email, nascimento, sexo, status, permissao FROM usuario ORDER BY nome ASC";

            $dataTable = $this->pdo->ExecuteQuery($sql);

            $listaUsuario = [];

            foreach ($dataTable as $resultado) {
                $usuario = new Usuario();

                $usuario->setIdusuario($resultado["idusuario"]);
                $usuario->setNome($resultado["nome"]);
                $usuario->setEmail($resultado["email"]);
                $usuario->setNascimento($resultado["nascimento"]);
                $usuario->setSexo($resultado["sexo"]);
                $usuario->setStatus($resultado["status"]);
                $usuario->setPermissao($resultado["permissao"]);

                $listaUsuario[] = $usuario;
            }

            return $listaUsuario;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return null;
            }
        }
    }

    public function RetornaIdusuario(int $usuarioIdusuario)
    {
        try {
            $sql = "SELECT nome, email, nascimento, sexo, status, permissao FROM usuario WHERE idusuario = :idusuario";

            $param = array(
                ":idusuario" => $usuarioIdusuario,
            );

            $dt = $this->pdo->ExecuteQueryOneRow($sql, $param);

            if ($dt != null) {
                $usuario = new Usuario();

                $usuario->setNome($dt["nome"]);
                $usuario->setEmail($dt["email"]);
                $usuario->setNascimento($dt["nascimento"]);
                $usuario->setSexo($dt["sexo"]);
                $usuario->setStatus($dt["status"]);
                $usuario->setPermissao($dt["permissao"]);

                return $usuario;
            } else {
                return null;
            }
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return null;
            }
        }
    }

    public function AutenticarUsuario(string $usu, string $senha, int $permissao)
    {
        try {
            if ($permissao == 1) {
                $sql = "SELECT idusuario, nome FROM usuario WHERE status = 1 AND permissao = :permissao AND email = :usuario AND senha = :senha";

                $param = array(
                    ":usuario" => $usu,
                    ":senha" => $senha,
                    ":permissao" => $permissao,
                );
            } else {
                $sql = "SELECT idusuario, nome FROM usuario WHERE status = 1 AND permissao = 2 AND email = :usuario AND senha = :senha";

                $param = array(
                    ":usuario" => $usu,
                    ":senha" => $senha,
                );
            }

            $dt = $this->pdo->ExecuteQueryOneRow($sql, $param);

            if ($dt != null) {
                $usuario = new Usuario();

                $usuario->setIdusuario($dt["idusuario"]);
                $usuario->setNome($dt["nome"]);

                return $usuario;
            } else {
                return null;
            }
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return null;
            }
        }
    }

    public function AlterarSenha(string $senha, int $idusuario)
    {
        try {
            $sql = "UPDATE usuario SET senha = :senha WHERE idusuario = :idusuario";

            $param = array(
                ":senha" => md5($senha),
                ":idusuario" => $idusuario,
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

    public function VerificarEmailExiste(string $email)
    {
        try {
            $sql = "SELECT email FROM usuario WHERE email = :email";

            $param = array(
                ":email" => $email,
            );

            $dr = $this->pdo->ExecuteQueryOneRow($sql, $param);

            if (!empty($dr)) {
                return 1;
            } else {
                return -1;
            }
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            } else {
                return null;
            }
        }
    }
}
