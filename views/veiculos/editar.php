<?php include ROOT_PATH . '/views/layout/header.php'; ?>

<div class="page-title">
    <div class="breadcrumb">CRM > Veículos > Editar</div>
    <h1>Editar Veículo: <?php echo htmlspecialchars($veiculo['marca'] . ' ' . $veiculo['modelo']); ?></h1>
</div>

<div class="card" style="margin-top: 2rem;">
    <form action="<?php echo BASE_URL; ?>/veiculos/editar/<?php echo $veiculo['id']; ?>" method="POST">
        <h3 style="margin-bottom: 1.5rem; color: var(--primary); border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Dados do Veículo</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr 150px; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Marca *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" name="marca" value="<?php echo htmlspecialchars($veiculo['marca'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Modelo *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" name="modelo" value="<?php echo htmlspecialchars($veiculo['modelo'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Ano *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" name="ano" value="<?php echo htmlspecialchars($veiculo['ano'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
        </div>

        <div style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Observações Gerais do Veículo</label>
            <textarea name="observacoes_veiculo" rows="2" style="width: 100%; border-radius: 10px; background-color: var(--bg-card); border: 1px solid var(--border); color: var(--text-main); padding: 1rem; outline: none; font-family: inherit;"><?php echo htmlspecialchars($veiculo['observacoes'] ?? ''); ?></textarea>
        </div>

        <!-- MOLA DIANTEIRA -->
        <?php $mD = $molas['dianteira'] ?? []; ?>
        <h3 style="margin-bottom: 1.5rem; color: var(--primary); border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Especificações Mola Dianteira</h3>

        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1rem;">
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Qtde</label>
                <input type="number" name="quantidade_dianteira" value="<?php echo htmlspecialchars($mD['quantidade'] ?? '2'); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Fio (mm)</label>
                <input type="number" step="0.01" name="fio_mm_dianteira" value="<?php echo htmlspecialchars($mD['fio_mm'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Alt. Livre (mm)</label>
                <input type="number" step="0.01" name="altura_livre_mm_dianteira" value="<?php echo htmlspecialchars($mD['altura_livre_mm'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Diâm. Int. (mm)</label>
                <input type="number" step="0.01" name="diametro_interno_mm_dianteira" value="<?php echo htmlspecialchars($mD['diametro_interno_mm'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1rem;">
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Vão Espiras (mm)</label>
                <input type="number" step="0.01" name="vao_entre_espiras_mm_dianteira" value="<?php echo htmlspecialchars($mD['vao_entre_espiras_mm'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Entre Elo (mm)</label>
                <input type="number" step="0.01" name="entre_elo_mm_dianteira" value="<?php echo htmlspecialchars($mD['entre_elo_mm'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Espiras Totais</label>
                <input type="number" step="0.01" name="espiras_totais_dianteira" value="<?php echo htmlspecialchars($mD['espiras_totais'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Espiras Ativas</label>
                <input type="number" step="0.01" name="espiras_ativas_dianteira" value="<?php echo htmlspecialchars($mD['espiras_ativas'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2rem;">
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Tipo Ponta</label>
                <select name="tipo_ponta_dianteira" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
                    <option value="fechada" <?php echo ($mD['tipo_ponta'] ?? '') == 'fechada' ? 'selected' : ''; ?>>Fechada</option>
                    <option value="aberta" <?php echo ($mD['tipo_ponta'] ?? '') == 'aberta' ? 'selected' : ''; ?>>Aberta</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Medida Ponta (mm)</label>
                <input type="number" step="0.01" name="medida_ponta_mm_dianteira" value="<?php echo htmlspecialchars($mD['medida_ponta_mm'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Olhal Cima/Baixo (mm)</label>
                <div style="display: flex; gap: 0.5rem;">
                    <input type="number" step="0.01" name="olhal_cima_mm_dianteira" placeholder="Cima" value="<?php echo htmlspecialchars($mD['olhal_cima_mm'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
                    <input type="number" step="0.01" name="olhal_baixo_mm_dianteira" placeholder="Baixo" value="<?php echo htmlspecialchars($mD['olhal_baixo_mm'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
                </div>
            </div>
            <div style="display: flex; align-items: center; padding-top: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: var(--text-main);">
                    <input type="checkbox" name="retifica_dianteira" value="1" <?php echo isset($mD['retifica']) && $mD['retifica'] ? 'checked' : ''; ?> style="width: 20px; height: 20px;">
                    Possui Retífica?
                </label>
            </div>
        </div>

        <!-- MOLA TRASEIRA -->
        <?php $mT = $molas['traseira'] ?? []; ?>
        <h3 style="margin-bottom: 1.5rem; color: var(--primary); border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Especificações Mola Traseira</h3>

        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1rem;">
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Qtde</label>
                <input type="number" name="quantidade_traseira" value="<?php echo htmlspecialchars($mT['quantidade'] ?? '2'); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Fio (mm)</label>
                <input type="number" step="0.01" name="fio_mm_traseira" value="<?php echo htmlspecialchars($mT['fio_mm'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Alt. Livre (mm)</label>
                <input type="number" step="0.01" name="altura_livre_mm_traseira" value="<?php echo htmlspecialchars($mT['altura_livre_mm'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Diâm. Int. (mm)</label>
                <input type="number" step="0.01" name="diametro_interno_mm_traseira" value="<?php echo htmlspecialchars($mT['diametro_interno_mm'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1rem;">
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Vão Espiras (mm)</label>
                <input type="number" step="0.01" name="vao_entre_espiras_mm_traseira" value="<?php echo htmlspecialchars($mT['vao_entre_espiras_mm'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Entre Elo (mm)</label>
                <input type="number" step="0.01" name="entre_elo_mm_traseira" value="<?php echo htmlspecialchars($mT['entre_elo_mm'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Espiras Totais</label>
                <input type="number" step="0.01" name="espiras_totais_traseira" value="<?php echo htmlspecialchars($mT['espiras_totais'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Espiras Ativas</label>
                <input type="number" step="0.01" name="espiras_ativas_traseira" value="<?php echo htmlspecialchars($mT['espiras_ativas'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2rem;">
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Tipo Ponta</label>
                <select name="tipo_ponta_traseira" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
                    <option value="fechada" <?php echo ($mT['tipo_ponta'] ?? '') == 'fechada' ? 'selected' : ''; ?>>Fechada</option>
                    <option value="aberta" <?php echo ($mT['tipo_ponta'] ?? '') == 'aberta' ? 'selected' : ''; ?>>Aberta</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Medida Ponta (mm)</label>
                <input type="number" step="0.01" name="medida_ponta_mm_traseira" value="<?php echo htmlspecialchars($mT['medida_ponta_mm'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.25rem;">Olhal Cima/Baixo (mm)</label>
                <div style="display: flex; gap: 0.5rem;">
                    <input type="number" step="0.01" name="olhal_cima_mm_traseira" placeholder="Cima" value="<?php echo htmlspecialchars($mT['olhal_cima_mm'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
                    <input type="number" step="0.01" name="olhal_baixo_mm_traseira" placeholder="Baixo" value="<?php echo htmlspecialchars($mT['olhal_baixo_mm'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-main);">
                </div>
            </div>
            <div style="display: flex; align-items: center; padding-top: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: var(--text-main);">
                    <input type="checkbox" name="retifica_traseira" value="1" <?php echo isset($mT['retifica']) && $mT['retifica'] ? 'checked' : ''; ?> style="width: 20px; height: 20px;">
                    Possui Retífica?
                </label>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="<?php echo BASE_URL; ?>/veiculos" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </div>
    </form>
</div>

<?php include ROOT_PATH . '/views/layout/footer.php'; ?>
