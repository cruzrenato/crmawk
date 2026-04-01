<?php
/**
 * Sistema CRM de Molas Helicoidais - Index Principal
 * Roteador MVC Manual
 */

// Iniciar sessão
session_start();

// Configurações
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']));
define('ROOT_PATH', __DIR__);
define('APP_NAME', 'Molas CRM');

// Incluir configurações
require_once 'config/database.php';

// Função para carregar classes automaticamente
spl_autoload_register(function($className) {
    $directories = ['models/', 'controllers/'];
    
    foreach ($directories as $directory) {
        $file = ROOT_PATH . '/' . $directory . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Função para carregar views
function loadView($viewPath, $data = []) {
    extract($data);
    $viewFile = ROOT_PATH . '/views/' . $viewPath . '.php';
    
    if (file_exists($viewFile)) {
        require_once $viewFile;
    } else {
        die("View não encontrada: " . $viewPath);
    }
}

// Função para redirecionar
function redirect($url) {
    header("Location: " . BASE_URL . '/' . $url);
    exit();
}

// Função para verificar autenticação
function requireAuth() {
    if (!isset($_SESSION['usuario_id'])) {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        redirect('login');
    }
}

// Função para verificar permissão de administrador
function requireAdmin() {
    requireAuth();
    if ($_SESSION['usuario_perfil'] !== 'administrador') {
        $_SESSION['error'] = 'Acesso restrito a administradores';
        redirect('dashboard');
    }
}

// Função para exibir mensagens flash
function flash($type, $message) {
    $_SESSION['flash_' . $type] = $message;
}

// Função para obter mensagens flash
function getFlash($type) {
    if (isset($_SESSION['flash_' . $type])) {
        $message = $_SESSION['flash_' . $type];
        unset($_SESSION['flash_' . $type]);
        return $message;
    }
    return null;
}

// Obter URL da requisição
$url = isset($_GET['url']) ? $_GET['url'] : 'dashboard';
$url = rtrim($url, '/');
$urlParts = explode('/', $url);

// Roteamento
$controllerName = isset($urlParts[0]) ? ucfirst($urlParts[0]) . 'Controller' : 'DashboardController';
$action = isset($urlParts[1]) ? $urlParts[1] : 'index';
$params = array_slice($urlParts, 2);

// Rotas públicas (não requerem autenticação)
$publicRoutes = ['login', 'logout', 'ficha'];

// Verificar se a rota é pública
$isPublicRoute = in_array($urlParts[0], $publicRoutes);

// Se não for rota pública, requer autenticação
if (!$isPublicRoute && $urlParts[0] !== '') {
    requireAuth();
}

// Carregar controller
$controllerFile = ROOT_PATH . '/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    // Verificar se a classe existe
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        
        // Verificar se o método existe
        if (method_exists($controller, $action)) {
            // Chamar o método com parâmetros
            call_user_func_array([$controller, $action], $params);
        } else {
            // Método não encontrado
            http_response_code(404);
            loadView('errors/404');
        }
    } else {
        // Classe não encontrada
        http_response_code(404);
        loadView('errors/404');
    }
} else {
    // Controller não encontrado - tentar rota especial
    
    // Rota para formulário externo de cadastro
    if ($urlParts[0] === 'ficha' && isset($urlParts[1])) {
        $token = $urlParts[1];
        require_once ROOT_PATH . '/controllers/LinkCadastroController.php';
        $controller = new LinkCadastroController();
        $controller->formularioExterno($token);
        exit();
    }
    
    // Rota para API
    if ($urlParts[0] === 'api') {
        $apiFile = ROOT_PATH . '/api/' . $urlParts[1] . '.php';
        if (file_exists($apiFile)) {
            require_once $apiFile;
            exit();
        }
    }
    
    // Página não encontrada
    http_response_code(404);
    loadView('errors/404');
}

// Inicializar modelos básicos se não existirem
function initializeModels() {
    $db = Database::getInstance();
    
    // Verificar se a tabela de usuários existe
    if (!$db->tableExists('usuarios')) {
        // Executar schema.sql
        $schemaFile = ROOT_PATH . '/database/schema.sql';
        if (file_exists($schemaFile)) {
            $sql = file_get_contents($schemaFile);
            $db->getConnection()->exec($sql);
        }
    }
}

// Executar inicialização se necessário
initializeModels();