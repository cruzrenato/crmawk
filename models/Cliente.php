<?php
/**
 * Modelo de Cliente
 */

class Cliente {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Gerar código do cliente
     */
    private function gerarCodigoCliente() {
        $sql = "SELECT COALESCE(MAX(CAST(SUBSTRING(codigo_cliente, 5) AS UNSIGNED)), 0) + 1 as next_num 
                FROM clientes";
        $nextNum = $this->db->fetchValue($sql);
        return 'AWK-' . str_pad($nextNum, 4, '0', STR_PAD_LEFT);
    }
    
    /**
     * Buscar cliente por ID
     */
    public function findById($id) {
        $sql = "SELECT * FROM clientes WHERE id = ?";
        return $this->db->fetchRow($sql, [$id]);
    }
    
    /**
     * Buscar cliente por código
     */
    public function findByCodigo($codigo) {
        $sql = "SELECT * FROM clientes WHERE codigo_cliente = ?";
        return $this->db->fetchRow($sql, [$codigo]);
    }
    
    /**
     * Buscar cliente por CPF/CNPJ
     */
    public function findByCpfCnpj($cpfCnpj) {
        $sql = "SELECT * FROM clientes WHERE cpf_cnpj = ?";
        return $this->db->fetchRow($sql, [$cpfCnpj]);
    }
    
    /**
     * Listar clientes com paginação
     */
    public function findAll($page = 1, $limit = 20, $search = '') {
        $offset = ($page - 1) * $limit;
        $params = [];
        
        $sql = "SELECT * FROM clientes WHERE 1=1";
        
        if (!empty($search)) {
            $sql .= " AND (
                nome LIKE ? OR 
                codigo_cliente LIKE ? OR 
                cpf_cnpj LIKE ? OR 
                telefone LIKE ? OR 
                email LIKE ? OR 
                cidade LIKE ? OR 
                endereco LIKE ?
            )";
            $searchTerm = "%{$search}%";
            $params = array_fill(0, 7, $searchTerm);
        }
        
        $sql .= " ORDER BY nome LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        return $this->db->fetchAll($sql, $params);
    }
    
    /**
     * Contar total de clientes
     */
    public function countAll($search = '') {
        $params = [];
        $sql = "SELECT COUNT(*) as total FROM clientes WHERE 1=1";
        
        if (!empty($search)) {
            $sql .= " AND (
                nome LIKE ? OR 
                codigo_cliente LIKE ? OR 
                cpf_cnpj LIKE ? OR 
                telefone LIKE ? OR 
                email LIKE ? OR 
                cidade LIKE ? OR 
                endereco LIKE ?
            )";
            $searchTerm = "%{$search}%";
            $params = array_fill(0, 7, $searchTerm);
        }
        
        return $this->db->fetchValue($sql, $params);
    }
    
    /**
     * Criar novo cliente
     */
    public function create($data) {
        // Verificar se CPF/CNPJ já existe
        if ($this->findByCpfCnpj($data['cpf_cnpj'])) {
            throw new Exception('CPF/CNPJ já cadastrado');
        }
        
        $codigo = $this->gerarCodigoCliente();
        
        $sql = "INSERT INTO clientes (
            codigo_cliente, nome, aniversario_dia, aniversario_mes, 
            cpf_cnpj, cep, endereco, numero, bairro, cidade, estado_uf,
            telefone, telefone2, email, observacoes
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $codigo,
            $data['nome'],
            $data['aniversario_dia'],
            $data['aniversario_mes'],
            preg_replace('/[^0-9]/', '', $data['cpf_cnpj']),
            $data['cep'],
            $data['endereco'],
            $data['numero'],
            $data['bairro'],
            $data['cidade'],
            $data['estado_uf'],
            $data['telefone'],
            $data['telefone2'] ?? null,
            $data['email'],
            $data['observacoes'] ?? null
        ];
        
        $this->db->query($sql, $params);
        return $this->db->lastInsertId();
    }
    
    /**
     * Atualizar cliente
     */
    public function update($id, $data) {
        // Verificar se CPF/CNPJ já existe para outro cliente
        if (isset($data['cpf_cnpj'])) {
            $existing = $this->findByCpfCnpj($data['cpf_cnpj']);
            if ($existing && $existing['id'] != $id) {
                throw new Exception('CPF/CNPJ já cadastrado para outro cliente');
            }
        }
        
        $fields = [];
        $params = [];
        
        $fieldMap = [
            'nome' => 'nome',
            'aniversario_dia' => 'aniversario_dia',
            'aniversario_mes' => 'aniversario_mes',
            'cpf_cnpj' => 'cpf_cnpj',
            'cep' => 'cep',
            'endereco' => 'endereco',
            'numero' => 'numero',
            'bairro' => 'bairro',
            'cidade' => 'cidade',
            'estado_uf' => 'estado_uf',
            'telefone' => 'telefone',
            'telefone2' => 'telefone2',
            'email' => 'email',
            'observacoes' => 'observacoes'
        ];
        
        foreach ($fieldMap as $key => $field) {
            if (isset($data[$key])) {
                $fields[] = "{$field} = ?";
                if ($key === 'cpf_cnpj') {
                    $params[] = preg_replace('/[^0-9]/', '', $data[$key]);
                } else {
                    $params[] = $data[$key];
                }
            }
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $params[] = $id;
        $sql = "UPDATE clientes SET " . implode(', ', $fields) . " WHERE id = ?";
        
        return $this->db->query($sql, $params);
    }
    
    /**
     * Excluir cliente
     */
    public function delete($id) {
        // Verificar se cliente tem projetos vinculados
        $sql = "SELECT COUNT(*) FROM projetos WHERE cliente_id = ?";
        $hasProjects = $this->db->fetchValue($sql, [$id]) > 0;
        
        if ($hasProjects) {
            throw new Exception('Não é possível excluir cliente com projetos vinculados');
        }
        
        $sql = "DELETE FROM clientes WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }
    
    /**
     * Buscar aniversariantes do mês
     */
    public function findAniversariantes($mes = null) {
        $mes = $mes ?? date('n');
        $sql = "SELECT * FROM clientes WHERE aniversario_mes = ? ORDER BY aniversario_dia";
        return $this->db->fetchAll($sql, [$mes]);
    }
    
    /**
     * Contar aniversariantes do mês
     */
    public function countAniversariantes($mes = null) {
        $mes = $mes ?? date('n');
        $sql = "SELECT COUNT(*) FROM clientes WHERE aniversario_mes = ?";
        return $this->db->fetchValue($sql, [$mes]);
    }
    
    /**
     * Verificar se cliente é aniversariante do mês atual
     */
    public function isAniversarianteMes($clienteId) {
        $sql = "SELECT COUNT(*) FROM clientes 
                WHERE id = ? AND aniversario_mes = MONTH(CURDATE())";
        return $this->db->fetchValue($sql, [$clienteId]) > 0;
    }
    
    /**
     * Buscar projetos do cliente
     */
    public function getProjetos($clienteId) {
        $sql = "SELECT p.*, v.marca, v.modelo, v.ano 
                FROM projetos p 
                JOIN veiculos v ON p.veiculo_id = v.id 
                WHERE p.cliente_id = ? 
                ORDER BY p.criado_em DESC";
        return $this->db->fetchAll($sql, [$clienteId]);
    }
}