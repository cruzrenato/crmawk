<?php include ROOT_PATH . '/views/layout/header.php'; ?>

<div class="page-title">
    <div class="breadcrumb">CRM > Veículos</div>
    <h1>Gestão de Veículos</h1>
</div>

<div class="card" style="margin-top: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <form action="<?php echo BASE_URL; ?>/veiculos" method="GET" style="display: flex; gap: 1rem; flex: 1; max-width: 500px;">
            <div class="search-box" style="flex: 1;">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Pesquisar veículos..." value="<?php echo htmlspecialchars($search); ?>" style="width: 100%;">
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
        
        <a href="<?php echo BASE_URL; ?>/veiculos/criar" class="btn btn-primary" style="background-color: var(--success);">
            <i class="fas fa-plus"></i> Novo Veículo
        </a>
    </div>

    <table style="width: 100%; border-collapse: separate; border-spacing: 0 0.5rem;">
        <thead>
            <tr style="text-align: left; color: var(--text-muted); font-size: 0.875rem;">
                <th style="padding: 1rem;">ID</th>
                <th style="padding: 1rem;">MARCA / MODELO</th>
                <th style="padding: 1rem;">ANO</th>
                <th style="padding: 1rem;">OBSERVAÇÕES</th>
                <th style="padding: 1rem; text-align: right;">AÇÕES</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($veiculos)): ?>
            <tr>
                <td colspan="5" style="padding: 2rem; text-align: center; color: var(--text-muted);">
                    Nenhum veículo encontrado.
                </td>
            </tr>
            <?php else: ?>
                <?php foreach ($veiculos as $veiculo): ?>
                <tr style="background-color: rgba(255,255,255,0.02); transition: var(--transition);">
                    <td style="padding: 1rem; font-weight: 600; border-radius: 12px 0 0 12px; color: var(--text-muted);">
                        #<?php echo $veiculo['id']; ?>
                    </td>
                    <td style="padding: 1rem;">
                        <div style="font-weight: 500; font-size: 1rem;"><?php echo htmlspecialchars($veiculo['marca'] . ' ' . $veiculo['modelo']); ?></div>
                    </td>
                    <td style="padding: 1rem; color: var(--text-muted);">
                        <?php echo htmlspecialchars($veiculo['ano']); ?>
                    </td>
                    <td style="padding: 1rem; color: var(--text-muted);">
                        <div style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <?php echo htmlspecialchars($veiculo['observacoes']); ?>
                        </div>
                    </td>
                    <td style="padding: 1rem; text-align: right; border-radius: 0 12px 12px 0;">
                        <a href="<?php echo BASE_URL; ?>/veiculos/editar/<?php echo $veiculo['id']; ?>" class="btn btn-outline" style="padding: 0.5rem;" title="Editar Ficha Técnica"><i class="fas fa-edit"></i></a>
                        <a href="<?php echo BASE_URL; ?>/veiculos/excluir/<?php echo $veiculo['id']; ?>" class="btn btn-outline" style="padding: 0.5rem; color: var(--danger); border-color: rgba(239, 68, 68, 0.2);" onclick="return confirm('Tem certeza que deseja excluir este veículo? Isso apagará todas as molas originais vinculadas.');" title="Excluir"><i class="fas fa-trash"></i></a>
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
