<?php
/**
 * Controller de Usuários
 */

class UsuarioController {
    private $usuarioModel;
    
    public function __construct() {
        $this->usuarioModel = new Usuario();
    }
    
    /**
     * Listar usuários
     */
    public function listar() {
        requireAdmin();
        
        $page = $_GET['page'] ?? 1;
        $search = $_GET['search'] ?? '';
        
        $usuarios = $this->usuarioModel->findAll($page, 20);
        $total = $this->usuarioModel->countAll();
        $totalPages = ceil($total / 20);
        
        $data = [
            'usuarios' => $usuarios,
            'page' => $page,
            'totalPages' => $totalPages,
            'search' => $search
        ];
        
        loadView('usuarios/listar', $data);
    }
    
    /**
     * Criar usuário
     */
    public function criar() {
        requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nome_usuario' => $_POST['nome_usuario'] ?? '',
                'senha' => $_POST['senha'] ?? '',
                'nome_exibicao' => $_POST['nome_exibicao'] ?? '',
                'perfil' => $_POST['perfil'] ?? 'usuario',
                'tema_preferido' => $_POST['tema_preferido'] ?? 'claro'
            ];
            
            // Validações
            $errors = [];
            
            if (empty($data['nome_usuario'])) {
                $errors[] = 'Nome de usuário é obrigatório';
            }
            
            if (empty($data['senha'])) {
                $errors[] = 'Senha é obrigatória';
            } elseif (strlen($data['senha']) < 6) {
                $errors[] = 'Senha deve ter no mínimo 6 caracteres';
            }
            
            if (empty($data['nome_exibicao'])) {
                $errors[] = 'Nome de exibição é obrigatório';
            }
            
            if ($this->usuarioModel->usernameExists($data['nome_usuario'])) {
                $errors[] = 'Nome de usuário já está em uso';
            }
            
            if (empty($errors)) {
                try {
                    $this->usuarioModel->create($data);
                    $_SESSION['success'] = 'Usuário criado com sucesso';
                    redirect('usuarios/listar');
                } catch (Exception $e) {
                    $_SESSION['error'] = 'Erro ao criar usuário: ' . $e->getMessage();
                }
            } else {
                $_SESSION['error'] = implode('<br>', $errors);
            }
        }
        
        loadView('usuarios/criar');
    }
    
    /**
     * Editar usuário
     */
    public function editar($id = null) {
        requireAdmin();
        
        if (!$id) {
            $_SESSION['error'] = 'ID do usuário não informado';
            redirect('usuarios/listar');
        }
        
        $usuario = $this->usuarioModel->findById($id);
        
        if (!$usuario) {
            $_SESSION['error'] = 'Usuário não encontrado';
            redirect('usuarios/listar');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nome_exibicao' => $_POST['nome_exibicao'] ?? '',
                'perfil' => $_POST['perfil'] ?? 'usuario',
                'tema_preferido' => $_POST['tema_preferido'] ?? 'claro'
            ];
            
            // Se senha foi fornecida, atualizar
            if (!empty($_POST['senha'])) {
                if (strlen($_POST['senha']) < 6) {
                    $_SESSION['error'] = 'Senha deve ter no mínimo 6 caracteres';
                    redirect('usuarios/editar/' . $id);
                }
                $data['senha'] = $_POST['senha'];
            }
            
            try {
                $this->usuarioModel->update($id, $data);
                $_SESSION['success'] = 'Usuário atualizado com sucesso';
                redirect('usuarios/listar');
            } catch (Exception $e) {
                $_SESSION['error'] = 'Erro ao atualizar usuário: ' . $e->getMessage();
            }
        }
        
        $data = ['usuario' => $usuario];
        loadView('usuarios/editar', $data);
    }
    
    /**
     * Excluir usuário
     */
    public function excluir($id = null) {
        requireAdmin();
        
        if (!$id) {
            $_SESSION['error'] = 'ID do usuário não informado';
            redirect('usuarios/listar');
        }
        
        // Não permitir excluir a si mesmo
        if ($id == $_SESSION['usuario_id']) {
            $_SESSION['error'] = 'Não é possível excluir seu próprio usuário';
            redirect('usuarios/listar');
        }
        
        try {
            $this->usuarioModel->delete($id);
            $_SESSION['success'] = 'Usuário excluído com sucesso';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erro ao excluir usuário: ' . $e->getMessage();
        }
        
        redirect('usuarios/listar');
    }
}