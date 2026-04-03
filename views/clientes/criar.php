<?php include ROOT_PATH . '/views/layout/header.php'; ?>

<div class="page-title">
    <div class="breadcrumb">CRM > Clientes > Novo</div>
    <h1>Novo Cliente</h1>
</div>

<div class="card" style="margin-top: 2rem;">
    <form action="<?php echo BASE_URL; ?>/clientes/criar" method="POST">
        <h3 style="margin-bottom: 1.5rem; color: var(--primary); border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Dados Pessoais</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Nome Completo / Razão Social *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" name="nome" value="<?php echo htmlspecialchars($formData['nome'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">CPF / CNPJ *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" id="cpf_cnpj" name="cpf_cnpj" value="<?php echo htmlspecialchars($formData['cpf_cnpj'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">E-mail *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="email" name="email" value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Aniversário</label>
                <div style="display: flex; gap: 1rem;">
                    <div class="search-box" style="flex: 1;">
                        <input type="number" name="aniversario_dia" placeholder="Dia" value="<?php echo htmlspecialchars($formData['aniversario_dia'] ?? ''); ?>" min="1" max="31" style="padding-left: 1rem;">
                    </div>
                    <div class="search-box" style="flex: 1;">
                        <input type="number" name="aniversario_mes" placeholder="Mês" value="<?php echo htmlspecialchars($formData['aniversario_mes'] ?? ''); ?>" min="1" max="12" style="padding-left: 1rem;">
                    </div>
                </div>
            </div>
        </div>

        <h3 style="margin-bottom: 1.5rem; color: var(--primary); border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Contato & Endereço</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Telefone/WhatsApp 1 *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($formData['telefone'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Telefone/WhatsApp 2</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" id="telefone2" name="telefone2" value="<?php echo htmlspecialchars($formData['telefone2'] ?? ''); ?>" style="padding-left: 1rem;">
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 200px 1fr 150px; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">CEP * <span id="cep-loading" style="display:none; color:var(--primary); font-size:0.8em;"><i class="fas fa-spinner fa-spin"></i> Buscando...</span></label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" id="cep" name="cep" value="<?php echo htmlspecialchars($formData['cep'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Endereço *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" id="endereco" name="endereco" value="<?php echo htmlspecialchars($formData['endereco'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Número *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" id="numero" name="numero" value="<?php echo htmlspecialchars($formData['numero'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 100px; gap: 1.5rem; margin-bottom: 2rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Bairro *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" id="bairro" name="bairro" value="<?php echo htmlspecialchars($formData['bairro'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Cidade *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" id="cidade" name="cidade" value="<?php echo htmlspecialchars($formData['cidade'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">UF *</label>
                <div class="search-box" style="width: 100%;">
                    <input type="text" id="estado_uf" name="estado_uf" maxlength="2" value="<?php echo htmlspecialchars($formData['estado_uf'] ?? ''); ?>" required style="padding-left: 1rem;">
                </div>
            </div>
        </div>

        <h3 style="margin-bottom: 1.5rem; color: var(--primary); border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Informações Adicionais</h3>

        <div style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Observações</label>
            <textarea name="observacoes" rows="4" style="width: 100%; border-radius: 10px; background-color: var(--bg-card); border: 1px solid var(--border); color: var(--text-main); padding: 1rem; outline: none; font-family: inherit;"><?php echo htmlspecialchars($formData['observacoes'] ?? ''); ?></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="<?php echo BASE_URL; ?>/clientes" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary" style="background-color: var(--success);">Salvar Cliente</button>
        </div>
    </form>
</div>

<script src="https://unpkg.com/imask"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if(document.getElementById('telefone')) {
            IMask(document.getElementById('telefone'), { mask: [{ mask: '(00) 0000-0000' }, { mask: '(00) 00000-0000' }] });
        }
        if(document.getElementById('telefone2')) {
            IMask(document.getElementById('telefone2'), { mask: [{ mask: '(00) 0000-0000' }, { mask: '(00) 00000-0000' }] });
        }
        if(document.getElementById('cpf_cnpj')) {
            IMask(document.getElementById('cpf_cnpj'), {
                mask: [
                    { mask: '000.000.000-00', maxLength: 11 },
                    { mask: '00.000.000/0000-00' }
                ],
                dispatch: function (appended, dynamicMasked) {
                    var number = (dynamicMasked.value + appended).replace(/\D/g,'');
                    return number.length <= 11 ? dynamicMasked.compiledMasks[0] : dynamicMasked.compiledMasks[1];
                }
            });
        }
        if(document.getElementById('cep')) {
            IMask(document.getElementById('cep'), { mask: '00000-000' });
            
            document.getElementById('cep').addEventListener('blur', function() {
                const cepCode = this.value.replace(/\D/g, '');
                if(cepCode.length === 8) {
                    document.getElementById('cep-loading').style.display = 'inline-block';
                    fetch(`https://viacep.com.br/ws/${cepCode}/json/`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('cep-loading').style.display = 'none';
                            if(!data.erro) {
                                document.getElementById('endereco').value = data.logradouro;
                                document.getElementById('bairro').value = data.bairro;
                                document.getElementById('cidade').value = data.localidade;
                                document.getElementById('estado_uf').value = data.uf;
                                document.getElementById('numero').focus();
                            }
                        });
                }
            });
        }
    });
</script>

<?php include ROOT_PATH . '/views/layout/footer.php'; ?>
