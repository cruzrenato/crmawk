<?php
/**
 * Modelo de Mola Modificada
 */

class MolaModificada {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Buscar mola modificada por ID
     */
    public function findById($id) {
        $sql = "SELECT * FROM molas_modificadas WHERE id = ?";
        return $this->db->fetchRow($sql, [$id]);
    }
    
    /**
     * Criar mola modificada
     */
    public function create($data) {
        // Verificar se já existe mola para esta posição no projeto
        $existing = $this->findByProjetoPosicao($data['projeto_id'], $data['posicao']);
        if ($existing) {
            throw new Exception('Já existe uma mola cadastrada para esta posição neste projeto');
        }
        
        $sql = "INSERT INTO molas_modificadas (
            projeto_id, mola_original_ref_id, posicao, quantidade, fio_mm, 
            altura_livre_mm, diametro_interno_mm, vao_entre_espiras_mm, retifica, 
            olhal_cima_mm, olhal_baixo_mm, tipo_ponta, medida_ponta_mm, 
            entre_elo_mm, espiras_ativas, espiras_totais, lift_mm, 
            ganho_carga_kg, observacoes_tecnicas
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $data['projeto_id'],
            $data['mola_original_ref_id'] ?? null,
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
            $data['espiras_totais'],
            $data['lift_mm'] ?? null,
            $data['ganho_carga_kg'] ?? null,
            $data['observacoes_tecnicas'] ?? null
        ];
        
        $this->db->query($sql, $params);
        return $this->db->lastInsertId();
    }
    
    /**
     * Atualizar mola modificada
     */
    public function update($id, $data) {
        $fields = [];
        $params = [];
        
        $fieldMap = [
            'mola_original_ref_id' => 'mola_original_ref_id',
            'quantidade' => 'quantidade',
            'fio_mm' => 'fio_mm',
            'altura_livre_mm' => 'altura_livre_mm',
            'diametro_interno_mm' => 'diametro_interno_mm',
            'vao_entre_espiras_mm' => 'vao_entre_espiras_mm',
            'retifica' => 'retifica',
            'tipo_ponta' => 'tipo_ponta',
            'entre_elo_mm' => 'entre_elo_mm',
            'espiras_ativas' => 'espiras_ativas',
            'espiras_totais' => 'espiras_totais',
            'lift_mm' => 'lift_mm',
            'ganho_carga_kg' => 'ganho_carga_kg',
            'observacoes_tecnicas' => 'observacoes_tecnicas'
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
        $sql = "UPDATE molas_modificadas SET " . implode(', ', $fields) . " WHERE id = ?";
        
        return $this->db->query($sql, $params);
    }
    
    /**
     * Excluir mola modificada
     */
    public function delete($id) {
        $sql = "DELETE FROM molas_modificadas WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }
    
    /**
     * Excluir todas as molas de um projeto
     */
    public function deleteByProjeto($projetoId) {
        $sql = "DELETE FROM molas_modificadas WHERE projeto_id = ?";
        return $this->db->query($sql, [$projetoId]);
    }
    
    /**
     * Buscar mola modificada por projeto e posição
     */
    public function findByProjetoPosicao($projetoId, $posicao) {
        $sql = "SELECT * FROM molas_modificadas 
                WHERE projeto_id = ? AND posicao = ?";
        return $this->db->fetchRow($sql, [$projetoId, $posicao]);
    }
    
    /**
     * Buscar molas modificadas de um projeto
     */
    public function findByProjeto($projetoId) {
        $sql = "SELECT * FROM molas_modificadas 
                WHERE projeto_id = ? 
                ORDER BY FIELD(posicao, 'dianteira', 'traseira')";
        return $this->db->fetchAll($sql, [$projetoId]);
    }
    
    /**
     * Comparar mola modificada com original
     */
    public function compareWithOriginal($molaModificadaId) {
        $sql = "SELECT 
                    mm.*,
                    mo.fio_mm as original_fio_mm,
                    mo.altura_livre_mm as original_altura_livre_mm,
                    mo.diametro_interno_mm as original_diametro_interno_mm,
                    mo.vao_entre_espiras_mm as original_vao_entre_espiras_mm,
                    mo.retifica as original_retifica,
                    mo.olhal_cima_mm as original_olhal_cima_mm,
                    mo.olhal_baixo_mm as original_olhal_baixo_mm,
                    mo.tipo_ponta as original_tipo_ponta,
                    mo.medida_ponta_mm as original_medida_ponta_mm,
                    mo.entre_elo_mm as original_entre_elo_mm,
                    mo.espiras_ativas as original_espiras_ativas,
                    mo.espiras_totais as original_espiras_totais
                FROM molas_modificadas mm
                LEFT JOIN molas_originais mo ON mm.mola_original_ref_id = mo.id
                WHERE mm.id = ?";
        
        return $this->db->fetchRow($sql, [$molaModificadaId]);
    }
}