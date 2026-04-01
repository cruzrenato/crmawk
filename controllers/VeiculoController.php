<?php
/**
 * Controller de Veículos
 */

class VeiculoController {
    private $veiculoModel;
    private $molaOriginalModel;
    
    public function __construct() {
        $this->veiculoModel = new Veiculo();
        $this->molaOriginalModel = new MolaOriginal();
    }
    
    /**
     * Listar veículos
     */
    public function listar() {
        requireAuth();
        
        $page = $_GET['page'] ?? 1;
        $search = $_GET['search'] ?? '';
        
        $veiculos = $this->veiculoModel->findAll($page, 20, $search);
        $total = $this->veiculoModel->countAll($search);
        $totalPages = ceil($total / 20);
        
        $data = [
            'veiculos' => $veiculos,
            'page' => $page,
            'totalPages' => $totalPages,
            'search' => $search
        ];
        
        loadView('veiculos/listar', $data);
    }
    
    /**
     * Criar veículo
     */
    public function criar() {
        requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Dados do veículo
            $veiculoData = [
                'marca' => $_POST['marca'] ?? '',
                'modelo' => $_POST['modelo'] ?? '',
                'ano' => $_POST['ano'] ?? '',
                'observacoes' => $_POST['observacoes_veiculo'] ?? ''
            ];
            
            // Dados das molas originais
            $molasData = [];
            
            // Mola dianteira
            if (!empty($_POST['fio_mm_dianteira'])) {
                $molasData['dianteira'] = [
                    'posicao' => 'dianteira',
                    'quantidade' => $_POST['quantidade_dianteira'] ?? 2,
                    'fio_mm' => $_POST['fio_mm_dianteira'],
                    'altura_livre_mm' => $_POST['altura_livre_mm_dianteira'],
                    'diametro_interno_mm' => $_POST['diametro_interno_mm_dianteira'],
                    'vao_entre_espiras_mm' => $_POST['vao_entre_espiras_mm_dianteira'],
                    'retifica' => isset($_POST['retifica_dianteira']) && $_POST['retifica_dianteira'] == '1',
                    'olhal_cima_mm' => $_POST['olhal_cima_mm_dianteira'] ?? null,
                    'olhal_baixo_mm' => $_POST['olhal_baixo_mm_dianteira'] ?? null,
                    'tipo_ponta' => $_POST['tipo_ponta_dianteira'] ?? 'fechada',
                    'medida_ponta_mm' => $_POST['medida_ponta_mm_dianteira'] ?? null,
                    'entre_elo_mm' => $_POST['entre_elo_mm_dianteira'] ?? null,
                    'espiras_ativas' => $_POST['espiras_ativas_dianteira'] ?? null,
                    'espiras_totais' => $_POST['espiras_totais_dianteira']
                ];
            }
            
            // Mola traseira
            if (!empty($_POST['fio_mm_traseira'])) {
                $molasData['traseira'] = [
                    'posicao' => 'traseira',
                    'quantidade' => $_POST['quantidade_traseira'] ?? 2,
                    'fio_mm' => $_POST['fio_mm_traseira'],
                    'altura_livre_mm' => $_POST['altura_livre_mm_traseira'],
                    'diametro_interno_mm' => $_POST['diametro_interno_mm_traseira'],
                    'vao_entre_espiras_mm' => $_POST['vao_entre_espiras_mm_traseira'],
                    'retifica' => isset($_POST['retifica_traseira']) && $_POST['retifica_traseira'] == '1',
                    'olhal_cima_mm' => $_POST['olhal_cima_mm_traseira'] ?? null,
                    'olhal_baixo_mm' => $_POST['olhal_baixo_mm_traseira'] ?? null,
                    'tipo_ponta' => $_POST['tipo_ponta_traseira'] ?? 'fechada',
                    'medida_ponta_mm' => $_POST['medida_ponta_mm_traseira'] ?? null,
                    'entre_elo_mm' => $_POST['entre_elo_mm_traseira'] ?? null,
                    'espiras_ativas' => $_POST['espiras_ativas_traseira'] ?? null,
                    'espiras_totais' => $_POST['espiras_totais_traseira']
                ];
            }
            
            try {
                // Iniciar transação
                $db = Database::getInstance();
                $db->beginTransaction();
                
                // Criar veículo
                $veiculoId = $this->veiculoModel->create($veiculoData);
                
                // Criar molas originais
                foreach ($molasData as $molaData) {
                    $molaData['veiculo_id'] = $veiculoId;
                    $this->molaOriginalModel->create($molaData);
                }
                
                $db->commit();
                
                $_SESSION['success'] = 'Veículo criado com sucesso';
                redirect('veiculos/listar');
                
            } catch (Exception $e) {
                $db->rollBack();
                $_SESSION['error'] = 'Erro ao criar veículo: ' . $e->getMessage();
                // Manter dados do formulário
                $_SESSION['form_data'] = $_POST;
                redirect('veiculos/criar');
            }
        }
        
        // Recuperar dados do formulário se houver erro
        $formData = $_SESSION['form_data'] ?? [];
        unset($_SESSION['form_data']);
        
        $data = ['formData' => $formData];
        loadView('veiculos/criar', $data);
    }
    
    /**
     * Editar veículo
     */
    public function editar($id = null) {
        requireAuth();
        
        if (!$id) {
            $_SESSION['error'] = 'ID do veículo não informado';
            redirect('veiculos/listar');
        }
        
        $veiculo = $this->veiculoModel->findById($id);
        
        if (!$veiculo) {
            $_SESSION['error'] = 'Veículo não encontrado';
            redirect('veiculos/listar');
        }
        
        // Buscar molas originais
        $molas = $this->molaOriginalModel->findByVeiculo($id);
        $molasPorPosicao = [];
        foreach ($molas as $mola) {
            $molasPorPosicao[$mola['posicao']] = $mola;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Dados do veículo
            $veiculoData = [
                'marca' => $_POST['marca'] ?? '',
                'modelo' => $_POST['modelo'] ?? '',
                'ano' => $_POST['ano'] ?? '',
                'observacoes' => $_POST['observacoes_veiculo'] ?? ''
            ];
            
            // Dados das molas originais
            $molasData = [];
            
            // Mola dianteira
            if (!empty($_POST['fio_mm_dianteira'])) {
                $molasData['dianteira'] = [
                    'posicao' => 'dianteira',
                    'quantidade' => $_POST['quantidade_dianteira'] ?? 2,
                    'fio_mm' => $_POST['fio_mm_dianteira'],
                    'altura_livre_mm' => $_POST['altura_livre_mm_dianteira'],
                    'diametro_interno_mm' => $_POST['diametro_interno_mm_dianteira'],
                    'vao_entre_espiras_mm' => $_POST['vao_entre_espiras_mm_dianteira'],
                    'retifica' => isset($_POST['retifica_dianteira']) && $_POST['retifica_dianteira'] == '1',
                    'olhal_cima_mm' => $_POST['olhal_cima_mm_dianteira'] ?? null,
                    'olhal_baixo_mm' => $_POST['olhal_baixo_mm_dianteira'] ?? null,
                    'tipo_ponta' => $_POST['tipo_ponta_dianteira'] ?? 'fechada',
                    'medida_ponta_mm' => $_POST['medida_ponta_mm_dianteira'] ?? null,
                    'entre_elo_mm' => $_POST['entre_elo_mm_dianteira'] ?? null,
                    'espiras_ativas' => $_POST['espiras_ativas_dianteira'] ?? null,
                    'espiras_totais' => $_POST['espiras_totais_dianteira']
                ];
            }
            
            // Mola traseira
            if (!empty($_POST['fio_mm_traseira'])) {
                $molasData['traseira'] = [
                    'posicao' => 'traseira',
                    'quantidade' => $_POST['quantidade_traseira'] ?? 2,
                    'fio_mm' => $_POST['fio_mm_traseira'],
                    'altura_livre_mm' => $_POST['altura_livre_mm_traseira'],
                    'diametro_interno_mm' => $_POST['diametro_interno_mm_traseira'],
                    'vao_entre_espiras_mm' => $_POST['vao_entre_espiras_mm_traseira'],
                    'retifica' => isset($_POST['retifica_traseira']) && $_POST['retifica_traseira'] == '1',
                    'olhal_cima_mm' => $_POST['olhal_cima_mm_traseira'] ?? null,
                    'olhal_baixo_mm' => $_POST['olhal_baixo_mm_traseira'] ?? null,
                    'tipo_ponta' => $_POST['tipo_ponta_traseira'] ?? 'fechada',
                    'medida_ponta_mm' => $_POST['medida_ponta_mm_traseira'] ?? null,
                    'entre_elo_mm' => $_POST['entre_elo_mm_traseira'] ?? null,
                    'espiras_ativas' => $_POST['espiras_ativas_traseira'] ?? null,
                    'espiras_totais' => $_POST['espiras_totais_traseira']
                ];
            }
            
            try {
                // Iniciar transação
                $db = Database::getInstance();
                $db->beginTransaction();
                
                // Atualizar veículo
                $this->veiculoModel->update($id, $veiculoData);
                
                // Atualizar ou criar molas originais
                foreach ($molasData as $posicao => $molaData) {
                    if (isset($molasPorPosicao[$posicao])) {
                        // Atualizar mola existente
                        $this->molaOriginalModel->update($molasPorPosicao[$posicao]['id'], $molaData);
                    } else {
                        // Criar nova mola
                        $molaData['veiculo_id'] = $id;
                        $this->molaOriginalModel->create($molaData);
                    }
                }
                
                $db->commit();
                
                $_SESSION['success'] = 'Veículo atualizado com sucesso';
                redirect('veiculos/listar');
                
            } catch (Exception $e) {
                $db->rollBack();
                $_SESSION['error'] = 'Erro ao atualizar veículo: ' . $e->getMessage();
            }
        }
        
        $data = [
            'veiculo' => $veiculo,
            'molas' => $molasPorPosicao
        ];
        
        loadView('veiculos/editar', $data);
    }
    
    /**
     * Excluir veículo
     */
    public function excluir($id = null) {
        requireAuth();
        
        if (!$id) {
            $_SESSION['error'] = 'ID do veículo não informado';
            redirect('veiculos/listar');
        }
        
        try {
            $this->veiculoModel->delete($id);
            $_SESSION['success'] = 'Veículo excluído com sucesso';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erro ao excluir veículo: ' . $e->getMessage();
        }
        
        redirect('veiculos/listar');
    }
}