<?php include ROOT_PATH . '/views/layout/header.php'; ?>

<div class="page-title">
    <div class="breadcrumb">CRM > Dashboard</div>
    <h1>Olá, <?php echo explode(' ', $_SESSION['usuario_nome'])[0]; ?>! 👋</h1>
</div>

<!-- Stats Grid -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-top: 2rem;">
    <!-- Projetos Ativos -->
    <div class="card" style="display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 50px; height: 50px; border-radius: 12px; background-color: rgba(99, 102, 241, 0.1); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
            <i class="fas fa-tasks"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">PROJETOS ATIVOS</div>
            <div style="font-size: 1.5rem; font-weight: 700;"><?php echo ($stats['status_logistica']['fabricacao'] ?? 0) + ($stats['status_logistica']['pintura'] ?? 0); ?></div>
        </div>
    </div>

    <!-- Clientes -->
    <div class="card" style="display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 50px; height: 50px; border-radius: 12px; background-color: rgba(16, 185, 129, 0.1); color: var(--success); display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">TOTAL CLIENTES</div>
            <div style="font-size: 1.5rem; font-weight: 700;"><?php echo $stats['total_clientes']; ?></div>
        </div>
    </div>

    <!-- Pendentes -->
    <div class="card" style="display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 50px; height: 50px; border-radius: 12px; background-color: rgba(239, 68, 68, 0.1); color: var(--danger); display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
            <i class="fas fa-hourglass-half"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">PGTO PENDENTE</div>
            <div style="font-size: 1.5rem; font-weight: 700;"><?php echo $stats['pagamento_pendente']; ?></div>
        </div>
    </div>

    <!-- Aniversariantes -->
    <div class="card" style="display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 50px; height: 50px; border-radius: 12px; background-color: rgba(245, 158, 11, 0.1); color: var(--warning); display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
            <i class="fas fa-cake-candles"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">ANIVERSARIANTES</div>
            <div style="font-size: 1.5rem; font-weight: 700;"><?php echo count($aniversariantes); ?></div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-top: 2rem;">
    <!-- Projetos Recentes -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2 style="font-size: 1.25rem; font-weight: 700;">Projetos Recentes</h2>
            <a href="<?php echo BASE_URL; ?>/projetos" style="font-size: 0.875rem; color: var(--primary); font-weight: 600; text-decoration: none;">Ver todos</a>
        </div>
        
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; color: var(--text-muted); font-size: 0.75rem; border-bottom: 1px solid var(--border);">
                    <th style="padding: 1rem 0;">CÓDIGO</th>
                    <th style="padding: 1rem 0;">PROJETO</th>
                    <th style="padding: 1rem 0;">STATUS</th>
                    <th style="padding: 1rem 0; text-align: right;">VALOR</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projetosRecentes as $p): ?>
                <tr style="border-bottom: 1px solid var(--border);">
                    <td style="padding: 1.25rem 0; font-weight: 600; font-size: 0.875rem;"><?php echo $p['codigo_pedido']; ?></td>
                    <td style="padding: 1.25rem 0;">
                        <div style="font-weight: 600; font-size: 0.875rem;"><?php echo $p['nome_projeto']; ?></div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);"><?php echo $p['cliente_nome']; ?></div>
                    </td>
                    <td style="padding: 1.25rem 0;">
                        <span style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: <?php echo $p['status_logistica'] == 'entregue' ? 'var(--success)' : 'var(--primary)'; ?>;">
                            <?php echo $p['status_logistica']; ?>
                        </span>
                    </td>
                    <td style="padding: 1.25rem 0; text-align: right; font-weight: 700; font-size: 0.875rem;">
                        R$ <?php echo number_format($p['valor_final'], 2, ',', '.'); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Aniversariantes do Mês -->
    <div class="card">
        <h2 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-birthday-cake" style="color: var(--accent);"></i>
            Aniversariantes do Mês
        </h2>
        
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <?php if (empty($aniversariantes)): ?>
                <div style="color: var(--text-muted); font-size: 0.875rem; font-style: italic; text-align: center; padding: 2rem;">
                    Nenhum aniversariante encontrado neste mês.
                </div>
            <?php else: ?>
                <?php foreach ($aniversariantes as $ani): ?>
                <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background-color: rgba(255,255,255,0.03); border-radius: 12px; border: 1px solid var(--border);">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--border); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                        <i class="fas fa-gift"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.875rem; font-weight: 600;"><?php echo $ani['nome']; ?></div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);"><?php echo str_pad($ani['aniversario_dia'], 2, '0', STR_PAD_LEFT); ?> / <?php echo str_pad($ani['aniversario_mes'], 2, '0', STR_PAD_LEFT); ?></div>
                    </div>
                    <a href="https://wa.me/<?php echo preg_replace('/\D/', '', $ani['telefone']); ?>" target="_blank" style="color: var(--success); font-size: 1.25rem;">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include ROOT_PATH . '/views/layout/footer.php'; ?>
