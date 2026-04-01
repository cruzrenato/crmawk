<?php include ROOT_PATH . '/views/layout/header.php'; ?>

<div class="page-title">
    <div class="breadcrumb">CRM > Projetos > <?php echo isset($isEdit) ? 'Editar' : 'Novo'; ?></div>
    <h1><?php echo isset($isEdit) ? 'Modificar Projeto' : 'Registrar Novo Projeto'; ?></h1>
</div>

<div class="card" style="margin-top: 2rem; max-width: 900px;">
    <form action="<?php echo BASE_URL; ?>/projetos/<?php echo isset($isEdit) ? 'editar/' . $projeto['id'] : 'criar'; ?>" method="POST" style="display: flex; flex-direction: column; gap: 2rem;">
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <!-- Dados Básicos -->
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <h3 style="font-size: 1rem; color: var(--primary); margin-bottom: 0.5rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Informações Gerais</h3>
                
                <div>
                    <label style="display: block; font-size: 0.875rem; margin-bottom: 0.5rem;">Nome do Projeto / Título</label>
                    <input type="text" name="nome_projeto" class="btn btn-outline" style="width: 100%; text-align: left;" placeholder="Ex: Lift 2'' Hilux Srx" value="<?php echo $projeto['nome_projeto'] ?? $formData['nome_projeto'] ?? ''; ?>" required>
                </div>
                
                <div>
                    <label style="display: block; font-size: 0.875rem; margin-bottom: 0.5rem;">Cliente</label>
                    <select name="cliente_id" class="btn btn-outline" style="width: 100%;" required>
                        <option value="">Selecione um cliente...</option>
                        <?php foreach ($clientes as $c): ?>
                            <option value="<?php echo $c['id']; ?>" <?php echo (($projeto['cliente_id'] ?? $formData['cliente_id'] ?? '') == $c['id']) ? 'selected' : ''; ?>>
                                <?php echo $c['nome']; ?> (<?php echo $c['codigo_cliente']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 0.875rem; margin-bottom: 0.5rem;">Veículo</label>
                    <select name="veiculo_id" class="btn btn-outline" style="width: 100%;" required>
                        <option value="">Selecione um veículo...</option>
                        <?php foreach ($veiculos as $v): ?>
                            <option value="<?php echo $v['id']; ?>" <?php echo (($projeto['veiculo_id'] ?? $formData['veiculo_id'] ?? '') == $v['id']) ? 'selected' : ''; ?>>
                                <?php echo $v['marca'] . ' ' . $v['modelo'] . ' ' . $v['ano']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <!-- Status e Prazos -->
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <h3 style="font-size: 1rem; color: var(--primary); margin-bottom: 0.5rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Gerenciamento</h3>
                
                <div>
                    <label style="display: block; font-size: 0.875rem; margin-bottom: 0.5rem;">Status Logística</label>
                    <select name="status_logistica" class="btn btn-outline" style="width: 100%;">
                        <option value="fabricacao" <?php echo (($projeto['status_logistica'] ?? $formData['status_logistica'] ?? '') == 'fabricacao') ? 'selected' : ''; ?>>Fabricação</option>
                        <option value="pintura" <?php echo (($projeto['status_logistica'] ?? $formData['status_logistica'] ?? '') == 'pintura') ? 'selected' : ''; ?>>Pintura</option>
                        <option value="transportadora" <?php echo (($projeto['status_logistica'] ?? $formData['status_logistica'] ?? '') == 'transportadora') ? 'selected' : ''; ?>>Transportadora</option>
                        <option value="entregue" <?php echo (($projeto['status_logistica'] ?? $formData['status_logistica'] ?? '') == 'entregue') ? 'selected' : ''; ?>>Entregue</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 0.875rem; margin-bottom: 0.5rem;">Status Pagamento</label>
                    <select name="status_pagamento" class="btn btn-outline" style="width: 100%;">
                        <option value="pendente" <?php echo (($projeto['status_pagamento'] ?? $formData['status_pagamento'] ?? '') == 'pendente') ? 'selected' : ''; ?>>Pendente</option>
                        <option value="pago" <?php echo (($projeto['status_pagamento'] ?? $formData['status_pagamento'] ?? '') == 'pago') ? 'selected' : ''; ?>>Pago</option>
                        <option value="garantia" <?php echo (($projeto['status_pagamento'] ?? $formData['status_pagamento'] ?? '') == 'garantia') ? 'selected' : ''; ?>>Garantia / Cortesia</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 0.875rem; margin-bottom: 0.5rem;">Status Frete</label>
                    <select name="status_frete" class="btn btn-outline" style="width: 100%;">
                        <option value="pendente" <?php echo (($projeto['status_frete'] ?? $formData['status_frete'] ?? '') == 'pendente') ? 'selected' : ''; ?>>Pendente</option>
                        <option value="pago" <?php echo (($projeto['status_frete'] ?? $formData['status_frete'] ?? '') == 'pago') ? 'selected' : ''; ?>>Pago</option>
                        <option value="nao_optante" <?php echo (($projeto['status_frete'] ?? $formData['status_frete'] ?? '') == 'nao_optante') ? 'selected' : ''; ?>>Não Optante / Retirada</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Financeiro -->
        <div>
            <h3 style="font-size: 1rem; color: var(--success); margin-bottom: 1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Financeiro</h3>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">Valor Venda (R$)</label>
                    <input type="number" step="0.01" name="valor_venda" class="btn btn-outline" style="width: 100%; text-align: left;" value="<?php echo $projeto['valor_venda'] ?? $formData['valor_venda'] ?? ''; ?>">
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">Desc. Aniversário (%)</label>
                    <input type="number" step="0.01" name="desconto_aniversario_perc" class="btn btn-outline" style="width: 100%; text-align: left;" value="<?php echo $projeto['desconto_aniversario_perc'] ?? $formData['desconto_aniversario_perc'] ?? ''; ?>">
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">Valor Final (R$)</label>
                    <input type="number" step="0.01" name="valor_final" class="btn btn-outline" style="width: 100%; text-align: left; background-color: rgba(16, 185, 129, 0.05); font-weight: 700; border-color: var(--success);" value="<?php echo $projeto['valor_final'] ?? $formData['valor_final'] ?? ''; ?>">
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">Valor Frete (R$)</label>
                    <input type="number" step="0.01" name="valor_frete" class="btn btn-outline" style="width: 100%; text-align: left;" value="<?php echo $projeto['valor_frete'] ?? $formData['valor_frete'] ?? ''; ?>">
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">Entrada (R$)</label>
                    <input type="number" step="0.01" name="valor_entrada" class="btn btn-outline" style="width: 100%; text-align: left;" value="<?php echo $projeto['valor_entrada'] ?? $formData['valor_entrada'] ?? ''; ?>">
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">Saldo Restante (R$)</label>
                    <input type="number" step="0.01" name="saldo_restante" class="btn btn-outline" style="width: 100%; text-align: left;" value="<?php echo $projeto['saldo_restante'] ?? $formData['saldo_restante'] ?? ''; ?>" readonly>
                </div>
            </div>
        </div>
        
        <!-- Observações -->
        <div>
            <label style="display: block; font-size: 0.875rem; margin-bottom: 0.5rem;">Observações / Notas</label>
            <textarea name="observacoes" class="btn btn-outline" style="width: 100%; min-height: 100px; text-align: left; padding: 1rem;" placeholder="Detalhes específicos para produção..."><?php echo $projeto['observacoes'] ?? $formData['observacoes'] ?? ''; ?></textarea>
        </div>
        
        <?php if (isset($isEdit)): ?>
        <div>
            <label style="display: block; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--danger);">Histórico de Garantia (Apenas se houver re-trabalho)</label>
            <textarea name="observacoes_garantia" class="btn btn-outline" style="width: 100%; min-height: 80px; text-align: left; padding: 1rem; border-color: rgba(239, 68, 68, 0.3);"><?php echo $projeto['observacoes_garantia'] ?? ''; ?></textarea>
        </div>
        <?php endif; ?>
        
        <div style="display: flex; justify-content: flex-end; gap: 1rem; border-top: 1px solid var(--border); padding-top: 2rem;">
            <a href="<?php echo BASE_URL; ?>/projetos" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary" style="padding: 0.8rem 2rem;">
                <i class="fas fa-save"></i> <?php echo isset($isEdit) ? 'Atualizar Projeto' : 'Salvar Projeto'; ?>
            </button>
        </div>
    </form>
</div>

<?php include ROOT_PATH . '/views/layout/footer.php'; ?>
