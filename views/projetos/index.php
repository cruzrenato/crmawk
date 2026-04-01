<?php include ROOT_PATH . '/views/layout/header.php'; ?>

<div class="page-title">
    <div class="breadcrumb">CRM > Projetos</div>
    <h1>Gestão de Projetos</h1>
</div>

<div class="card" style="margin-top: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <form action="<?php echo BASE_URL; ?>/projetos" method="GET" style="display: flex; gap: 1rem; flex: 1;">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Pesquisar projetos..." value="<?php echo $filters['search'] ?? ''; ?>">
            </div>
            
            <select name="status_logistica" class="btn btn-outline" style="min-width: 150px;">
                <option value="">Logística: Todos</option>
                <option value="fabricacao" <?php echo ($filters['status_logistica'] ?? '') == 'fabricacao' ? 'selected' : ''; ?>>Fabricação</option>
                <option value="pintura" <?php echo ($filters['status_logistica'] ?? '') == 'pintura' ? 'selected' : ''; ?>>Pintura</option>
                <option value="transportadora" <?php echo ($filters['status_logistica'] ?? '') == 'transportadora' ? 'selected' : ''; ?>>Transportadora</option>
                <option value="entregue" <?php echo ($filters['status_logistica'] ?? '') == 'entregue' ? 'selected' : ''; ?>>Entregue</option>
            </select>
            
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>
        
        <a href="<?php echo BASE_URL; ?>/projetos/criar" class="btn btn-primary" style="background-color: var(--success);">
            <i class="fas fa-plus"></i> Novo Projeto
        </a>
    </div>

    <table style="width: 100%; border-collapse: separate; border-spacing: 0 0.5rem;">
        <thead>
            <tr style="text-align: left; color: var(--text-muted); font-size: 0.875rem;">
                <th style="padding: 1rem;">CÓDIGO</th>
                <th style="padding: 1rem;">CLIENTE</th>
                <th style="padding: 1rem;">VEÍCULO</th>
                <th style="padding: 1rem;">LOGÍSTICA</th>
                <th style="padding: 1rem;">PAGAMENTO</th>
                <th style="padding: 1rem;">VALOR</th>
                <th style="padding: 1rem; text-align: right;">AÇÕES</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projetos as $projeto): ?>
            <tr style="background-color: rgba(255,255,255,0.02); transition: var(--transition);">
                <td style="padding: 1rem; font-weight: 600; border-radius: 12px 0 0 12px;"><?php echo $projeto['codigo_pedido']; ?></td>
                <td style="padding: 1rem;">
                    <div style="font-weight: 500;"><?php echo $projeto['cliente_nome']; ?></div>
                    <div style="font-size: 0.75rem; color: var(--text-muted);"><?php echo $projeto['codigo_cliente']; ?></div>
                </td>
                <td style="padding: 1rem;">
                    <div><?php echo $projeto['marca'] . ' ' . $projeto['modelo']; ?></div>
                    <div style="font-size: 0.75rem; color: var(--text-muted);"><?php echo $projeto['ano']; ?></div>
                </td>
                <td style="padding: 1rem;">
                    <span style="padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; 
                        <?php 
                        switch($projeto['status_logistica']) {
                            case 'fabricacao': echo 'background-color: rgba(99, 102, 241, 0.1); color: var(--primary);'; break;
                            case 'pintura': echo 'background-color: rgba(245, 158, 11, 0.1); color: var(--warning);'; break;
                            case 'transportadora': echo 'background-color: rgba(59, 130, 246, 0.1); color: var(--info);'; break;
                            case 'entregue': echo 'background-color: rgba(16, 185, 129, 0.1); color: var(--success);'; break;
                        }
                        ?>">
                        <?php echo ucfirst($projeto['status_logistica']); ?>
                    </span>
                </td>
                <td style="padding: 1rem;">
                    <span style="font-size: 0.875rem; color: <?php echo $projeto['status_pagamento'] == 'pago' ? 'var(--success)' : 'var(--danger)'; ?>;">
                        <i class="fas <?php echo $projeto['status_pagamento'] == 'pago' ? 'fa-check-circle' : 'fa-clock'; ?>"></i>
                        <?php echo ucfirst($projeto['status_pagamento']); ?>
                    </span>
                </td>
                <td style="padding: 1rem; font-weight: 600;">R$ <?php echo number_format($projeto['valor_final'], 2, ',', '.'); ?></td>
                <td style="padding: 1rem; text-align: right; border-radius: 0 12px 12px 0;">
                    <a href="<?php echo BASE_URL; ?>/projetos/visualizar/<?php echo $projeto['id']; ?>" class="btn btn-outline" style="padding: 0.5rem;"><i class="fas fa-eye"></i></a>
                    <a href="<?php echo BASE_URL; ?>/projetos/editar/<?php echo $projeto['id']; ?>" class="btn btn-outline" style="padding: 0.5rem;"><i class="fas fa-edit"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <!-- Paginação -->
    <div style="margin-top: 2rem; display: flex; justify-content: center; gap: 0.5rem;">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&search=<?php echo $filters['search']; ?>" 
               class="btn <?php echo $i == $page ? 'btn-primary' : 'btn-outline'; ?>" 
               style="padding: 0.5rem 1rem;">
               <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>
</div>

<?php include ROOT_PATH . '/views/layout/footer.php'; ?>
