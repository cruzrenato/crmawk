<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de Cadastro - AWK CRM</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- IMask CDN -->
    <script src="https://unpkg.com/imask"></script>
    <style>
        :root {
            --primary: #E01010;
            --primary-hover: #b90d0d;
            --bg-main: #0f172a;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border: #334155;
            --card-bg: #1e293b;
            --input-bg: #0f172a;
            --transition: all 0.3s ease;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--bg-main); color: var(--text-main); display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 1rem; }
        .form-container { background-color: var(--card-bg); width: 100%; max-width: 800px; padding: 2.5rem; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.5); border-top: 4px solid var(--primary); }
        .header { text-align: center; margin-bottom: 2.5rem; }
        .logo-container { margin-bottom: 1.5rem; }
        .logo-container img { max-height: 60px; }
        h1 { font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem; }
        p { color: var(--text-muted); font-size: 0.9375rem; }
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 2rem; }
        @media (max-width: 600px) { .form-grid { grid-template-columns: 1fr; } }
        .form-group { margin-bottom: 0.5rem; }
        label { display: block; font-size: 0.8125rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; }
        input, select, textarea { width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: 10px; font-size: 0.9375rem; outline: none; transition: var(--transition); background-color: var(--input-bg); color: var(--text-main); }
        input:focus, select:focus, textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(224, 16, 16, 0.1); }
        .section-title { grid-column: 1 / -1; margin: 1.5rem 0 0.5rem; font-size: 0.875rem; color: var(--primary); font-weight: 700; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem; }
        .btn { width: 100%; padding: 1rem; background-color: var(--primary); color: white; border: none; border-radius: 12px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: var(--transition); margin-top: 1rem; text-transform: uppercase; letter-spacing: 1px; }
        .btn:hover { background-color: var(--primary-hover); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(224, 16, 16, 0.3); }
        
        /* Validade indicator */
        .loading-cep { display: none; margin-left: 10px; color: var(--primary); font-size: 0.8em; }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="header">
            <div class="logo-container">
                <img src="https://awkmolasoffroad.com.br/images/awk-logo.svg" alt="AWK Molas Offroad">
            </div>
            <h1>Ficha de Cadastro</h1>
            <p>Olá! Por favor, preencha seus dados abaixo para seguirmos com seu projeto.</p>
        </div>

        <?php if(isset($_SESSION['error'])): ?>
            <div style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid rgba(239, 68, 68, 0.2);">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo BASE_URL; ?>/linkCadastro/salvarExterno" method="POST">
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            
            <div class="form-grid">
                <div class="section-title">DADOS PESSOAIS / EMPRESA</div>
                
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Nome Completo / Razão Social *</label>
                    <input type="text" name="nome" value="<?php echo $cliente['nome'] ?? ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>CPF / CNPJ *</label>
                    <input type="text" id="cpf_cnpj" name="cpf_cnpj" value="<?php echo $cliente['cpf_cnpj'] ?? ''; ?>" required placeholder="Digite os números">
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
                    <label>E-mail *</label>
                    <input type="email" name="email" value="<?php echo $cliente['email'] ?? ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Telefone (WhatsApp) *</label>
                    <input type="text" id="telefone" name="telefone" value="<?php echo $cliente['telefone'] ?? ''; ?>" required placeholder="(00) 00000-0000">
                </div>

                <div class="section-title">ENDEREÇO DE ENTREGA <span id="cep-loading" class="loading-cep"><i class="fas fa-spinner fa-spin"></i> Buscando...</span></div>
                
                <div class="form-group">
                    <label>CEP *</label>
                    <input type="text" id="cep" name="cep" value="<?php echo $cliente['cep'] ?? ''; ?>" required placeholder="00000-000">
                </div>
                
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Endereço *</label>
                    <input type="text" id="endereco" name="endereco" value="<?php echo $cliente['endereco'] ?? ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Número / Apto *</label>
                    <input type="text" id="numero" name="numero" value="<?php echo $cliente['numero'] ?? ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Bairro *</label>
                    <input type="text" id="bairro" name="bairro" value="<?php echo $cliente['bairro'] ?? ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Cidade *</label>
                    <input type="text" id="cidade" name="cidade" value="<?php echo $cliente['cidade'] ?? ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Estado (UF) *</label>
                    <select id="estado_uf" name="estado_uf" required>
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
            
            <button type="submit" class="btn"><i class="fas fa-check-circle" style="margin-right: 8px;"></i> FINALIZAR CADASTRO</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Máscara Telefone
            IMask(document.getElementById('telefone'), {
                mask: [
                    { mask: '(00) 0000-0000' },
                    { mask: '(00) 00000-0000' }
                ]
            });

            // Máscara CPF / CNPJ Dinâmico
            IMask(document.getElementById('cpf_cnpj'), {
                mask: [
                    { mask: '000.000.000-00', maxLength: 11 },
                    { mask: '00.000.000/0000-00' }
                ],
                dispatch: function (appended, dynamicMasked) {
                    var number = (dynamicMasked.value + appended).replace(/\D/g,'');
                    return number.length <= 11 ? dynamicMasked.compiledMasks[0] : dynamicMasked.compiledMasks[1];
                }
            });

            // Máscara CEP
            var cepMask = IMask(document.getElementById('cep'), { mask: '00000-000' });

            // Integração ViaCEP
            const cepInput = document.getElementById('cep');
            const loading = document.getElementById('cep-loading');

            cepInput.addEventListener('blur', function() {
                // Remove traços para consultar
                const cepCode = this.value.replace(/\D/g, '');
                
                if(cepCode.length === 8) {
                    loading.style.display = 'inline-block';
                    fetch(`https://viacep.com.br/ws/${cepCode}/json/`)
                        .then(response => response.json())
                        .then(data => {
                            loading.style.display = 'none';
                            if(!data.erro) {
                                document.getElementById('endereco').value = data.logradouro;
                                document.getElementById('bairro').value = data.bairro;
                                document.getElementById('cidade').value = data.localidade;
                                document.getElementById('estado_uf').value = data.uf;
                                // Focar no número após preencher automático
                                document.getElementById('numero').focus();
                            } else {
                                alert("CEP não encontrado!");
                            }
                        })
                        .catch(error => {
                            loading.style.display = 'none';
                            console.error("Erro ao buscar CEP:", error);
                        });
                }
            });
        });
    </script>
</body>
</html>
