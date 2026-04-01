<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de Cadastro - AWK CRM</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --bg-main: #f1f5f9;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --card-bg: #ffffff;
            --transition: all 0.3s ease;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--bg-main); color: var(--text-main); display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 1rem; }
        .form-container { background-color: var(--card-bg); width: 100%; max-width: 800px; padding: 2.5rem; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .header { text-align: center; margin-bottom: 2.5rem; }
        .logo { width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary), #818cf8); border-radius: 15px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; margin: 0 auto 1rem; }
        h1 { font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem; }
        p { color: var(--text-muted); font-size: 0.9375rem; }
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 2rem; }
        @media (max-width: 600px) { .form-grid { grid-template-columns: 1fr; } }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: 0.8125rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; }
        input, select, textarea { width: 100%; padding: 0.75rem 1rem; border: 1.5px solid var(--border); border-radius: 12px; font-size: 0.9375rem; outline: none; transition: var(--transition); background-color: #f8fafc; }
        input:focus, select:focus, textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); }
        .section-title { grid-column: 1 / -1; margin: 1.5rem 0 0.5rem; font-size: 0.875rem; color: var(--primary); font-weight: 700; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem; }
        .btn { width: 100%; padding: 1rem; background-color: var(--primary); color: white; border: none; border-radius: 12px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: var(--transition); margin-top: 1rem; }
        .btn:hover { background-color: var(--primary-hover); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2); }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="header">
            <div class="logo"><i class="fas fa-microchip"></i></div>
            <h1>Ficha de Cadastro</h1>
            <p>Olá! Por favor, preencha seus dados abaixo para seguirmos com seu projeto.</p>
        </div>

        <form action="<?php echo BASE_URL; ?>/linkCadastro/salvarExterno" method="POST">
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            
            <div class="form-grid">
                <div class="section-title">DADOS PESSOAIS / EMPRESA</div>
                
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Nome Completo / Razão Social</label>
                    <input type="text" name="nome" value="<?php echo $cliente['nome'] ?? ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>CPF / CNPJ</label>
                    <input type="text" name="cpf_cnpj" value="<?php echo $cliente['cpf_cnpj'] ?? ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Aniversário (Dia/Mês)</label>
                    <div style="display: flex; gap: 0.5rem;">
                        <input type="number" name="aniversario_dia" placeholder="Dia" value="<?php echo $cliente['aniversario_dia'] ?? ''; ?>" min="1" max="31" style="flex: 1;">
                        <input type="number" name="aniversario_mes" placeholder="Mês" value="<?php echo $cliente['aniversario_mes'] ?? ''; ?>" min="1" max="12" style="flex: 1;">
                    </div>
                </div>

                <div class="section-title">CONTATO</div>
                
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" value="<?php echo $cliente['email'] ?? ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Telefone (WhatsApp)</label>
                    <input type="text" name="telefone" value="<?php echo $cliente['telefone'] ?? ''; ?>" required>
                </div>

                <div class="section-title">ENDEREÇO DE ENTREGA</div>
                
                <div class="form-group">
                    <label>CEP</label>
                    <input type="text" name="cep" value="<?php echo $cliente['cep'] ?? ''; ?>" required>
                </div>
                
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Endereço</label>
                    <input type="text" name="endereco" value="<?php echo $cliente['endereco'] ?? ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Número / Apto</label>
                    <input type="text" name="numero" value="<?php echo $cliente['numero'] ?? ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Bairro</label>
                    <input type="text" name="bairro" value="<?php echo $cliente['bairro'] ?? ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Cidade</label>
                    <input type="text" name="cidade" value="<?php echo $cliente['cidade'] ?? ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Estado (UF)</label>
                    <select name="estado_uf" required>
                        <option value="">Selecione...</option>
                        <?php 
                        $ufs = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];
                        foreach ($ufs as $uf): ?>
                            <option value="<?php echo $uf; ?>" <?php echo (($cliente['estado_uf'] ?? '') == $uf) ? 'selected' : ''; ?>><?php echo $uf; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="section-title">OUTRAS INFORMAÇÕES</div>
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Observações / Como nos conheceu?</label>
                    <textarea name="observacoes" rows="3"><?php echo $cliente['observacoes'] ?? ''; ?></textarea>
                </div>
            </div>
            
            <button type="submit" class="btn">FINALIZAR CADASTRO</button>
        </form>
    </div>
</body>
</html>
