<?php
/**
 * Controller de Links de Cadastro e Ficha Externa
 */

class LinkCadastroController {
    private $linkModel;
    private $clienteModel;
    
    public function __construct() {
        $this->linkModel = new LinkCadastro();
        $this->clienteModel = new Cliente();
    }
    
    /**
     * Listar links (Admin)
     */
    public function index() {
        requireAuth();
        
        $this->linkModel->limparExpirados();
        
        // Buscar links recentes (sem paginação por enquanto)
        $sql = "SELECT l.*, c.nome as cliente_nome 
                FROM links_cadastro l 
                LEFT JOIN clientes c ON l.cliente_id = c.id 
                ORDER BY l.criado_em DESC LIMIT 100";
        $links = db_fetch_all($sql);
        
        $data = ['links' => $links];
        loadView('links/index', $data);
    }
    
    /**
     * Gerar link avulso (para novo cliente)
     */
    public function gerarAvulso() {
        requireAuth();
        
        $token = $this->linkModel->create(null);
        $link = BASE_URL . '/ficha/' . $token;
        flash('success', "Link externo gerado com sucesso! <br><br>Copie e envie para seu cliente: <br><br><b><a href='$link' target='_blank' style='color:#fff; text-decoration:underline;'>$link</a></b>");
        
        $referer = $_SERVER['HTTP_REFERER'] ?? BASE_URL . '/clientes';
        redirect($referer);
    }
    
    /**
     * Formulário Externo (Público)
     */
    public function formularioExterno($token) {
        // NÃO usar requireAuth() aqui!
        
        if (!$this->linkModel->isValid($token)) {
            loadView('errors/token_invalido');
            return;
        }
        
        $link = $this->linkModel->findByToken($token);
        $cliente = null;
        
        if ($link['cliente_id']) {
            $cliente = $this->clienteModel->findById($link['cliente_id']);
        }
        
        $data = [
            'token' => $token,
            'cliente' => $cliente,
            'isExternal' => true
        ];
        
        // Carrega uma view específica que não deve ter o menu lateral padrão
        loadView('ficha/externo', $data);
    }
    
    /**
     * Salvar Cadastro Externo (Público)
     */
    public function salvarExterno() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('login');
        }
        
        $token = $_POST['token'] ?? '';
        
        if (!$this->linkModel->isValid($token)) {
            $_SESSION['error'] = 'Link de cadastro inválido ou expirado';
            redirect('login');
        }
        
        $link = $this->linkModel->findByToken($token);
        
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
            if ($link['cliente_id']) {
                // Atualizar cliente existente
                $this->clienteModel->update($link['cliente_id'], $data);
                $clienteId = $link['cliente_id'];
            } else {
                // Criar novo cliente
                $clienteId = $this->clienteModel->create($data);
            }
            
            // Marcar link como usado
            $this->linkModel->marcarComoUsado($token, $clienteId);
            
            // Sucesso - carregar uma página de agradecimento
            loadView('ficha/sucesso');
            
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erro ao processar cadastro: ' . $e->getMessage();
            $_SESSION['form_data'] = $data;
            redirect('ficha/' . $token);
        }
    }
}
