<?php
/**
 * Modelo de Link de Cadastro
 */

class LinkCadastro {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Gerar token único
     */
    private function gerarToken() {
        return bin2hex(random_bytes(32));
    }
    
    /**
     * Buscar link por token
     */
    public function findByToken($token) {
        $sql = "SELECT * FROM links_cadastro WHERE token = ?";
        return $this->db->fetchRow($sql, [$token]);
    }
    
    /**
     * Buscar link por ID
     */
    public function findById($id) {
        $sql = "SELECT * FROM links_cadastro WHERE id = ?";
        return $this->db->fetchRow($sql, [$id]);
    }
    
    /**
     * Buscar links de um cliente
     */
    public function findByCliente($clienteId) {
        $sql = "SELECT * FROM links_cadastro 
                WHERE cliente_id = ? 
                ORDER BY criado_em DESC";
        return $this->db->fetchAll($sql, [$clienteId]);
    }
    
    /**
     * Buscar links ativos
     */
    public function findAtivos($clienteId = null) {
        $params = [];
        $sql = "SELECT * FROM links_cadastro 
                WHERE status = 'ativo' AND expira_em > NOW()";
        
        if ($clienteId) {
            $sql .= " AND cliente_id = ?";
            $params[] = $clienteId;
        }
        
        $sql .= " ORDER BY criado_em DESC";
        
        return $this->db->fetchAll($sql, $params);
    }
    
    /**
     * Criar novo link
     */
    public function create($clienteId = null) {
        $token = $this->gerarToken();
        $expiraEm = date('Y-m-d H:i:s', strtotime('+24 hours'));
        
        $sql = "INSERT INTO links_cadastro (token, cliente_id, expira_em, status) 
                VALUES (?, ?, ?, 'ativo')";
        
        $params = [
            $token,
            $clienteId,
            $expiraEm
        ];
        
        $this->db->query($sql, $params);
        return $token;
    }
    
    /**
     * Invalidar links anteriores de um cliente
     */
    public function invalidarLinksAnteriores($clienteId) {
        $sql = "UPDATE links_cadastro 
                SET status = 'expirado' 
                WHERE cliente_id = ? AND status = 'ativo'";
        return $this->db->query($sql, [$clienteId]);
    }
    
    /**
     * Marcar link como usado
     */
    public function marcarComoUsado($token, $clienteId = null) {
        $sql = "UPDATE links_cadastro 
                SET status = 'usado', cliente_id = COALESCE(?, cliente_id)
                WHERE token = ?";
        return $this->db->query($sql, [$clienteId, $token]);
    }
    
    /**
     * Marcar link como expirado
     */
    public function marcarComoExpirado($token) {
        $sql = "UPDATE links_cadastro SET status = 'expirado' WHERE token = ?";
        return $this->db->query($sql, [$token]);
    }
    
    /**
     * Verificar se link é válido
     */
    public function isValid($token) {
        $link = $this->findByToken($token);
        
        if (!$link) {
            return false;
        }
        
        if ($link['status'] !== 'ativo') {
            return false;
        }
        
        if (strtotime($link['expira_em']) < time()) {
            $this->marcarComoExpirado($token);
            return false;
        }
        
        return true;
    }
    
    /**
     * Limpar links expirados
     */
    public function limparExpirados() {
        $sql = "UPDATE links_cadastro 
                SET status = 'expirado' 
                WHERE status = 'ativo' AND expira_em < NOW()";
        return $this->db->query($sql);
    }
    
    /**
     * Contar links por status
     */
    public function countByStatus($clienteId = null) {
        $params = [];
        $sql = "SELECT status, COUNT(*) as total 
                FROM links_cadastro 
                WHERE 1=1";
        
        if ($clienteId) {
            $sql .= " AND cliente_id = ?";
            $params[] = $clienteId;
        }
        
        $sql .= " GROUP BY status";
        
        $result = $this->db->fetchAll($sql, $params);
        $counts = ['ativo' => 0, 'usado' => 0, 'expirado' => 0];
        
        foreach ($result as $row) {
            $counts[$row['status']] = $row['total'];
        }
        
        return $counts;
    }
}