<?php
class DatabaseConnection {
    private $host = 'localhost';
    private $port = '3306'; // Especifique a porta 3306
    private $username = 'root';
    private $password = '';
    private $database = 'prog_web';
    private $connection;

    public function connect() {
        try {
            // Constrói a string de conexão DSN (Data Source Name) com a porta especificada.
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->database}";

            // Cria uma nova instância da classe PDO.
            $this->connection = new PDO($dsn, $this->username, $this->password);

            // Define o modo de tratamento de erros para lançar exceções em caso de erro.
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
        }
    }

    public function disconnect() {
        // Fecha a conexão com o banco de dados.
        $this->connection = null;
    }

    public function getConnection() {
        // Retorna a instância de conexão ativa.
        return $this->connection;
    }
}
?>