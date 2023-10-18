<?php
class AtendimentoDAO {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function criarAtendimento(Atendimento $atendimento) {
        $senha = $atendimento->getSenha();
        $tipo = $atendimento->getTipo();

        $query = "INSERT INTO atendimento (senha, tipo) VALUES (?, ?)";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$senha, $tipo]);
    }

    public function buscarAtendimento($id) {
        $query = "SELECT * FROM atendimento WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Atendimento($row['id'], $row['senha'], $row['tipo']);
        }

        return null;
    }

    public function atualizarAtendimento(Atendimento $atendimento) {
        $id = $atendimento->getId();
        $senha = $atendimento->getSenha();
        $tipo = $atendimento->getTipo();

        $query = "UPDATE atendimento SET senha = ?, tipo = ? WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$senha, $tipo, $id]);
    }

    public function excluirAtendimento($id) {
        $query = "DELETE FROM atendimento WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$id]);
    }

    public function buscarTodosAtendimentos() {
        $query = "SELECT * FROM atendimento";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $atendimentos = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $atendimentos[] = new Atendimento($row['id'], $row['senha'], $row['tipo']);
        }

        return $atendimentos;
    }

    public function gerarSenhaNormal() {
        $query = "SELECT MAX(id) as max_id FROM atendimento";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $ultimoId = $row['max_id'];

        $novoId = $ultimoId + 1;

        $query = "INSERT INTO atendimento (id, senha, tipo) VALUES (?, ?, 'Normal')";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$novoId, 0]);

        return new Atendimento($novoId, 0, 'Normal');
    }

    public function gerarSenhaPrioritario() {
        $query = "SELECT MAX(senha) as max_senha FROM atendimento WHERE tipo = 'Prioritário'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $maxSenha = $row['max_senha'];

        $novaSenha = $maxSenha + 1;

        $query = "INSERT INTO atendimento (senha, tipo) VALUES (?, 'Prioritário')";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$novaSenha]);

        $query = "SELECT id FROM atendimento WHERE senha = ? AND tipo = 'Prioritário'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$novaSenha]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $novoId = $row['id'];

        return new Atendimento($novoId, $novaSenha, 'Prioritário');
    }

    public function atendimentoSenha() {
        $query = "SELECT * FROM atendimento WHERE tipo = 'Prioritário' ORDER BY senha ASC LIMIT 1";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $atendimento = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$atendimento) {
            $query = "SELECT * FROM atendimento WHERE tipo = 'Normal' ORDER BY senha ASC LIMIT 1";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $atendimento = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        if ($atendimento) {
            $senhaId = $atendimento['id'];

            $query = "DELETE FROM atendimento WHERE id = ?";
            $stmt = $this->connection->prepare($query);
            $stmt->execute([$senhaId]);

            return new Atendimento($senhaId, $atendimento['senha'], $atendimento['tipo']);
        } else {
            return null;
        }
    }

    public function retornaSenhas() {
        $senhas = array();

        $query = "SELECT * FROM atendimento";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $senhas[] = new Atendimento($row['id'], $row['senha'], $row['tipo']);
        }

        return $senhas;
    }
}
?>
