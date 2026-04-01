<?php
/**
 * Controller de Projetos
 */

class ProjetoController {
    private $projetoModel;
    private $clienteModel;
    private $veiculoModel;
    private $molaOriginalModel;
    private $molaModificadaModel;
    
    public function __construct() {
        $this->projetoModel = new Projeto();
        $this->clienteModel = new Cliente();
        $this->veiculoModel = new Veiculo();
        $this->molaOriginalModel = new MolaOriginal();
        $this->molaModificadaModel = new MolaModificada();
    }
    
    /**
     * Listar projetos
     */
    public function index() {
        requireAuth();
        
        $page = $_GET['page'] ?? 1;
        $search = $_GET['search'] ?? '';
        $status_logistica = $_GET['status_logistica'] ?? '';
        $status_pagamento = $_GET['status_pagamento'] ?? '';
        
        $filters = [
            'search' => $search,
            'status_logistica' => $status_logistica,
            'status_pagamento' => $status_pagamento
        ];
        
        $projetos = $this->projetoModel->findAll($page, 20, $filters);
        $total = $this->projetoModel->countAll($filters);
        $totalPages = ceil($total / 20);
        
        $data = [
            'projetos' => $projetos,
            'page' => $page,
            'totalPages' => $totalPages,
            'filters' => $filters
        ];
        
        loadView('projetos/index', $data);
    }
    
    /**
     * Visualizar detalhes do projeto
     */
    public function visualizar($id = null) {
        requireAuth();
        
        if (!$id) {
            $_SESSION['error'] = 'ID do projeto não informado';
            redirect('projetos');
        }
        
        $projeto = $this->projetoModel->findById($id);
        
        if (!$projeto) {
            $_SESSION['error'] = 'Projeto não encontrado';
            redirect('projetos');
        }
        
        // Buscar molas originais do veículo
        $molasOriginais = $this->molaOriginalModel->findByVeiculo($projeto['veiculo_id']);
        
        // Buscar molas modificadas do projeto
        $molasModificadas = $this->projetoModel->getMolasModificadas($id);
        
        $data = [
            'projeto' => $projeto,
            'molasOriginais' => $molasOriginais,
            'molasModificadas' => $molasModificadas
        ];
        
        loadView('projetos/visualizar', $data);
    }
    
    /**
     * Criar novo projeto
     */
    public function criar() {
        requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'cliente_id' => $_POST['cliente_id'] ?? '',
                'veiculo_id' => $_POST['veiculo_id'] ?? '',
                'nome_projeto' => $_POST['nome_projeto'] ?? '',
                'status_logistica' => $_POST['status_logistica'] ?? 'fabricacao',
                'status_pagamento' => $_POST['status_pagamento'] ?? 'pendente',
                'status_frete' => $_POST['status_frete'] ?? 'pendente',
                'valor_venda' => $_POST['valor_venda'] ?? null,
                'desconto_aniversario_perc' => $_POST['desconto_aniversario_perc'] ?? null,
                'valor_final' => $_POST['valor_final'] ?? null,
                'valor_entrada' => $_POST['valor_entrada'] ?? null,
                'saldo_restante' => $_POST['saldo_restante'] ?? null,
                'valor_frete' => $_POST['valor_frete'] ?? null,
                'observacoes' => $_POST['observacoes'] ?? ''
            ];
            
            try {
                $projetoId = $this->projetoModel->create($data);
                $_SESSION['success'] = 'Projeto criado com sucesso';
                redirect('projetos/visualizar/' . $projetoId);
            } catch (Exception $e) {
                $_SESSION['error'] = 'Erro ao criar projeto: ' . $e->getMessage();
                $_SESSION['form_data'] = $data;
                redirect('projetos/criar');
            }
        }
        
        // Para o formulário de criação, precisamos de listas de clientes e veículos
        $clientes = $this->clienteModel->findAll(1, 1000); // Simplificado para busca no select
        $veiculos = $this->veiculoModel->findAll(1, 1000);
        
        $formData = $_SESSION['form_data'] ?? [];
        unset($_SESSION['form_data']);
        
        $data = [
            'clientes' => $clientes,
            'veiculos' => $veiculos,
            'formData' => $formData
        ];
        
        loadView('projetos/form', $data);
    }
    
    /**
     * Editar projeto
     */
    public function editar($id = null) {
        requireAuth();
        
        if (!$id) {
            $_SESSION['error'] = 'ID do projeto não informado';
            redirect('projetos');
        }
        
        $projeto = $this->projetoModel->findById($id);
        
        if (!$projeto) {
            $_SESSION['error'] = 'Projeto não encontrado';
            redirect('projetos');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'cliente_id' => $_POST['cliente_id'] ?? $projeto['cliente_id'],
                'veiculo_id' => $_POST['veiculo_id'] ?? $projeto['veiculo_id'],
                'nome_projeto' => $_POST['nome_projeto'] ?? $projeto['nome_projeto'],
                'status_logistica' => $_POST['status_logistica'] ?? $projeto['status_logistica'],
                'status_pagamento' => $_POST['status_pagamento'] ?? $projeto['status_pagamento'],
                'status_frete' => $_POST['status_frete'] ?? $projeto['status_frete'],
                'valor_venda' => $_POST['valor_venda'] ?? $projeto['valor_venda'],
                'desconto_aniversario_perc' => $_POST['desconto_aniversario_perc'] ?? $projeto['desconto_aniversario_perc'],
                'valor_final' => $_POST['valor_final'] ?? $projeto['valor_final'],
                'valor_entrada' => $_POST['valor_entrada'] ?? $projeto['valor_entrada'],
                'saldo_restante' => $_POST['saldo_restante'] ?? $projeto['saldo_restante'],
                'valor_frete' => $_POST['valor_frete'] ?? $projeto['valor_frete'],
                'observacoes' => $_POST['observacoes'] ?? $projeto['observacoes'],
                'observacoes_garantia' => $_POST['observacoes_garantia'] ?? $projeto['observacoes_garantia']
            ];
            
            try {
                $this->projetoModel->update($id, $data);
                $_SESSION['success'] = 'Projeto atualizado com sucesso';
                redirect('projetos/visualizar/' . $id);
            } catch (Exception $e) {
                $_SESSION['error'] = 'Erro ao atualizar projeto: ' . $e->getMessage();
            }
        }
        
        $clientes = $this->clienteModel->findAll(1, 1000);
        $veiculos = $this->veiculoModel->findAll(1, 1000);
        
        $data = [
            'projeto' => $projeto,
            'clientes' => $clientes,
            'veiculos' => $veiculos,
            'isEdit' => true
        ];
        
        loadView('projetos/form', $data);
    }
    
    /**
     * Excluir projeto
     */
    public function excluir($id = null) {
        requireAuth();
        
        if (!$id) {
            $_SESSION['error'] = 'ID do projeto não informado';
            redirect('projetos');
        }
        
        try {
            $this->projetoModel->delete($id);
            $_SESSION['success'] = 'Projeto excluído com sucesso';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erro ao excluir projeto: ' . $e->getMessage();
        }
        
        redirect('projetos');
    }
    
    /**
     * Salvar dados técnicos da mola modificada
     */
    public function salvarMola($projetoId) {
        requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'projeto_id' => $projetoId,
                'mola_original_ref_id' => $_POST['mola_original_ref_id'] ?? null,
                'posicao' => $_POST['posicao'],
                'quantidade' => $_POST['quantidade'] ?? 2,
                'fio_mm' => $_POST['fio_mm'],
                'altura_livre_mm' => $_POST['altura_livre_mm'],
                'diametro_interno_mm' => $_POST['diametro_interno_mm'],
                'vao_entre_espiras_mm' => $_POST['vao_entre_espiras_mm'],
                'retifica' => isset($_POST['retifica']) ? 1 : 0,
                'olhal_cima_mm' => $_POST['olhal_cima_mm'] ?? null,
                'olhal_baixo_mm' => $_POST['olhal_baixo_mm'] ?? null,
                'tipo_ponta' => $_POST['tipo_ponta'],
                'medida_ponta_mm' => $_POST['medida_ponta_mm'] ?? null,
                'entre_elo_mm' => $_POST['entre_elo_mm'] ?? null,
                'espiras_ativas' => $_POST['espiras_ativas'] ?? null,
                'espiras_totais' => $_POST['espiras_totais'],
                'lift_mm' => $_POST['lift_mm'] ?? null,
                'ganho_carga_kg' => $_POST['ganho_carga_kg'] ?? null,
                'observacoes_tecnicas' => $_POST['observacoes_tecnicas'] ?? ''
            ];
            
            try {
                // Verificar se já existe mola nesta posição para este projeto
                $existente = $this->projetoModel->getMolaModificadaByPosicao($projetoId, $data['posicao']);
                
                if ($existente) {
                    $this->molaModificadaModel->update($existente['id'], $data);
                } else {
                    $this->molaModificadaModel->create($data);
                }
                
                $_SESSION['success'] = 'Dados técnicos da mola salvos com sucesso';
            } catch (Exception $e) {
                $_SESSION['error'] = 'Erro ao salvar mola: ' . $e->getMessage();
            }
            
            redirect('projetos/visualizar/' . $projetoId);
        }
    }
}
