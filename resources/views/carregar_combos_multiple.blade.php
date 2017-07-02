<!--
    dados = $instancia da tabela
    titulo = Nome da label para o combo
    id_combo = Id da combo
    complemento = informacoes adicionais, exemplo quando combo multiple enviar o codigo para gerar
    comparar = quando for edicao, enviar o id gravado no banco para ele selecionar o item correspondente quando carregar a combo
-->

 <label for={{$id_combo}} class="control-label">{{$titulo}}</label>

<select id="{{$id_combo}}" name="{{$id_combo}}" {{$complemento}}  data-live-search="true" data-none-selected-text="(Selecionar)"  placeholder="(Selecionar)" class="form-control selectpicker" data-actions-box="true" style="width: 100%;">

@foreach($dados as $item)

    <?php $resultado = ''; ?>

    @if ($comparar=='')
            <option  value="{{$item->id}}">{{$item->nome}}</option>
    @else

            @foreach($comparar as $selecionar)
                    @if ($selecionar->id==$item->id)
                           <?php $resultado = 'selected'; ?>
                    @endif
            @endforeach

            <option  value="{{$item->id}}" {{$resultado}}>{{$item->nome}}</option>

    @endif

@endforeach

</select>