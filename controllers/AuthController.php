<?php
/**
 * Controller de Autenticação
 */

class AuthController {
    private $usuarioModel;
    
    public function __construct() {
        $this->usuarioModel = new Usuario();
    }
    
    /**
     * Página de login
     */
    public function login() {
        // Se já estiver logado, redirecionar para dashboard
        if (isset($_SESSION['usuario_id'])) {
            redirect('dashboard');
        }
        
        // Processar formulário de login
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // Validar campos
            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'Preencha todos os campos';
                redirect('login');
            }
            
            // Autenticar usuário
            $user = $this->usuarioModel->authenticate($username, $password);
            
            if ($user) {
                // Criar sessão
                $_SESSION['usuario_id'] = $user['id'];
                $_SESSION['usuario_nome'] = $user['nome_exibicao'];
                $_SESSION['usuario_perfil'] = $user['perfil'];
                $_SESSION['usuario_tema'] = $user['tema_preferido'];
                
                // Redirecionar para URL anterior ou dashboard
                $redirectUrl = $_SESSION['redirect_url'] ?? 'dashboard';
                unset($_SESSION['redirect_url']);
                
                redirect($redirectUrl);
            } else {
                $_SESSION['error'] = 'Usuário ou senha inválidos';
                redirect('login');
            }
        }
        
        // Carregar view de login
        loadView('auth/login');
    }
    
    /**
     * Logout
     */
    public function logout() {
        // Destruir sessão
        session_destroy();
        
        // Redirecionar para login
        redirect('login');
    }
    
    /**
     * Alterar tema
     */
    public function tema() {
        requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tema = $_POST['tema'] ?? 'claro';
            
            if (in_array($tema, ['claro', 'escuro'])) {
                // Atualizar no banco
                $this->usuarioModel->updateTheme($_SESSION['usuario_id'], $tema);
                
                // Atualizar na sessão
                $_SESSION['usuario_tema'] = $tema;
                
                // Salvar no localStorage via cookie
                setcookie('tema_preferido', $tema, time() + (86400 * 30), '/');
                
                echo json_encode(['success' => true, 'tema' => $tema]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Tema inválido']);
            }
            exit();
        }
        
        // Se não for POST, redirecionar
        redirect('dashboard');
    }
}