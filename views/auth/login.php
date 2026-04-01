<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo APP_NAME; ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --bg-main: #0f172a;
            --bg-card: #1e293b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border: #334155;
            --input-bg: #0f172a;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        /* Abstract Background Elements */
        body::before, body::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #818cf8);
            filter: blur(150px);
            opacity: 0.1;
            z-index: -1;
        }

        body::before { top: -100px; left: -100px; }
        body::after { bottom: -100px; right: -100px; }

        .login-container {
            width: 100%;
            max-width: 440px;
            animation: fadeIn 0.8s ease-out;
        }

        .login-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .logo {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary), #818cf8);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
        }

        .login-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .login-header p {
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-muted);
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            transition: var(--transition);
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1.25rem 0.875rem 3.25rem;
            background-color: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            color: var(--text-main);
            font-size: 1rem;
            outline: none;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .form-control:focus + i {
            color: var(--primary);
        }

        .btn-login {
            width: 100%;
            padding: 1rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .btn-login:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        }

        .error-message {
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border: 1px solid rgba(239, 68, 68, 0.2);
            animation: shake 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .login-footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .login-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo">
                    <i class="fas fa-microchip"></i>
                </div>
                <h1>Bem-vindo</h1>
                <p>Acesse o painel do AWK CRM</p>
            </div>

            <?php 
            $session_error = getFlash('error');
            if ($session_error): 
            ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo $session_error; ?></span>
                </div>
            <?php endif; ?>

            <form action="<?php echo BASE_URL; ?>/login" method="POST">
                <div class="form-group">
                    <label class="form-label" for="username">Usuário</label>
                    <div class="input-group">
                        <input type="text" id="username" name="username" class="form-control" placeholder="admin" required autofocus>
                        <i class="fas fa-user"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Senha</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                        <i class="fas fa-lock"></i>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <span>Entrar no Sistema</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>
        </div>
        
        <div class="login-footer">
            <p>&copy; <?php echo date('Y'); ?> AWK CRM - Molas Helicoidais</p>
            <p>Desenvolvido com <i class="fas fa-heart" style="color: #ef4444;"></i> para precisão total.</p>
        </div>
    </div>
</body>
</html>
