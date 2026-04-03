<?php include ROOT_PATH . '/views/layout/header.php'; ?>

<div class="page-title">
    <div class="breadcrumb">CRM > Usuários</div>
    <h1>Controle de Acesso</h1>
</div>

<div class="card" style="margin-top: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <form action="<?php echo BASE_URL; ?>/usuarios" method="GET" style="display: flex; gap: 1rem; flex: 1; max-width: 500px;">
            <div class="search-box" style="flex: 1;">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Pesquisar usuários..." value="<?php echo htmlspecialchars($search ?? ''); ?>" style="width: 100%;">
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
        
        <a href="<?php echo BASE_URL; ?>/usuarios/criar" class="btn btn-primary" style="background-color: var(--success);">
            <i class="fas fa-user-plus"></i> Novo Usuário
        </a>
    </div>

    <table style="width: 100%; border-collapse: separate; border-spacing: 0 0.5rem;">
        <thead>
            <tr style="text-align: left; color: var(--text-muted); font-size: 0.875rem;">
                <th style="padding: 1rem;">NOME DE EXIBIÇÃO</th>
                <th style="padding: 1rem;">NOME DE USUÁRIO (LOGIN)</th>
                <th style="padding: 1rem;">PERFIL / STATUS</th>
                <th style="padding: 1rem;">TEMA PREFERIDO</th>
                <th style="padding: 1rem; text-align: right;">AÇÕES</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($usuarios)): ?>
            <tr>
                <td colspan="5" style="padding: 2rem; text-align: center; color: var(--text-muted);">
                    Nenhum usuário encontrado.
                </td>
            </tr>
            <?php else: ?>
                <?php foreach ($usuarios as $usuario): ?>
                <tr style="background-color: rgba(255,255,255,0.02); transition: var(--transition);">
                    <td style="padding: 1rem; font-weight: 600; border-radius: 12px 0 0 12px; display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background-color: <?php echo $usuario['perfil'] == 'admin' ? 'var(--primary)' : 'var(--border)'; ?>; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                            <?php echo strtoupper(substr($usuario['nome_exibicao'], 0, 1)); ?>
                        </div>
                        <?php echo htmlspecialchars($usuario['nome_exibicao']); ?>
                    </td>
                    <td style="padding: 1rem; color: var(--text-muted);">
                        @<?php echo htmlspecialchars($usuario['nome_usuario']); ?>
                    </td>
                    <td style="padding: 1rem;">
                        <span style="padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; 
                            <?php echo $usuario['perfil'] == 'admin' ? 'background-color: rgba(99, 102, 241, 0.1); color: var(--primary);' : 'background-color: rgba(107, 114, 128, 0.1); color: var(--text-muted);'; ?>">
                            <?php echo strtoupper($usuario['perfil']); ?>
                        </span>
                        <?php if ($usuario['ativo']): ?>
                            <span style="margin-left: 0.5rem; color: var(--success); font-size: 0.875rem;" title="Ativo"><i class="fas fa-check-circle"></i></span>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 1rem;">
                        <?php echo ucfirst($usuario['tema_preferido']); ?>
                    </td>
                    <td style="padding: 1rem; text-align: right; border-radius: 0 12px 12px 0;">
                        <a href="<?php echo BASE_URL; ?>/usuarios/editar/<?php echo $usuario['id']; ?>" class="btn btn-outline" style="padding: 0.5rem;" title="Editar"><i class="fas fa-edit"></i></a>
                        <?php if ($usuario['id'] != $_SESSION['usuario_id']): ?>
                        <a href="<?php echo BASE_URL; ?>/usuarios/excluir/<?php echo $usuario['id']; ?>" class="btn btn-outline" style="padding: 0.5rem; color: var(--danger); border-color: rgba(239, 68, 68, 0.2);" onclick="return confirm('Tem certeza que deseja excluir este usuário?');" title="Excluir"><i class="fas fa-trash"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    
    <!-- Paginação -->
    <?php if (isset($totalPages) && $totalPages > 1): ?>
    <div style="margin-top: 2rem; display: flex; justify-content: center; gap: 0.5rem;">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search ?? ''); ?>" 
               class="btn <?php echo $i == ($page ?? 1) ? 'btn-primary' : 'btn-outline'; ?>" 
               style="padding: 0.5rem 1rem;">
               <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</div>

<?php include ROOT_PATH . '/views/layout/footer.php'; ?>
