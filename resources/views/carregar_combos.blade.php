<!--
    dados = $instancia da tabela
    titulo = Nome da label para o combo
    id_combo = Id da combo
    complemento = informacoes adicionais, exemplo quando combo multiple enviar o codigo para gerar
    comparar = quando for edicao, enviar o id gravado no banco para ele selecionar o item correspondente quando carregar a combo
-->

<label for={{$id_combo}} class="control-label">{{$titulo}}</label>
<div class="input-group">
       <div class="input-group-addon">
          <a href="#" data-toggle="tooltip" title="Clique em 'Incluir Novo Registro' para cadastrar sem sair da página.">
                <img src="{{ url('/images/help.png') }}" class="user-image" alt="Ajuda"  />
           </a>
        </div>

        <!-- class="form-control selectpicker" -->
        <select id="{!!$id_combo!!}" onchange="incluir_registro_combo('{!!$id_combo!!}');" placeholder="(Selecionar)" name="{!!$id_combo!!}" {!!$complemento!!} data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
        <option  value=""></option>

        <!-- Verifica permissão de inclusao da pagina/tabela-->
        @can('verifica_permissao', [$id_pagina ,'incluir'])
            <optgroup label="Ação">
        @else
            <optgroup label="Ação" disabled>
        @endcan

        <option  value=""  data-icon="fa fa-eraser">(Nenhum)</option>
        <option  value=""  data-icon="fa fa-plus-circle">(Incluir Novo Registro)</option>
        <option data-divider="true"></option>
        </optgroup>


        <optgroup label="Registros">
        @foreach($dados as $item)
               <option  value="{{$item->id}}" {{$comparar==$item->id ? 'selected' : '' }}>{{$item->nome}}</option>
        @endforeach
        </select>
        </optgroup>

</div>