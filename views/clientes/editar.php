<?php include ROOT_PATH . '/views/layout/header.php'; ?>

<div class="page-title">
    <div class="breadcrumb">CRM > Clientes > Editar</div>
    <h1>Editar Cliente: <?php echo htmlspecialchars($cliente['nome']); ?></h1>
</div>

<div class="card" style="margin-top: 2rem;">
    <form action="<?php echo BASE_URL; ?>/clientes/editar/<?php echo $cliente['id']; ?>" method="POST">
        <h3 style="margin-bottom: 1.5rem; color: var(--primary); border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Dados Pessoais</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Nome Completo / Razão Social *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" name="nome" value="<?php echo htmlspecialchars($cliente['nome'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">CPF / CNPJ *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" name="cpf_cnpj" value="<?php echo htmlspecialchars($cliente['cpf_cnpj'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">E-mail *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="email" name="email" value="<?php echo htmlspecialchars($cliente['email'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Aniversário</label>
                <div style="display: flex; gap: 1rem;">
                    <div class="search-box" style="flex: 1;">
                        <input type="number" name="aniversario_dia" placeholder="Dia" value="<?php echo htmlspecialchars($cliente['aniversario_dia'] ?? ''); ?>" min="1" max="31" style="padding-left: 1rem;">
                    </div>
                    <div class="search-box" style="flex: 1;">
                        <input type="number" name="aniversario_mes" placeholder="Mês" value="<?php echo htmlspecialchars($cliente['aniversario_mes'] ?? ''); ?>" min="1" max="12" style="padding-left: 1rem;">
                    </div>
                </div>
            </div>
        </div>

        <h3 style="margin-bottom: 1.5rem; color: var(--primary); border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Contato & Endereço</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Telefone/WhatsApp 1 *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" name="telefone" value="<?php echo htmlspecialchars($cliente['telefone'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Telefone/WhatsApp 2</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" name="telefone2" value="<?php echo htmlspecialchars($cliente['telefone2'] ?? ''); ?>" style="padding-left: 1rem;">
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 200px 1fr 150px; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">CEP *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" name="cep" value="<?php echo htmlspecialchars($cliente['cep'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Endereço *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" name="endereco" value="<?php echo htmlspecialchars($cliente['endereco'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Número *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" name="numero" value="<?php echo htmlspecialchars($cliente['numero'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 100px; gap: 1.5rem; margin-bottom: 2rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Bairro *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" name="bairro" value="<?php echo htmlspecialchars($cliente['bairro'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Cidade *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" name="cidade" value="<?php echo htmlspecialchars($cliente['cidade'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">UF *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" name="estado_uf" maxlength="2" value="<?php echo htmlspecialchars($cliente['estado_uf'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
        </div>

        <h3 style="margin-bottom: 1.5rem; color: var(--primary); border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Informações Adicionais</h3>

        <div style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Observações</label>
            <textarea name="observacoes" rows="4" style="width: 100%; border-radius: 10px; background-color: var(--bg-card); border: 1px solid var(--border); color: var(--text-main); padding: 1rem; outline: none; font-family: inherit;"><?php echo htmlspecialchars($cliente['observacoes'] ?? ''); ?></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="<?php echo BASE_URL; ?>/clientes" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </div>
    </form>
</div>

<?php include ROOT_PATH . '/views/layout/footer.php'; ?>
