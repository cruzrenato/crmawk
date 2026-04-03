<?php include ROOT_PATH . '/views/layout/header.php'; ?>

<div class="page-title">
    <div class="breadcrumb">CRM > Usuários > Novo</div>
    <h1>Registrar Novo Usuário</h1>
</div>

<div class="card" style="margin-top: 2rem; max-width: 800px;">
    <form action="<?php echo BASE_URL; ?>/usuarios/criar" method="POST">
        <h3 style="margin-bottom: 1.5rem; color: var(--primary); border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Credenciais de Acesso</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Nome de Usuário (Login) *</label>
                <div class="search-box" style="width: 100%;">
                    <i class="fas fa-user" style="margin-right: 0.5rem;"></i>
                    <input type="text" name="nome_usuario" required pattern="[A-Za-z0-9_]{3,20}" title="Apenas letras, números e underscore. Sem espaços." autocomplete="none">
                </div>
                <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">Ex: renato_cruz</small>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Senha de Acesso *</label>
                <div class="search-box" style="width: 100%;">
                    <i class="fas fa-key" style="margin-right: 0.5rem;"></i>
                    <input type="password" name="senha" required minlength="6" autocomplete="new-password">
                </div>
                <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">Mínimo 6 caracteres.</small>
            </div>
        </div>

        <h3 style="margin-bottom: 1.5rem; color: var(--primary); border-bottom: 1px solid var(--border); padding-bottom: 0.5rem; margin-top: 2rem;">Configurações do Perfil</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 150px 150px; gap: 1.5rem; margin-bottom: 2rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Nome de Exibição *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" name="nome_exibicao" required style="padding-left: 1rem;">
                </div>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Perfil</label>
                <select name="perfil" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
                    <option value="usuario">Usuário Padrão</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Tema Preferido</label>
                <select name="tema_preferido" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
                    <option value="escuro">Escuro</option>
                    <option value="claro">Claro</option>
                </select>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="<?php echo BASE_URL; ?>/usuarios" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary" style="background-color: var(--success);">Criar Conta</button>
        </div>
    </form>
</div>

<?php include ROOT_PATH . '/views/layout/footer.php'; ?>
