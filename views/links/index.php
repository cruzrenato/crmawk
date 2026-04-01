<?php include ROOT_PATH . '/views/layout/header.php'; ?>

<div class="page-title">
    <div class="breadcrumb">CRM > Links</div>
    <h1>Gerenciamento de Links de Cadastro</h1>
</div>

<div class="card" style="margin-top: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.25rem;">Links Recentes</h2>
        <a href="<?php echo BASE_URL; ?>/linkCadastro/gerarAvulso" class="btn btn-primary">
            <i class="fas fa-link"></i> Gerar Novo Link Avulso
        </a>
    </div>

    <?php if (isset($_SESSION['link_gerado'])): ?>
    <div class="alert alert-success" style="flex-direction: column; align-items: flex-start; gap: 0.5rem;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <i class="fas fa-check-circle"></i>
            <span><strong>Link gerado com sucesso!</strong> Copie e envie para o cliente:</span>
        </div>
        <div style="display: flex; width: 100%; gap: 0.5rem; margin-top: 0.5rem;">
            <input type="text" value="<?php echo $_SESSION['link_gerado']; ?>" id="linkInput" readonly class="btn btn-outline" style="flex: 1; text-align: left; background: rgba(0,0,0,0.2);">
            <button class="btn btn-primary" onclick="copyLink()">Copiar</button>
        </div>
        <?php unset($_SESSION['link_gerado']); ?>
    </div>
    <script>
    function copyLink() {
        var copyText = document.getElementById("linkInput");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
        alert("Link copiado!");
    }
    </script>
    <?php endif; ?>

    <table style="width: 100%; border-collapse: separate; border-spacing: 0 0.5rem;">
        <thead>
            <tr style="text-align: left; color: var(--text-muted); font-size: 0.875rem;">
                <th style="padding: 1rem;">CRIADO EM</th>
                <th style="padding: 1rem;">CLIENTE ALVO</th>
                <th style="padding: 1rem;">TOKEN (INÍCIO)</th>
                <th style="padding: 1rem;">EXPIRA EM</th>
                <th style="padding: 1rem;">STATUS</th>
                <th style="padding: 1rem; text-align: right;">AÇÕES</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($links as $link): ?>
            <tr style="background-color: rgba(255,255,255,0.02);">
                <td style="padding: 1rem; border-radius: 12px 0 0 12px;"><?php echo date('d/m/Y H:i', strtotime($link['criado_em'])); ?></td>
                <td style="padding: 1rem;">
                    <?php echo $link['cliente_nome'] ?? '<span style="color: var(--text-muted); font-style: italic;">Novo Cliente</span>'; ?>
                </td>
                <td style="padding: 1rem; font-family: monospace; font-size: 0.75rem;"><?php echo substr($link['token'], 0, 10); ?>...</td>
                <td style="padding: 1rem;"><?php echo date('d/m/Y H:i', strtotime($link['expira_em'])); ?></td>
                <td style="padding: 1rem;">
                    <span style="padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; 
                        <?php 
                        switch($link['status']) {
                            case 'ativo': echo 'background-color: rgba(16, 185, 129, 0.1); color: var(--success);'; break;
                            case 'usado': echo 'background-color: rgba(59, 130, 246, 0.1); color: var(--info);'; break;
                            case 'expirado': echo 'background-color: rgba(239, 68, 68, 0.1); color: var(--danger);'; break;
                        }
                        ?>">
                        <?php echo ucfirst($link['status']); ?>
                    </span>
                </td>
                <td style="padding: 1rem; text-align: right; border-radius: 0 12px 12px 0;">
                    <?php if ($link['status'] == 'ativo'): ?>
                        <button class="btn btn-outline" style="padding: 0.5rem;" title="Copiar Link" onclick="navigator.clipboard.writeText('<?php echo BASE_URL . '/ficha/' . $link['token']; ?>'); alert('Link copiado!');">
                            <i class="fas fa-copy"></i>
                        </button>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include ROOT_PATH . '/views/layout/footer.php'; ?>
