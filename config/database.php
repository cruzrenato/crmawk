<?php
/**
 * Configuração do Banco de Dados - PDO MySQL
 */

class Database {
    private static $instance = null;
    private $connection;
    
    // Configurações do banco de dados
    private $host = 'localhost';
    private $dbname = 'u784428213_base';
    private $username = 'u784428213_rehz';
    private $password = 'H/b9WzMpG';
    private $charset = 'utf8mb4';
    
    private function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ];
            
            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
            
        } catch (PDOException $e) {
            die("Erro de conexão com o banco de dados: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    /**
     * Executa uma query com prepared statements
     */
    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die("Erro na query: " . $e->getMessage() . "<br>SQL: " . $sql);
        }
    }
    
    /**
     * Executa uma query e retorna um único valor
     */
    public function fetchValue($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchColumn();
    }
    
    /**
     * Executa uma query e retorna uma única linha
     */
    public function fetchRow($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }
    
    /**
     * Executa uma query e retorna todas as linhas
     */
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    /**
     * Retorna o último ID inserido
     */
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }
    
    /**
     * Inicia uma transação
     */
    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }
    
    /**
     * Confirma uma transação
     */
    public function commit() {
        return $this->connection->commit();
    }
    
    /**
     * Desfaz uma transação
     */
    public function rollBack() {
        return $this->connection->rollBack();
    }
    
    /**
     * Verifica se uma tabela existe
     */
    public function tableExists($tableName) {
        $sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = ?";
        $result = $this->fetchValue($sql, [$tableName]);
        return !empty($result);
    }
}

// Função helper para obter a conexão
function db() {
    return Database::getInstance()->getConnection();
}

// Função helper para executar queries
function db_query($sql, $params = []) {
    return Database::getInstance()->query($sql, $params);
}

// Função helper para fetchAll
function db_fetch_all($sql, $params = []) {
    return Database::getInstance()->fetchAll($sql, $params);
}

// Função helper para fetchRow
function db_fetch_row($sql, $params = []) {
    return Database::getInstance()->fetchRow($sql, $params);
}

// Função helper para fetchValue
function db_fetch_value($sql, $params = []) {
    return Database::getInstance()->fetchValue($sql, $params);
}

// Função helper para lastInsertId
function db_last_insert_id() {
    return Database::getInstance()->lastInsertId();
}