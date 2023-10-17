<?php
class HandleAtendimento {
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
}
?>