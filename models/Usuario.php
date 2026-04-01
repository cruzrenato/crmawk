<?php
/**
 * Modelo de Usuário
 */

class Usuario {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Buscar usuário por ID
     */
    public function findById($id) {
        $sql = "SELECT * FROM usuarios WHERE id = ?";
        return $this->db->fetchRow($sql, [$id]);
    }
    
    /**
     * Buscar usuário por nome de usuário
     */
    public function findByUsername($username) {
        $sql = "SELECT * FROM usuarios WHERE nome_usuario = ?";
        return $this->db->fetchRow($sql, [$username]);
    }
    
    /**
     * Verificar credenciais de login
     */
    public function authenticate($username, $password) {
        $user = $this->findByUsername($username);
        
        if ($user && password_verify($password, $user['senha_hash'])) {
            return $user;
        }
        
        return false;
    }
    
    /**
     * Listar todos os usuários
     */
    public function findAll($page = 1, $limit = 20) {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM usuarios ORDER BY nome_exibicao LIMIT ? OFFSET ?";
        return $this->db->fetchAll($sql, [$limit, $offset]);
    }
    
    /**
     * Contar total de usuários
     */
    public function countAll() {
        $sql = "SELECT COUNT(*) as total FROM usuarios";
        return $this->db->fetchValue($sql);
    }
    
    /**
     * Criar novo usuário
     */
    public function create($data) {
        $sql = "INSERT INTO usuarios (nome_usuario, senha_hash, nome_exibicao, perfil, tema_preferido) 
                VALUES (?, ?, ?, ?, ?)";
        
        $params = [
            $data['nome_usuario'],
            password_hash($data['senha'], PASSWORD_DEFAULT),
            $data['nome_exibicao'],
            $data['perfil'],
            $data['tema_preferido'] ?? 'claro'
        ];
        
        $this->db->query($sql, $params);
        return $this->db->lastInsertId();
    }
    
    /**
     * Atualizar usuário
     */
    public function update($id, $data) {
        $fields = [];
        $params = [];
        
        if (isset($data['nome_exibicao'])) {
            $fields[] = 'nome_exibicao = ?';
            $params[] = $data['nome_exibicao'];
        }
        
        if (isset($data['senha']) && !empty($data['senha'])) {
            $fields[] = 'senha_hash = ?';
            $params[] = password_hash($data['senha'], PASSWORD_DEFAULT);
        }
        
        if (isset($data['tema_preferido'])) {
            $fields[] = 'tema_preferido = ?';
            $params[] = $data['tema_preferido'];
        }
        
        if (isset($data['perfil'])) {
            $fields[] = 'perfil = ?';
            $params[] = $data['perfil'];
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $params[] = $id;
        $sql = "UPDATE usuarios SET " . implode(', ', $fields) . " WHERE id = ?";
        
        return $this->db->query($sql, $params);
    }
    
    /**
     * Excluir usuário
     */
    public function delete($id) {
        // Não permitir excluir a si mesmo
        if ($id == $_SESSION['usuario_id']) {
            return false;
        }
        
        $sql = "DELETE FROM usuarios WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }
    
    /**
     * Verificar se nome de usuário já existe
     */
    public function usernameExists($username, $excludeId = null) {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE nome_usuario = ?";
        $params = [$username];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        return $this->db->fetchValue($sql, $params) > 0;
    }
    
    /**
     * Atualizar tema preferido do usuário
     */
    public function updateTheme($userId, $theme) {
        $sql = "UPDATE usuarios SET tema_preferido = ? WHERE id = ?";
        return $this->db->query($sql, [$theme, $userId]);
    }
}