<?php
/**
 * Modelo de Mola Original
 */

class MolaOriginal {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Buscar mola original por ID
     */
    public function findById($id) {
        $sql = "SELECT * FROM molas_originais WHERE id = ?";
        return $this->db->fetchRow($sql, [$id]);
    }
    
    /**
     * Buscar mola original por veículo e posição
     */
    public function findByVeiculoPosicao($veiculoId, $posicao) {
        $sql = "SELECT * FROM molas_originais 
                WHERE veiculo_id = ? AND posicao = ?";
        return $this->db->fetchRow($sql, [$veiculoId, $posicao]);
    }
    
    /**
     * Criar mola original
     */
    public function create($data) {
        // Verificar se já existe mola para esta posição no veículo
        $existing = $this->findByVeiculoPosicao($data['veiculo_id'], $data['posicao']);
        if ($existing) {
            throw new Exception('Já existe uma mola cadastrada para esta posição neste veículo');
        }
        
        $sql = "INSERT INTO molas_originais (
            veiculo_id, posicao, quantidade, fio_mm, altura_livre_mm, 
            diametro_interno_mm, vao_entre_espiras_mm, retifica, 
            olhal_cima_mm, olhal_baixo_mm, tipo_ponta, medida_ponta_mm, 
            entre_elo_mm, espiras_ativas, espiras_totais
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $data['veiculo_id'],
            $data['posicao'],
            $data['quantidade'] ?? 2,
            $data['fio_mm'],
            $data['altura_livre_mm'],
            $data['diametro_interno_mm'],
            $data['vao_entre_espiras_mm'],
            $data['retifica'] ? 1 : 0,
            $data['retifica'] ? null : ($data['olhal_cima_mm'] ?? null),
            $data['retifica'] ? null : ($data['olhal_baixo_mm'] ?? null),
            $data['tipo_ponta'],
            $data['tipo_ponta'] === 'aberta' ? ($data['medida_ponta_mm'] ?? null) : null,
            $data['entre_elo_mm'] ?? null,
            $data['espiras_ativas'] ?? null,
            $data['espiras_totais']
        ];
        
        $this->db->query($sql, $params);
        return $this->db->lastInsertId();
    }
    
    /**
     * Atualizar mola original
     */
    public function update($id, $data) {
        $fields = [];
        $params = [];
        
        $fieldMap = [
            'quantidade' => 'quantidade',
            'fio_mm' => 'fio_mm',
            'altura_livre_mm' => 'altura_livre_mm',
            'diametro_interno_mm' => 'diametro_interno_mm',
            'vao_entre_espiras_mm' => 'vao_entre_espiras_mm',
            'retifica' => 'retifica',
            'tipo_ponta' => 'tipo_ponta',
            'entre_elo_mm' => 'entre_elo_mm',
            'espiras_ativas' => 'espiras_ativas',
            'espiras_totais' => 'espiras_totais'
        ];
        
        foreach ($fieldMap as $key => $field) {
            if (isset($data[$key])) {
                $fields[] = "{$field} = ?";
                if ($key === 'retifica') {
                    $params[] = $data[$key] ? 1 : 0;
                } else {
                    $params[] = $data[$key];
                }
            }
        }
        
        // Campos condicionais
        if (isset($data['retifica'])) {
            if ($data['retifica']) {
                // Se retifica = true, campos de olhal devem ser NULL
                $fields[] = "olhal_cima_mm = NULL";
                $fields[] = "olhal_baixo_mm = NULL";
            } else {
                // Se retifica = false, campos de olhal devem ter valores
                if (isset($data['olhal_cima_mm'])) {
                    $fields[] = "olhal_cima_mm = ?";
                    $params[] = $data['olhal_cima_mm'];
                }
                if (isset($data['olhal_baixo_mm'])) {
                    $fields[] = "olhal_baixo_mm = ?";
                    $params[] = $data['olhal_baixo_mm'];
                }
            }
        }
        
        if (isset($data['tipo_ponta'])) {
            if ($data['tipo_ponta'] === 'aberta' && isset($data['medida_ponta_mm'])) {
                $fields[] = "medida_ponta_mm = ?";
                $params[] = $data['medida_ponta_mm'];
            } else {
                $fields[] = "medida_ponta_mm = NULL";
            }
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $params[] = $id;
        $sql = "UPDATE molas_originais SET " . implode(', ', $fields) . " WHERE id = ?";
        
        return $this->db->query($sql, $params);
    }
    
    /**
     * Excluir mola original
     */
    public function delete($id) {
        $sql = "DELETE FROM molas_originais WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }
    
    /**
     * Excluir todas as molas de um veículo
     */
    public function deleteByVeiculo($veiculoId) {
        $sql = "DELETE FROM molas_originais WHERE veiculo_id = ?";
        return $this->db->query($sql, [$veiculoId]);
    }
    
    /**
     * Buscar molas originais de um veículo
     */
    public function findByVeiculo($veiculoId) {
        $sql = "SELECT * FROM molas_originais 
                WHERE veiculo_id = ? 
                ORDER BY FIELD(posicao, 'dianteira', 'traseira')";
        return $this->db->fetchAll($sql, [$veiculoId]);
    }
}