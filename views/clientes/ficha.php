<?php include ROOT_PATH . '/views/layout/header.php'; ?>

<div class="page-title">
    <div class="breadcrumb">CRM > Clientes > Ficha</div>
    <h1>Ficha do Cliente / Painel</h1>
</div>

<div style="display: grid; grid-template-columns: 1fr 300px; gap: 2rem; margin-top: 2rem;">
    <!-- Coluna Esquerda: Dados Principais e Projetos -->
    <div>
        <div class="card" style="margin-bottom: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
                <div>
                    <h2 style="margin-bottom: 0.25rem;"><?php echo htmlspecialchars($cliente['nome']); ?></h2>
                    <span style="color: var(--text-muted); font-size: 0.875rem;">Código: <?php echo htmlspecialchars($cliente['codigo_cliente']); ?></span>
                </div>
                <a href="<?php echo BASE_URL; ?>/clientes/editar/<?php echo $cliente['id']; ?>" class="btn btn-outline"><i class="fas fa-edit"></i> Editar</a>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; color: var(--text-muted); font-size: 0.875rem;">
                <div><strong>CPF/CNPJ:</strong> <?php echo htmlspecialchars($cliente['cpf_cnpj']); ?></div>
                <div><strong>Aniversário:</strong> <?php echo $cliente['aniversario_dia'] ? str_pad($cliente['aniversario_dia'], 2, '0', STR_PAD_LEFT) . '/' . str_pad($cliente['aniversario_mes'], 2, '0', STR_PAD_LEFT) : 'Não informado'; ?></div>
                <div><strong>Telefone:</strong> <?php echo htmlspecialchars($cliente['telefone']); ?></div>
                <div><strong>E-mail:</strong> <?php echo htmlspecialchars($cliente['email']); ?></div>
                <div style="grid-column: 1 / -1;"><strong>Endereço:</strong> <?php echo htmlspecialchars($cliente['endereco'] . ', ' . $cliente['numero'] . ' - ' . $cliente['bairro'] . ', ' . $cliente['cidade'] . ' - ' . $cliente['estado_uf'] . ' | CEP: ' . $cliente['cep']); ?></div>
            </div>
        </div>

        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3>Projetos do Cliente</h3>
                <a href="<?php echo BASE_URL; ?>/projetos/criar?cliente_id=<?php echo $cliente['id']; ?>" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                    <i class="fas fa-plus"></i> Novo Projeto
                </a>
            </div>
            
            <?php if (empty($projetos)): ?>
                <div style="text-align: center; color: var(--text-muted); padding: 2rem 0;">Nenhum projeto encontrado para este cliente.</div>
            <?php else: ?>
                <table style="width: 100%; border-collapse: separate; border-spacing: 0 0.5rem;">
                    <thead>
                        <tr style="text-align: left; color: var(--text-muted); font-size: 0.75rem;">
                            <th style="padding: 0.75rem;">CÓDIGO</th>
                            <th style="padding: 0.75rem;">VEÍCULO</th>
                            <th style="padding: 0.75rem;">STATUS</th>
                            <th style="padding: 0.75rem;">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projetos as $proj): ?>
                        <tr style="background-color: rgba(255,255,255,0.02);">
                            <td style="padding: 0.75rem; border-radius: 8px 0 0 8px;"><?php echo $proj['codigo_pedido']; ?></td>
                            <td style="padding: 0.75rem;"><?php echo htmlspecialchars($proj['nome_projeto']); ?></td>
                            <td style="padding: 0.75rem;">
                                <span style="font-size: 0.75rem;"><?php echo ucfirst($proj['status_logistica']); ?></span>
                            </td>
                            <td style="padding: 0.75rem; border-radius: 0 8px 8px 0;">
                                <a href="<?php echo BASE_URL; ?>/projetos/visualizar/<?php echo $proj['id']; ?>" class="btn btn-outline" style="padding: 0.25rem 0.5rem;"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Coluna Direita: Links de Cadastro e Observações -->
    <div>
        <div class="card" style="margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1rem;"><i class="fas fa-link" style="color: var(--primary);"></i> Link de Cadastro</h3>
            <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1rem;">Gere um link para que o cliente atualize os próprios dados.</p>
            
            <form action="<?php echo BASE_URL; ?>/clientes/gerarLink/<?php echo $cliente['id']; ?>" method="POST" style="margin-bottom: 1.5rem;">
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Gerar Novo Link</button>
            </form>
            
            <?php if(isset($_SESSION['link_gerado'])): ?>
                <div style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid var(--success); padding: 1rem; border-radius: 8px; font-size: 0.875rem; margin-bottom: 1rem; word-break: break-all;">
                    <div style="color: var(--success); font-weight: bold; margin-bottom: 0.5rem;">Link Gerado!</div>
                    <a href="<?php echo $_SESSION['link_gerado']; ?>" target="_blank" style="color: var(--text-main); font-family: monospace;"><?php echo $_SESSION['link_gerado']; ?></a>
                </div>
                <?php unset($_SESSION['link_gerado']); ?>
            <?php endif; ?>
            
            <div style="border-top: 1px solid var(--border); padding-top: 1rem; font-size: 0.875rem; color: var(--text-muted);">
                <strong>Histórico de Links:</strong><br>
                Links ativos: <?php echo $linksCount['ativos'] ?? 0; ?><br>
                Links usados: <?php echo $linksCount['usados'] ?? 0; ?>
            </div>
        </div>
        
        <div class="card">
            <h3 style="margin-bottom: 1rem;">Observações</h3>
            <div style="font-size: 0.875rem; color: var(--text-muted); white-space: pre-wrap;"><?php echo empty($cliente['observacoes']) ? 'Nenhuma observação cadastrada.' : htmlspecialchars($cliente['observacoes']); ?></div>
        </div>
    </div>
</div>

<?php include ROOT_PATH . '/views/layout/footer.php'; ?>
