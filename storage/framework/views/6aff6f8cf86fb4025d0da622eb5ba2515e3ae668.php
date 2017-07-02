<!--
    dados = $instancia da tabela
    titulo = Nome da label para o combo
    id_combo = Id da combo
    complemento = informacoes adicionais, exemplo quando combo multiple enviar o codigo para gerar
    comparar = quando for edicao, enviar o id gravado no banco para ele selecionar o item correspondente quando carregar a combo
-->

<label for=<?php echo e($id_combo); ?> class="control-label"><?php echo e($titulo); ?></label>
<div class="input-group">
       <div class="input-group-addon">
          <a href="#" data-toggle="tooltip" title="Clique em 'Incluir Novo Registro' para cadastrar sem sair da página.">
                <img src="<?php echo e(url('/images/help.png')); ?>" class="user-image" alt="Ajuda"  />
           </a>
        </div>

        <!-- class="form-control selectpicker" -->
        <select id="<?php echo $id_combo; ?>" onchange="incluir_registro_combo('<?php echo $id_combo; ?>');" placeholder="(Selecionar)" name="<?php echo $id_combo; ?>" <?php echo $complemento; ?> data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
        <option  value=""></option>

        <!-- Verifica permissão de inclusao da pagina/tabela-->
        <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('verifica_permissao', [$id_pagina ,'incluir'])): ?>
            <optgroup label="Ação">
        <?php else: ?>
            <optgroup label="Ação" disabled>
        <?php endif; ?>

        <option  value=""  data-icon="fa fa-eraser">(Nenhum)</option>
        <option  value=""  data-icon="fa fa-plus-circle">(Incluir Novo Registro)</option>
        <option data-divider="true"></option>
        </optgroup>


        <optgroup label="Registros">
        <?php foreach($dados as $item): ?>
               <option  value="<?php echo e($item->id); ?>" <?php echo e($comparar==$item->id ? 'selected' : ''); ?>><?php echo e($item->nome); ?></option>
        <?php endforeach; ?>
        </select>
        </optgroup>

</div>