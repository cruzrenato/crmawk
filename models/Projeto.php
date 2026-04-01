<?php
/**
 * Modelo de Projeto
 */

class Projeto {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Gerar código do pedido
     */
    private function gerarCodigoPedido() {
        $sql = "SELECT COALESCE(MAX(CAST(SUBSTRING(codigo_pedido, 4) AS UNSIGNED)), 0) + 1 as next_num 
                FROM projetos";
        $nextNum = $this->db->fetchValue($sql);
        return 'OP-' . str_pad($nextNum, 4, '0', STR_PAD_LEFT);
    }
    
    /**
     * Buscar projeto por ID
     */
    public function findById($id) {
        $sql = "SELECT p.*, c.codigo_cliente, c.nome as cliente_nome, 
                       v.marca, v.modelo, v.ano
                FROM projetos p
                JOIN clientes c ON p.cliente_id = c.id
                JOIN veiculos v ON p.veiculo_id = v.id
                WHERE p.id = ?";
        return $this->db->fetchRow($sql, [$id]);
    }
    
    /**
     * Buscar projeto por código do pedido
     */
    public function findByCodigoPedido($codigo) {
        $sql = "SELECT p.*, c.codigo_cliente, c.nome as cliente_nome, 
                       v.marca, v.modelo, v.ano
                FROM projetos p
                JOIN clientes c ON p.cliente_id = c.id
                JOIN veiculos v ON p.veiculo_id = v.id
                WHERE p.codigo_pedido = ?";
        return $this->db->fetchRow($sql, [$codigo]);
    }
    
    /**
     * Listar projetos com paginação
     */
    public function findAll($page = 1, $limit = 20, $filters = []) {
        $offset = ($page - 1) * $limit;
        $params = [];
        
        $sql = "SELECT p.*, c.codigo_cliente, c.nome as cliente_nome, 
                       v.marca, v.modelo, v.ano
                FROM projetos p
                JOIN clientes c ON p.cliente_id = c.id
                JOIN veiculos v ON p.veiculo_id = v.id
                WHERE 1=1";
        
        // Filtros
        if (!empty($filters['search'])) {
            $sql .= " AND (
                p.codigo_pedido LIKE ? OR 
                c.codigo_cliente LIKE ? OR 
                c.nome LIKE ? OR 
                v.marca LIKE ? OR 
                v.modelo LIKE ? OR 
                p.nome_projeto LIKE ?
            )";
            $searchTerm = "%{$filters['search']}%";
            $params = array_fill(0, 6, $searchTerm);
        }
        
        if (!empty($filters['status_logistica'])) {
            $sql .= " AND p.status_logistica = ?";
            $params[] = $filters['status_logistica'];
        }
        
        if (!empty($filters['status_pagamento'])) {
            $sql .= " AND p.status_pagamento = ?";
            $params[] = $filters['status_pagamento'];
        }
        
        if (!empty($filters['cliente_id'])) {
            $sql .= " AND p.cliente_id = ?";
            $params[] = $filters['cliente_id'];
        }
        
        $sql .= " ORDER BY p.criado_em DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        return $this->db->fetchAll($sql, $params);
    }
    
    /**
     * Contar total de projetos
     */
    public function countAll($filters = []) {
        $params = [];
        $sql = "SELECT COUNT(*) as total 
                FROM projetos p
                JOIN clientes c ON p.cliente_id = c.id
                JOIN veiculos v ON p.veiculo_id = v.id
                WHERE 1=1";
        
        // Filtros
        if (!empty($filters['search'])) {
            $sql .= " AND (
                p.codigo_pedido LIKE ? OR 
                c.codigo_cliente LIKE ? OR 
                c.nome LIKE ? OR 
                v.marca LIKE ? OR 
                v.modelo LIKE ? OR 
                p.nome_projeto LIKE ?
            )";
            $searchTerm = "%{$filters['search']}%";
            $params = array_fill(0, 6, $searchTerm);
        }
        
        if (!empty($filters['status_logistica'])) {
            $sql .= " AND p.status_logistica = ?";
            $params[] = $filters['status_logistica'];
        }
        
        if (!empty($filters['status_pagamento'])) {
            $sql .= " AND p.status_pagamento = ?";
            $params[] = $filters['status_pagamento'];
        }
        
        if (!empty($filters['cliente_id'])) {
            $sql .= " AND p.cliente_id = ?";
            $params[] = $filters['cliente_id'];
        }
        
        return $this->db->fetchValue($sql, $params);
    }
    
    /**
     * Criar novo projeto
     */
    public function create($data) {
        $codigo = $this->gerarCodigoPedido();
        
        $sql = "INSERT INTO projetos (
            codigo_pedido, cliente_id, veiculo_id, nome_projeto,
            status_logistica, status_pagamento, status_frete,
            valor_venda, desconto_aniversario_perc, valor_final,
            valor_entrada, saldo_restante, valor_frete, observacoes
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $codigo,
            $data['cliente_id'],
            $data['veiculo_id'],
            $data['nome_projeto'],
            $data['status_logistica'] ?? 'fabricacao',
            $data['status_pagamento'] ?? 'pendente',
            $data['status_frete'] ?? 'pendente',
            $data['valor_venda'] ?? null,
            $data['desconto_aniversario_perc'] ?? null,
            $data['valor_final'] ?? null,
            $data['valor_entrada'] ?? null,
            $data['saldo_restante'] ?? null,
            $data['valor_frete'] ?? null,
            $data['observacoes'] ?? null
        ];
        
        $this->db->query($sql, $params);
        return $this->db->lastInsertId();
    }
    
    /**
     * Atualizar projeto
     */
    public function update($id, $data) {
        $fields = [];
        $params = [];
        
        $fieldMap = [
            'cliente_id' => 'cliente_id',
            'veiculo_id' => 'veiculo_id',
            'nome_projeto' => 'nome_projeto',
            'status_logistica' => 'status_logistica',
            'status_pagamento' => 'status_pagamento',
            'status_frete' => 'status_frete',
            'valor_venda' => 'valor_venda',
            'desconto_aniversario_perc' => 'desconto_aniversario_perc',
            'valor_final' => 'valor_final',
            'valor_entrada' => 'valor_entrada',
            'saldo_restante' => 'saldo_restante',
            'valor_frete' => 'valor_frete',
            'observacoes' => 'observacoes',
            'observacoes_garantia' => 'observacoes_garantia'
        ];
        
        foreach ($fieldMap as $key => $field) {
            if (isset($data[$key])) {
                $fields[] = "{$field} = ?";
                $params[] = $data[$key];
            }
        }
        
        // Se status mudou para entregue, atualizar data de conclusão
        if (isset($data['status_logistica']) && $data['status_logistica'] === 'entregue') {
            $fields[] = "concluido_em = NOW()";
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $params[] = $id;
        $sql = "UPDATE projetos SET " . implode(', ', $fields) . " WHERE id = ?";
        
        return $this->db->query($sql, $params);
    }
    
    /**
     * Excluir projeto
     */
    public function delete($id) {
        $sql = "DELETE FROM projetos WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }
    
    /**
     * Buscar estatísticas do dashboard
     */
    public function getDashboardStats() {
        $stats = [];
        
        // Total de projetos
        $stats['total_projetos'] = $this->db->fetchValue("SELECT COUNT(*) FROM projetos");
        
        // Projetos por status logístico
        $sql = "SELECT status_logistica, COUNT(*) as total 
                FROM projetos 
                GROUP BY status_logistica";
        $statusLogistica = $this->db->fetchAll($sql);
        $stats['status_logistica'] = array_column($statusLogistica, 'total', 'status_logistica');
        
        // Projetos com pagamento pendente
        $stats['pagamento_pendente'] = $this->db->fetchValue(
            "SELECT COUNT(*) FROM projetos WHERE status_pagamento = 'pendente'"
        );
        
        // Projetos entregues no mês atual
        $stats['entregues_mes'] = $this->db->fetchValue(
            "SELECT COUNT(*) FROM projetos 
             WHERE status_logistica = 'entregue' 
             AND MONTH(concluido_em) = MONTH(CURDATE()) 
             AND YEAR(concluido_em) = YEAR(CURDATE())"
        );
        
        return $stats;
    }
    
    /**
     * Buscar molas modificadas do projeto
     */
    public function getMolasModificadas($projetoId) {
        $sql = "SELECT mm.*, mo.posicao as original_posicao
                FROM molas_modificadas mm
                LEFT JOIN molas_originais mo ON mm.mola_original_ref_id = mo.id
                WHERE mm.projeto_id = ?
                ORDER BY mm.posicao";
        return $this->db->fetchAll($sql, [$projetoId]);
    }
    
    /**
     * Buscar mola modificada por posição
     */
    public function getMolaModificadaByPosicao($projetoId, $posicao) {
        $sql = "SELECT * FROM molas_modificadas 
                WHERE projeto_id = ? AND posicao = ?";
        return $this->db->fetchRow($sql, [$projetoId, $posicao]);
    }
}