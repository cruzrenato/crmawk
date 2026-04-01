<?php
/**
 * Modelo de Veículo
 */

class Veiculo {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Buscar veículo por ID
     */
    public function findById($id) {
        $sql = "SELECT * FROM veiculos WHERE id = ?";
        return $this->db->fetchRow($sql, [$id]);
    }
    
    /**
     * Listar veículos com paginação
     */
    public function findAll($page = 1, $limit = 20, $search = '') {
        $offset = ($page - 1) * $limit;
        $params = [];
        
        $sql = "SELECT * FROM veiculos WHERE 1=1";
        
        if (!empty($search)) {
            $sql .= " AND (
                marca LIKE ? OR 
                modelo LIKE ? OR 
                ano LIKE ? OR 
                observacoes LIKE ?
            )";
            $searchTerm = "%{$search}%";
            $params = array_fill(0, 4, $searchTerm);
        }
        
        $sql .= " ORDER BY marca, modelo, ano LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        return $this->db->fetchAll($sql, $params);
    }
    
    /**
     * Listar todos os veículos para select
     */
    public function findAllForSelect() {
        $sql = "SELECT id, CONCAT(marca, ' ', modelo, ' ', ano) as descricao 
                FROM veiculos 
                ORDER BY marca, modelo, ano";
        return $this->db->fetchAll($sql);
    }
    
    /**
     * Contar total de veículos
     */
    public function countAll($search = '') {
        $params = [];
        $sql = "SELECT COUNT(*) as total FROM veiculos WHERE 1=1";
        
        if (!empty($search)) {
            $sql .= " AND (
                marca LIKE ? OR 
                modelo LIKE ? OR 
                ano LIKE ? OR 
                observacoes LIKE ?
            )";
            $searchTerm = "%{$search}%";
            $params = array_fill(0, 4, $searchTerm);
        }
        
        return $this->db->fetchValue($sql, $params);
    }
    
    /**
     * Criar novo veículo
     */
    public function create($data) {
        $sql = "INSERT INTO veiculos (marca, modelo, ano, observacoes) 
                VALUES (?, ?, ?, ?)";
        
        $params = [
            $data['marca'],
            $data['modelo'],
            $data['ano'],
            $data['observacoes'] ?? null
        ];
        
        $this->db->query($sql, $params);
        return $this->db->lastInsertId();
    }
    
    /**
     * Atualizar veículo
     */
    public function update($id, $data) {
        $fields = [];
        $params = [];
        
        $fieldMap = [
            'marca' => 'marca',
            'modelo' => 'modelo',
            'ano' => 'ano',
            'observacoes' => 'observacoes'
        ];
        
        foreach ($fieldMap as $key => $field) {
            if (isset($data[$key])) {
                $fields[] = "{$field} = ?";
                $params[] = $data[$key];
            }
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $params[] = $id;
        $sql = "UPDATE veiculos SET " . implode(', ', $fields) . " WHERE id = ?";
        
        return $this->db->query($sql, $params);
    }
    
    /**
     * Excluir veículo
     */
    public function delete($id) {
        // Verificar se veículo tem projetos vinculados
        $sql = "SELECT COUNT(*) FROM projetos WHERE veiculo_id = ?";
        $hasProjects = $this->db->fetchValue($sql, [$id]) > 0;
        
        if ($hasProjects) {
            throw new Exception('Não é possível excluir veículo com projetos vinculados');
        }
        
        $sql = "DELETE FROM veiculos WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }
    
    /**
     * Buscar molas originais do veículo
     */
    public function getMolasOriginais($veiculoId) {
        $sql = "SELECT * FROM molas_originais WHERE veiculo_id = ? ORDER BY posicao";
        return $this->db->fetchAll($sql, [$veiculoId]);
    }
    
    /**
     * Buscar mola original por posição
     */
    public function getMolaOriginalByPosicao($veiculoId, $posicao) {
        $sql = "SELECT * FROM molas_originais 
                WHERE veiculo_id = ? AND posicao = ?";
        return $this->db->fetchRow($sql, [$veiculoId, $posicao]);
    }
    
    /**
     * Verificar se veículo tem molas originais cadastradas
     */
    public function hasMolasOriginais($veiculoId) {
        $sql = "SELECT COUNT(*) FROM molas_originais WHERE veiculo_id = ?";
        return $this->db->fetchValue($sql, [$veiculoId]) > 0;
    }
}