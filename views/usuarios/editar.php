<?php include ROOT_PATH . '/views/layout/header.php'; ?>

<div class="page-title">
    <div class="breadcrumb">CRM > Usuários > Editar</div>
    <h1>Editar Perfil: <?php echo htmlspecialchars($usuario['nome_exibicao']); ?></h1>
</div>

<div class="card" style="margin-top: 2rem; max-width: 800px;">
    <form action="<?php echo BASE_URL; ?>/usuarios/editar/<?php echo $usuario['id']; ?>" method="POST">
        <h3 style="margin-bottom: 1.5rem; color: var(--primary); border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Credenciais do Sistema</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Nome de Usuário (Login)</label>
                <div class="search-box" style="width: 100%; opacity: 0.7;">
                    <i class="fas fa-user-lock" style="margin-right: 0.5rem;"></i>
                    <input type="text" value="<?php echo htmlspecialchars($usuario['nome_usuario']); ?>" readonly disabled>
                </div>
                <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">O login original não pode ser alterado.</small>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Nova Senha de Acesso</label>
                <div class="search-box" style="width: 100%;">
                    <i class="fas fa-key" style="margin-right: 0.5rem;"></i>
                    <input type="password" name="senha" minlength="6" autocomplete="new-password">
                </div>
                <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">Deixe em branco para manter a atual.</small>
            </div>
        </div>

        <h3 style="margin-bottom: 1.5rem; color: var(--primary); border-bottom: 1px solid var(--border); padding-bottom: 0.5rem; margin-top: 2rem;">Configurações do Perfil</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 150px 150px; gap: 1.5rem; margin-bottom: 2rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Nome de Exibição *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" name="nome_exibicao" value="<?php echo htmlspecialchars($usuario['nome_exibicao'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Perfil</label>
                <select name="perfil" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
                    <option value="usuario" <?php echo ($usuario['perfil'] ?? '') == 'usuario' ? 'selected' : ''; ?>>Usuário Padrão</option>
                    <option value="admin" <?php echo ($usuario['perfil'] ?? '') == 'admin' ? 'selected' : ''; ?>>Administrador</option>
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Tema Preferido</label>
                <select name="tema_preferido" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
                    <option value="escuro" <?php echo ($usuario['tema_preferido'] ?? '') == 'escuro' ? 'selected' : ''; ?>>Escuro</option>
                    <option value="claro" <?php echo ($usuario['tema_preferido'] ?? '') == 'claro' ? 'selected' : ''; ?>>Claro</option>
                </select>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="<?php echo BASE_URL; ?>/usuarios" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </div>
    </form>
</div>

<?php include ROOT_PATH . '/views/layout/footer.php'; ?>
