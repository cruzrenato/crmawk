<?php include ROOT_PATH . '/views/layout/header.php'; ?>

<div class="page-title">
    <div class="breadcrumb">CRM > Projetos > Detalhes</div>
    <h1 style="display: flex; align-items: center; gap: 0.75rem;">
        <span style="color: var(--primary);"><i class="fas fa-project-diagram"></i></span>
        <?php echo $projeto['codigo_pedido'] . ' - ' . $projeto['nome_projeto']; ?>
    </h1>
</div>

<div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem; margin-top: 2rem;">
    <!-- Coluna Principal -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        
        <!-- Bloco de Comparação de Molas -->
        <div class="card">
            <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-sliders-h" style="color: var(--primary);"></i>
                Especificações Técnicas das Molas
            </h2>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <?php 
                $posicoes = ['dianteira', 'traseira'];
                foreach ($posicoes as $pos): 
                    $molaMod = null;
                    foreach ($molasModificadas as $m) {
                        if ($m['posicao'] == $pos) { $molaMod = $m; break; }
                    }
                    $molaOrig = null;
                    foreach ($molasOriginais as $o) {
                        if ($o['posicao'] == $pos) { $molaOrig = $o; break; }
                    }
                ?>
                <div style="background-color: rgba(255,255,255,0.01); border: 1px solid var(--border); border-radius: 12px; padding: 1.5rem;">
                    <h3 style="font-size: 1rem; color: var(--primary); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem; display: flex; justify-content: space-between; align-items: center;">
                        <span><?php echo ucfirst($pos); ?></span>
                        <button class="btn btn-outline" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;" onclick="openMolaModal('<?php echo $pos; ?>')">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                    </h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div style="font-size: 0.875rem; border-right: 1px solid var(--border); padding-right: 0.5rem;">
                            <div style="color: var(--text-muted); font-size: 0.75rem; margin-bottom: 0.5rem;">ORIGINAL</div>
                            <?php if ($molaOrig): ?>
                                <div style="display: flex; justify-content: space-between;"><span>Fio:</span> <b><?php echo $molaOrig['fio_mm']; ?> mm</b></div>
                                <div style="display: flex; justify-content: space-between;"><span>Altura:</span> <b><?php echo $molaOrig['altura_livre_mm']; ?> mm</b></div>
                                <div style="display: flex; justify-content: space-between;"><span>Diâmetro:</span> <b><?php echo $molaOrig['diametro_interno_mm']; ?> mm</b></div>
                                <div style="display: flex; justify-content: space-between;"><span>Totais:</span> <b><?php echo $molaOrig['espiras_totais']; ?></b></div>
                            <?php else: ?>
                                <div style="color: var(--text-muted); font-style: italic;">Não informado</div>
                            <?php endif; ?>
                        </div>
                        
                        <div style="font-size: 0.875rem;">
                            <div style="color: var(--primary); font-size: 0.75rem; margin-bottom: 0.5rem;">MODIFICADA (PROJETO)</div>
                            <?php if ($molaMod): ?>
                                <div style="display: flex; justify-content: space-between;"><span>Fio:</span> <b><?php echo $molaMod['fio_mm']; ?> mm</b></div>
                                <div style="display: flex; justify-content: space-between;"><span>Altura:</span> <b style="color: var(--accent);"><?php echo $molaMod['altura_livre_mm']; ?> mm</b></div>
                                <div style="display: flex; justify-content: space-between;"><span>Lift:</span> <b style="color: var(--success);">+<?php echo $molaMod['lift_mm']; ?> mm</b></div>
                                <div style="display: flex; justify-content: space-between;"><span>Carga:</span> <b style="color: var(--info);">+<?php echo $molaMod['ganho_carga_kg']; ?> kg</b></div>
                            <?php else: ?>
                                <div style="color: var(--text-muted); font-style: italic;">Aguardando projeto</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Observações do Projeto -->
        <div class="card">
            <h2 style="font-size: 1rem; font-weight: 700; margin-bottom: 1rem;">Observações Técnicas / Notas</h2>
            <div style="background-color: var(--bg-main); padding: 1rem; border-radius: 8px; font-size: 0.9rem; border-left: 4px solid var(--primary);">
                <?php echo !empty($projeto['observacoes']) ? nl2br($projeto['observacoes']) : 'Sem observações adicionais.'; ?>
            </div>
            
            <?php if (!empty($projeto['observacoes_garantia'])): ?>
            <h2 style="font-size: 1rem; font-weight: 700; margin: 1.5rem 0 1rem; color: var(--danger);">Histórico de Garantia</h2>
            <div style="background-color: rgba(239, 68, 68, 0.05); padding: 1rem; border-radius: 8px; font-size: 0.9rem; border-left: 4px solid var(--danger);">
                <?php echo nl2br($projeto['observacoes_garantia']); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Coluna Lateral (Infos resumidas) -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div class="card" style="padding: 1.5rem;">
            <div style="text-align: center; margin-bottom: 1.5rem;">
                <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(99, 102, 241, 0.1); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 1rem;">
                    <i class="fas fa-truck-loading"></i>
                </div>
                <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase;">STATUS LOGÍSTICA</div>
                <div style="font-size: 1.25rem; font-weight: 700; color: var(--primary);"><?php echo strtoupper($projeto['status_logistica']); ?></div>
            </div>
            
            <div style="border-top: 1px solid var(--border); padding-top: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                <div style="font-size: 0.875rem;">
                    <div style="color: var(--text-muted); font-size: 0.75rem;">CLIENTE</div>
                    <a href="<?php echo BASE_URL; ?>/clientes/ficha/<?php echo $projeto['cliente_id']; ?>" style="color: var(--text-main); font-weight: 600; text-decoration: none;">
                        <?php echo $projeto['cliente_nome']; ?>
                    </a>
                </div>
                <div style="font-size: 0.875rem;">
                    <div style="color: var(--text-muted); font-size: 0.75rem;">VEÍCULO</div>
                    <div style="font-weight: 600;"><?php echo $projeto['marca'] . ' ' . $projeto['modelo']; ?> (<?php echo $projeto['ano']; ?>)</div>
                </div>
                <div style="font-size: 0.875rem;">
                    <div style="color: var(--text-muted); font-size: 0.75rem;">VALOR FINAL</div>
                    <div style="font-size: 1.125rem; font-weight: 700; color: var(--success);">R$ <?php echo number_format($projeto['valor_final'], 2, ',', '.'); ?></div>
                </div>
            </div>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            <a href="<?php echo BASE_URL; ?>/projetos/editar/<?php echo $projeto['id']; ?>" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1rem;">
                <i class="fas fa-edit"></i> EDITAR PROJETO
            </a>
            <button class="btn btn-outline" style="width: 100%; justify-content: center; padding: 1rem;">
                <i class="fas fa-print"></i> IMPRIMIR FICHA
            </button>
            <button class="btn btn-outline" style="width: 100%; justify-content: center; padding: 1rem; color: var(--danger); border-color: rgba(239, 68, 68, 0.2);" onclick="if(confirm('Excluir este projeto permanentemente?')){ location.href='<?php echo BASE_URL; ?>/projetos/excluir/<?php echo $projeto['id']; ?>'; }">
                <i class="fas fa-trash"></i> EXCLUIR
            </button>
        </div>
    </div>
</div>

<!-- Modal de Edição de Mola (Simplificado para o exemplo) -->
<div id="molaModal" style="display:none; position: fixed; inset: 0; background-color: rgba(0,0,0,0.8); z-index: 2000; align-items: center; justify-content: center;">
    <div class="card" style="width: 90%; max-width: 600px; padding: 2rem;">
        <h2 id="modalTitle" style="margin-bottom: 2rem;">Editar Mola</h2>
        <form action="<?php echo BASE_URL; ?>/projetos/salvarMola/<?php echo $projeto['id']; ?>" method="POST">
            <input type="hidden" name="posicao" id="modalPosicao">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">Fio (mm)</label>
                    <input type="number" step="0.01" name="fio_mm" class="btn btn-outline" style="width: 100%; text-align: left;" required>
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">Altura (mm)</label>
                    <input type="number" step="0.01" name="altura_livre_mm" class="btn btn-outline" style="width: 100%; text-align: left;" required>
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">Lift Desejado (mm)</label>
                    <input type="number" step="0.01" name="lift_mm" class="btn btn-outline" style="width: 100%; text-align: left;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">Espiras Totais</label>
                    <input type="number" step="0.01" name="espiras_totais" class="btn btn-outline" style="width: 100%; text-align: left;" required>
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">Tipo Ponta</label>
                    <select name="tipo_ponta" class="btn btn-outline" style="width: 100%;">
                        <option value="aberta">Aberta</option>
                        <option value="fechada">Fechada</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">Ganho de Carga (kg)</label>
                    <input type="number" step="0.01" name="ganho_carga_kg" class="btn btn-outline" style="width: 100%; text-align: left;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">Diâmetro Interno (mm)</label>
                    <input type="number" step="0.01" name="diametro_interno_mm" class="btn btn-outline" style="width: 100%; text-align: left;" required>
                </div>
                 <div>
                    <label style="display: block; font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">Vão Espiras (mm)</label>
                    <input type="number" step="0.01" name="vao_entre_espiras_mm" class="btn btn-outline" style="width: 100%; text-align: left;" required>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                <button type="button" class="btn btn-outline" onclick="closeMolaModal()">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>

<script>
function openMolaModal(pos) {
    document.getElementById('modalPosicao').value = pos;
    document.getElementById('modalTitle').innerText = 'Dados Técnicos: Mola ' + pos.charAt(0).toUpperCase() + pos.slice(1);
    document.getElementById('molaModal').style.display = 'flex';
}
function closeMolaModal() {
    document.getElementById('molaModal').style.display = 'none';
}
</script>

<?php include ROOT_PATH . '/views/layout/footer.php'; ?>
