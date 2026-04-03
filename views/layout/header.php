<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - ' . APP_NAME : APP_NAME; ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --secondary: #64748b;
            --accent: #f59e0b;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --bg-main: #0f172a;
            --bg-sidebar: #1e293b;
            --bg-card: #1e293b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border: #334155;
            --input-bg: #0f172a;
            --sidebar-width: 260px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-theme="claro"] {
            --bg-main: #f1f5f9;
            --bg-sidebar: #ffffff;
            --bg-card: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --input-bg: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            transition: var(--transition);
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: var(--transition);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid var(--border);
        }

        .logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), #818cf8);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .brand-name {
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: -0.5px;
            background: linear-gradient(to right, var(--text-main), var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-menu {
            padding: 1.5rem 1rem;
            flex: 1;
            overflow-y: auto;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.875rem 1rem;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 0.5rem;
            transition: var(--transition);
            font-weight: 500;
        }

        .nav-item:hover {
            background-color: rgba(99, 102, 241, 0.1);
            color: var(--primary);
        }

        .nav-item.active {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
        }

        .nav-item i {
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid var(--border);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .user-details {
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.875rem;
            display: block;
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 2rem;
            width: calc(100% - var(--sidebar-width));
        }

        header.top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-title h1 {
            font-size: 1.875rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .breadcrumb {
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn {
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            font-size: 0.875rem;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--border);
            color: var(--text-main);
        }

        .btn-outline:hover {
            background-color: var(--border);
        }

        /* Notifications / Search */
        .search-box {
            position: relative;
            width: 300px;
        }

        .search-box input {
            width: 100%;
            padding: 0.625rem 1rem 0.625rem 2.5rem;
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text-main);
            outline: none;
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        /* Flash Messages */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideIn 0.3s ease-out;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .alert-error {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Card Styles */
        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body data-theme="<?php echo isset($_SESSION['usuario_tema']) ? $_SESSION['usuario_tema'] : 'escuro'; ?>">

<?php if (isset($_SESSION['usuario_id'])): ?>
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <i class="fas fa-microchip"></i>
        </div>
        <span class="brand-name">AWK CRM</span>
    </div>
    
    <nav class="nav-menu">
        <a href="<?php echo BASE_URL; ?>/dashboard" class="nav-item <?php echo $urlParts[0] == 'dashboard' ? 'active' : ''; ?>">
            <i class="fas fa-th-large"></i>
            <span>Dashboard</span>
        </a>
        <a href="<?php echo BASE_URL; ?>/clientes" class="nav-item <?php echo $urlParts[0] == 'clientes' ? 'active' : ''; ?>">
            <i class="fas fa-users"></i>
            <span>Clientes</span>
        </a>
        <a href="<?php echo BASE_URL; ?>/veiculos" class="nav-item <?php echo $urlParts[0] == 'veiculos' ? 'active' : ''; ?>">
            <i class="fas fa-car"></i>
            <span>Veículos</span>
        </a>
        <a href="<?php echo BASE_URL; ?>/projetos" class="nav-item <?php echo $urlParts[0] == 'projetos' ? 'active' : ''; ?>">
            <i class="fas fa-project-diagram"></i>
            <span>Projetos</span>
        </a>
        <a href="<?php echo BASE_URL; ?>/usuarios" class="nav-item <?php echo $urlParts[0] == 'usuarios' ? 'active' : ''; ?>">
            <i class="fas fa-user-shield"></i>
            <span>Usuários</span>
        </a>
    </nav>
    
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="user-details">
                <span class="user-name"><?php echo $_SESSION['usuario_nome'] ?? 'Admin'; ?></span>
                <span class="user-role"><?php echo ucfirst($_SESSION['usuario_perfil'] ?? 'Usuário'); ?></span>
            </div>
            <a href="<?php echo BASE_URL; ?>/logout" title="Sair" style="color: var(--text-muted);">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>
</aside>
<?php endif; ?>

<main class="main-content">
    <?php if (isset($_SESSION['usuario_id'])): ?>
    <header class="top-bar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Pesquisar...">
        </div>
        
        <div class="actions">
            <button class="btn btn-outline" id="theme-toggle">
                <i class="fas fa-moon"></i>
            </button>
            <a href="<?php echo BASE_URL; ?>/projetos/criar" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Novo Projeto
            </a>
        </div>
    </header>
    <?php endif; ?>

    <!-- Flash Messages -->
    <?php 
    $flashError = getFlash('error');
    $flashSuccess = getFlash('success');
    ?>
    
    <?php if ($flashError): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <span><?php echo $flashError; ?></span>
        </div>
    <?php endif; ?>
    
    <?php if ($flashSuccess): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <span><?php echo $flashSuccess; ?></span>
        </div>
    <?php endif; ?>
