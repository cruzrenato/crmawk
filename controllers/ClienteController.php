<?php
/**
 * Controller de Clientes
 */

class ClienteController {
    private $clienteModel;
    private $linkCadastroModel;
    
    public function __construct() {
        $this->clienteModel = new Cliente();
        $this->linkCadastroModel = new LinkCadastro();
    }
    
    /**
     * Listar clientes
     */
    public function listar() {
        requireAuth();
        
        $page = $_GET['page'] ?? 1;
        $search = $_GET['search'] ?? '';
        
        $clientes = $this->clienteModel->findAll($page, 20, $search);
        $total = $this->clienteModel->countAll($search);
        $totalPages = ceil($total / 20);
        
        $data = [
            'clientes' => $clientes,
            'page' => $page,
            'totalPages' => $totalPages,
            'search' => $search
        ];
        
        loadView('clientes/listar', $data);
    }
    
    /**
     * Criar cliente
     */
    public function criar() {
        requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nome' => $_POST['nome'] ?? '',
                'aniversario_dia' => $_POST['aniversario_dia'] ?? '',
                'aniversario_mes' => $_POST['aniversario_mes'] ?? '',
                'cpf_cnpj' => $_POST['cpf_cnpj'] ?? '',
                'cep' => $_POST['cep'] ?? '',
                'endereco' => $_POST['endereco'] ?? '',
                'numero' => $_POST['numero'] ?? '',
                'bairro' => $_POST['bairro'] ?? '',
                'cidade' => $_POST['cidade'] ?? '',
                'estado_uf' => $_POST['estado_uf'] ?? '',
                'telefone' => $_POST['telefone'] ?? '',
                'telefone2' => $_POST['telefone2'] ?? '',
                'email' => $_POST['email'] ?? '',
                'observacoes' => $_POST['observacoes'] ?? ''
            ];
            
            try {
                $clienteId = $this->clienteModel->create($data);
                $_SESSION['success'] = 'Cliente criado com sucesso';
                redirect('clientes/ficha/' . $clienteId);
            } catch (Exception $e) {
                $_SESSION['error'] = 'Erro ao criar cliente: ' . $e->getMessage();
                // Manter dados do formulário
                $_SESSION['form_data'] = $data;
                redirect('clientes/criar');
            }
        }
        
        // Recuperar dados do formulário se houver erro
        $formData = $_SESSION['form_data'] ?? [];
        unset($_SESSION['form_data']);
        
        $data = ['formData' => $formData];
        loadView('clientes/criar', $data);
    }
    
    /**
     * Editar cliente
     */
    public function editar($id = null) {
        requireAuth();
        
        if (!$id) {
            $_SESSION['error'] = 'ID do cliente não informado';
            redirect('clientes/listar');
        }
        
        $cliente = $this->clienteModel->findById($id);
        
        if (!$cliente) {
            $_SESSION['error'] = 'Cliente não encontrado';
            redirect('clientes/listar');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nome' => $_POST['nome'] ?? '',
                'aniversario_dia' => $_POST['aniversario_dia'] ?? '',
                'aniversario_mes' => $_POST['aniversario_mes'] ?? '',
                'cpf_cnpj' => $_POST['cpf_cnpj'] ?? '',
                'cep' => $_POST['cep'] ?? '',
                'endereco' => $_POST['endereco'] ?? '',
                'numero' => $_POST['numero'] ?? '',
                'bairro' => $_POST['bairro'] ?? '',
                'cidade' => $_POST['cidade'] ?? '',
                'estado_uf' => $_POST['estado_uf'] ?? '',
                'telefone' => $_POST['telefone'] ?? '',
                'telefone2' => $_POST['telefone2'] ?? '',
                'email' => $_POST['email'] ?? '',
                'observacoes' => $_POST['observacoes'] ?? ''
            ];
            
            try {
                $this->clienteModel->update($id, $data);
                $_SESSION['success'] = 'Cliente atualizado com sucesso';
                redirect('clientes/ficha/' . $id);
            } catch (Exception $e) {
                $_SESSION['error'] = 'Erro ao atualizar cliente: ' . $e->getMessage();
            }
        }
        
        $data = ['cliente' => $cliente];
        loadView('clientes/editar', $data);
    }
    
    /**
     * Excluir cliente
     */
    public function excluir($id = null) {
        requireAuth();
        
        if (!$id) {
            $_SESSION['error'] = 'ID do cliente não informado';
            redirect('clientes/listar');
        }
        
        try {
            $this->clienteModel->delete($id);
            $_SESSION['success'] = 'Cliente excluído com sucesso';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erro ao excluir cliente: ' . $e->getMessage();
        }
        
        redirect('clientes/listar');
    }
    
    /**
     * Ficha do cliente
     */
    public function ficha($id = null) {
        requireAuth();
        
        if (!$id) {
            $_SESSION['error'] = 'ID do cliente não informado';
            redirect('clientes/listar');
        }
        
        $cliente = $this->clienteModel->findById($id);
        
        if (!$cliente) {
            $_SESSION['error'] = 'Cliente não encontrado';
            redirect('clientes/listar');
        }
        
        // Buscar projetos do cliente
        $projetos = $this->clienteModel->getProjetos($id);
        
        // Buscar links de cadastro
        $links = $this->linkCadastroModel->findByCliente($id);
        $linksCount = $this->linkCadastroModel->countByStatus($id);
        
        $data = [
            'cliente' => $cliente,
            'projetos' => $projetos,
            'links' => $links,
            'linksCount' => $linksCount
        ];
        
        loadView('clientes/ficha', $data);
    }
    
    /**
     * Gerar link de cadastro
     */
    public function gerarLink($clienteId = null) {
        requireAuth();
        
        if (!$clienteId) {
            $_SESSION['error'] = 'ID do cliente não informado';
            redirect('clientes/listar');
        }
        
        // Invalidar links anteriores
        $this->linkCadastroModel->invalidarLinksAnteriores($clienteId);
        
        // Gerar novo link
        $token = $this->linkCadastroModel->create($clienteId);
        
        $_SESSION['success'] = 'Link gerado com sucesso';
        $_SESSION['link_gerado'] = BASE_URL . '/ficha/' . $token;
        
        redirect('clientes/ficha/' . $clienteId);
    }
}