<?php include ROOT_PATH . '/views/layout/header.php'; ?>

<div class="page-title">
    <div class="breadcrumb">CRM > Clientes</div>
    <h1>Gestão de Clientes</h1>
</div>

<div class="card" style="margin-top: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <form action="<?php echo BASE_URL; ?>/clientes" method="GET" style="display: flex; gap: 1rem; flex: 1; max-width: 500px;">
            <div class="search-box" style="flex: 1;">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Pesquisar por nome ou código..." value="<?php echo htmlspecialchars($search); ?>" style="width: 100%;">
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
        
        <div style="display: flex; gap: 0.5rem;">
            <a href="<?php echo BASE_URL; ?>/links/gerarAvulso" class="btn btn-outline" style="border-color: var(--primary); color: var(--text-main);" title="Gerar link externo para o cliente preencher">
                <i class="fas fa-link"></i> Gerar Link Externo
            </a>
            <a href="<?php echo BASE_URL; ?>/clientes/criar" class="btn btn-primary" style="background-color: var(--success);">
                <i class="fas fa-plus"></i> Novo Cliente
            </a>
        </div>
    </div>

    <table style="width: 100%; border-collapse: separate; border-spacing: 0 0.5rem;">
        <thead>
            <tr style="text-align: left; color: var(--text-muted); font-size: 0.875rem;">
                <th style="padding: 1rem;">CÓDIGO</th>
                <th style="padding: 1rem;">NOME</th>
                <th style="padding: 1rem;">CPF/CNPJ</th>
                <th style="padding: 1rem;">CONTATO</th>
                <th style="padding: 1rem;">LOCALIDADE</th>
                <th style="padding: 1rem; text-align: right;">AÇÕES</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($clientes)): ?>
            <tr>
                <td colspan="6" style="padding: 2rem; text-align: center; color: var(--text-muted);">
                    Nenhum cliente encontrado.
                </td>
            </tr>
            <?php else: ?>
                <?php foreach ($clientes as $cliente): ?>
                <tr style="background-color: rgba(255,255,255,0.02); transition: var(--transition);">
                    <td style="padding: 1rem; font-weight: 600; border-radius: 12px 0 0 12px;">
                        <?php echo htmlspecialchars($cliente['codigo_cliente']); ?>
                    </td>
                    <td style="padding: 1rem;">
                        <div style="font-weight: 500; font-size: 1rem;"><?php echo htmlspecialchars($cliente['nome']); ?></div>
                    </td>
                    <td style="padding: 1rem; color: var(--text-muted);">
                        <?php echo htmlspecialchars($cliente['cpf_cnpj']); ?>
                    </td>
                    <td style="padding: 1rem;">
                        <div><?php echo htmlspecialchars($cliente['telefone']); ?></div>
                        <?php if(!empty($cliente['email'])): ?>
                            <div style="font-size: 0.75rem; color: var(--text-muted);"><?php echo htmlspecialchars($cliente['email']); ?></div>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 1rem;">
                        <div><?php echo htmlspecialchars($cliente['cidade'] . ' - ' . $cliente['estado_uf']); ?></div>
                    </td>
                    <td style="padding: 1rem; text-align: right; border-radius: 0 12px 12px 0;">
                        <a href="<?php echo BASE_URL; ?>/clientes/ficha/<?php echo $cliente['id']; ?>" class="btn btn-outline" style="padding: 0.5rem;" title="Ver Ficha"><i class="fas fa-eye"></i></a>
                        <a href="<?php echo BASE_URL; ?>/clientes/editar/<?php echo $cliente['id']; ?>" class="btn btn-outline" style="padding: 0.5rem;" title="Editar"><i class="fas fa-edit"></i></a>
                        <a href="<?php echo BASE_URL; ?>/clientes/excluir/<?php echo $cliente['id']; ?>" class="btn btn-outline" style="padding: 0.5rem; color: var(--danger); border-color: rgba(239, 68, 68, 0.2);" onclick="return confirm('Tem certeza que deseja excluir este cliente?');" title="Excluir"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    
    <!-- Paginação -->
    <?php if ($totalPages > 1): ?>
    <div style="margin-top: 2rem; display: flex; justify-content: center; gap: 0.5rem;">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" 
               class="btn <?php echo $i == $page ? 'btn-primary' : 'btn-outline'; ?>" 
               style="padding: 0.5rem 1rem;">
               <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</div>

<?php include ROOT_PATH . '/views/layout/footer.php'; ?>
